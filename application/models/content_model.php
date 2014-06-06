<?php
class Content_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getList($type=false, $search=false) {
        $this->db->select('*');
        if (!empty($type))
            $this->db->where('type',$type);
        if (!empty($search))
        {
            $this->db->like('h1',$search);
            $this->db->or_like('alias',$search);
            $this->db->or_like('title',$search);
            $this->db->or_like('content',$search);
            $this->db->or_like('meta_description',$search);
            $this->db->or_like('meta_keywords',$search);

        }


        $q =  $this->db->get('content');
        return  $q->result_array();
	}



	public function getType() {
		$q = $this->db;
		$this->sql = "SELECT * FROM `type_content`";
		$q = $q->query($this->sql);
		return $q->result();
	}

    public function get($page) {
		$q = $this->db;
		$this->sql = "
			SELECT * FROM content WHERE alias = '".$page."' and enabled = 1
		";
		$q = $q->query($this->sql);
		return $q->row();
	}

    public function getToId($id) {
        $q = $this->db;
        $this->sql = "
			SELECT * FROM content WHERE id = '".$id."'
		";
        $q = $q->query($this->sql);
        if ($q->num_rows() > 0)
            return $q->row();

        return false;
    }

    public function getToAlias($alias) {
        $q = $this->db;
        $this->sql = "
			SELECT * FROM content WHERE alias = '".$alias."'
		";
        $q = $q->query($this->sql);
        if ($q->num_rows() > 0)
            return $q->row();

        return false;
    }

    public function Add ($data)
    {
        $this->db->insert('content', $data);
        $return = $this->db->insert_id();

        return $return;
    }

    public function Update ($id, $data)
    {
       if ($this->db->update('content', $data, array('id' => $id)))
        //$return = $this->db->affected_rows() == 1;
            return true;
        else
            return false;
    }

	public function get_all_langs() {
		
	}

	public function delete($id)
    {
        if ($this->db->delete('content', array('id' => $id)))
            //$return = $this->db->affected_rows() == 1;
            return true;
        else
            return false;
	}

}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */