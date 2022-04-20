<?php 

class Register_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->database(); 
    } 
    public function insert_otp($email, $otp) 
    {
        try 
        {
        $this->db->where('email', $email);
        $this->db->delete('register_otp'); 
        $this->db->insert('register_otp', array(
            'id' => NULL, 
            'email' => $email, 
            'otp' => $otp, 
            'created_at' => strtotime(date('Y-m-d H:i:s'))
        ));
        return true;
        } 
        catch(Exception $e) 
        {
            return false; 
        } 
    }
    public function get_otp_info($email) 
    {
        $where = array(
            'email' => $email
        ); 
        $row = $this->db->get_where('register_otp', $where)->result_array(); 
        return $row; 
    }
    public function create_user($email, $password) 
    {
        $password = password_hash($password, PASSWORD_DEFAULT); 
        $insertData = array(
            'email' => $email, 
            'password' => $password
        ); 
        try{
            $this->db->insert('users', $insertData); 
            return true; 
        } 
        catch(Exception $e) 
        {
            return false; 
        }
    }
    public function user_exists($email) 
    {
        $whereData = array(
            'email' => $email
        );
        $rowResult = $this->db->get_where('users', $whereData)->result_array();
        if(isset($rowResult[0])) 
        {
            return true; 
        } 
        else 
        {
            return false; 
        }
    }
}