<?php 

/**
* 
*/
class Pages_m extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}

	public function list_pages($site_id=false,$limit=false)
	{
		if($site_id){
		$this->db->select('pages.*,site.site_path')
			->from('pages')
			->join('site','site.site_id = pages.site_id','left');
		$this->db->where(array('pages.site_id'=>$site_id,'pages.page_content <>'=>''));
			if($limit){

			$this->db->limit($limit);
			}

		return $this->db->get()->result();

		}


		$this->db->select('pages.*, site.site_name')
			->from('pages')
			->join('site','site.site_id = pages.site_id','left');
		return $this->db->get()->result();
	}

	public function getParentPages($parent_id=0,$site_id = 0)
	{
		if($site_id != 0){

		return $this->db->get_where('pages',array('parent_id'=>0,'site_id'=>$site_id))->result();

		}else{

		return $this->db->get_where('pages',array('parent_id'=>0))->result();
		}

	}

	public function getPage($title=false,$site_id = 0)
	{
		if($title){

		return $this->db->get_where('pages',array('site_id'=>$site_id,'page_title'=>$title))->result();

		}
		return false;

	}

	public function getPageById($page_id=0,$site_id = 0)
	{
		if($page_id != 0){

		return $this->db->get_where('pages',array('page_id'=>$page_id))->result();

		}
		return false;

	}
	public function save_page($data=false)
	{
		//var_dump($data);exit();
		return $this->db->insert('pages',$data);
	}

	public function update_page($data=false,$page_id= 0)
	{
		//var_dump($data);exit();
			$this->db->where('page_id',$page_id);
		return $this->db->update('pages',$data);
	}

	public function save_parent($data=false)
	{
		if($this->db->get_where('pages',$data)->result()){
			return true;
		}else{

		return $this->db->insert('pages',$data);
		}
	}
	public function is_pageTitle($title='')
	{
		return $this->db->get_where('pages',array('page_title'=>$title))->result();
	}





	public function remove_page($page_id=0)
	{
		
		$this->db->where('page_id',$page_id);
		return $this->db->delete('pages');


	}










}