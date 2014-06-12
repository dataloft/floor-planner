<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Floor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('floors_model');
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