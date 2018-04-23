<?php 
/**
* 
*/
class Guest extends CI_Controller
{

	public $uid = 0;
	public $username = 'Guest';
	public $salt = '_salt-';
	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init($value='')
	{
		if($this->permission->is_loggedIn()){

		$this->uid = $this->session->userdata['id'];
		$this->username = $this->session->userdata['username'];
		}

		$this->load->model('category_m');
		$this->load->model('quiz_m');
		$this->load->model('user_m');
		$this->load->model('Userexam_m');
		$this->load->model('exam_m');
	}
	public function index($value='')
	{
		# code...
		redirect();
	}
	public function exam($exam_id=0)
	{
		# code...

		if(!$this->permission->is_loggedIn()){
			//redirect('login');
			//echo "Create account";
				        $this->load->model('email_m');
	        $code = uniqid();
			//if($is_verify =
			$guest_username = 'guest'.mt_rand(10,1000);

			$pass = md5($this->salt.$guest_username);

			if($create_user = $this->permission->create_user($guest_username,$pass,0)){
				$data = array(
					'verify_code'=>$code
				);
				$this->user_m->update_user($guest_username,$data); 
				
				$this->permission->login($guest_username, $pass);

				redirect(base_url($_SERVER['REQUEST_URI']));
				
			}else{

			}

		}

			$info = false;
			$categories=false;

		if($exam_id){
			$info = $this->exam_m->getExamById($exam_id);
			
				if($category = $this->exam_m->getExamCategories($exam_id)){
					foreach ($category as $key) {
						# code...
						$categories[] = $key->category_id;

					}
				}



			$_SESSION['user_exam_id'] = false;
			$_SESSION['category_id'] = false;
			$_SESSION['exam_id'] = $exam_id;
			$_SESSION['categories'] = false;
			if(!$this->session->LAST_ACTIVITY){

			$_SESSION['LAST_ACTIVITY'] = false;
			}
		}

		$data['exam'] = $info;
		$data['categories'] = (is_array($categories)) ? implode(',', $categories) : false;
		$data['exam_id'] = $exam_id;
		$data['site_title'] = 'Take exam as guest';

		$this->template->load(false,'examination/guest_exam',$data);
	}
	public function saveAnswer($value='')
	{
		# code...

		if($this->input->post()){
			$object = (object)$this->input->post();
			$user_exam_id = $this->session->user_exam_id;
			$category_id = $this->session->category_id;
			
			$answers = json_decode($object->answers);

			if($category_id > 0 && $user_exam_id > 0){
				$is_added = '';
				foreach ($answers as $key) {
					# code...
				$is_added[] =  $this->Userexam_m->saveAnswer($user_exam_id,$category_id,$this->uid,$key->answer,$key->id);
				}
			var_dump($is_added);
			
			}else{
			echo "No answer";
			}
			
		}
		//var_dump(json_decode($answers));
	}



} /*      ------------end of Examination---------------- */