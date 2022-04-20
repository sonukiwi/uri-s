<?php 

class Url_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->database(); 
    } 
    public function get_urls_info($email, $count) 
    {
        $urlsInfo = $this->db->get_where('urls', array('created_by' => $email), 5, 5*($count-1))->result_array(); 
        return $urlsInfo; 
    }
    public function get_urls_by_email($email) 
    {
        $urlsInfo = $this->db->get_where('urls', array('created_by' => $email))->result_array(); 
        return $urlsInfo; 
    }
    public function get_all_urls_count($email) 
    {
        return count($this->db->get_where('urls', array('created_by' => $email))->result_array()); 
    }
    public function insert_record($actualUrl, $shortUrl, $clicks, $createdBy, $status, $description) 
    {
        try {
            $dataArray = array(
                'actual_url' => $actualUrl, 
                'short_url' => $shortUrl, 
                'clicks' => $clicks, 
                'created_by' => $createdBy, 
                'status' => $status, 
                'description' => $description
            ); 
            $this->db->insert('urls', $dataArray); 
            return true; 
        } 
        catch(Exception $e) 
        {
            return false; 
        }
    }
    public function url_exists($url) 
    {
        $data = $this->db->get_where('urls', array('actual_url' => $url), 1)->result_array();
        return count($data) == 1; 
    }
    public function url_exists_for_email($email, $url) 
    {
        $data = $this->db->get_where('urls', array('actual_url' => $url, 'created_by' => $email), 1)->result_array();
        return count($data) == 1; 
    }
    public function search_data($queryString, $email) 
    {
        return $this->db->query("SELECT * from urls where created_by = '$email' AND description like '%$queryString%'")->result_array();
    }
    public function short_url_exists($url) 
    {
        $data = $this->db->get_where('urls', array('short_url' => $url), 1)->result_array();
        return count($data) == 1; 
    }
    public function change_status($id) 
    {
        $currentStatus = $this->db->get_where('urls', array('id' => $id))->result_array(); 
        $currentStatus = $currentStatus[0]['status']; 
        try {
        if($currentStatus == 1) 
        {
            $this->db->update('urls', array('status' => 0), array('id' => $id)); 
        } 
        else 
        {
            $this->db->update('urls', array('status' => 1), array('id' => $id)); 
        } 
        return true; 
        }
        catch(Exception $e) 
        {
            return false; 
        }
    }
    public function is_active($shortUrl) 
    {
        return $this->db->get_where('urls', array('short_url' => $shortUrl))->result_array()[0]['status']; 
    } 
    public function get_actual_url($shortUrl) 
    {
        return $this->db->get_where('urls', array('short_url' => $shortUrl))->result_array()[0]['actual_url']; 
    } 
    public function increment_count($shortUrl) 
    {
        $count = $this->db->get_where('urls', array('short_url' => $shortUrl))->result_array()[0]['clicks'];
        $count++;  
        $this->db->update('urls', array('clicks' => $count), array('short_url' => $shortUrl)); 
    }
    public function get_minimum_id() 
    {
        $data = $this->db->query("SELECT min(id) as min_id from urls")->result_array()[0];
        return $data['min_id'];
    }
}