<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->init();

	}
	public function init()
	{
		$this->load->model('site_m');
		$this->load->model('user_m');
		$this->load->model('quiz_m');
		$this->load->model('email_m');
	}

	public function index()
	{
		$data['is_index'] = true;

		$quiz = $this->quiz_m->list_exams();
		
		//print_r($quiz);

		//exit();
		$data['posts'] = $quiz;

		$data['site_path'] = $this->site_m->getSiteName(false,1)[0]->site_path;
		$data['site_title'] = 'Coloftech: Civil Service Exam Review';
		$data['meta_title'] = $data['site_title'];
		$this->template->load(false,'home/index',$data);
	}

	public function login($page='home')
	{
	
		if($this->permission->is_loggedIn()){

			redirect($page);
		}
		$redirect = '';
		if ($this->input->get('redirect')) {
			# code...
			$redirect = urldecode($this->input->get('redirect'));
		}
		if ($redirect == '/index.php/login.html' ||$redirect == '/index.php/login' || $redirect == 'login') {
			# code...
			$redirect = '';
		}


		$data['js_script'] = "
			<script>
				  $('#frmlogin').on('submit',function(){
				    var data = $(this).serialize();
				    $.ajax({
				      type: 'post',
				      dataType: 'json',
				      data: data,
				      url: 'check_login',
				      success: function(res){
				        if(res.stats){

				             $('header').notify(res.msg, { position:\"bottom right\", className:\"success\" }); 

				             setTimeout(function(){
				              window.location = '".base_url($redirect)."';//.reload() = true;
				             },2000);
				             return false;
				          }else{

				             $('header').notify(res.msg, { position:\"bottom right\", className:\"error\" }); 
				          }

				      }
				    });
				    return false;

				  });
				  </script>
		";

		$data['site_path'] = $this->site_m->getSiteName(false,1)[0]->site_path;

		$data['site_title'] = 'Login';
		$this->template->load(false,'site/login',$data);

	}
	public function check_login($value='')
	{
		if ($this->input->post()) {
			$user = $this->input->post('user_name');
			$pass = $this->input->post('user_pass');

			if($is_found = $this->permission->login($user,$pass)){

				echo json_encode(array('stats'=>true,'msg'=>'Login successful.'));
			}else{
				$this->session->userdata['is_logged_in'] = false;
				echo json_encode(array('stats'=>false,'msg'=>'Login unsuccessful.'));

			}



		}
	}
	public function logout($value='')
	{
		$this->permission->logout();
		redirect();
	}

	public function register($value='')
	{
		# code...
		if($this->input->post()){



		}
		$data['to_verify'] = false;
		$_SESSION['to_verify'] = false;
		$data['site_title'] = 'Signup';
		$this->template->load(false,'home/register',$data);
	}

	public function verify($value='')
	{

		//$this->email_m->verify_code('5ad548a8f0fc9','rhoy');
		//exit();

				$data['to_verify'] = true;
				
	    if($this->input->post()){
	    	$object = (object) $this->input->post();
	    	if(!isset($object->verify)){

	    	
	    	if(empty($object->username) || empty($object->mail) || empty($object->pass_word)){

				redirect('register?stats=false');
	    		exit();
	    	}

	        $this->load->model('email_m');
	        $code = uniqid();
			//if($is_verify =
			if($create_user = $this->permission->create_user($object->username,$object->pass_word,0,$object->mail)){
				$data = array(
					'verify_code'=>$code
				);
				$this->user_m->update_user($object->username,$data);
			 	
			 	$this->email_m->verify_email($this->input->post('mail'),$code);
				


				$this->session->set_userdata('username', $object->username);
				$_SESSION['to_verify'] = true;
				redirect('verify?stats=true');
			}

		}else{

			if($this->email_m->verify_code($object->verify,$this->session->userdata('username'))){

				$_SESSION['to_verify'] = false;
				
				redirect('login');
			}else{

				$_SESSION['to_verify'] = true;
				redirect('verify?stats=true&is_verify=false');
				$data['is_verify'] = false;
			}
		}


	    }
	    $data['site_title'] = 'verify account';
	    $this->template->load(false,'home/register',$data);
		
		
	}
}