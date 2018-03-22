<?php 
/**
* 
*/
class Quiz extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init(){
		$this->load->model('category_m');
		$this->load->model('quiz_m');
	}
	public function index($value='')
	{
		# code...
		$data['site_title'] = 'Quiz home';
		$this->template->load(false,'quiz/index',$data);
	}

	public function list_questions($value='')
	{
		$quiz = $this->quiz_m->list_questions();
		$data['lists'] = $quiz;
		$data['site_title'] = 'List all';
		$this->template->load('admin','quiz/listall',$data);
	}

	public function takeaquiz(){


		$quiz = $this->quiz_m->list_questions();
		$data['lists'] = $quiz;
		

		$data['site_title'] = 'Take a quiz';

		$this->template->load('admin','quiz/takeaquiz',$data);
	}
	public function create($value='')
	{

		$cat = '<select class="form-control" name="category" id="category"><option value="0">No category</option></select>';
		if($category = $this->category_m->get_Categories()){
			$cat = '<select class="form-control" name="category" id="category">';
			foreach ($category as $key) {
				# code...
				$cat .= "<option value='$key->cat_id'>$key->cat_name</option>";
			}

			$cat .= '</select>';
		}
		$data['category']=$cat;
		$data['site_title'] = 'Create quiz';
		$this->template->load('admin','quiz/create',$data);
	}

	public function add($value=''){
		if($this->input->post()){
			$input = (object)$this->input->post();
			$num = $input->answer;
			$answer = $this->input->post('choice'.$num);
			$choice = '';
			$j=0;
			for ($i=1; $i <= 6 ; $i++) { 

				if($answer != ($this->input->post('choice'.$i))){
				$choice[$j] = $this->input->post('choice'.$i);
				$j++;
				}

			}

			$data = array(
				'post_question'=>$input->question,
				'post_answer'=>$answer,
				'post_choice1'=>$choice[0],
				'post_choice2'=>$choice[1],
				'post_choice3'=>$choice[2],
				'post_choice4'=>$choice[3],
				'post_choice5'=>$choice[4],
				'date_posted'=>date('Y-m-d H:i:s')


			);
			$isExist = $this->quiz_m->question_exist($input->question);
			if(count($isExist) > 0){

				echo json_encode(array('stats'=>false,'msg'=>'Post failed! The question already exist.'));

			}else{

				if($id = $this->quiz_m->add_quiz($data)){

				$category = array('post_id'=>$id,'cat_id'=>$input->category);
				$set_category = $this->quiz_m->set_category($category);

				echo json_encode(array('stats'=>true,'msg'=>$set_category));
				}
			}
			exit();
		


		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No input receveid.'));
		}

	}

}