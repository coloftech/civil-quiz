<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {



	public $uid;
	public $username;
	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init($value='')
	{
			 if (!$this->permission->is_loggedIn() || !$this->permission->is_admin()){
		 	redirect();
		 }
		 $this->uid = $this->session->userdata['id'];
		 $this->username = $this->session->userdata['username'];
		 $this->load->model('post_m');
		$this->load->model('admin_m');
		$this->load->model('site_m');
	}
	public function index($value='')
	{

		$data['hosted_site'] = $this->permission->list_user_sites($this->uid);
		$site = $this->site_m->getallSettings();
		//var_dump($site);
		$data['about_settings'] = $this->site_m->getaboutSettings();
		$data['services_settings'] = $this->site_m->getservicesSettings();
		$data['site_title']='Site settings';
		$this->template->load('admin','admin/settings/setting_index.php',$data);
	}



}