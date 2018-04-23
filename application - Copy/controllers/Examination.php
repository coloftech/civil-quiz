<?php 
/**
* 
*/
class Examination extends CI_Controller
{

	public $uid = 0;
	public $username = 'Guest';
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
	}
	public function index($value='')
	{
		# code...

		if(!$this->permission->is_loggedIn()){
			redirect('login');
		}
		$quiz = $this->quiz_m->list_exams();
		$data['lists'] = $quiz;

		$data['profile'] = $this->user_m->info($this->uid);
		$data['site_title'] = 'Examination home';
		$this->template->load(false,'exam/index',$data);
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
			//var_dump($is_added);
				echo json_encode(array('stats'=>true,'msg'=>'Answer save.'));
			
			}else{
			echo json_encode(array('stats'=>false,'msg'=>"No answer"));
			}
			
		}
		//var_dump(json_decode($answers));
	}



} /*      ------------end of Examination---------------- */