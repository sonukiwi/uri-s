<?php
class Common
{
    protected $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Register_model', 'r_m');
    }
    public function verify_otp($data)
    {
        $currentTime = strtotime(date('Y-m-d H:i:s'));
        $otpInfo = $this->CI->r_m->get_otp_info($data['email']);
        if (!$otpInfo) {
            return false;
        }
        $otpInfo = $otpInfo[0];
        if (($otpInfo['created_at'] + 60) < $currentTime) {
            return false;
        } else {
            if ($data['otp'] == $otpInfo['otp']) {
                return true;
            } else
                return false;
        }
    }
}
