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
		$title = isset($info[0]->quizes_title) ? $info[0]->quizes_title : '';
		$data['link'] = base_url($_SERVER['REQUEST_URI']);
		$data['keywords'] = 'CIVIL SERVICE EXAM, ONLINE REVIEW, DOWNLOAD REVIEWER, PH REVIEW CENTER, '.$title;
		$data['description'] = isset($info[0]->e_description) ? $info[0]->e_description : '';
		$data['meta_title'] = isset($title) ? $title : false;
		$data['site_title'] = isset($title) ? $title : 'Exam info';
		$this->template->load(false,'exam/info',$data);
	}


	public function rating($value='')
	{
		# code...
		
		if(!$this->permission->is_loggedIn()){
			redirect('login');
		}
		$exam_id = $this->uri->segment(3);
		$quiz = $this->quiz_m->list_exams();
		$data['lists'] = $quiz;

		$data['profile'] = $this->user_m->info($this->uid);
		$d = $this->input->get('d');
		$r = $this->input->get('r');
		if (isset($r) && isset($d)) {
			# code...
			if($r){

			$ratings = $this->Userexam_m->rating_by_exam_id($this->uid,$exam_id,$d,$r);
			}else{

			$ratings = $this->Userexam_m->rating_by_exam_id($this->uid,$exam_id,$d);
			}


		}else{

		$ratings = $this->Userexam_m->rating_by_exam_id($this->uid,$exam_id);
		}

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
		redirect('examination/review/'.$exam_id);
		exit();
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
		$this->template->load(false,'exam/start',$data);

	}

	public function stop_exam()
	{
		//if($this->input->post()){
			
		//echo $this->Userexam_m->save_answer(1,2,1,'gwegawg',1);
		//}
		//echo "string";exit();
		echo $this->session->categories;
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
			$exam_id = $this->session->exam_id;
			/*$data = array($user_exam_id,$exam_id);

			echo json_encode(array('stats'=>false,'msg'=>$data));
			exit();
			/*
			$result = $this->Userexam_m->get_result($exam_id,$category_id,$user_exam_id);

			$save_result = $this->Userexam_m->save_result($exam_id,$category_id,$user_exam_id,$result,$object->timer);
			*/
			$categories = json_decode($object->catergories);
				$total_exam = 0;
				foreach ($categories as $key) {
					# code...
				
					$result = $this->Userexam_m->get_result($exam_id,$key,$user_exam_id);
					$save_result = $this->Userexam_m->save_result($exam_id,$key,$user_exam_id,$result,$object->timer);

				$t = $this->quiz_m->countExamByCategory($exam_id,$key);
				$total_exam = $total_exam + $t;
				}

			

			echo json_encode(array('stats'=>true,'result'=>$result,'total_exam'=>$total_exam));


			$time = $_SERVER['REQUEST_TIME'];
			$_SESSION['LAST_ACTIVITY'] = $time;

			/**/

		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No action done.'));
		}
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
				echo json_encode(array('stats'=>true,'exam'=>$exam,'user_exam_id'=>$user_exam_id));
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

	public function test(){
			$this->load->model('exam_m');
			$input = (object)$this->input->post();

			if($exam = $this->exam_m->randomByCategory($input->exam_id,$input->category_id)){
				//var_dump($exam); 
				$html = "";
				$quiz_id = false;
				$j=1;
				$e=0;
				foreach ($exam as $key) {
					# code...
					$html .= "<div class='panel panel-default'><div class='panel-heading  panel-question'>$j) $key->question</div><div class='panel-body  panel-choices'>";
					$i='A';
					$html .= "<ul class='list'>";
					$choices = $key->choices;
					//shuffle($choices);
						foreach ($choices as $c) {
							# code...
							$html .= "<li class='list=item'><input type='radio' value='$c' id='choice_".$i."_$key->quiz_id' name='choice_$key->quiz_id'  onclick='saveanswer($key->quiz_id)' class='radio radio-inline radio-btn'/><label for='choice_".$i."_$key->quiz_id'  class='label'>$i. $c</label></li>";
							$i++;
						}
					$html .='</ul></div></div>';
					$quiz_id[] = $key->quiz_id;
					$j++;
					$e++;
				}		
				/*				

					if(!$this->session->user_exam_id){

						$user_exam_id = $this->Userexam_m->start_user_exam($input->exam_id,$input->category_id,$this->uid);
						$_SESSION['user_exam_id'] = $user_exam_id;
						$_SESSION['category_id'] = $input->category_id;
					}
					*/

				echo json_encode(array('stats'=>true,'questions'=>$html,'total'=>$e,'arr_quiz_id'=>$quiz_id));
			}
	}

	
}