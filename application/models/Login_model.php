<?php 

class Login_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->database();
    }
    public function user_exists($email, $password) 
    {
        $whereData = array(
            'email' => $email
        );
        $rowResult = $this->db->get_where('users', $whereData)->result_array();
        if(isset($rowResult[0])) 
        {
            if(password_verify($password, $rowResult[0]['password'])) 
            {
                return true; 
            } 
            else 
            {
                return false; 
            }
        } 
        else 
        {
            return false; 
        }
    }
    public function update_user_password($email, $password) 
    {
        try{
            $this->db->update('users', array('password' => password_hash($password, PASSWORD_DEFAULT)), array('email' => $email));
            return true; 
        } 
        catch(Exception $e) 
        {
            return false; 
        }
    }
    public function email_exists($email) 
    {
        $data = $this->db->get_where('users', array('email' => $email), 1)->result_array(); 
        return count($data) >= 1; 
    }
}