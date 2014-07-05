<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flats extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('flats_model');
        $this->load->model('blocks_model');
        $this->load->model('objects_model');
        $this->load->library('upload');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index() {
        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        $data['main_menu'] = 'flats';
        $data['menu'] = array();
        $data['usermenu'] = array();
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
        $data['block'] = $this->blocks_model->getBlock($_GET['block_id']);
        $data['object'] = $this->objects_model->getObject($data['block']->object_id);
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
            setlocale(LC_ALL, 'ru_RU.UTF-8');
            ini_set('auto_detect_line_endings',TRUE);
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
                while ($row = fgetcsv($csvHandle, 100000, ';', '"'))
                {
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
                                    'text' => 'Неверный формат данных'
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

    public function addFlatCsv()
    {
        if ( isset($_POST['upload'])) {
            $csv = $this->parseCSV($_FILES['csv-flat'],$_GET['block_id']);
            if (!empty($csv))
            {
                /*$old_flats = $this->flats_model->getFlats();
                $this->flats_model->deleteAll();*/

                foreach ($csv as $item)
                {
                    $flat = $this->flats_model->getNumbFlat($item['numb_flat'],$_GET['block_id']);

                    if (empty($flat))
                        $res = $this->flats_model->addFlat($item);
                    else
                        $res = $this->flats_model->updateFlat($item, $flat->id);

                }


            }
            else
            {
                if (!$this->session->flashdata('message'))
                    $this->session->set_flashdata('message',  array(
                            'type' => 'danger',
                            'text' => 'Файл пуст'
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
        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        $this->form_validation->set_rules('numb_flat', '', 'required|is_natural_no_zero');

        // Если передан Ид ищем содержание в БД
        if (!empty($id))
        {
            $flat = $this->flats_model->getFlatToId($id);
            $data['block'] = $this->blocks_model->getBlock($flat['block_id']);
            $data['object'] = $this->objects_model->getObject($data['block']->object_id);
            $data['flat'] = $flat;

            if (empty($data['flat']))
                show_404();
            $data['id'] = $id;
            if (file_exists ($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'a.png'))
                $data['thumb'] = '/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'a.png';
            else
                $data['thumb'] = '';
            if (file_exists ($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'b.png'))
                $data['img'] = '/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'b.png';
            else
                $data['img'] = '';
            if (!empty($_POST))
            {
                if ($this->input->post('del_thumb'))
                {
                    @unlink($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'a.png');
                    @rmdir($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/');
                }

                if ($this->input->post('del_img'))
                {
                    @unlink($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'b.png');
                    @rmdir($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/');
                }

                $data['flat']["numb_flat"] = $this->input->post('numb_flat');
                $data['flat']["full_area"] = $this->input->post('full_area');
                $data['flat']["living_area"] = $this->input->post('living_area');
                $data['flat']["kitchen_area"] = $this->input->post('kitchen_area');
                $data['flat']["floor"] = $this->input->post('floor');
                $data['flat']["count_room"] = $this->input->post('count_room');
                $data['flat']["status"] = $this->input->post('status');
                $data['flat']["price"] = $this->input->post('price');
                $data['flat']["sale_price"] = $this->input->post('sale_price');
                $data['flat']["wc_type"] = $this->input->post('wc_type');
                $data['flat']["balcon"] = $this->input->post('balcon');
                $data['flat']["loggia"] = $this->input->post('loggia');

                if ($this->form_validation->run() == true)
                {
                    if ($this->input->post('numb_flat') != $flat['numb_flat'])
                    {
                        $flat_num = $this->flats_model->getNumbFlat($this->input->post('numb_flat'),$flat['block_id']);
                        if (empty($flat_num))
                            $result = $this->flats_model->updateFlat($data['flat'], $flat['id']);
                        else
                        {
                            $data['flat']["numb_flat"] = $flat["numb_flat"];
                        }
                    }
                    else
                        $result = $this->flats_model->updateFlat($data['flat'], $flat['id']);

                    if (!empty($result))
                    {
                        $this->session->set_flashdata('message', array(
                                'type' => 'success',
                                'text' => 'Запись обновлена'
                            )
                        );

                        if (isset($_FILES['thumb']))
                            $this->imgUpload("thumb",$_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/',$this->input->post('numb_flat').'a');
                        if (isset($_FILES['img']))
                            $this->imgUpload("img",$_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/',$this->input->post('numb_flat').'b');



                        redirect('admin/flats/'.$id, 'refresh');
                    }
                    else
                    {
                        if (!empty($flat_num))
                            $data['message'] = array(
                                'type' => 'danger',
                                'text' => 'Квартира с номером '.$this->input->post('numb_flat').' уже существует.'

                            );
                        else
                            $data['message'] = array(
                                'type' => 'danger',
                                'text' => 'Произошла ошибка при обновлении записи.'

                            );
                    }
                }
                else
                {
                    $data['message'] =  array(
                        'type' => 'danger',
                        'text' => validation_errors()

                    );

                }

            }
        }

        $this->load->view('admin/header', @$data);
        $this->load->view('admin/flats/edit', @$data);
        $this->load->view('admin/footer', @$data);
    }

    public function addFlat() {

        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        if (!isset($_GET['block_id']))
        {
            $this->session->set_flashdata('message',  array(
                    'type' => 'danger',
                    'text' => 'Неизвестный объект'
                )
            );
            redirect('admin/blocks', 'refresh');
        }
        $data['main_menu'] = 'floor';
        $data['menu'] = array();
        $data['usermenu'] = array();
        $data['type'] = '';
        $data['search'] = '';
        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        $this->form_validation->set_rules('numb_flat', '', 'required|is_natural_no_zero');
        $data['flat']["block_id"] = $_GET['block_id'];
        // Если передан Ид ищем содержание в БД
        $data['block'] = $this->blocks_model->getBlock($_GET['block_id']);
        $data['object'] = $this->objects_model->getObject($data['block']->object_id);
        //$data['flat'] = $flat;

        /*if (file_exists ($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'a.png'))
            $data['thumb'] = '/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'a.png';
        else*/
        $data['thumb'] = '';
        /* if (file_exists ($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'b.png'))
             $data['img'] = '/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'b.png';
         else*/
        $data['img'] = '';
        if (!empty($_POST))
        {
            /*if ($this->input->post('del_thumb'))
                unlink($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'a.png');
            if ($this->input->post('del_img'))
                unlink($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'b.png');*/

            $data['flat']["numb_flat"] = $this->input->post('numb_flat');
            $data['flat']["full_area"] = $this->input->post('full_area');
            $data['flat']["living_area"] = $this->input->post('living_area');
            $data['flat']["kitchen_area"] = $this->input->post('kitchen_area');
            $data['flat']["floor"] = $this->input->post('floor');
            $data['flat']["count_room"] = $this->input->post('count_room');
            $data['flat']["status"] = $this->input->post('status');
            $data['flat']["price"] = $this->input->post('price');
            $data['flat']["sale_price"] = $this->input->post('sale_price');
            $data['flat']["wc_type"] = $this->input->post('wc_type');
            $data['flat']["balcon"] = $this->input->post('balcon');
            $data['flat']["loggia"] = $this->input->post('loggia');


            if ($this->form_validation->run() == true)
            {
                $flat_num = $this->flats_model->getNumbFlat($this->input->post('numb_flat'),$_GET['block_id']);
                if (empty($flat_num))
                    $result = $this->flats_model->addFlat($data['flat']);


                if (!empty($result))
                {
                    $this->session->set_flashdata('message', array(
                            'type' => 'success',
                            'text' => 'Квартира добавлена'
                        )
                    );

                    if (isset($_FILES['thumb']))
                        $this->imgUpload("thumb",$_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$_GET['block_id'].'/',$this->input->post('numb_flat').'a');
                    if (isset($_FILES['img']))
                        $this->imgUpload("img",$_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$_GET['block_id'].'/',$this->input->post('numb_flat').'b');
                    redirect('admin/flats?block_id='. $data['flat']["block_id"], 'refresh');
                }
                else
                {
                    if (!empty($flat_num))
                        $data['message'] = array(
                            'type' => 'danger',
                            'text' => 'Квартира с номером '.$this->input->post('numb_flat').' уже существует.'

                        );
                    else
                        $data['message'] = array(
                            'type' => 'danger',
                            'text' => 'Произошла ошибка при обновлении записи.'

                        );
                }
            }
            else
            {
                $data['message'] =  array(
                    'type' => 'danger',
                    'text' => validation_errors()

                );

            }

        }


        $this->load->view('admin/header', @$data);
        $this->load->view('admin/flats/add', @$data);
        $this->load->view('admin/footer', @$data);
    }

    public function imgUpload ($file_name,$dir,$name)
    {
        if (!file_exists ($dir))
            mkdir($dir, 0777);
        $config['upload_path'] = $dir;
        $config['allowed_types'] = 'png';
        $config['file_name'] = $name;
        $config['overwrite'] = true;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( !$this->upload->do_upload($file_name))
        {
            return array('error' => $this->upload->display_errors());
        }
        else
        {
            return $this->upload->data();

        }
    }

    public function deleteFlat()
    {
        if (!empty($_GET['id'])){
            $flat = $this->flats_model->getFlatToId($_GET['id']);
            if (!empty($flat))
            {
                $this->flats_model->deleteFlat($_GET['id']);
                @unlink($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'a.png');
                @unlink($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/'.$flat['numb_flat'].'b.png');
                @rmdir($_SERVER['DOCUMENT_ROOT'].'/public/layout/flats/'.$flat['block_id'].'/');
                $output["success"] = "ok";
                $this->session->set_flashdata('message',  array(
                        'type' => 'success',
                        'text' => 'Квартира удалена'
                    )
                );
            }

        }
        else
        {
            $this->session->set_flashdata('message',  array(
                    'type' => 'danger',
                    'text' => 'Произошла ошибка при удалении квартиры'
                )
            );
        }
        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }

}