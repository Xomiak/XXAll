<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
require_once('./application/thumbs/ThumbLib.inc.php');

class Interactive extends CI_Controller {

	private $current_lang;

	public function __construct() {
		parent::__construct();
		$this->load->helper('captcha_img');
		$this->load->model('Model_interactive', 'interactive');
		$this->load->model('Model_pages', 'pages');
		$this->load->model('Model_options', 'options');
		$this->load->model('Model_users', 'users');

		set_userdata('last_url', $_SERVER['REQUEST_URI']);
	}

	public function questions($url) {
		$page = $this->pages->getPageByUrl('questions/' . $url);
		$questionsCount = $this->interactive->getQuestionsCount(-1, 1);

		$per_page = userdata('per_page');
		if (!$per_page)
			$per_page = 10;

		$from = intval(str_replace('!', '', $this->uri->segment(2)));
		$page_number = $from / $per_page + 1;

		$data['pager'] = createPaginator($url, $per_page, $questionsCount);

		$data['questions'] = $this->interactive->getQuestions(-1, $per_page, $from,
			'DESC', 1);

		$data['title'] = getLangText($page['title']) . getOption('global_title_' . $this->
					current_lang);
		$data['keywords'] = getLangText($page['keywords']) . getOption('global_keywords_' .
				$this->current_lang);
		$data['description'] = getLangText($page['description']) . getOption('global_description_' .
				$this->current_lang);
		$data['robots'] = $page['robots'];
		$data['page'] = $page;
		$data['server_name'] = $this->model_options->getOption('server_name');
		$data['seo'] = getLangText($page['seo']);
		$data['page_number'] = $page_number;
		$data['cap'] = createCaptcha();
		if ($page['template'] != '')
			$this->load->view('templates/' . $page['template'], $data);
		else
			$this->load->view('templates/page.tpl.php', $data);

	}

	public function opinions($url) {
		$page = $this->pages->getPageByUrl('opinions/' . $url);
		$questionsCount = $this->interactive->getQuestionsCount(-1, 1);

		$per_page = userdata('per_page');
		if (!$per_page)
			$per_page = 10;

		$from = intval(str_replace('!', '', $this->uri->segment(2)));
		$page_number = $from / $per_page + 1;

		$data['pager'] = createPaginator($url, $per_page, $questionsCount);

		$data['opinions'] = $this->interactive->getOpinions(-1, $per_page, $from, 'DESC', 1);

		$data['title'] = getLangText($page['title']) . getOption('global_title_' . $this->
					current_lang);
		$data['keywords'] = getLangText($page['keywords']) . getOption('global_keywords_' .
				$this->current_lang);
		$data['description'] = getLangText($page['description']) . getOption('global_description_' .
				$this->current_lang);
		$data['robots'] = $page['robots'];
		$data['page'] = $page;
		$data['server_name'] = $this->model_options->getOption('server_name');
		$data['seo'] = getLangText($page['seo']);
		$data['page_number'] = $page_number;
		$data['cap'] = createCaptcha();
		if ($page['template'] != '')
			$this->load->view('templates/' . $page['template'], $data);
		else
			$this->load->view('templates/page.tpl.php', $data);
	}

	function addQuestion() {
		$name = validate($_POST['name'], 'string');
		$email = validate($_POST['email'], 'string');
		$question = validate($_POST['question'], 'string');
		//$cat_id = validate($_POST['category_id'], 'number', '', true);

		if ($name === false)
			set_userdata('msg', 'Не задано имя');
		elseif ($email === false)
			set_userdata('msg', 'Не задан email');
		elseif ($question === false)
			set_userdata('msg', 'Не задан вопрос');
		else {
			$res = $this->interactive->addQuestion($name, $email, $question); //, $cat_id);
			if ($res) {
				set_userdata('msg', 'Вопрос принят. Ожидайте ответа администратора.');
			} else {
				set_userdata('msg', 'Не удалось отправить вопрос.');
			}
			redirect('/questions/vopros-otvet/');
		}
	}

	function addOpinion() {
		//$name = validate($_POST['name'], 'string');
		$id = validate($_POST['user_id'], 'number');
		$opinion = validate($_POST['opinion'], 'string');
		$article_id = validate($_POST['article_id'], 'number');
		$captcha = (isset($_POST['captcha']) && strlen($_POST['captcha']) < 5) ? validate($_POST['captcha'], 'string') : false;

		if ($id === false)
			set_userdata('msg', 'Не определен пользователь');
		elseif ($article_id === false)
			set_userdata('msg', 'Не задан идентификатор статьи');
		elseif ($opinion === false)
			set_userdata('msg', 'Не задан отзыв');
		elseif ($captcha === false || ($cap = checkCaptcha($captcha)) !== true)
			set_userdata('msg', 'Не правильно введены цифры с картинки');
		else {
			$user = $this->users->getUserById($id);
			if ($user && $user['login'] == userdata('login')) {
				$res = $this->interactive->addOpinion($user['name'], $user['email'], $opinion, $article_id); //, $cat_id);
				if ($res)
					set_userdata('msg', 'Отзыв принят. Ожидайте ответа администратора.');
				else
					set_userdata('msg', 'Не удалось отправить отзыв.');
			} else
				set_userdata('msg', 'Пользователь не найден');
		}
		redirect($_POST['back']);
	}

}
