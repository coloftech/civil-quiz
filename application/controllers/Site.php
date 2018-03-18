<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->init();

	}
	public function init()
	{
		$this->load->model('site_m');
		$this->load->model('user_m');
		$this->load->model('post_m');
		$this->load->model('pages_m');
	}
	public function index()
	{
		$data['is_index'] = true;
		$limit = 5;
		$start = $this->input->get('row') ? $this->input->get('row') : 0;
		$total_rows = count($this->post_m->get_site_post());

		$data['posts'] = $this->post_m->get_site_post(false,$limit,$start);
		$data['pagination'] = $this->paging($total_rows,$limit,$start);
		$data['site_path'] = $this->site_m->getSiteName(false,1)[0]->site_path;

		//echo json_encode($data['posts']);exit();
		$data['site_title'] = 'Bohol Island State University - Bilar Campus';
		$this->template->load(false,'site/index',$data);
	}
	function get_json_post($limit=5,$start=0){

		$limit = 5;
		$start = $this->input->get('row') ? $this->input->get('row') : 0;
		$total_rows = count($this->post_m->get_site_post());

		$data['posts'] = $this->post_m->get_site_post(false,$limit,$start);

		echo json_encode($data['posts']);
	}

	public function paging($total=0,$limit=0,$start=0)
	{
		
						$config['base_url'] = site_url();
			            $config['total_rows']=$total;
			            $config['per_page'] = $limit;			            
				        $choice = $config["total_rows"]/$config["per_page"];
				        $config["num_links"] = floor($choice);             
             
			            $this->pagination->initialize($config);
			                 
			            return $this->pagination->create_links();
	}

	public function subpaging($total=0,$limit=0,$start=0,$page='')
	{
		
						$config['base_url'] = site_url($page);
			            $config['total_rows']=$total;
			            $config['per_page'] = $limit;			            
				        $choice = $config["total_rows"]/$config["per_page"];
				        $config["num_links"] = floor($choice);             
             
			            $this->pagination->initialize($config);
			                 
			            return $this->pagination->create_links();
	}
	public function sites($sites='home'){

		if(empty($sites)){
			$site = $this->site_m->getSiteName(false,1);
		}else{
			if(is_numeric($sites)){
			$site = $this->site_m->getSiteName(false,1);
			}else{

			$site = $this->site_m->getSiteName($sites);
			}
		}
		$siteName = "Coloftech Multiblog";

		if($site){

			$siteName = $site[0]->site_name  ;
			$siteId = $site[0]->site_id ;
			$site_path = $site[0]->site_path ;

				$limit = 5;
				$start = $this->input->get('row') ? $this->input->get('row') : 0;
				$total_rows = count($this->post_m->get_site_post($siteId));

				$data['pagination'] = $this->subpaging($total_rows,$limit,$start,$site_path);

				$data['posts'] = $this->post_m->get_site_post($siteId,$limit,$start);

			//	var_dump($data['posts']);
		//exit();
			}
		$data['site_path'] = $site_path;
		$data['site_title'] = $siteName;
		$data['list_pages'] = $this->pages_m->list_pages($siteId,3);
		$data['sidebar_pages'] = $this->pages_m->list_pages($siteId);

		$this->template->load(false,'site/indexSite',$data);
	}
	
	public function sites_pages($site='',$p=false,$page=''){

		

			$site = $this->site_m->getSiteName($site);
			$siteName = isset($site[0]->site_name) ? $site[0]->site_name : '' ;
			$siteId = isset($site[0]->site_id) ? $site[0]->site_id : 1 ;
			$data['site_path'] = isset($site[0]->site_path) ? $site[0]->site_path : 'home' ;

			$info = $this->uri->segment(2);
			if($info == 'p'){
				$page = urldecode($this->uri->segment(3));

				if($sitesetting = $this->site_m->getSettings($page,$siteId)){

				$data['about'] = $sitesetting[0]->page_content;

				$info_v = 'site/settingInfo';

				$siteName = urldecode($page);

			}

		}

		$data['page'] = $page;
		$this->template->load(false,'site/settingInfo',$data);
	}
	public function read($page='home',$info='')
	{	

		if(!empty($info)){
				if(!empty($info)){

					if($site_id =  $this->site_m->getSiteId($page)){

						$info = $this->post_m->get_postBySlug($info,$site_id);
						$data['sidebar_pages'] = $this->pages_m->list_pages($site_id);

					}
				}
			}
			else{
				return false;
		}
		if(is_array($info)){
			$data['site_title'] = $info[0]->post_title;
			$data['post'] = $info;
		}else{
			$data['site_title'] = 'Read post';
		}
		$data['site_path'] = $page;

		if($info){

		$data['link'] = site_url(''.$page.'/'.$info[0]->slug);
		$data['meta_title'] = $info[0]->post_title;
		$data['description'] = $this->auto_m->limit_300($info[0]->post_content);
		$data['featured_image'] = $this->post_m->get_featuredImg($info[0]->post_id);
		$cat = '';
		if($category = $this->post_m->get_categories($info[0]->post_id)){
		$cats = '';
			foreach ($category as $ca) {
				$cats[] = $ca->cat_name;
			}
			$cat = implode(',', $cats);
		}
		$dkeywords = $this->post_m->get_tagsById($info[0]->post_id);
		$tags=array();
		foreach ($dkeywords as $key) {
			$tags[] = $key->keyword;
		}
		$data['keywords'] = implode(',', $tags).','.$cat;
		}


		$this->template->load(false,'site/read',$data);

	}

	public function login($page='home')
	{
	
		if($this->permission->is_loggedIn()){

			redirect($page);
		}

		$data['js_script'] = "
			<script>
				  $('#frmlogin').on('submit',function(){
				    var data = $(this).serialize();
				    $.ajax({
				      type: 'post',
				      dataType: 'json',
				      data: data,
				      url: 'site/check_login',
				      success: function(res){
				        if(res.stats){

				             $('header').notify(res.msg, { position:\"bottom right\", className:\"success\" }); 

				             setTimeout(function(){
				              window.location.reload() = true;
				             },2000);
				             return false;
				          }else{

				             $('header').notify(res.msg, { position:\"bottom right\", className:\"error\" }); 
				          }

				      }
				    });
				    return false;

				  });
				  </script>
		";

		$data['site_path'] = $this->site_m->getSiteName(false,1)[0]->site_path;

		$data['site_title'] = 'Login';
		$this->template->load(false,'site/login',$data);

	}
	public function check_login($value='')
	{
		if ($this->input->post()) {
			$user = $this->input->post('user_name');
			$pass = $this->input->post('user_pass');

			if($is_found = $this->permission->login($user,$pass)){

				echo json_encode(array('stats'=>true,'msg'=>'Login successful.'));
			}else{
				$this->session->userdata['is_logged_in'] = false;
				echo json_encode(array('stats'=>false,'msg'=>'Login unsuccessful.'));

			}



		}
	}
	public function logout($value='')
	{
		$this->permission->logout();
		redirect();
	}

	public function search($site='home',$q=''){
		
		$data['site_path'] = $this->site_m->getSiteName(false,1)[0]->site_path;
		if($q = $this->input->get('q')){

			if(!empty($q)){

				$q = $this->slug->removecommon($q);

				$keys = array_filter(explode(' ', $q));
				
				$result = '';
				foreach ($keys as $q) {
					
				$result[] = $this->post_m->post_search(false,false,false,$q);
					
				}
				
					$posted_id = array();
					$list_post = false;
					$i = 0;
					if(!empty($result)){

						if (is_array($result)) {
							# code...		
							foreach ($result as $key) {
							
								foreach ($key as $obj) {
									# code...
									if(in_array($obj->post_id,$posted_id)){

									}else{

										$list_post[] = $obj;
										$posted_id[] = $obj->post_id;

										}
								}
								$i++;
						}
						}
					}

			}
		}


		$data['posts'] = isset($list_post) ? $list_post : '';

		//var_dump($list_post);
		//exit();

		$data['site_title'] = 'Search post';
		$this->template->load(false,'site/search',$data);
	}



}
