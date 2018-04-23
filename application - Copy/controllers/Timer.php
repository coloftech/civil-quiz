<?php

/**
* 
*/
class Timer extends CI_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}
	public function index($value='')
	{
		# code...
	}
	public function start($value='')
	{
		# code...

		$timer_start = time();
		$_SESSION['timer'] = $timer_start;

		print_r($timer_start);

	}
	public function pause($value='')
	{
		# code...

		$timer_start = time();

		$elapse = $this->timerlapse(true);
		$_SESSION['elapse'] = $elapse;

		$_SESSION['timer'] = 0; //$timer_start - $elapse;

		print($elapse);

	}
	public function continue_timer($value='')
	{
		# code...

		$timer_start = time();
		$elapse = $this->session->elapse;
		$new_timer = $timer_start - $elapse;;

		$_SESSION['timer'] = $new_timer;

		echo $elapse;

	}
	public function timerlapse($timer=false)
	{

		$timer_start = $this->session->timer;
		$current_time = time();
		$elapse = $current_time - $timer_start ;

		if($timer){
			$timer = false;
			return $elapse;
		}else{

			echo $elapse;
		}
	}
}