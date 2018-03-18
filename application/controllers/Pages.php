<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {



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
		 $this->load->model('post_m');
		$this->load->model('admin_m');
		$this->load->model('site_m');
		$this->load->model('pages_m');
	}
	public function index($value='')
	{
		$data['list_pages'] = $this->pages_m->list_pages();
		$data['is_hidden'] = 'hidden';
		$data['site_title'] = 'List pages';
		$this->template->load('admin','admin/pages/list_pages.php',$data);
	}

	public function edit_page($page_id='')
	{
		$data['editform'] = true;


		//if($this->input->get()){
			//$page_id = $this->input->get('id');
			$info = $this->pages_m->getPageById($page_id);

			$data['page_title'] = $info[0]->page_title;
			$data['page_id'] = $info[0]->page_id;
			$data['page_content'] = $info[0]->page_content;
			$data['site_id'] = $info[0]->site_id;
			$data['parent_id'] = $info[0]->parent_id;
			$data['page_title'] = $info[0]->page_title;
		//}

		//var_dump($data);exit();
		$data['hosted_site'] = $this->permission->list_user_sites($this->uid);


		$data['parents'] = $this->pages_m->getParentPages();

		$data['is_hidden'] = 'hidden';
		$data['site_title'] = 'Edit page';
		$this->template->load('admin','admin/pages/edit_page.php',$data);
	}

	public function add_page($value='')
	{
		$data['editform'] = true;
		$data['hosted_site'] = $this->permission->list_user_sites($this->uid);


		$data['parents'] = $this->pages_m->getParentPages();

		$data['is_hidden'] = 'hidden';
		$data['site_title'] = 'Add new page';
		$this->template->load('admin','admin/pages/add_page.php',$data);
	}
	public function get_parent(){
		if($this->input->post()){
			$input = (object)$this->input->post();
			$selected = '';
			if($parents = $this->pages_m->getParentPages(0,$input->opt_site)){

			//var_dump($parents);
			//exit();
				$parent = '<select class="form-control" id="opt_parent" name="opt_parent">';
				foreach ($parents as $key) {
					
					if(isset($input->parent_id)){
						if($key->parent_id == $input->parent_id){
							$selected = ' selected ';
						}
					}
					$parent .= '<option value="'.$key->page_id.$selected .'" >'.$key->page_title.'</option>';
				}
				$parent .= '</select>';

			//echo $parent;
			echo json_encode(array('stats'=>true,'msg'=>$parent));
			}else{

			echo json_encode(array('stats'=>false,'msg'=>'<option value="0">No parent yet</option>'));
			}

		}
	}

	public function save_page($value='')
	{
		if ($this->input->post()) {
			$input = (object) $this->input->post();
			//var_dump($input);
			//exit();
			if(empty($input->opt_parent)){
				echo json_encode(array('stats'=>false,'msg'=>'Parent is required'));
				exit();
			}
			if(empty($input->title)){
				echo json_encode(array('stats'=>false,'msg'=>'Title is required'));
				exit();
			}
			if($this->pages_m->getPage($input->title,$input->opt_site)){

				echo json_encode(array('stats'=>false,'msg'=>'Page Title already exist'));
				exit();
			}
			//var_dump($input->desc);exit();
			if($this->pages_m->save_page(array('page_title'=>$input->title,'site_id'=>$input->opt_site,'parent_id'=>$input->opt_parent,'page_content'=>$input->desc))){
				echo json_encode(array('stats'=>true));
			}else{
				echo json_encode(array('stats'=>false,'msg'=>'Post unsuccessful;'));
			}

		}
	}

	public function update_page($value='')
	{
		if ($this->input->post()) {
			$input = (object) $this->input->post();

			if(empty($input->opt_parent)){
				echo json_encode(array('stats'=>false,'msg'=>'Parent is required'));
				exit();
			}
			if(empty($input->title)){
				echo json_encode(array('stats'=>false,'msg'=>'Title is required'));
				exit();
			}
			if($page = $this->pages_m->getPage($input->title,$input->opt_site)){
				if($page[0]->page_id != $input->page_id){

				echo json_encode(array('stats'=>false,'msg'=>'Page Title already used.'));
				exit();
				}
			}
			//var_dump($input->desc);exit();

			if($this->pages_m->update_page(array('page_title'=>$input->title,'site_id'=>$input->opt_site,'parent_id'=>$input->opt_parent,'page_content'=>$input->desc),$input->page_id)){
				echo json_encode(array('stats'=>true));
			}else{
				echo json_encode(array('stats'=>false,'msg'=>'Post unsuccessful;'));
			}

		}
	}

	public function add_parent(){
		//var_dump($this->input->post());
		if ($this->input->post()) {
			$input = (object) $this->input->post();

			if($this->pages_m->save_parent(array('page_title'=>$input->parent_title,'site_id'=>$input->parent_site_id,'parent_id'=>0))){
				echo json_encode(array('stats'=>true));
			}else{
				echo json_encode(array('stats'=>false,'msg'=>'Post unsuccessful;'));
			}
		}
	}

	public function remove_page()
	{
		if($this->input->post()){
			$input = (object)$this->input->post();
			if($this->pages_m->remove_page($input->page_id)){
				echo json_encode(array('stats'=>true));
				exit();
			}
				echo json_encode(array('stats'=>true));
				exit();
		}

	}


}