<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Floor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
    }

    public function index($id) {
        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        
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