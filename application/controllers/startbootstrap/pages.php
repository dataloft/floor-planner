<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('content_model');
		$this->load->model('counters_model');
		$this->load->model('menu_model');
	}

	public function index($page = '') {
        $page = $this->uri->uri_string();
		$data['page'] = $this->content_model->get($page);
        $data['menu'] = $this->menu_model->getList(1,true);
        
		if($data['page']) {
			$this->load->view('startbootstrap/header', $data);
			$this->load->view('startbootstrap/nav', $data);
			
			if ($this->uri->uri_string != '') {
				$this->load->view('startbootstrap/pages_inner', $data);
			}
			else {
				$this->load->view('startbootstrap/pages_home', $data);
			}
            if($counters = $this->counters_model->getCounters($this->input->ip_address(), $_SERVER['HTTP_HOST'])) $data['counters'] = $counters; else $data['counters'] = '';

			$this->load->view('startbootstrap/footer', $data);
		} else {
			show_404();
		}
	}
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */