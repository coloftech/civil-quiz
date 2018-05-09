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
		$this->load->model('exam_m');
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
	public function review($exam_id=false)
	{
		# code...

			$info = false;
			$categories=false;
			$title = '';

		if($exam_id){
			$info = $this->exam_m->getExamById($exam_id);
			
				if($category = $this->exam_m->getExamCategories($exam_id)){
					foreach ($category as $key) {
						# code...
						$categories[] = $key->category_id;

					}
				}

			$title = $info[0]->quizes_title;



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
		$data['site_title'] = $title.' - start exam';
		$this->template->load(false,'examination/exam',$data);
	}
	public function startexam()
	{
		//*
		if(!$this->permission->is_loggedIn()){
			//redirect('login');
			
		}
		/**/
		# code...
				$time = $_SERVER['REQUEST_TIME'];
				$timeout_duration = 30;
				if($this->session->LAST_ACTIVITY && ($time - $this->session->LAST_ACTIVITY < $timeout_duration)){
					$timeout =$timeout_duration - ( $time - $this->session->LAST_ACTIVITY);
					#2
					$remain = floor($timeout/60) . ":" . $timeout % 60;
					echo json_encode(array('stats'=>false,'msg'=>'Exam is on hold for '.$remain.' second.'));
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

	public function questions($value='')
	{
		# code...


		if($this->input->post()){
			$object = (object)$this->input->post();


			if($exam = $this->exam_m->randomByCategory2($object->exam_id,$object->category_id)){
				/*if(!$this->session->user_exam_id){

				$user_exam_id = $this->Userexam_m->start_user_exam($object->exam_id,$object->category_id,$this->uid);
				$_SESSION['user_exam_id'] = $user_exam_id;
				$_SESSION['category_id'] = $object->category_id;


				}*/
				echo json_encode(array('stats'=>true,'questions'=>$exam));
				exit();
			}


			echo json_encode(array('stats'=>false,'msg'=>'No Exam available right now!'));
				exit();

		}
		
	}
	public function save_answer()
	{
		if($this->input->post()){

			

			$data = $this->input->post();
			$object = (object)$data;

					
			$questions = json_decode($object->questions_id);
			$answer = '';
			$is_save = '';

			if(!$this->session->user_exam_id){

						$user_exam_id = $this->Userexam_m->start_user_exam($object->exam_id,0,$this->uid);

						$_SESSION['user_exam_id'] = $user_exam_id;
					}else{

						$user_exam_id = $this->session->user_exam_id;
					}


			foreach ($questions as $key) {
				# code...
				$answer = $data['choice_'.$key];
				$quiz_id = $key;
				$is_save[] = $this->exam_m->saveAnswer($user_exam_id,$object->category_id,$this->uid,$answer,$quiz_id);
				usleep(150000);
			}

			$this->exam_m->save_result($user_exam_id,$object->category_id,$object->exam_id,0,$object->timefinnish);

			echo json_encode(array('stats'=>true));
			exit();

		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No input received.'));
		}

	}
	public function results($exam_id='')
	{
		# code...
		if($this->input->post()){
			$data = $this->input->post();
			$object = (object)$data;
			$category_id = json_decode($object->category_id);
			$answer = '';
			$is_save = '';

			$user_exam_id = $this->session->user_exam_id;
			$total_exam = 0;
			$res = 0;
			$i=0;
			foreach ($category_id as $key) {
				# code...

				$total = 0;
				
				$total = $this->exam_m->get_results($user_exam_id,$key,$object->exam_id);
				//$res++;


				usleep(150000);
				$total_exam = $total_exam + $total;
				//echo " $total |";

			}
			$res = $this->exam_m->save_final_result($user_exam_id,$total_exam);


			echo json_encode(array('stats'=>true,'total_exam'=>$total_exam,'res'=>$res));

			exit();

		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No input received.'));
		}
	}
	function pdf()
	{
		$data['site_title'] = 'PDF Create';
     $this->load->helper(array('pdf_create', 'file'));
     // page info here, db calls, etc.     
     $html = $this->load->view('exam/exam', $data, true);
     pdf_create($html, 'filename');
     /*or
     $data = pdf_create($html, '', false);
     write_file('name', $data);*/
     //if you want to write it to disk and/or send it as an attachment    
	}




} /*      ------------end of Examination---------------- */