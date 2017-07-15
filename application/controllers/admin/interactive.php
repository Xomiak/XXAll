<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Interactive extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('login_helper');
		isAdminLogin();
		$this->load->model('Model_admin', 'ma');
		$this->load->model('Model_interactive', 'interactive');
	}

	public function questions() {
		$data['questions'] = $this->interactive->getQuestions();
		$data['title'] = "Вопрос-ответ";

		$this->load->view('admin/interactive/questions', $data);
	}

	public function opinions() {
		$data['opinions'] = $this->interactive->getopinions();
		$data['title'] = "Отзывы";

		$this->load->view('admin/interactive/opinions', $data);
	}

	public function editQuestion($id) {

		if (isset($_POST['question'])) {
			$question['name'] = validate($_POST['name'], 'string');
			$question['email'] = validate($_POST['email'], 'string');
			$question['question'] = validate($_POST['question'], 'string');
			$question['answer'] = validate($_POST['answer'], 'string');
			$question['show'] = (isset($_POST['show']) && $_POST['show']) ? 1 : 0;
			$question['id'] = $id;

			$res = $this->interactive->editQuestion($question); //, $cat_id);
		}
		$data['type'] = $this->session->userdata('type');
		$data['question'] = $this->interactive->getQuestion($id);
		$data['title'] = "Редактирование вопроса";
		$this->load->view('admin/interactive/question_edit', $data);
	}

	public function editOpinion($id) {

		if (isset($_POST['opinion'])) {
			$opinion['name'] = validate($_POST['name'], 'string');
			$opinion['email'] = validate($_POST['email'], 'string');
			$opinion['opinion'] = validate($_POST['opinion'], 'string');
			$opinion['active'] = (isset($_POST['active']) && $_POST['active']) ? 1 : 0;
			$opinion['id'] = $id;

			$res = $this->interactive->editOpinion($opinion); //, $cat_id);
		}
		$data['type'] = $this->session->userdata('type');
		$data['opinion'] = $this->interactive->getOpinion($id);
		$data['title'] = "Редактирование отзыва";
		$this->load->view('admin/interactive/opinion_edit', $data);
	}

	public function delQuestion($id) {
		$this->db->where('id', $id)->limit(1)->delete('questions');
		redirect("/admin/interactive/questions/");
	}
	public function delOpinion($id) {
		$this->db->where('id', $id)->limit(1)->delete('opinions');
		redirect("/admin/interactive/opinions/");
	}

	public function sendNotifyToEmail() {
		$subject = 'Ответ на сайте ' . $_SERVER['HTTP_PATH'];
		$msg = 'Ваш вопрос: <br />' . nl2br($_POST['question']);
		if (isset($_POST['answer']) && !empty($_POST['answer']))
			$msg .= '<br />Ответ: <br />' . nl2br($_POST['answer']);
		mail_send();
	}
}