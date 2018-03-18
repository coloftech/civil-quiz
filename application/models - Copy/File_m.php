<?php 

/**
* 
*/
class File_m extends CI_Model
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}
	public function save_resource_info($title=false,$desc=false,$tags=false)
	{
		# code...

		if ($title) {
			# code...
			$this->db->insert('post',array('title'=>$title,'date_created'=>date('Y-m-d')));
			$id = $this->db->insert_id();
			if ($desc) {

			$this->db->insert('post_content',array('name'=>'description','value'=>$desc,'post_id'=>$id));
			}
			if ($tags) {
				# code...
				if (is_array($tags)) {
					# code...
					foreach ($tags as $key) {
						# code...
					$this->db->insert('post_tags',array('tags'=>$key, 'post_id'=>$id));
					}
				}
			}

			return $id;

		}
		return false;

	}
	public function save_resource($file='')
	{
		# code...

			if ($file) {

			 return $this->db->insert('post_files',$file));

			}
			return false;
	}
}