<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class User_m extends CI_Model
{

public function user($user=false,$pass=false)
{
	if ($user && $pass) {


		$query =  $this->db->get_where('users',array('user_name'=>$user,'user_pass'=>$pass));
		return $query->result();


	}
	return false;

}




}