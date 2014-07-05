<?php
class Flats_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

    public function getFlats($block_id = false) {
        $this->db->select('*');
        if (!empty($block_id))
            $this->db->where('block_id',$block_id);
            $this->db->order_by("numb_flat", "ASC");
        $q =  $this->db->get('_flats');
        return  $q->result_array();
    }

    public function getNumbFlat($numb_flat,$block_id = false) {
        $this->db->select('*');
        $this->db->where('numb_flat',$numb_flat);
        if (!empty($block_id))
        $this->db->where('block_id',$block_id);
        $q =  $this->db->get('_flats');
        return  $q->row();
    }
    public function getFlatToId($id) {
        $this->db->select('*');
        $this->db->where('id',$id);
        $q =  $this->db->get('_flats');
        return  $q->row_array();
    }

    public function addFlat ($data)
    {
        $this->db->insert('_flats', $data);
        $return = $this->db->insert_id();
        return $return;
    }

    public function updateFlat ($data, $id)
    {

        $this->db->where('id', $id);
        if ($this->db->update('_flats',$data))
            return true;
        else
            return false;
    }

    public function addFlatBatch ($data)
    {
       if ($this->db->insert_batch('_flats', $data))
           return true;
       else
           return false;
    }

    public function deleteFlat ($id)
    {
        if ($this->db->delete('_flats', array('id' => $id)))
            //$return = $this->db->affected_rows() == 1;
            return true;
        else
            return false;
    }

    public function deleteAll ()
    {
        if ($this->db->empty_table('_flats'))
            //$return = $this->db->affected_rows() == 1;
            return true;
        else
            return false;
    }
}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */