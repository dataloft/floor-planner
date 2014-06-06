<?php
class Trash_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

    public function Add ($data)
    {
        $this->db->insert('trash', $data);
        $return = $this->db->insert_id();

        return $return;
    }

}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */