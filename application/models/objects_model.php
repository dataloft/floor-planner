<?php
class Objects_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getObjects() {
        $this->db->select('*');
        $this->db->order_by('title_object', 'asc');
        $q =  $this->db->get('_objects');
        return  $q->result_array();
	}
}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */