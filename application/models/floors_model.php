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

    public function getFloor($id) {
        $this->db->select('*');
        if (!empty($id))
            $this->db->where('id',$id);
        $q =  $this->db->get('_floors');
        return  $q->row();
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

    public function delMarkedFlat ($id)
    {
        if ($this->db->delete('checked_flats', array('id' => $id)))
           return true;
        else
            return false;
    }

    public function update ($plan, $id)
    {
        $this->db->set('plan', $plan);
        $this->db->where('id', $id);
        if ($this->db->update('_floors'))
            return true;
        else
            return false;
    }

    public function updateMarkFlat ($data, $floor, $numb)
    {

        $this->db->where('floor_id', $floor);
        $this->db->where('numb_flat', $numb);
        if ($this->db->update('checked_flats',$data))
            return true;
        else
            return false;
    }

    public function getMarkedFlats ($id,$numb_flat = false)
    {
        $this->db->select('*');
        $this->db->where('floor_id',$id);
        if ($numb_flat)
            $this->db->where('numb_flat',$numb_flat);
        $q =  $this->db->get('checked_flats');
        return  $q->result_array();
    }

    public function markFlat ($data)
    {
        $this->db->insert('checked_flats', $data);
        $return = $this->db->insert_id();
        return $return;
    }
}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */