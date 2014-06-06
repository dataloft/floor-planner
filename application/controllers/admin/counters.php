<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Counters extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('counters_model');
        $this->load->model('trash_model');
        $this->lang->load('content');
        $this->load->helper('language');
    }

    public function index() {
        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        $data['main_menu'][0] = 'modules';
        $data['main_menu'][1] = 'counters';
        $data['menu'] = array();
        $data['usermenu'] = array();
        $data['type'] = '';
        $data['search'] = '';
        $counters = new ArrayObject;
        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        //$this->form_validation->set_rules('text', '', 'required');
        $data['counters'] = $this->counters_model->getCounters();
        if (empty($data['counters']))
            show_404();

        if ($this->input->post('save'))
        {
            $counters->text = $this->input->post('text');
            $counters->ip = $this->input->post('ip');
            $counters->domain = $this->input->post('domain');
            $counters->id = $data['counters']->id;
            $data['counters'] = $counters;
            $additional_data = array(
                'text' => $counters->text,
                'ip' => $counters->ip,
                'domain' =>  $counters->domain
            );

            if ($this->counters_model->Update($counters->id, $additional_data))
            {
                $data['message'] = array(
                    'type' => 'success',
                    'text' => 'Запись обновлена'
                );
            }
            else
            {

                $counters->text = $this->input->post('text');
                $counters->ip = $this->input->post('ip');
                $counters->domain = $this->input->post('domain');
                $counters->id = $data['counters']->id;
                $data['counters'] = $counters;
                $data['message'] = array(
                    'type' => 'danger',
                    'text' => validation_errors()
                );
            }
        }
        $this->load->view('admin/header', $data);
        $this->load->view('admin/counters/counters', $data);
        $this->load->view('admin/footer', $data);
    }
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */