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
}