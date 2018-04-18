<?php 
/**
* 
*/
class Exam extends CI_Controller
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
		$data['site_title'] = 'Exam home';
		$this->template->load(false,'exam/index',$data);
	}

	public function create($value='')
	{
			 if (!$this->permission->is_loggedIn() || !$this->permission->is_admin()){
			redirect('login');
		}
		# code...
		$data['site_title'] = 'Create exam';
		$this->template->load(false,'exam/exam',$data);
	}
	public function info($slug='')
	{
		# code...
		$info = $this->quiz_m->getInfoBySlug($slug);
		//var_dump($info);exit();
		$data['info'] = $info;
		$data['site_title'] = 'Exam information';
		$this->template->load(false,'exam/info',$data);
	}


	public function rating($value='')
	{
		# code...
		
		if(!$this->permission->is_loggedIn()){
			redirect('login');
		}
		$exam_id = $this->input->get('exam');
		$quiz = $this->quiz_m->list_exams();
		$data['lists'] = $quiz;

		$data['profile'] = $this->user_m->info($this->uid);
		$ratings = $this->Userexam_m->rating_by_exam_id($this->uid,$exam_id);
		//var_dump($ratings);
		$data['ratings'] = $ratings;
		$data['site_title'] = 'Exam rating';
		$this->template->load(false,'exam/rating',$data);
	}

	public function search($value='')
	{
		# code...
		$data['site_title'] = 'Exam search';
		$this->template->load(false,'exam/rating',$data);
	}
		public function take_exam($exam_id=0,$cat=0)
	{
		if(!$this->permission->is_loggedIn()){
			redirect('login');
		}
		# code...
		$data['list_exam'] = 'Not found!';
		//if($list_exam = $this->quiz_m->take_exam($exam_id)){
		if($list_exam = $this->quiz_m->randomAllByCategory($exam_id)){
			$data['list_exam'] = $list_exam;
		}
		if($info = $this->quiz_m->getInfoByexamId($exam_id)){
			$data['examinfo'] = $info;
		}
		$_SESSION['user_exam_id'] = false;
		$_SESSION['category_id'] = false;
		$_SESSION['exam_id'] = $exam_id;
		$_SESSION['categories'] = false;
		if(!$this->session->LAST_ACTIVITY){

		$_SESSION['LAST_ACTIVITY'] = false;
		}

		$data['exam_id'] = $exam_id;
		$data['site_title'] = 'Take exam';
		$this->template->load(false,'exam/exam',$data);

	}

	public function stop_exam()
	{
		//if($this->input->post()){
			
		//echo $this->Userexam_m->save_answer(1,2,1,'gwegawg',1);
		//}
		//echo "string";exit();
		echo $this->session->categories;
	}
	public function save_answer()
	{

		if(!$this->permission->is_loggedIn()){
			redirect('login');
		}

		if($this->input->post()){
			$object = (object)$this->input->post();
			$user_exam_id = $this->session->user_exam_id;
			$category_id = $this->session->category_id;
			//echo $object->answer;
			//echo "- $category_id";
			//exit();
			if($category_id > 0 && $user_exam_id > 0){

			$is_added =  $this->Userexam_m->save_answer($user_exam_id,$category_id,$this->uid,$object->answer,$object->question);
			echo "Answer save";
			}else{
			echo "No answer";
			}
			
		}else{
			echo "No input";
		}
		//echo $this->session->user_exam_id;
	}
	public function show_result()
	{
		if(!$this->permission->is_loggedIn()){
			redirect('login');
		}
		# code...
		if($this->input->post()){

			$object = (object)$this->input->post();

			$user_exam_id =  $this->session->user_exam_id;
			$category_id = $this->session->category_id;
			$exam_id = $this->session->exam_id;

			$result = $this->Userexam_m->get_result($exam_id,$category_id,$user_exam_id);

			$save_result = $this->Userexam_m->save_result($exam_id,$category_id,$user_exam_id,$result);
			
			$categories = json_decode($object->catergories);
				$total_exam = 0;
				foreach ($categories as $key) {
					# code...

				$t = $this->quiz_m->countExamByCategory($exam_id,$key);
				$total_exam = $total_exam + $t;
				}

			

			echo json_encode(array('stats'=>true,'result'=>$result,'total_exam'=>$total_exam));


			$time = $_SERVER['REQUEST_TIME'];
			$_SESSION['LAST_ACTIVITY'] = $time;

		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No action done.'));
		}
	}
	public function startexam()
	{
		if(!$this->permission->is_loggedIn()){
			redirect('login');
		}
		# code...
				$time = $_SERVER['REQUEST_TIME'];
				$timeout_duration = 30;
				if($this->session->LAST_ACTIVITY && ($time - $this->session->LAST_ACTIVITY < $timeout_duration)){
					$timeout =$timeout_duration - ( $time - $this->session->LAST_ACTIVITY);
					#2
					$remain = floor($timeout/60) . ":" . $timeout % 60;
					echo json_encode(array('stats'=>false,'msg'=>'Exam is on hold for '.$remain.' minutes.'));
					exit();
				}


		if($this->input->post()){
			$object = (object)$this->input->post();


			if($exam = $this->quiz_m->randomByCategory($object->exam_id,$object->category_id)){
				if(!$this->session->user_exam_id){

				$user_exam_id = $this->Userexam_m->start_user_exam($object->exam_id,$object->category_id,$this->uid);
				$_SESSION['user_exam_id'] = $user_exam_id;
				$_SESSION['category_id'] = $object->category_id;


				}
				echo json_encode(array('stats'=>true,'exam'=>$exam));
				exit();
			}


			echo json_encode(array('stats'=>false,'msg'=>'No Exam available right now!'));
				exit();

		}
			echo json_encode(array('stats'=>false,'msg'=>'Exam not found!'));
				exit();
	}

	public function js_script(){
		$js_script = '';
	}

	
}