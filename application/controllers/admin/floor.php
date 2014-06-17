<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Floor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('floors_model');
        $this->load->library('form_validation');
    }

    public function index($id) {
        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }

    }

    public function addFloor()
    {

        if (!empty($_POST['block_id']) && !empty($_POST['floor_name']))
        {

            $data = array(
                'numb_floor' => $this->input->post('floor_name'),
                'block_id' => $this->input->post('block_id')

            );
            $output["id"] = $this->floors_model->addFloor($data);
            $output["numb_floor"] = $this->input->post('floor_name');
            $output["success"] = "ok";
            $this->session->set_flashdata('message',  array(
                    'type' => 'success',
                    'text' => 'Этаж добавлен'
                )
            );

        }
        else
        {
            $output["error"] = "error";
            $this->session->set_flashdata('message',  array(
                    'type' => 'success',
                    'text' => 'Ошибка добавления этажа'
                )
            );

        }
        redirect('admin/blocks', 'refresh');
        echo json_encode($output);
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

    public function edit($id)
    {
        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        $data['main_menu'] = 'floor';
        $data['menu'] = array();
        $data['usermenu'] = array();
        $data['type'] = '';
        $data['search'] = '';
        $data['floor'] = $this->floors_model->getFloor($id);
        $data['checked_flats'] = $this->floors_model->getCheckedFlats($id);
        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        if (!empty($_POST['upload-plan']) && !empty($_FILES))
        {
            $plan = $this->doUpload($_FILES);
            if(!$plan)
                redirect('admin/floor/'.$id, 'refresh');
            else
            {
                if ($this->floors_model->update($plan,$id))
                {
                    $this->session->set_flashdata('message',  array(
                            'type' => 'success',
                            'text' => 'План загружен'
                        )
                    );
                }
                else
                {
                    $this->session->set_flashdata('message',  array(
                            'type' => 'danger',
                            'text' => 'Ошибка записи в базу'
                        )
                    );
                }
                redirect('admin/floor/'.$id, 'refresh');
            }
        }
        if (empty($data['floor']))
        {
            $this->session->set_flashdata('message',  array(
                    'type' => 'danger',
                    'text' => 'Этаж не найден'
                )
            );
            redirect('admin/blocks', 'refresh');
        }

        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/layout/floor', $data);
        $this->load->view('admin/footer', $data);
    }

    protected function doUpload($file)
    {
        if(is_uploaded_file($file["plan"]["tmp_name"]))
        {
            $imageinfo = getimagesize($file['plan']['tmp_name']);
            if ($imageinfo['mime']=='image/jpeg') {$prefix='jpg';}
            else if ($imageinfo['mime']=='image/png') {$prefix='png';}
            else if ($imageinfo['mime']=='image/gif') {$prefix='gif';}
            else {
                $this->session->set_flashdata('message',  array(
                        'type' => 'danger',
                        'text' => 'Неверный формат файла'
                    )
                );

                return false;
            }

            //  $error = 'No file was uploaded..';
            $letters = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9","0");

            $adding_word='';

            for ($i=0;$i<14;$i++)
                $adding_word.=$letters[rand(0,sizeof($letters)-1)];

            $new_picturename=$_SERVER['DOCUMENT_ROOT']."/public/layout/floors/".$adding_word.".".$prefix;

            if (copy($_FILES['plan']['tmp_name'], $new_picturename))
            {

                return "/public/layout/floors/".$adding_word.".".$prefix;
            }

        }
        else
            $this->session->set_flashdata('message',  array(
                    'type' => 'danger',
                    'text' => 'Ошибка загрузки'
                )
            );

        return false;
    }

    public function checkFlat()
    {

            $this->form_validation->set_rules('coords', '', 'required');
            $this->form_validation->set_rules('floor_id', '', 'required');
            $this->form_validation->set_rules('numb_flat', '', 'required');
            if ($this->form_validation->run() == true)
            {
                $data = array(
                    'coords' => $this->input->post('coords'),
                    'numb_flat' => $this->input->post('numb_flat'),
                    'floor_id' => $this->input->post('floor_id')
                );
                if ($this->floors_model->checkFlat($data))
                {
                    $this->session->set_flashdata('message',  array(
                            'type' => 'success',
                            'text' => 'Квартира отмечена'
                        )
                    );
                }
                else
                    $this->session->set_flashdata('message',  array(
                            'type' => 'danger',
                            'text' => 'Ошибка записи'
                        )
                    );
            } else $this->session->set_flashdata('message',  array(
                'type' => 'danger',
                'text' => 'Заполнены не все поля'
            )
        );

        redirect('admin/floor/'.$_POST['floor_id'], 'refresh');
    }

    public function delPlan()
    {
        $floor_id = '';
        if (!empty($_POST['floor_id']))
            $floor_id = $_POST['floor_id'];

        if (!empty($floor_id) and $this->floors_model->update('', $floor_id))
        {
            if (!empty($_POST['plan']))
                unlink($_SERVER['DOCUMENT_ROOT'].$_POST['plan']);

            $output["success"] = "ok";
            $this->session->set_flashdata('message',  array(
                    'type' => 'success',
                    'text' => 'План удален'
                )
            );

        }
        else
        {
            $this->session->set_flashdata('message',  array(
                    'type' => 'danger',
                    'text' => 'Произошла ошибка при удалении плана'
                )
            );
            $output["error"] = "error";
        }
        redirect('admin/floor/'.$_POST['floor_id'], 'refresh');
        echo json_encode($output);
    }

    public function delCheckedFlat()
    {
        if (!empty($_GET['id'])){
            $this->floors_model->delCheckedFlat($_GET['id']);
            $output["success"] = "ok";
            $this->session->set_flashdata('message',  array(
                    'type' => 'success',
                    'text' => 'Отметка удалена'
                )
            );
        }
        else
        {
            $this->session->set_flashdata('message',  array(
                    'type' => 'danger',
                    'text' => 'Произошла ошибка при удалении отметки'
                )
            );
        }
        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }
   
}