<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		/*
		$this->load->model('content_model');
		$this->load->model('counters_model');
		$this->load->model('menu_model');
		*/
	}

	public function index() {
	
        $this->load->view('nsc/list', @$data);
		
	}
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */