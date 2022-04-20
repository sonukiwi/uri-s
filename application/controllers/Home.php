<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('register');
		$this->load->library('login');
		$this->load->library('common');
		$this->load->model('Register_model', 'r_m');
		$this->load->model('Count_model', 'c_m');
		$this->load->library('session');
		$this->load->model('Url_model', 'u_m');
		$this->load->model('Login_model', 'l_m');
		//$this->load->library('login');
		$this->email->set_newline("\r\n");
	}
	public function index($num = 0)
	{
		if ($this->session->has_userdata('email')) {
			redirect(base_url() . 'dashboard');
		} else {
			$header['title'] = "URL Shortener And Management Tool";
			$this->load->view('home_page');
		}
	}
	public function register_validation()
	{
		if (!$this->input->is_ajax_request()) {
			echo "No direct script access allowed";
			die;
		} else {
			if ($this->input->post()) {
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$this->form_validation->set_rules('email', 'Email', 'required');
				$this->form_validation->set_rules('password', 'Password', 'required');
				if ($this->form_validation->run() == false) {
					echo json_encode(array(false, "Form validation failed"));
					die;
				} else {
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						echo json_encode(array(false, "Email not valid."));
						die;
					} else if (strlen($password) < 8) {
						echo json_encode(array(false, "Password not valid."));
						die;
					} else {
						$userExists = $this->r_m->user_exists($email);
						if ($userExists) {
							echo json_encode(array(false, "Email already exists."));
							die;
						}
						if ($this->register->send_otp($email)) {
							echo json_encode(array(true, "An OTP has been sent to your email id."));
							die;
						} else {
							echo json_encode(array(false, "Some error occured"));
							die;
						}
					}
				}
			}
		}
	}
	public function login_validation()
	{
		if (!$this->input->is_ajax_request()) {
			echo "No direct script access allowed";
			die;
		} else {
			if ($this->input->post()) {
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$this->form_validation->set_rules('email', 'Email', 'required');
				$this->form_validation->set_rules('password', 'Password', 'required');
				if ($this->form_validation->run() == false) {
					echo json_encode(array(false, "Form validation failed"));
					die;
				} else {
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						echo json_encode(array(false, "Email not valid."));
						die;
					} else if (strlen($password) < 8) {
						echo json_encode(array(false, "Password not valid."));
						die;
					} else {
						$userExists = $this->r_m->user_exists($email);
						if ($userExists) {
							if ($this->login->authenticate($email, $password)) {
								$this->session->set_userdata('email', $email);
								echo json_encode(array(true, "You are logged in. Redirecting to dashboard"));
								die;
							} else {
								echo json_encode(array(false, "Entered password is incorrect"));
								die;
							}
						} else {
							echo json_encode(array(false, "Email id is not registered"));
							die;
						}
					}
				}
			}
		}
	}
	public function verify_otp()
	{
		if (!$this->input->is_ajax_request()) {
			echo "No direct script access allowed";
			die;
		} else {
			if ($this->input->post()) {
				$data = $this->input->post();
				if (!$data['email'] || !$data['password'] || !$data['otp']) {
					echo json_encode(false);
					die;
				}
				if ($this->common->verify_otp($data)) {
					if ($this->register->save_user($data['email'], $data['password'])) {
						echo json_encode(true);
						die;
					} else {
						echo json_encode(false);
						die;
					}
				} else {
					echo json_encode(false);
					die;
				}
			}
		}
	}




	public function forgot_password_verify_otp()
	{
		if (!$this->input->is_ajax_request()) {
			echo "No direct script access allowed";
			die;
		} else {
			if ($this->input->post()) {
				$data = $this->input->post();
				if (!$data['email'] || !$data['otp']) {
					echo json_encode(array(false, "Please fill in required fields."));
					die;
				}
				if ($this->common->verify_otp($data)) {
					$newPassword = rand(11111111,99999999); 
					$this->l_m->update_user_password($data['email'], $newPassword); 
					echo json_encode(array(true, $newPassword));
					die;
				} else {
					echo json_encode(array(false, "Entered OTP is invalid"));
					die;
				}
			}
		}
	}




	public function dashboard($page = 1)
	{
		if ($this->session->has_userdata('email')) {
			if ($page == 0 || $page < 0) {
				redirect(base_url() . 'dashboard/1');
			}
			$data = array();
			$data = $this->u_m->get_urls_info($this->session->userdata('email'), $page);
			$dataTotalCount = $this->u_m->get_all_urls_count($this->session->userdata('email'));
			$lastPage = null;
			if ($dataTotalCount % 5 == 0) {
				$lastPage = $dataTotalCount / 5;
			} else {
				$lastPage = intdiv($dataTotalCount, 5) + 1;
			}
			if ($dataTotalCount == 0) {
				$this->load->view('dashboard', array('data' => $data, 'count' => $dataTotalCount, 'page' => $page, 'lastPageNumber' => $lastPage));
			} else if (($dataTotalCount % 5 == 0) && (($dataTotalCount / 5) < $page)) {
				$this->load->view('errors/html/error_404');
			} else if (($dataTotalCount / 5 + 1) < $page) {
				$this->load->view('errors/html/error_404');
			} else {
				$this->load->view('dashboard', array('data' => $data, 'count' => $dataTotalCount, 'page' => $page, 'lastPageNumber' => $lastPage));
			}
		} else {
			redirect(base_url());
		}
	}
	function url_exists($url)
	{
		return curl_init($url) !== false;
	}
	public function generate_short_url()
	{
		if ($this->session->has_userdata('email')) {
			if (!$this->input->is_ajax_request()) {
				echo "No direct script access allowed here";
				die;
			} else {
				if ($this->input->post()) {
					$postData = $this->input->post();
					$url = $postData['url'];
					$description = $postData['description'];
					$this->form_validation->set_rules('url', 'URL', 'required');
					if ($this->form_validation->run() == false) {
						echo json_encode(array(false, "Something went wrong. Please try again."));
						die;
					}
					if (!filter_var($url, FILTER_VALIDATE_URL)) {
						echo json_encode(array(false, "Something went wrong. Please try again."));
						die;
					}
					if ($this->u_m->url_exists_for_email($this->session->userdata('email'), $url)) {
						echo json_encode(array(false, "You have already shorted this URL"));
						die;
					}
					$currentCount = $this->c_m->get_current_count();
					$shortUrl = base_url() . 'u/' . $currentCount;
					$createdBy = $this->session->userdata('email');
					if ($this->u_m->insert_record($url, $shortUrl, 0, $createdBy, 1, $description)) {
						$this->c_m->update_current_count($currentCount + 1);
						echo json_encode(array(true, $shortUrl));
						die;
					} else {
						echo json_encode(array(false, "Something went wrong. Please try again."));
						die;
					}
				}
			}
		}
	}
	public function change_status()
	{
		if ($this->session->has_userdata('email')) {
			if (!$this->input->is_ajax_request()) {
				echo "No direct script access allowed";
				die;
			} else {
				if ($this->input->post()) {
					$postData = $this->input->post();
					$id = $postData['id'];
					if ($this->u_m->change_status($id)) {
						echo json_encode(array(true, "Status Changed Successfully"));
						die;
					} else {
						echo json_encode(array(false, "Some Error Occured"));
						die;
					}
				}
			}
		}
	}
	public function u($num = 0)
	{
		$shortUrl = base_url() . 'u/' . $num;
		if (!$this->u_m->short_url_exists($shortUrl)) {
			echo "Entered URL is invalid";
			die;
		}
		if ($this->u_m->is_active($shortUrl)) {
			$actualUrl = $this->u_m->get_actual_url($shortUrl);
			$this->u_m->increment_count($shortUrl);
			redirect($actualUrl);
			die;
		} else {
			echo "Url is not active";
			die;
		}
	}
	public function search()
	{
		if ($this->session->has_userdata('email')) {
			$queryString = $this->input->get('q');
			$resultDataFromQueryString = $this->u_m->search_data($queryString, $this->session->userdata('email'));
			$allUrls = $this->u_m->get_urls_by_email($this->session->userdata('email')); 
			$minId = $this->u_m->get_minimum_id(); 
			for($i=0;$i<count($resultDataFromQueryString);$i++) 
			{
				$tempCount = 0; 
				for($j=0;$j<count($allUrls);$j++) 
				{
					$tempCount++; 
					if($allUrls[$j]['id'] == $resultDataFromQueryString[$i]['id'])
					{
						break; 
					}
				}
				$tempId = $tempCount;  
				$page = 1; 
				if($tempId % 5 == 0) 
				{
					$page = intdiv($tempId, 5); 
				}  
				else 
				{
					$page = intdiv($tempId, 5)+1; 
				} 
				$resultDataFromQueryString[$i]['url'] = base_url().'dashboard/'.$page;
			}
			$this->load->view('search', array('data' => $resultDataFromQueryString, 'min_id' => $minId));
		}
	}
	public function change_password()
	{
		if ($this->session->has_userdata('email')) {
			if (!$this->input->is_ajax_request()) {
				echo "No direct script access allowed";
				die;
			} else {
				if ($this->input->post()) {
					$postData = $this->input->post();
					$email = $this->session->userdata('email'); 
					$currentPassword = $postData['current_password'];
					$newPassword = $postData['new_password'];
					$this->form_validation->set_rules('current_password', 'current_password', 'required|min_length[8]');
					$this->form_validation->set_rules('new_password', 'new_password', 'required|min_length[8]');
					if ($this->form_validation->run() == false) {
						echo json_encode(array(false, "Something went wrong, please try again."));
						die;
					} else {
						$this->load->model('Login_model', 'l_m');
						$credentialsAreCorrect = $this->l_m->user_exists($email, $currentPassword);
						if (!$credentialsAreCorrect) {
							echo json_encode(array(false, "Please Enter correct current password"));
							die;
						} 
						if(!$this->l_m->update_user_password($email, $newPassword)) 
						{
							echo json_encode(array(false, "Database error occured")); 
							die;
						} 
						echo json_encode(array(true, "Password updated successfully. Please Login again.")); 
						die;
					}
				}
			}
		}
	}
	public function forgot_password() 
	{
		$this->load->model('Login_model', 'l_m'); 
			if(!$this->input->is_ajax_request()) 
			{
				echo "Direct script access is not allowed here"; 
				die;
			} 
			else 
			{
				if($this->input->post()) 
				{
					$postData = $this->input->post(); 
					$email = $postData['email']; 
					$this->form_validation->set_rules('email', 'email', 'required|valid_email'); 
					if($this->form_validation->run() == false) 
					{
						echo json_encode(array(false, "Something went wrong. Please try again.")); 
						die;
					}
					if($this->l_m->email_exists($email)) 
					{
						if($this->register->send_otp($email)) 
						{
							echo json_encode(array(true, "An OTP has been sent to your email id.")); 
							die;
						} 
						else 
						{
							echo json_encode(array(false, "An error occured while sending OTP.")); 
							die;
						}
					} 
					else 
					{
						echo json_encode(array(false, "Email id is not registered")); 
						die;
					}
				}
			}
	}
	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
