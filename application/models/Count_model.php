<?php 

class Count_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->database(); 
    } 
    public function get_current_count() 
    {
        $data = $this->db->get_where('current_count', array('id' => 1))->result_array();
        return $data[0]['currentCount']; 
    }
    public function update_current_count($count) 
    {
        $this->db->update('current_count', array('currentCount' => $count), array('id' => 1)); 
    }
}