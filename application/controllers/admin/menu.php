<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('menu_model');
        $this->load->model('trash_model');
        //$this->lang->load('menu');
        $this->load->helper('language');
	}

	public function index()
    {
        if(!$this->ion_auth->logged_in())
        {
            redirect('admin', 'refresh');
        }
        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        $data['main_menu'] = 'menu';
        $data['menu'] = array();
        $data['usermenu'] = array();
        $data['menu_group'] = '';
        $data['menu_list'] =  $this->menu_model->getMenuGroup();
        $data['menu_group'] = $data['menu_list'][0]['id'];
        if ($this->input->post('typeSelect'))
            $data['menu_group'] = $this->input->post('typeSelect');
        if ($list = $this->menu_model->getList($data['menu_group']))
           $data['content']  = $this->printTreeList($this->buildTree($list));
        else
            $data['content'] = '';
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu/list', $data);
        $this->load->view('admin/footer', $data);
	}

    public function buildTree($array_items)
    {

        if (is_array($array_items))
        {

            $items_count = count($array_items);

            for ($i = 0; $i < $items_count; $i++)
            {

                $item = clone($array_items[$i]);

                if ($item->parent_id == 0) { //верхний уровень

                    $children = $this->getChildNode($array_items, $item->id);

                    $item->child = $children;

                    $result[] = $item;

                }

            }

        }

        return (isset($result)) ? $result : false;

    }

    public function getChildNode($array, $id)
    {

        $count = count($array);

        for ($i = 0; $i < $count; $i++) { // перебор массива

            $item = clone($array[$i]);

            if ($item->parent_id == $id) { // 2 уровень найден

                $children = $this->getChildNode($array, $item->id);

                $item->child = $children;

                $child_array[] = $item; // добавить 2 уровень

            }

        }

        if (isset($child_array))
        {

            return $child_array;

        }

        else
        {

            return false;

        }

    }

    function printSelectList($items, $current=0, $level=0, $id=0, $mem_lvl = -1)
    {
        $echo = '';
        foreach ($items as $item)
        {
            $echo.= '<option value="'.$item->id . '"';
            if ($current == $item->id)
                $echo.= 'selected';
            if ($mem_lvl>=$level)
                $mem_lvl = -1;
            if ($id && $id == $item->id)
                $mem_lvl = $level;
            if (($id && $id == $item->id) or ($mem_lvl>-1 && $level>$mem_lvl))
                $echo.= 'disabled';
            $echo.= '>';
            for ($i = 0; $i < $level;$i++)
                $echo.=' - ';
            $echo.=$item->name .'</option>';
            if ($item->child !== false)
            {
                $level++;
                $echo.= $this->printSelectList($item->child, $current, $level, $id, $mem_lvl);
                $level--;
            }
        }
        return $echo;
    }

    function printTreeList($items, $current=0, $level=0)
    {
        $echo = '';
        foreach ($items as $item) {
            $echo.= '<li class="list-group-item">';
            if ($item->id != $current)
            {
                $echo.= '<a href="menu/edit/'.$item->id . '"';
                if ($level>0)
                    $echo.='style="margin-left:'.($level*20).'px"';
               $echo.=  '>' . $item->name . '</a>';
            }
            else
            {
                $echo.= '<span>' . $item->name . '</span>';
            }
            if ($item->child !== false)
            {
                $level++;
                $echo.= $this->printTreeList($item->child, $item->id, $level);
                $level--;
            }
            $echo.= '</li>';
        }
        return $echo;
    }

    public function add($mid=0)
    {
        $data = array();
        $data['id'] = '';
        $data['message'] = '';
        $data['menu'] = array();
        $data['main_menu'] = 'menu';
        $data['usermenu'] = array();
        $menu = new ArrayObject;
        $data['title'] = "Добавить/редактировать пункт меню";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $data['menu_group'] = $mid;
        if ($list = $this->menu_model->getList($data['menu_group']))
            $data['lvl_menu']  = $this->printSelectList($this->buildTree($list));
        else
            $data['lvl_menu'] = '';

        $this->form_validation->set_rules('name', '', 'required');
        $this->form_validation->set_rules('url', '', 'required');
        $menu->name = $this->input->post('name');
        $menu->url = $this->input->post('url');
        $menu->order = $this->input->post('order',TRUE);
        $menu->menu_group = $this->input->post('menu_group');
        $data['menu'] = $menu;
        if ($this->form_validation->run() == true)
        {
            if ($check = $this->menu_model->ckeckUniqueOrder($this->input->post('level_menu',TRUE), $this->input->post('order',TRUE)))
            {
                $check_order = $this->menu_model->getMaxOrder($this->input->post('level_menu',TRUE))+1;
                $this->menu_model->Update($check, array('order' => $check_order));
                $menu->order = $this->input->post('order',TRUE);
            }
            else
            {
                $menu->order = $this->input->post('order',TRUE);
            }
            $additional_data = array(
                'name' => $menu->name,
                'url' => $menu->url,
                'menu_group' =>  $mid,
                'parent_id' =>  $this->input->post('level_menu'),
                'order' =>  $menu->order
            );
            if ($id = $this->menu_model->Add($additional_data))
            {
                $this->session->set_flashdata('message',  array(
                        'type' => 'success',
                        'text' => 'Пункт меню создан'
                    )
                );
                redirect("admin/menu/edit/$id", 'refresh');
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
        $this->load->view('admin/menu/edit', $data);
        $this->load->view('admin/footer', $data);

    }

    public function edit($id = '')
    {
        $data = array();
        $data['id'] = '';
        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        $data['menu'] = array();
        $data['main_menu'] = 'menu';
        $data['usermenu'] = array();
        $menu = new ArrayObject;
        $data['title'] = "Добавить/редактировать пункт меню";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $this->form_validation->set_rules('name', '', 'required');
        $this->form_validation->set_rules('url', '', 'required');
        // Если передан Ид ищем содержание стр в БД
        if (!empty($id))
        {
            $data['menu'] = $this->menu_model->getToId($id);

            if (empty($data['menu']))
                show_404();
            $data['id'] = $id;
            $old_parent_id = $data['menu']->parent_id;
            if ($this->input->post('level_menu',TRUE))
                $menu->level_menu = $this->input->post('level_menu',TRUE);
            else
                $menu->level_menu = $data['menu']->parent_id;
            if ($list = $this->menu_model->getList($data['menu']->menu_group))
                $data['lvl_menu']  = $this->printSelectList($this->buildTree($list),$menu->level_menu, 0, $id);
            else
                $data['lvl_menu'] = '';
            if ($this->form_validation->run() == true)
            {

                $menu->name = $this->input->post('name',TRUE);
                $menu->url = $this->input->post('url',TRUE);
                //Если сменился родитель добавляем пункт к новому родитель в конец списка
                if ($old_parent_id != $this->input->post('level_menu',TRUE))
                    $menu->order = $this->menu_model->getMaxOrder($this->input->post('level_menu',TRUE)) + 1;
                elseif ($check = $this->menu_model->ckeckUniqueOrder($this->input->post('level_menu',TRUE), $this->input->post('order',TRUE), $id))
                {
                    $check_order = $this->menu_model->getMaxOrder($this->input->post('level_menu',TRUE))+1;
                    $this->menu_model->Update($check, array('order' => $check_order));
                    $menu->order = $this->input->post('order',TRUE);

                }
                else
                {
                    $menu->order = $this->input->post('order',TRUE);
                }

                $menu->menu_group = $data['menu']->menu_group;

                $data['menu'] = $menu;
                $additional_data = array(
                    'name' => $menu->name,
                    'url' => $menu->url,
                    'order' => $menu->order,
                    'menu_group' =>   $data['menu']->menu_group,
                    'parent_id' =>   $this->input->post('level_menu',TRUE),
                );
                if ($this->menu_model->Update($data['id'],$additional_data))
                {
                    $this->reOrder($data['menu']->menu_group);
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
                $menu->name = $this->input->post('name',TRUE);
                $menu->url = $this->input->post('url',TRUE);
                $menu->order = $this->input->post('order',TRUE);
                $menu->menu_group = $this->input->post('menu_group',TRUE);

                $data['menu'] = $menu;
                $data['message'] = array(
                    'type' => 'danger',
                    'text' => validation_errors()
                );

            }
        }
        //Вставляем новую запись
        else
        {
            redirect("admin/menu/add", 'refresh');
        }
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu/edit', $data);
        $this->load->view('admin/footer', $data);

    }

    // Пресортировка пунктов меню
    public function reOrder ($menu_group = 1)
    {
        $old_parent_id = 0;
        $order = 0;
        $order_list = $this->menu_model->getOrderList($menu_group);
        foreach ($order_list as $row)
        {
            if ($old_parent_id == $row->parent_id)
            {
                $order ++;
                $row->order = $order;
            }
            else
            {
                $old_parent_id = $row->parent_id;
                $order = 1;
                $row->order = $order;

            }
            $this->menu_model->UpdateOrderList($row);
        }
    }

    public function delete ()
    {
        if (isset($_POST)) {
            $id = $this->input->post('id');
            if ($id)
            {
                $data['menu'] = $this->menu_model->getToId($id);
                if (!empty($data['menu']))
                {
                    $additional_data = array(
                        'deleted_id' => $id,
                        'type' =>  'menu',
                        'data' =>     serialize($data['menu'])
                    );
                    if ($this->trash_model->Add($additional_data))
                    {
                        if ($this->menu_model->delete($id))
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