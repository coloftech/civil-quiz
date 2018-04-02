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
	public function list_exam($value='')
	{
		$quiz = $this->quiz_m->list_exams();
		$data['lists'] = $quiz;
		$data['site_title'] = 'List all';
		$this->template->load('admin','quiz/listexam',$data);
	}

	public function edit($examId='')
	{
		# code...
		if($this->input->post()){

			$input =(object) $this->input->post();



			if($isExist = $this->quiz_m->exam_exist($input->q_title)){

				$existId = $isExist[0]->quizes_id;

				if($existId != $input->quizes_id){
					echo json_encode(array('stats'=>false,'msg'=>'This exam title cannot be used. Please try another.'));
					exit();
				}
			}

			$choices = isset($input->q_random_choices) ? $input->q_random_choices : 0;
			$questions = isset($input->q_random_question) ? $input->q_random_question : 0;
			
			$data = array(
				'quizes_title'=>$input->q_title,
				'total'=>$input->q_total,
				'type_id'=>$input->q_type,
				'category_id'=>$input->s_category,
				'shuffle_choices'=>$choices,
				'suffle_questions'=>$questions
			);
			if($quizes_id = $this->quiz_m->update_exam($data,$input->quizes_id)){

				echo json_encode(array('stats'=>true,'msg'=>'Quiz settings updated successfuly.'));
			}else{

				echo json_encode(array('stats'=>false,'msg'=>'Nothing to change.'));
			}

			exit();
		}
		if($exam = $this->quiz_m->getExamById($examId)){
			//print_r($exam);exit();
			$data['examId'] = $examId;
			$data['q_title'] = $exam[0]->quizes_title;
			$data['e_description'] = $exam[0]->e_description;

			if($exam[0]->shuffle_choices == 1){
				$data['isChoice'] = 'checked';
			}
			if($exam[0]->suffle_questions == 1){
				$data['isQuestion'] = 'checked';
			}
			if($total = $this->quiz_m->countExamById($examId)){
				$data['q_questions'] = $total;
			}

			$categories = $exam[0]->category;
			$tr = '';
			foreach ($categories as $key) {

				$category = $this->quiz_m->exam_category_exist($examId,$key->category_id);

				$total_questions = $this->quiz_m->countExamById($examId,$key->category_id);
				# code...
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

				$tr .= "<tr><td>$key->category_name</td><td>$t</td><td>$total_questions<input type='hidden' id='input_questions_$key->category_id' value='$total_questions'/></td><td>$cat->exam_total <input type='hidden' id='max_$key->category_id' value='$cat->exam_total' /></td><td><button class='btn btn-sm btn-default' type='button' onclick='add_questions($examId,$key->category_id,$total_questions,$cat->exam_total,1,\"$key->category_name\",\"$t\")'><i class='fa fa-plus'></i> questions</button></td></tr>";

				}
			}
			$data['tr'] = $tr;
			
		$cat = '<select class="form-control" name="s_category" id="s_category"><option value="0">No category</option></select>';
		if($category = $this->category_m->get_Categories()){
			$cat = '<select class="form-control" name="s_category" id="s_category">';
			foreach ($category as $key) {
				# code...
				$cat .= "<option value='$key->cat_id'>$key->cat_name</option>";
			}

			$cat .= '</select>';
		}
		$data['category']=$cat;
		}
		
		
		$data['editform'] = true;
		$data['js_script'] = $this->is_cript();
		$data['site_title'] = 'Edit exam';
		$this->template->load('admin','quiz/edit',$data);
		
	}
	public function removeExam($value='')
	{
		# code...
		if($this->input->post()){
			if($isRemove = $this->quiz_m->removeExam($this->input->post('quizes_id'))){

				echo json_encode(array('stats'=>true,'msg'=>'Exam remove successfully'));
			}else{

				echo json_encode(array('stats'=>false,'msg'=>'Nothing to remove.'));
			}
		}else{

				echo json_encode(array('stats'=>false,'msg'=>'No input received.'));
			}
	}

	public function takeaquiz(){
		$quiz = false;
		if ($this->input->get('category')) {

		$quiz = $this->quiz_m->list_questions($this->input->get('category'));
		$data['lists'] = $quiz;

		}else{
			
			$cat = '<select class="form-control" name="category" id="category"><option value="0">No category</option></select>';
		if($category = $this->category_m->get_Categories()){
			$cat = '<select class="form-control" name="category" id="category">';
			foreach ($category as $key) {
				# code...
				$cat .= "<option value='$key->cat_id'>$key->cat_name</option>";
			}

			$cat .= '</select>';
		
		$data['category']=$cat;
		}
		}
		

		

		$data['site_title'] = 'Take a quiz';

		$this->template->load('admin','quiz/takeaquiz',$data);
	}

	public function checkquiz($input='')
	{
		# code...
		
		$input = $this->input->post();
		$total = 0;
		$i = 1;
		$html = '';

		foreach ($input as $key => $value) {
			# code...
			$id = str_replace('question_', '', $key);
			if($this->quiz_m->isAnswer($id, $value)){
				$answer = 'correct';
				$total++;
			}else{
				$answer = 'wrong';
			}

			$html .= "<br />$i) $value is $answer  ";
			$i++;
		}
			$html .= "<br />Total point: $total  ";

	}
	public function result($result='')
	{
		# code...

		$input = $this->input->post();
		$total = 0;
		$i = 1;
		$html = '';

		foreach ($input as $key => $value) {
			# code...
			$id = str_replace('question_', '', $key);
			if($this->quiz_m->isAnswer($id, $value)){
				$answer = 'correct';
				$total++;
			}else{
				$answer = 'wrong';
			}

			$html .= "<br />$i) $value is $answer  ";
			$i++;
		}
			$html .= "<br /><br /><b>Total point:<font color='red'> $total </font></b>  ";

		$data['results'] = $html;
		$data['site_title'] = 'Quiz result';

		$this->template->load('admin','quiz/result',$data);
	}
	public function create($value='')
	{

		$cat = '<select class="form-control" name="s_category" id="s_category"><option value="0">No category</option></select>';
		if($category = $this->category_m->get_Categories()){
			$cat = '<select class="form-control" name="s_category" id="s_category">';
			foreach ($category as $key) {
				# code...
				$cat .= "<option value='$key->cat_id'>$key->cat_name</option>";
			}

			$cat .= '</select>';
		}
		$data['category']=$cat;

		$data['editform'] = true;
		$data['js_script'] = $this->is_cript();
		$data['category']=$cat;
		$data['site_title'] = 'Create quiz';
		$this->template->load('admin','quiz/create_q',$data);
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

			//echo json_encode($input);
			//exit();

			$data = array(
				'post_question'=>$input->question,
				'post_answer'=>$answer,
				'post_choice1'=>$choice[0],
				'post_choice2'=>$choice[1],
				'post_choice3'=>$choice[2],
				'post_choice4'=>$choice[3],
				'date_posted'=>date('Y-m-d H:i:s')


			);


			$isExist = $this->quiz_m->question_exist($input->question);
			if(count($isExist) > 0){

				echo json_encode(array('stats'=>false,'msg'=>'Post failed! The question already exist.'));

			}else{


				if($id = $this->quiz_m->add_quiz($data)){

				$category = array('post_id'=>$id,'cat_id'=>$input->category_id);
				$set_category = $this->quiz_m->set_category($category);

				$add_to_exam = $this->quiz_m->add_to_exam(array('quiz_id'=>$id,'quizes_setting_id'=>$input->quizes_id));

				echo json_encode(array('stats'=>true,'msg'=>'Question added','quiz_id'=>$id));
				}
			}
			exit();
		


		}else{
			echo json_encode(array('stats'=>false,'msg'=>'No input receveid.'));
		}

	}

	public function examsetting($value='')
	{

		if ($this->input->post()) {
			$input = (object)$this->input->post();
			

			$isExist = $this->quiz_m->exam_category_exist($input->quizes_id,$input->s_category);
			if(count($isExist) > 0){

				echo json_encode(array('stats'=>false,'msg'=>'Failed! Exam category cannot be duplicate.'));
				exit();
			
			}

			$data = array(
				'exam_id'=>$input->quizes_id,
				'category_id'=>$input->s_category,
				'exam_total'=>$input->q_total,
				'exam_type'=>$input->q_type
			);
			if($quizes_id = $this->quiz_m->add_to_exam_setting($data)){

			echo json_encode(array('stats'=>true,'msg'=>'Exam setting added'));
			}else{

			echo json_encode(array('stats'=>false,'msg'=>'No changes made.'));
			}
		}
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

			$isExist = $this->quiz_m->exam_exist($input->q_title);
			if(count($isExist) > 0){

				echo json_encode(array('stats'=>false,'msg'=>'Post failed! The exam title already used.','quizes_id'=>$isExist[0]->quizes_id));
				exit();

			}
			$choices = isset($input->q_random_choices) ? $input->q_random_choices : 0;
			$questions = isset($input->q_random_question) ? $input->q_random_question : 0;
			
			$data = array(
				'quizes_title'=>$input->q_title,
				'e_description'=>$input->e_description,
				'slug'=>$this->slug->create($input->q_title),
				'shuffle_choices'=>$choices,
				'suffle_questions'=>$questions,
				'date_posted'=>date('Y-m-d H:i:s')
			);
			$quizes_id = $this->quiz_m->add_exam($data);
			echo json_encode(array('stats'=>true,'msg'=>'Quiz settings added successfuly.','quizes_id'=>$quizes_id));
			exit();
		}
	}

	public function is_cript($value='')
	{
			
	$js_script = "

		<script>

			$('input[name=\"q_type\"]').on('change click',function(e){
				
				var selected =  $('input[name=q_type]:checked').val();

				if(selected == 1){
					$('.is_new').show('slow');
					$('.is_exist').hide();

					$('.q_type1').addClass('alert alert-info');
					$('.q_type2').removeClass('alert alert-info');

				}
				if(selected == 2){
					$('.is_exist').show('slow');
					$('.is_new').hide();

					$('.q_type2').addClass('alert alert-info');
					$('.q_type1').removeClass('alert alert-info');

				}
				
			});

		</script>

		";

		return $js_script;
	}

}