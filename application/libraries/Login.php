<?php 

class Login{
    protected $CI; 
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('Login_model', 'l_m'); 
        $this->CI->load->library('email'); 
    }
    public function authenticate($email, $password) 
    {
        if($this->CI->l_m->user_exists($email, $password)) 
        {
            return true; 
        } 
        else 
        {
            return false; 
        }
    }
}