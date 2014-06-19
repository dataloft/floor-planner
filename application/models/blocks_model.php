<?php
class Blocks_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

    public function getBlocks($object_id = false) {
        $this->db->select('*');
        if (!empty($object_id))
            $this->db->where('object_id',$object_id);
        $q =  $this->db->get('_blocks');
        return  $q->result_array();
    }
    public function getBlock($id) {
        $this->db->select('*');
        $this->db->where('id',$id);
        $q =  $this->db->get('_blocks');
        return  $q->row();
    }
    public function addBlock ($data)
    {
        $this->db->insert('_blocks', $data);
        $return = $this->db->insert_id();

        return $return;
    }

    public function delete ($id)
    {
        if ($this->db->delete('_blocks', array('id' => $id)))
            //$return = $this->db->affected_rows() == 1;
            return true;
        else
            return false;
    }
}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */