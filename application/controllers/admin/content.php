<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('content_model');
        $this->load->model('trash_model');
        $this->lang->load('content');
        $this->load->helper('language');
    }

    public function index($page = '') {
        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }

        $data['main_menu'] = 'content';
        $data['menu'] = array();
        $data['usermenu'] = array();
        $data['type'] = '';
        $data['search'] = '';
        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        if ($this->input->post('typeSelect'))
            $data['type'] = $this->input->post('typeSelect');
        if ($this->input->post('search'))
            $data['search'] = $this->input->post('search');


        $data['content']  = $this->content_model->getList($data['type'],$data['search']);
        $data['type_list']  = $this->content_model->getType();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/content/list', $data);
        $this->load->view('admin/footer', $data);
    }

    public function add() {
        $data = array();
        $data['id'] = '';
        $data['message'] = '';
        $data['main_menu'] = 'content';
        $data['menu'] = array();
        $data['usermenu'] = array();
        $page = new ArrayObject;
        $data['title'] = "Добавить/редактировать страницу";
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }
        $data['type_list']  = $this->content_model->getType();
        /*$this->form_validation->set_rules('content', '', 'required');*/
        $this->form_validation->set_rules('h1', '', 'required');
        $this->form_validation->set_rules('alias', '', 'is_unique[content.alias]');
        $page->content = $this->input->post('content');
        $page->h1 = $this->input->post('h1');
        $page->alias = $this->input->post('alias');
        $page->title = $this->input->post('title');
        $page->meta_description = $this->input->post('meta_description');
        $page->meta_keywords = $this->input->post('meta_keywords');
        $page->type = $this->input->get('type')?$this->input->get('type'):$this->input->post('type');
        $page->enabled = $this->input->post('enabled');
        $data['page'] = $page;
        if ($this->form_validation->run() == true)
        {
            $additional_data = array(
                'content' => $page->content,
                'h1' => $page->h1,
                'alias' =>  $page->alias,
                'type' =>  $page->type,
                'title' =>  $page->title,
                'meta_description' =>  $page->meta_description,
                'meta_keywords' =>  $page->meta_keywords,
                'enabled' =>    $page->enabled
            );
            if ($id = $this->content_model->Add($additional_data))
            {
                $this->session->set_flashdata('message',  array(
                        'type' => 'success',
                        'text' => 'Запись создана'
                    )
                );
                redirect("admin/content/edit/$id", 'refresh');
            }
            else
            {
                $data['message'] = array(
                    'type' => 'danger',
                    'text' => 'Произошла ошибка при сохранении записи.'
                );
            }
        }
        elseif ($this->input->post('action') == 'add')
        {
            $data['message'] = array(
                'type' => 'danger',
                'text' =>  validation_errors()
            );
        }
        $this->load->view('admin/header', $data);
        $alias = 'edit';
        foreach ($data['type_list'] as $item) {
            if ($page->type == $item->id)
                $alias = $item->alias;
            else
                continue;
        }
        $this->load->view('admin/content/'.$alias, $data);

        $this->load->view('admin/footer', $data);
    }

    public function edit($id = '') {
        $data = array();
        $data['id'] = '';
        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        $data['main_menu'] = 'content';
        $data['menu'] = array();
        $data['usermenu'] = array();
        $page = new ArrayObject;
        $data['title'] = "Добавить/редактировать страницу";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }
        $data['type_list']  = $this->content_model->getType();
        /* $this->form_validation->set_rules('content', '', 'required');*/
        $this->form_validation->set_rules('h1', '', 'required');
        $this->form_validation->set_rules('alias', '', 'callback_check_alias');
        // Если передан Ид ищем содержание стр в БД
        if (!empty($id))
        {
            $data['page'] = $this->content_model->getToId($id);
            if (empty($data['page']))
                show_404();
            $data['id'] = $id;
            if ($this->form_validation->run() == true)
            {

                $page->content = $this->input->post('content');
                $page->h1 = $this->input->post('h1',TRUE);
                $page->alias = $this->input->post('alias',TRUE);
                $page->title = $this->input->post('title',TRUE);
                $page->meta_description = $this->input->post('meta_description',TRUE);
                $page->meta_keywords = $this->input->post('meta_keywords',TRUE);
                $page->type = $this->input->post('type',TRUE);
                $page->enabled = $this->input->post('enabled',TRUE);
                $data['page'] = $page;
                $additional_data = array(
                    'content' => $page->content,
                    'h1' => $page->h1,
                    'alias' =>  $page->alias,
                    'type' =>  $page->type,
                    'title' =>  $page->title,
                    'meta_description' =>  $page->meta_description,
                    'meta_keywords' =>  $page->meta_keywords,
                    'enabled' =>  $page->enabled
                );
                if ($this->content_model->Update($data['id'],$additional_data))
                {
                    $data['message'] = array(
                        'type' => 'success',
                        'text' => 'Запись обновлена'
                    );
                }
                else
                {
                    $data['message'] = array(
                        'type' => 'danger',
                        'text' => 'Произошла ошибка при обновлении записи.'
                    );
                }
            }
            elseif($this->input->post('id')==$id)
            {
                $page->content = $this->input->post('content',TRUE);
                $page->h1 = $this->input->post('h1',TRUE);
                $page->alias = $this->input->post('alias',TRUE);
                $page->title = $this->input->post('title',TRUE);
                $page->meta_description = $this->input->post('meta_description',TRUE);
                $page->meta_keywords = $this->input->post('meta_keywords',TRUE);
                $page->type = $this->input->post('type',TRUE);
                $page->enabled = $this->input->post('enabled',TRUE);

                $data['page'] = $page;
                $data['message'] = array(
                    'type' => 'danger',
                    'text' => validation_errors()
                );

            }
        }
        //Вставляем новую запись
        else
        {
            redirect("admin/content/add?type=".$this->input->get('type'), 'refresh');
        }
        $this->load->view('admin/header', $data);
        $alias = 'edit';
        foreach ($data['type_list'] as $item) {
            if ( $data['page']->type == $item->id)
                $alias = $item->alias;
            else
                continue;
        }
        $this->load->view('admin/content/'.$alias, $data);
        $this->load->view('admin/footer', $data);

    }

    public function check_alias ()
    {
        $page =  $this->content_model->getToAlias($this->input->post('alias'));
        $this->form_validation->set_message(__FUNCTION__, 'The alias you entered is already used.');
        if (empty($page))
            return true;
        if ($this->input->post('id') == $page->id)
            return true;
        else
            return false;
    }

    public function delete ()
    {
        if (isset($_POST)) {
            $id = $this->input->post('id');
            if ($id)
            {
                $data['page'] = $this->content_model->getToId($id);
                if (!empty($data['page']))
                {
                    $additional_data = array(
                        'deleted_id' => $id,
                        'type' =>  'page',
                        'data' =>     serialize($data['page'])
                    );
                    if ($this->trash_model->Add($additional_data))
                    {
                        if ($this->content_model->delete($id))
                        {
                            $output['success']='success';
                            $this->session->set_flashdata('message',  array(
                                    'type' => 'success',
                                    'text' => 'Запись удалена'
                                )
                            );
                        }
                        else
                        {
                            $output['error']='error';
                        }
                    }
                    else {
                        $output['error']='error';
                    }
                    echo json_encode($output);

                }

            }
        }
    }
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */