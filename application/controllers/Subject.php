<?php 

/**
* 
*/
class Subject extends CI_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
		$this->init();
	}
	public function init($value='')
	{
			 if (!$this->permission->is_loggedIn() || !$this->permission->is_admin()){
		 	redirect();
		 }
		# code...
	}
	public function index($value='')
	{
		# code...
		echo "List all";
	}
	public function create($value='')
	{
		# code...
	}
}