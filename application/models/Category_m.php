<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Category_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	public function get_Categories($value='')
	{

		return $this->db->order_by('cat_name','ASC')->get('category')->result();
	}
}