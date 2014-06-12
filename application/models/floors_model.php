<?php
class Floors_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

    public function getFloors($block_id = false) {
        $this->db->select('*');
        if (!empty($block_id))
            $this->db->where('block_id',$block_id);
        $q =  $this->db->get('_floors');
        return  $q->result_array();
    }

    public function addFloor ($data)
    {
        $this->db->insert('_floors', $data);
        $return = $this->db->insert_id();

        return $return;
    }

    public function delete ($id)
    {
        if ($this->db->delete('_floors', array('id' => $id)))
            //$return = $this->db->affected_rows() == 1;
            return true;
        else
            return false;
    }
}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */