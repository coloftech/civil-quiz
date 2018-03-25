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

	public function add_to_exam($data=false)
	{

			return $this->db->insert('quizes',$data);

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

	public function exam_exist($question='')
	{
		# code...
		return $this->db->get_where('quizes_setting',array('quizes_title'=>$question))->result();
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

			$this->db->select('quizes_setting.*,category.cat_name')
				->join('category','category.cat_id = quizes_setting.category_id','LEFT')
				->from('quizes_setting');
			return $this->db->get()->result();
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
		return $this->db->delete('quizes_setting',array('quizes_id'=>$exam_id));
	}
}