<?php
class Menu_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getList($type=false,$first_lvl=false) {
        $this->db->select('*');
        if (!empty($type))
            $this->db->where('menu_group',$type);
        if (!empty($first_lvl))
            $this->db->where('parent_id',0);
        $this->db->order_by('order','asc');
        $this->db->order_by('parent_id','asc');
        $this->db->order_by('id','asc');

        $q =  $this->db->get('menu');
        if ($q->num_rows() > 0)
        {
            foreach ( $q->result() as $row )
            {
                $result[] = $row;
            }
            return  $result;
        }
        return false;

	}

    public function getOrderList($menu_group) {
        $this->db->select('*');
           $this->db->where('menu_group',$menu_group);
        $this->db->order_by('parent_id','asc');
        $this->db->order_by('order','asc');
        $q =  $this->db->get('menu');
        if ($q->num_rows() > 0)
        {
           return  $q->result();
        }
        return false;
    }

    public function updateOrderList($data) {
        if ($this->db->update('menu', $data, array('id' => $data->id)))
            //$return = $this->db->affected_rows() == 1;
            return true;
        else
            return false;
    }

	public function getMenuGroup($id="") {
        $this->db->select('*');
        if (!empty($id))
            $this->db->where('id',$id);
        $q =  $this->db->get('menu_group');
        return  $q->result_array();
    }

    public function getMaxOrder($parent_id) {
        $this->db->select('order');
        $this->db->where('parent_id',$parent_id);
        $this->db->order_by('order','desc');
        $this->db->limit(1);
        $q = $this->db->get('menu');
        if ($q->num_rows() > 0)
        {
            $row = $q->row();
            return $row->order;
        }
        return false;
    }

    public function ckeckUniqueOrder($parent_id, $order, $id = false) {
        $this->db->select('id');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('order', $order);
        $this->db->where('id !=', $id);
        $q = $this->db->get('menu');
        if ($q->num_rows() > 0)
        {
            $row = $q->row();
            return $row->id;
        }
        return false;
    }

    public function getToId($id) {
        $q = $this->db;
        $this->sql = "
			SELECT * FROM menu WHERE id = '".$id."'
		";
        $q = $q->query($this->sql);
        if ($q->num_rows() > 0)
            return $q->row();

        return false;
    }

    public function Add ($data)
    {
        $this->db->insert('menu', $data);
        $return = $this->db->insert_id();
        return $return;
    }

    public function Update ($id, $data)
    {
       if ($this->db->update('menu', $data, array('id' => $id)))
            return true;
        else
            return false;
    }

	public function get_all_langs() {
		
	}

    public function delete($id)
    {
        if ($this->db->delete('menu', array('id' => $id)))
            //$return = $this->db->affected_rows() == 1;
            return true;
        else
            return false;
    }

}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */