<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public $uid;
	public $username;

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{

		 if (!$this->permission->is_loggedIn()){
		 	redirect();
		 }
		 $this->uid = $this->session->userdata['id'];
		 $this->username = $this->session->userdata['username'];

		$this->load->model('category_m');
		$this->load->model('quiz_m');
		$this->load->model('user_m');
		$this->load->model('Userexam_m');
		$this->load->model('email_m');

	}
	public function index($value='')
	{

		$quiz = $this->quiz_m->list_exams();
		$data['lists'] = $quiz;


		$ratings = $this->Userexam_m->best_rating($this->uid);
		//var_dump($ratings);exit();
		$data['ratings'] = $ratings;

		$data['profile'] = $this->user_m->info($this->uid);

		$data['site_title'] = 'My account';
		$this->template->load(false,'user/index',$data);
	}
	public function create($value='')
	{

			 if (!$this->permission->is_loggedIn() || !$this->permission->is_admin()){
		 	redirect();
		 }
		$data['display'] = 'block';
		$data['site_title'] = 'Create user';
		$this->template->load('admin','admin/user/user',$data);
	}

	public function add_user($value='')
	{
			 if (!$this->permission->is_loggedIn() || !$this->permission->is_admin()){
		 	redirect();
		 }
		$this->email_m->verify_email('test@mail.com','sfijfifksifsfwef');
		exit();
		if($this->input->post()){
			$input = (object)$this->input->post();
			if(!empty($input->username) && !empty($input->password)){
				if($user = $this->permission->create_user($input->username,$input->password,0,$input->email)){
					echo json_encode(array('stats'=>true,'msg'=>'User successfully added'));
				}

			}else{
				echo json_encode(array('stats'=>false,'msg'=>'No input'));
			}
		}
	}
	public function change_pass()
	{
		if ($this->input->post()) {
			$input = (object) $this->input->post();

			if($update = $this->permission->update_user($this->username,$input->password,0,$input->email)){
				echo "Password change.";
				redirect('c=user');
			}else{
				echo "No action done.";
				redirect('c=user');
			}
		}
		$data['site_title'] = 'Change password';
		$this->template->load('admin','admin/user/change_pass',$data);
	}
	public function info($user_id='')
	{
		# code...
		
	}









# code... end

}