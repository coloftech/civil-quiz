<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Quiz_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	public function add_quiz($data=false)
	{

			$this->db->insert('quiz',$data);
			return $this->db->insert_id();

	}
	public function add_exam($data=false)
	{

			$this->db->insert('quizes_setting',$data);
			return $this->db->insert_id();

	}
	public function update_exam($data=false,$exam_id=0)
	{
			$this->db->where('quizes_id',$exam_id);
			return $this->db->update('quizes_setting',$data);

	}

	public function add_to_exam($data=false)
	{

			return $this->db->insert('quizes',$data);

	}


	public function add_to_exam_setting($data=false)
	{

			return $this->db->insert('exam_setting',$data);

	}
	public function countExamById($exam_id=0)
	{
		

			$this->db->select('count(*) as total')
				->from('quizes')
				->where('quizes_setting_id',$exam_id);
			if($result = $this->db->get()->result()){
				return $result[0]->total;
			}else{
				return 0;
			}
	}

	public function getExamById($exam_id=0)
	{
		

			$this->db->select('exam_setting.*,category.cat_name')
				->from('exam_setting')				
				->join('category','category.cat_id = exam_setting.category_id','LEFT')
				->where('exam_id',$exam_id);
			return $this->db->get()->result();

	}
	public function exam_exist($question='')
	{
		# code...
		return $this->db->get_where('quizes_setting',array('quizes_title'=>$question))->result();
	}
		public function exam_category_exist($exam_id=0,$category_id=0)
	{
		# code...
		return $this->db->get_where('exam_setting',array('exam_id'=>$exam_id,'category_id'=>$category_id))->result();
	}

	public function set_category($data=false)
	{

			return $this->db->insert('quiz_category',$data);
	}

	public function question_exist($question='')
	{
		# code...
		return $this->db->get_where('quiz',array('post_question'=>$question))->result();
		//return $this->db->get()->result();
	}
	public function isAnswer($question=0, $answer = '')
	{

		if($this->db->get_where('quiz',array('post_id'=>$question,'post_answer'=>$answer))->result()){
			return true;
		}else{
			return false;
		}

	}

	public function list_exams($category=false)
	{
		if($category){

			$this->db->select('quizes_setting.*')
				->from('quizes_setting')
				->where('quizes_setting.category_id',$category);
			return $this->db->get()->result();

		}else{

			$this->db->select('quizes_setting.*,COUNT('.$this->db->dbprefix("exam_setting").'.exam_id) as totalexam')
				->from('quizes_setting')
				->join('exam_setting','exam_setting.exam_id = quizes_setting.quizes_id','LEFT')
				->group_by('exam_setting.exam_id')
				->order_by('quizes_setting.date_posted','DESC');
			$result =  $this->db->get()->result();
			$ar = '';
			foreach ($result as $key) {
				# code...
				//$ar[] = $key;
				$cat_names = '';
				$category = '';
				$categories = '';
				$sql = $this->db->select('exam_setting.category_id,category.cat_name')
					->from('exam_setting')
					->join('category','category.cat_id = exam_setting.category_id','left')
					->where('exam_id',$key->quizes_id);
					$category = $this->db->get()->result();
					foreach ($category as $cat) {
						# code...
						$cat_names[] = $cat->cat_name;
						//$cat_ids[] = $cat->category_id;
						$categories[] =(object) array('category_id'=>$cat->category_id,'category_name'=>$cat->cat_name);
					}
					

					$ar[] =(object) array(
						'quizes_id'=>$key->quizes_id,		
						'quizes_title'=>$key->quizes_title,
						'e_description'=>$key->e_description,
						'slug'=>$key->slug,
						'shuffle_choices'=>$key->shuffle_choices,
						'suffle_questions'=>$key->suffle_questions,
						'date_posted'=>$key->date_posted,
						'status'=>$key->status,
						'category_names'=>$cat_names,
						//'category_ids'=>$cat_ids,
						'category'=>$categories,
						'totalexam'=>$key->totalexam
					);


			}
			return $ar;
			
		}
	}
	public function list_questions($category=false)
	{
		if($category){

			$this->db->select('quiz.*,quiz_category.cat_id,category.cat_name')
				->from('quiz')
				->join('quiz_category','quiz_category.post_id = quiz.post_id','LEFT')
				->join('category','category.cat_id = quiz_category.cat_id','LEFT')
				->where('quiz_category.cat_id',$category);
			return $this->db->get()->result();

		}else{

			$this->db->select('quiz.*,quiz_category.cat_id,category.cat_name')
				->from('quiz')
				->join('quiz_category','quiz_category.post_id = quiz.post_id','LEFT')
				->join('category','category.cat_id = quiz_category.cat_id','LEFT');
			return $this->db->get()->result();
		}
	}

	public function removeExam($exam_id=0)
	{
		# code...
		$this->db->delete('exam_setting',array('exam_id'=>$exam_id));
		$this->db->delete('quizes',array('quizes_setting_id'=>$exam_id));
		return $this->db->delete('quizes_setting',array('quizes_id'=>$exam_id));
	}
}


/*

SELECT s.quizes_id,s.quizes_title,q.*,c.cat_id FROM q_quiz as q LEFT JOIN q_quiz_category as c ON c.post_id = q.post_id LEFT JOIN q_quizes as qq ON q.post_id = qq.quiz_id LEFT JOIN q_exam_setting as e ON e.exam_id = qq.quizes_setting_id LEFT JOIN q_quizes_setting as s ON e.exam_id = s.quizes_id ORDER BY s.quizes_id DESC

*/