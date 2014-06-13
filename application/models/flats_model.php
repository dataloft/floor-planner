<?php
class Flats_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

    public function getFlats($block_id = false) {
        $this->db->select('*');
        if (!empty($block_id))
            $this->db->where('block_id',$block_id);
        $q =  $this->db->get('_flats');
        return  $q->result_array();
    }

    public function addFlatBatch ($data)
    {
       if ($this->db->insert_batch('_flats', $data))
           return true;
       else
           return false;
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