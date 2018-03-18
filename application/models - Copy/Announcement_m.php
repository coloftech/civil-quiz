<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Announcement_m extends CI_Model
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}
	public function add_a($data='')
	{
		# code...

        if($data !== null){
        
        $data = $this->escape_str($data);

        $result = $this->db->insert('col_announcement',$data);
            return $result;
        }else{
            return false;
        }

	}

	public function isExist($title=false)
	{
		# code...
		if ($title) {

			$res = '';
			$sql = "SELECT * FROM `col_announcement` WHERE title = ? limit 1";
			$query =  $this->db->query($sql,$title);
			$res = $query->result();
			if(count($res) > 0){
				return $res;
			}else{
				return false;
			}

		}else{
			return false;
		}
	}
}