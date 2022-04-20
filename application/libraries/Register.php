<?php 
class Register{
    protected $CI; 
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('Register_model', 'r_m'); 
        $this->CI->load->library('email'); 
    }
    public function send_email($to, $subject, $message) 
    {
        $this->CI->email->from('sonumohammad185@gmail.com', 'URL Shortener Team');
		$this->CI->email->to($to);
		$this->CI->email->subject($subject);
		$this->CI->email->message($message);
		$this->CI->email->send(); 
    }
    public function send_otp($email)
    { 
        $otp = rand(1000, 9999); 
        $message = "Your otp for verification is " . $otp; 
        $message = $message . "\n This is valid only for 1 minute"; 
        $this->send_email($email, 'OTP verification from URIS', $message);
        if($this->CI->r_m->insert_otp($email, $otp)) 
        {
            return true; 
        } 
        else 
        {
            return false; 
        }
    }
    public function save_user($email, $password) 
    {
        if($this->CI->r_m->create_user($email, $password)) 
        {
            return true; 
        } 
        else 
        {
            return false; 
        }
    }
}