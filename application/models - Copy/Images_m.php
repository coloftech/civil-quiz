<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Images_m extends CI_Model
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}
	public function get_featured_img($id=0)
	{
		# code...
		if($id > 0){

		$this->db->select('url')->from('col_images')->where('page_id',$id);
		$result = $this->db->get()->result();
		if (count($result) > 0) {
			# code...
		return $result[0]->url;
		}
		return false;
		}
		return false;


	}
}