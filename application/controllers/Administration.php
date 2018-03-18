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
			 if (!$this->permission->is_loggedIn()){
		 	redirect();
		 }
		 $this->uid = $this->session->userdata['id'];
		 $this->username = $this->session->userdata['username'];

		$this->load->model('admin_m');
		$this->load->model('site_m');
		$this->load->model('post_m');
		$this->load->library('visitors');


		$this->auto_m->free_space();
	}
	public function index($value='')
	{
		# code...

		$visitor = '';
		$today = date('Y-m-d');

		$oneweek = date('Y-m-d',strtotime('- 7 days')) ;
		/*/exit();
		//$oneweek = date('d',$oneweek);
		for ($i=1; $i <= 7 ; $i++) { 
			//echo "<br />";
			$date = date('Y-m-d', strtotime("+".$i." day", strtotime($oneweek)));
			
			if($count = $this->visitors->visits($date)){

			$visitor[] =  array('day'=>$date,'visit'=>$count);
			}else{

			$visitor[] =  array('day'=>$date,'visit'=>0);
			}
		}

		$day = '';
		$visits = '';
		foreach ($visitor as $key) {
			$day[] = $key['day'];
			$visit[] = (int)$key['visit'];
		}
		/*$total_post = $this->post_m->total_post();
		$today_visit = $this->visitors->visits($today);
		$total_visitors = $this->visitors->total_visitors();
		$unique_visitors = $this->visitors->unique_visitors();
		$data = array(
 
		    'isadmindashboard' => true,
		    'site_title' => 'Administration',
		    'day'=>$day,
		    'visit'=>$visit,
		    'total_post'=>	$total_post,
		    'today_visit'=>	$today_visit,
		    'total_visitors'=>	$total_visitors,
		    'unique_visitors'=>	$unique_visitors	     
		);
		*/
		$data['isadmindashboard'] =  true;
		$data['site_title'] =  'Administration';
		
		$this->template->load('admin','admin/index',$data);
	}
	public function sites($value='')
	{
		$is_display = 'none';
		if($this->input->get('a')){

		$is_display = 'block';
		}
		$data['is_display'] = $is_display;
		$site_ids = $this->permission->list_user_sites($this->uid);
		$site_id = $site_ids[0]->site_id;

		$data['users'] = $this->permission->list_user();
		$data['site_category'] = $this->site_m->getSiteCategory();
		$data['hosted_site'] = $this->admin_m->hosted_sites();
		$data['site_title'] = 'Hosted Site';
		$this->template->load('admin','admin/hostedSites',$data);
	}
	public function add_site($value='')
	{
		if ($this->input->post()) {
			$input =(object) $this->input->post();

			if(empty($input->site_path)){
				$path = $this->slug->create($input->site_name);
			}else{
				$path = $input->site_path;
			}

			$is_added = $this->admin_m->save_site($input->site_name,$path,$input->category);
		}
		redirect('c=administration&f=sites');
	}

	public function add_site_user($user_id=0,$site_id=0)
	{
		$this->permission->allow_user($user_id,$site_id);

	}
		public function create_zip()
	{

    // Load the DB utility class
    $this->load->dbutil();

    // Backup your entire database and assign it to a variable
    $backup =& $this->dbutil->backup();

    $fileName = 'db-backup-'.$this->username.'-'.date('Y-m-d-h-m-s').'.zip';
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