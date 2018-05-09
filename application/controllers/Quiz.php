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

			 if (!$this->permission->is_loggedIn() || !$this->permission->is_admin()){
			 	redirect();
			 }
		$this->load->model('category_m');
		$this->load->model('quiz_m');
		$this->load->model('exam_m');
	}
	public function index($value='')
	{
		# code...
		$data['site_title'] = 'Quiz home';
		$this->template->load(false,'quiz/index',$data);
	}

	public function list_exam($value='')
	{
		$quiz = $this->quiz_m->list_exams(true);
		$data['lists'] = $quiz;
		$data['site_title'] = 'List all';
		$this->template->load('admin','admin/exam/list_exam',$data);
	}

	public function list_question($exam_id=0,$category_id = 0){
		if($this->input->post()){
			$obj = (object) $this->input->post();
			//echo json_encode($obj);
			//exit();
			$lists = $this->quiz_m->list_question($obj->category_id,$obj->exam_id);
			echo json_encode($lists);
		}
	}
	public function publishexam($status=0)
	{
		# code...

		if($this->input->post()){
			$exam_id = $this->input->post('exam_id');
			$s= $this->input->post('status');
			if($s == 0){
				$status = 1;
			}else{
				$status = 0;
			}
			if($is_publish = $this->exam_m->is_publish($status,$exam_id)){

			echo json_encode(array('stats'=>true,'msg'=>'Exam updated'));
				exit();
			}
			echo json_encode(array('stats'=>false,'msg'=>'No action done.'));
		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No input received.'));
		}
	}
	public function update_title_description($exam_id=0){
		if($this->input->post()){

			$exam_id = $this->input->post('exam_id');
			$exam_title = trim($this->input->post('q_title'));
			$e_description = $this->input->post('e_description');


			$is_exist = $this->exam_m->is_title_exist($exam_title,$exam_id);
			if($is_exist > 0){

				echo json_encode(array('stats'=>false,'msg'=>'This title cannot be used.'));
			}else{
				$data = array(
					'quizes_title'=>$exam_title,
					'e_description'=>$e_description
				);
				$is_update = $this->exam_m->update($exam_id,$data);
				if ($no_error = $this->auto_m->no_error($is_update)) {
					# code...
					//var_dump($no_error);

				echo json_encode(array('stats'=>true,'msg'=>'Update successful.'));

				}else{
				echo json_encode(array('stats'=>false,'msg'=>$is_update));

				}
			}
			//var_dump($is_exist);

		}else{
			json_encode(array('No input received.'));
		}
	}
	public function edit($exam_id=0)
	{
		# code...
		if($exam_id > 0){
			if($exam = $this->quiz_m->getExamById($exam_id)){

			$data['exam_title'] = $exam[0]->quizes_title;
			$data['exam_description'] = $exam[0]->e_description;


			$categories = $exam[0]->category;

				$tr = '';
				if(is_array($categories)){
					foreach ($categories as $key) {
						# code...

					$category = $this->quiz_m->exam_category_exist($exam_id,$key->category_id);				
					$total_questions = $this->quiz_m->countExamByCategory($exam_id,$key->category_id);
						foreach ($category as $cat) {
							# code...
							$type = $cat->exam_type;
								switch ($type) {
									case 1:
										# code...
										$t = 'Multiple choice';
										break;
									case 2:
										# code...
										$t = 'Identification';
										break;
									default:
										# code...
										$t = 'Undefined';
										break;
								}
							$tr .= "
								<tr class='list' data-category='$key->category_id' id='tr_$key->category_id'>
									<td>$key->category_name</td>
									<td>$t</td>
									<td><span class='btn list-question' id='questions_$key->category_id' style='width:40%;'>$total_questions</span> / <span class='btn span_exam_total' id='mtotal_$key->category_id' style='width:40%;' onClick='maxQuestion(this)'>$cat->exam_total</span></td>
									<td><button class='btn btn-info btn-sm' onClick='addquestion(this)'><i class='fa fa-plus fa-questions'></i></button> <button class='btn btn-danger btn-sm' type='button' onClick='removeCategory(this)'><i class='fa fa-remove'></i></button></td>
								</tr>
								";


						}
						$data['tr'] = $tr;



								$this->load->model('exam_m');
								$exam_type = '<option value="1">Default</option>';
								if($list_type = $this->exam_m->examType()){
									$exam_type = '';
									foreach ($list_type as $key) {
										# code...
										$exam_type .= "<option value='$key->type_id'>$key->type_title</option>";
									}
									$exam_type .= "<option value='0'>Others</option>";

								}
								$data['exam_type'] = $exam_type;


								if($exam[0]->shuffle_choices == 1){
									$data['isChoice'] = 'checked';
								}
								if($exam[0]->suffle_questions == 1){
									$data['isQuestion'] = 'checked';
								}
					}
				}
			}
		}

		$category = $this->category_m->optionCategory();
		$data['category']=$category;
		

		$data['exam_id'] = $exam_id;
		$data['editform'] = true;

		$data['site_title'] = 'Edit';
		$this->template->load('admin','admin/exam/edit',$data);
	}

	public function changemaxquestion()
	{
		# code...
		//exit(1);
		if($this->input->post()){
			$post =(object) $this->input->post();
			//var_dump($post);
			$is_update = $this->exam_m->update_exam($post->exam_id,$post->category_id,$post->maxquestions);
			echo json_encode(array('stats'=>$is_update));

		}else{
			echo json_encode(array('No input received.'));
		}
	}

	public function removecategory($exam_id='')
	{
		if($this->input->post()){

			$is_remove = $this->quiz_m->removeExamCategory($this->input->post('exam_id'),$this->input->post('category_id'));
			if(is_array($is_remove)){
				echo json_encode(array('stats'=>false,'msg'=>$is_remove['message']));
			}else{
				echo json_encode(array('stats'=>true,'msg'=>'Removed successfuly.'));
			}

		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No input received!'));
		}
	}
	public function removeExam($category_id='')
	{
		# code...
		if($this->input->post()){
			if($isRemove = $this->quiz_m->removeExam($this->input->post('exam_id'))){

				echo json_encode(array('stats'=>true,'msg'=>'Exam remove successfully'));
			}else{

				echo json_encode(array('stats'=>false,'msg'=>'Nothing to remove.'));
			}
		}else{

				echo json_encode(array('stats'=>false,'msg'=>'No input received.'));
			}
	}

	public function exam_setting($exam_id=0){
		if($this->input->post()){
			//$post = $this->input->post();
			//echo json_encode($post);
			//exit();

			$input = (object)$this->input->post();
			

			$isExist = $this->quiz_m->exam_category_exist($input->exam_id,$input->s_category);
			if(count($isExist) > 0){

				echo json_encode(array('stats'=>false,'msg'=>'Failed! Exam category cannot be duplicate.'));
				exit();
			
			}

			$shuffle_choices = (isset($input->q_random_choices)) ? 1 : 0;
			$shuffle_question = (isset($input->q_random_question)) ? 1 : 0;

			$data = array(
				'exam_id'=>$input->exam_id,
				'category_id'=>$input->s_category,
				'exam_total'=>$input->txtmtotal,
				'exam_type'=>$input->q_type,
				'directions'=>$input->directions,
				'is_shuffle'=>$shuffle_choices,
				'is_shuffle_question'=>$shuffle_question
			);

			//echo json_encode(array('stats'=>false,'msg'=>'No changes made.','data'=>$data));
			//exit();
			if($quizes_id = $this->quiz_m->add_to_exam_setting($data)){

			echo json_encode(array('stats'=>true,'msg'=>'Exam setting added'));
			}else{

			echo json_encode(array('stats'=>false,'msg'=>'No changes made.'));
			}
		}
	}


	public function add_question($exam_id=0){

		if($this->input->post()){
			$input = (object)$this->input->post();
			$choice = $input->choices;
			$answer = $choice[0];

			$uniqid =uniqid();
			$quiz_id = $this->quiz_m->add_quiz(
				array(
					'post_question'=>$input->question,
					'date_posted'=>date('Y-m-d H:i:s'),
					'token'=>$uniqid
					)
			);
			if($quiz_id > 0){

					$answer_id = $this->quiz_m->add_to_choices(array('quiz_id'=>$quiz_id,'choice_label'=>$answer,'is_answer'=>1));
					$c=0;
					foreach ($choice as $choi) {
						# code...
						if(!empty($choi) && $c > 0){

						$this->quiz_m->add_to_choices(array('quiz_id'=>$quiz_id,'choice_label'=>$choi,'is_answer'=>0));
						}
						$c++;
					}

					$set_answer = $this->quiz_m->update_quiz(array('choice_id'=>$answer_id),$quiz_id);

				$add_to_exam = $this->quiz_m->add_to_exam(array('quiz_id'=>$quiz_id,'exam_id'=>$input->exam_id,'category_id'=>$input->category_id));

				echo json_encode(array('stats'=>true,'msg'=>'Question added','quiz_id'=>$quiz_id));

			}

			exit();

		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No input receveid.'));
		}
	}

	public function add_question_old($exam_id=0){

		if($this->input->post()){
			$input = (object)$this->input->post();
			//$num = $input->answer;
			//$answer = $this->input->post('choice'.$num);
			$answer = $input->answer;
			$choice = '';
			$j=0;
			/*for ($i=1; $i <= 6 ; $i++) { 

				if($answer != ($this->input->post('choice'.$i))){
				$choice[$j] = $this->input->post('choice'.$i);
				$j++;
				}

			}
			*/
			$choice = $input->choices;

			var_dump($choice);
			exit();
			$uniqid =uniqid();
			$data = array(
				'post_question'=>$input->question,
				'post_answer'=>$answer,
				'post_choice1'=>$choice[0],
				'post_choice2'=>$choice[1],
				'post_choice3'=>$choice[2],
				'post_choice4'=>$choice[3],
				'date_posted'=>date('Y-m-d H:i:s'),
				'token'=>$uniqid
			);

				if($id = $this->quiz_m->add_quiz($data)){


					$answer_id = $this->quiz_m->add_to_choices(array('quiz_id'=>$id,'choice_label'=>$answer,'is_answer'=>1));
					foreach ($choice as $choi) {
						# code...
						if(!empty($choi)){

						$this->quiz_m->add_to_choices(array('quiz_id'=>$id,'choice_label'=>$choi,'is_answer'=>0));
						}
					}
					$set_answer = $this->quiz_m->update_quiz(array('choice_id'=>$answer_id),$id);


				$add_to_exam = $this->quiz_m->add_to_exam(array('quiz_id'=>$id,'exam_id'=>$input->exam_id,'category_id'=>$input->category_id));

				echo json_encode(array('stats'=>true,'msg'=>'Question added','quiz_id'=>$id));
				}
			exit();

		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No input receveid.'));
		}
	}

	public function create($exam_id=0)
	{
		# code...


		$category = $this->category_m->optionCategory();
		$data['category']=$category;

		$data['editform'] = true;
		
		$data['site_title'] = 'Create exam';
		$this->template->load('admin','admin/exam/create',$data);
	}

	public function addexam($value='')
	{
		# code...
				if ($this->input->post()) {
			
			$input = (object)$this->input->post();
			if(empty($input->q_title)){

				echo json_encode(array('stats'=>false,'msg'=>'Title of quiz should not be empty.'));
				exit();
			}

			$isExist = $this->exam_m->is_title_exist(trim($input->q_title));
			if($isExist > 0){

				echo json_encode(array('stats'=>false,'msg'=>'Post failed! The exam title already used.'));
				exit();

			}
			
			$data = array(
				'quizes_title'=>$input->q_title,
				'e_description'=>$input->e_description,
				'slug'=>$this->slug->create($input->q_title),
				'date_posted'=>date('Y-m-d H:i:s')
			);
			$exam_id = $this->quiz_m->add_exam($data);
			echo json_encode(array('stats'=>true,'msg'=>'Quiz settings added successfuly.','exam_id'=>$exam_id));
			exit();
		}
	}

}