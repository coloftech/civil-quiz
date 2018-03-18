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

		$this->load->model('admin_m');


		$this->auto_m->free_space();
	}
	public function index($value='')
	{
		$data['display'] = 'none';
		$data['list_user'] = $this->permission->list_user();
		//var_dump($data['list_user']);
		$data['site_title'] = 'User';
		$this->template->load('admin','admin/user/user',$data);
	}
	public function create($value='')
	{

		$data['display'] = 'block';
		$data['site_title'] = 'Create user';
		$this->template->load('admin','admin/user/user',$data);
	}

	public function add_user($value='')
	{
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









# code... end

}