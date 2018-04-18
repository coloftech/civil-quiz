<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends CI_Controller {



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

		$this->load->model('admin_m');
		$this->load->model('site_m');
		//$this->load->model('post_m');
		//$this->load->library('visitors');
	}
	public function index($value='')
	{
		$data['isadmindashboard'] =  true;
		$data['site_title'] =  'Administration';
		
		$this->template->load('admin','admin/index',$data);
	}
	public function create_zip()
	{

    // Load the DB utility class
    $this->load->dbutil();

    // Backup your entire database and assign it to a variable
    $backup =& $this->dbutil->backup();

    $fileName = 'civil-quiz-backup-'.date('Y-m-d H:i:s').'.zip';
    // Load the file helper and write the file to your server
    $this->load->helper('file');
    write_file(UPLOADPATH.'/admin/'.$fileName, $backup);

    // Load the download helper and send the file to your desktop
    $this->load->helper('download');
    force_download($fileName, $backup);

	}

	function import_dump($folder_name = null , $file_name) {
		$folder_name = 'dumps';
		$path = 'assets/backup_db/'; // Codeigniter application /assets
		$file_restore = $this->load->file($path . $folder_name . '/' . $file_name, true);
		$file_array = explode(';', $file_restore);
			foreach ($file_array as $query)
			 {
			 $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
			 $this->db->query($query);
			 $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
			 }
	}
	
}