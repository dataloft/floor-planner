<?php
class Blocks_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

    public function getBlocks() {
        $this->db->select('*');
        $q =  $this->db->get('_blocks');
        return  $q->result_array();
    }

    public function addBlock ($data)
    {
        $this->db->insert('_blocks', $data);
        $return = $this->db->insert_id();

        return $return;
    }
}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */