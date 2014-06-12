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

        if (!empty($_POST['block_id']))
        {
            $newfloor = 1 + count($this->floors_model->getFloors($this->input->post('block_id')));
            $data = array(
                'numb_floor' => $newfloor,
                'block_id' => $this->input->post('block_id')

            );
            $output["id"] = $this->floors_model->addFloor($data);
            $output["numb_floor"] = $newfloor;
            $output["success"] = "ok";
        }
        else
        {
            $output["error"] = "error";
        }

        echo json_encode($output);
    }

    public function delFloor()
    {

        if (!empty($_POST['floor_id']) and $this->floors_model->delete($_POST['floor_id']))
        {


            $output["success"] = "ok";
        }
        else
        {
            $output["error"] = "error";
        }

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