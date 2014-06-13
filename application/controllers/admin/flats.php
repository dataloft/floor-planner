<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flats extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('flats_model');
        $this->load->library('upload');
        $this->load->helper('form');
    }

    public function index() {
        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        if (!isset($_GET['block_id']))
        {
            $this->session->set_flashdata('message',  array(
                    'type' => 'danger',
                    'text' => 'Неизвестный объект'
                )
            );
            redirect('admin/blocks', 'refresh');
        }
        $data['flats_list'] = $this->flats_model->getFlats($_GET['block_id']);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/flats/list', $data);
        $this->load->view('admin/footer', $data);
        
    }

    public function parseCSV($uploadFile, $block_id)
    {
        $pattern = array("numb_flat", "full_area", "living_area", "kitchen_area", "floor", "count_room", "status", "price", "sale_price", "wc_type", "balcon", "loggia");
        //Здесь работаем с содержимым переданного файла.
        $tmp_name = $uploadFile['tmp_name'];
        if (!is_uploaded_file($tmp_name))
        {
            $this->session->set_flashdata('message',  array(
                    'type' => 'danger',
                    'text' => 'Ошибка загрузки файла'
                )
            );
        }
        else
        {
            //Считываем файл в строку
            $csvData = file_get_contents($tmp_name);
            $csvData = iconv('cp1251', 'utf-8', $csvData);
            $fname = tempnam($_SERVER['DOCUMENT_ROOT']."/tmp", "priceCsv");
            file_put_contents($fname, $csvData);
            $csvHandle = fopen($fname, 'r');
            if ($csvHandle === false) {
                $this->session->set_flashdata('message',  array(
                        'type' => 'danger',
                        'text' => 'Ошибка открытия файла'
                    )
                );

            }
            else
            {
                $rowNumber = 0;
                while ($row = fgetcsv($csvHandle, 100000, ';', '"')) {
                    $rowNumber += 1;
                    $row = array_map('trim', $row);
                    if ($rowNumber==1)
                    {
                        $diff = array_diff_assoc($pattern,$row);
                       if (empty($diff))
                           continue;
                       else
                       {
                           $this->session->set_flashdata('message',  array(
                                   'type' => 'danger',
                                   'text' => 'Неврный формат данных'
                               )
                           );
                           return false;
                       }

                    }
                    $rowOrig = $row;
                    unset($row);
                    foreach ($rowOrig as $n => $val) {
                        $row[$pattern[$n]] = $val;
                    }
                    $row['block_id'] = $block_id;
                    unset($rowOrig);
                    $data[] = $row;
                }
                return $data;
            }
        }
        return false;
    }

    public function addFlat()
    {
        if ( isset($_POST['upload'])) {
            $csv = $this->parseCSV($_FILES['csv-flat'],$_GET['block_id']);
            if (!empty($csv))
                if ($this->flats_model->addFlatBatch($csv))
                {
                    $this->session->set_flashdata('message',  array(
                            'type' => 'success',
                            'text' => 'Квартиры добавлены'
                        )
                    );
                }
                else
                {
                    $this->session->set_flashdata('message',  array(
                            'type' => 'danger',
                            'text' => 'Ошибка сохранения данных'
                        )
                    );
                }
        }
        redirect('admin/flats?block_id='.$_GET['block_id'], 'refresh');
    }

    public function delFloor()
    {
        $floor_id = '';
        if (!empty($_POST['floor_id']))
            $floor_id = $_POST['floor_id'];
        if (!empty($_GET['floor_id']))
            $floor_id = $_GET['floor_id'];

        if (!empty($floor_id) and $this->floors_model->delete($floor_id))
        {


            $output["success"] = "ok";
            $this->session->set_flashdata('message',  array(
                    'type' => 'success',
                    'text' => 'Этаж удален'
                )
            );

        }
        else
        {
            $this->session->set_flashdata('message',  array(
                    'type' => 'danger',
                    'text' => 'Произошла ошибка при удалении этажа'
                )
            );
            $output["error"] = "error";
        }
        redirect('admin/blocks', 'refresh');
        echo json_encode($output);
    }

    public function edit($id) {
        
        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        
        
        $data['main_menu'] = 'floor';
        $data['menu'] = array();
        $data['usermenu'] = array();
        $data['type'] = '';
        $data['search'] = '';
        
        
        $this->load->view('admin/header', @$data);
        $this->load->view('admin/layout/floor', @$data);
        $this->load->view('admin/footer', @$data);
    }

   
}