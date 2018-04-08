<?php 
/**
* 
*/
class Exam extends CI_Controller
{

	public $uid;
	public $username;
	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init($value='')
	{
		
		$this->uid = $this->session->userdata['id'];
		$this->username = $this->session->userdata['username'];

		$this->load->model('category_m');
		$this->load->model('quiz_m');
		$this->load->model('user_m');
	}
	public function index($value='')
	{
		# code...

		$quiz = $this->quiz_m->list_exams();
		$data['lists'] = $quiz;

		$data['profile'] = $this->user_m->info($this->uid);
		$data['site_title'] = 'Exam home';
		$this->template->load(false,'exam/index',$data);
	}

	public function create($value='')
	{
		# code...
		$data['site_title'] = 'Create exam';
		$this->template->load(false,'exam/exam',$data);
	}
	public function info($slug='')
	{
		# code...
		$info = $this->quiz_m->getInfoBySlug($slug);

		$data['info'] = $info;
		$data['site_title'] = 'Exam information';
		$this->template->load(false,'exam/info',$data);
	}


	public function rating($value='')
	{
		# code...
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
		# code...
		$data['list_exam'] = 'Not found!';
		//if($list_exam = $this->quiz_m->take_exam($exam_id)){
		if($list_exam = $this->quiz_m->randomByCategory($exam_id)){
			$data['list_exam'] = $list_exam;
		}
		//foreach ($list_exam as $key) {
			# code...
		//	print_r($key);
		//}
		//exit();


		$data['exam_id'] = $exam_id;
		$data['site_title'] = 'Take exam';
		$this->template->load(false,'exam/exambycategory',$data);

	}

	
}