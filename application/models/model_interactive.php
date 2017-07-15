<?php

class Model_interactive extends CI_Model {

	function getQuestions($category_id = -1, $per_page = -1, $from = -1, $order_by = "DESC", $active = -1) {
		//$this->db->select('q.id, q.category_id, q.date_question, q.date_answer, u.name AS answerer, q.question_text, q.answer_text, q.user_email, q.user_name, q.show');
		//$this->db->from('questions q, users u');
		//$this->db->where('q.answerer_id', 'u.id');
		if ($active != -1)
			$this->db->where('active', $active);
		if ($category_id != -1)
			$this->db->where('category_id', $category_id);
		$this->db->order_by('id', $order_by);
		if ($per_page != -1 && $from != -1)
			$this->db->limit($per_page, $from);

		$questions = $this->db->get('questions')->result_array();
		if ($questions) {
			for ($i = 0; $i < count($questions); $i++) {
				if (isset($questions[$i]['answerer_id']) && !empty($questions[$i]['answerer_id'])) {
					$this->db->select('name');
					$this->db->where('id', $questions[$i]['answerer_id']);
					$answerer = $this->db->get('users')->result_array();
					unset($questions[$i]['answerer_id']);
					$questions[$i]['answerer'] = $answerer[0]['name'];
				}
			}
		}
		//var_dump($this->db->last_query());die();
		return $questions;
	}

	function getQuestion($id) {
		$this->db->where('id', $id);
		$question = $this->db->get('questions')->result_array();
		$question = $question[0];
		if ($question) {
			if (isset($question['answerer_id']) && !empty($question['answerer_id'])) {
				$this->db->select('name');
				$this->db->where('id', $question['answerer_id']);
				$answerer = $this->db->get('users')->result_array();
				unset($question['answerer_id']);
				$question['answerer'] = $answerer[0]['name'];
			}
		}
		return $question;
	}

	function getOpinion($id) {
		$this->db->where('id', $id);
		$opinion = $this->db->get('opinions')->result_array();
		$opinion = $opinion[0];
		return $opinion;
	}

	function getQuestionsCount($category_id = -1, $active = -1) {
		$this->db->select('count(id) as cid');
		if ($active != -1)
			$this->db->where('active', $active);
		if ($category_id != -1)
			$this->db->where('category_id', $category_id);
		$count = $this->db->get('questions')->result_array();
		return $count[0]['cid'];
	}

	function addQuestion($name, $email, $question, $cat_id = false) {
		$dbins = array(
			'user_name' => $name,
			'user_email' => $email,
			'question_text' => $question,
			'date_question' => date('d/m/Y H:i'),
			'active' => 0
		);
		if ($cat_id !== false)
			$dbins['category_id'] = $cat_id;
		return ($this->db->insert('questions', $dbins)) ? true : false;
	}

	function delQuestion($id) {
		if ($id) {
			$this->db->where('id', $id);
			if ($this->db->delete('questions'))
				return true;
		}
		return false;
	}

	function editQuestion($question) {
		$dbins = array(
			'user_name' => $question['name'],
			'user_email' => $question['email'],
			'question_text' => $question['question'],
			'active' => $question['active']
		);
		if (isset($question['answer']) && !empty($question['answer'])) {
			$dbins['answer_text'] = $question['answer'];
			$dbins['date_answer'] = date('d/m/Y H:i');
			if (!userdata('login'))
				exit();
			$this->db->select('id');
			$this->db->where('login', userdata('login'));
			$this->db->limit(1);
			$answerer_id = $this->db->get('users')->result_array();
			if (!$answerer_id[0]['id'])
				exit();
			$dbins['answerer_id'] = $answerer_id[0]['id'];
		}
		$this->db->where('id', $question['id']);

		return ($this->db->update('questions', $dbins))? true : false ;
	}

	function getOpinions($article_id = -1, $per_page = -1, $from = -1, $order_by = "DESC", $active = -1) {
		if ($active != -1)
			$this->db->where('active', $active);
		if ($article_id != -1)
			$this->db->where('article_id', $article_id);
		$this->db->order_by('id', $order_by);
		if ($per_page != -1 && $from != -1)
			$this->db->limit($per_page, $from);

		$opinions = $this->db->get('opinions')->result_array();
		return $opinions;
	}

	function getOpinionsCount($category_id = -1, $active = -1) {
		$this->db->select('count(id) as cid');
		if ($active != -1)
			$this->db->where('active', $active);
		if ($category_id != -1)
			$this->db->where('category_id', $category_id);
		$count = $this->db->get('Opinions')->result_array();
		return $count[0]['cid'];
	}

	function addOpinion($name, $email, $opinion, $article_id = false) {
		$dbins = array(
			'user_name' => $name,
			'user_email' => $email,
			'opinion' => $opinion,
			'date' => date('d/m/Y H:i'),
			'active' => 0
		);
		if ($article_id !== false)
			$dbins['article_id'] = $article_id;
		return ($this->db->insert('opinions', $dbins))? true : false;
	}

	function delOpinion($id) {
		if ($id) {
			$this->db->where('id', $id);
			if ($this->db->delete('Opinions'))
				return true;
		}
		return false;
	}

	function editOpinion($opinion) {
		$dbins = array(
			'user_name' => $opinion['name'],
			'user_email' => $opinion['email'],
			'opinion' => $opinion['opinion'],
			'date' => date('d/m/Y H:i'),
			'active' => $opinion['active']
		);
		$this->db->where('id', $opinion['id']);

		return ($this->db->update('opinions', $dbins))? true : false ;
	}
}

?>