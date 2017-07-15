<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Comments extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('login_helper');
		$this->load->model('Model_articles', 'art');
		$this->load->model('Model_categories', 'categories');
		$this->load->model('Model_users', 'users');
		$this->load->model('Model_gallery', 'gallery');
		$this->load->model('Model_comments', 'comments');
		$this->load->model('Model_spambot', 'spambot');
		//$this->session->set_userdata('last_url', $_SERVER['REQUEST_URI']);
	}

	public function index() {
		err404();
		$this->load->model('Model_main', 'main');
		$this->load->helper('menu_helper');
		$tkdzst = $this->main->getMain();
		$data['title'] = $tkdzst['title'];
		$data['keywords'] = $tkdzst['keywords'];
		$data['description'] = $tkdzst['description'];
		$data['robots'] = "index, follow";
		$data['h1'] = $tkdzst['h1'];
		$data['seo'] = $tkdzst['seo'];
		$data['glavnoe'] = $this->art->getGlavnoe();
		$this->load->view('main', $data);
	}


	public function add() {
		if (isset($_POST['comment']) && isset($_POST['name']) && (isset($_POST['article_id']) || isset($_POST['image_id']) || isset($_POST['page_id']))) {
			$this->session->set_userdata('comment_name', $_POST['name']);
			$this->session->set_userdata('comment_comment', $_POST['comment']);

			$comment = '';
			if (isset($_POST['answerComment']))
				$comment = validate($_POST['answerComment'], 'string');

			$comment .= $_POST['comment'];
			$comment = validate($comment, 'string');
			$comments_allowed_tags = $this->model_options->getOption('comments_allowed_tags');
			$comment = strip_tags($comment, $comments_allowed_tags);
			$name = validate($_POST['name'], 'string');
			if (isset($_POST['answ_comm_id']))
				$answ_comm_id = validate($_POST['answ_comm_id'], 'number');
			$article_id = '';
			$image_id = '';
			$page_id = '';
			if (isset($_POST['article_id'])) {
				$article_id = $_POST['article_id'];
				$this->session->set_userdata('comment_article_id', $article_id);
			}
			if (isset($_POST['image_id'])) {
				$image_id = $_POST['image_id'];
				$this->session->set_userdata('comment_image_id', $image_id);
			}
			if (isset($_POST['page_id'])) {
				$page_id = $_POST['page_id'];
				$this->session->set_userdata('comment_page_id', $page_id);
			}

			/*
			// КАПЧА
			$expiration = time()-7200; // Two hour limit
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

			// Then see if a captcha exists:
			$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
			$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();
			///////////
			*/
			$user_id = 0;
			if (isset($_POST['user_id']))
				$user_id = validate($_POST['user_id'], 'number');
			if ($comment == '')
				$this->session->set_userdata('err_comment', 'Комментарий не может быть пустым!');
			elseif ($name == '')
				$this->session->set_userdata('err_name', 'Имя не может быть пустым!');
			//elseif($row->count > 0){
			else {
				$dbins = array(
					'name' => $name,
					'comment' => $comment,
					'article_id' => $article_id,
					'image_id' => $image_id,
					'page_id' => $page_id,
					'answ_comm_id' => isset($answ_comm_id) ? $answ_comm_id : null,
					'ip' => $_SERVER['REMOTE_ADDR'],
					'date' => date("Y-m-d"),
					'time' => date("H:i"),
					'user_id' => $user_id
				);
				$this->comments->addComment($dbins);
				$this->session->unset_userdata('comment_name');
				$this->session->unset_userdata('comment_comment');
				$this->session->unset_userdata('comment_article_id');


				// ОТПРАВКА СООБЩЕНИЯ АВТОРУ О НОВОМ КОММЕНТАРИИ
				/*
				$new_comment_author_mail_send = $this->model_options->getOption('new_comment_author_mail_send');
				if(!$new_comment_author_mail_send) $new_comment_author_mail_send = 1;

				if($new_comment_author_mail_send == 1)
				{
					$this->load->helper("translit_helper");
					$comment = BBCodesToHtml($comment);

					if($article_id != '' && $article_id != 0)
					{
						$article = $this->art->getArticleById($article_id);
						if($article)
						{
							$url = '/'.$article['url'].'/';
							$category = $this->categories->getCategoryById($article['category_id']);
							$url = '/'.$category['url'].$url;
							while($category['parent'] != 0)
							{
								$category = $this->categories->getCategoryById($category['parent']);
								$url = '/'.$category['url'].$url;
							}

							$url = "http://".$_SERVER['SERVER_NAME'].$url;
							$message = 'К Вашей статье на сайте <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a> добавлен новый комментарий!<br /><br />
							Автор комментария: '.$name.'<br />
							Текст комментария:<br />
							'.$comment.'
							<br /><br />
							<a href="'.$url.'#comments">Перейти к просмотру комментариев</a><br /><br />
							<i>С Уважением, Администрация сайта <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a></i>';

							$user = $this->users->getUserByLogin($article['login']);
							if($user)
							{
								$this->load->helper('mail_helper');
								mail_send($user['email'],'Новый комментарий', $message);
							}
						}
					}
					elseif($image_id != '')
					{
						$image = $this->gallery->getFoto($image_id,1);
						if($image)
						{
							$url = '/image/'.$image['id'].'/';
							$category = $this->gallery->getCategoryById($image['category_id']);
							if($category)
							{
								$url = '/'.$category['url'].$url;
								while($category['parent_id'] != 0)
								{
									$category = $this->gallery->getCategoryById($category['parent_id']);
									$url = '/'.$category['url'].$url;
									$url = "http://".$_SERVER['SERVER_NAME'].$url;

									$message = 'К Вашей фото "'.$image['name'].'" на сайте <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a> добавлен новый комментарий!<br /><br />
									Автор комментария: '.$name.'<br />
									Текст комментария:<br />
									'.$comment.'
									<br /><br />
									<a href="'.$url.'#comments">Перейти к просмотру комментариев</a><br /><br />
									<i>С Уважением, Администрация сайта <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a></i>';

									$user = $this->users->getUserByLogin($image['login']);
									if($user)
									{
										$this->load->helper('mail_helper');
										mail_send($user['email'],'Новый комментарий', $message);
									}
								}
							}
						}
					}
				}

				// ОТПРАВКА СООБЩЕНИЯ АДМИНУ О НОВОМ КОММЕНТАРИИ
				$send_mail_new_comment = $this->model_options->getOption('send_mail_new_comment');
				if(!$send_mail_new_comment) $send_mail_new_comment = false;

				if($send_mail_new_comment)
				{
					$this->load->helper("translit_helper");
					$comment = BBCodesToHtml($comment);

					if($article_id != '' && $article_id != 0)
					{
						$article = $this->art->getArticleById($article_id);
						if($article)
						{
							$url = '/'.$article['url'].'/';
							$category = $this->categories->getCategoryById($article['category_id']);
							$url = '/'.$category['url'].$url;
							while($category['parent'] != 0)
							{
								$category = $this->categories->getCategoryById($category['parent']);
								$url = '/'.$category['url'].$url;
							}

							$url = "http://".$_SERVER['SERVER_NAME'].$url;
							$message = 'К Вашей статье на сайте <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a> добавлен новый комментарий!<br /><br />
							Автор комментария: '.$name.'<br />
							Текст комментария:<br />
							'.$comment.'
							<br /><br />
							<a href="'.$url.'#comments">Перейти к просмотру комментариев</a><br /><br />
							<i>С Уважением, Администрация сайта <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a></i>';


							$this->load->helper('mail_helper');
							mail_send($send_mail_new_comment,'Новый комментарий', $message);
						}
					}
				}

				if(isset($_POST['answer']))
				{
					$answer = $this->users->getUserByLogin($_POST['answer']);
					if($answer)
					{
						if($article_id != '' && $article_id != 0)
						{
							$url = '/'.$article['url'].'/';
							$category = $this->categories->getCategoryById($article['category_id']);
							$url = '/'.$category['url'].$url;
							while($category['parent'] != 0)
							{
								$category = $this->categories->getCategoryById($category['parent']);
								$url = '/'.$category['url'].$url;
							}
							$url = "http://".$_SERVER['SERVER_NAME'].$url;
							$pos = strpos($comment,'[/quote]') + 8;

							$this->load->helper("translit_helper");
							//$comment = BBCodesToHtml($comment);

							//$comment = substr($comment,$pos);
							$message = 'К Вашему комментарию к статье на сайте <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a> добавлен новый ответ!<br /><br />
							Автор комментария: '.$name.'<br />
							Текст комментария:<br />
							'.$comment.'
							<br /><br />
							<a href="'.$url.'#comments">Перейти к просмотру комментариев</a><br /><br />
							<i>С Уважением, Администрация сайта <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a></i>';

							//$user = $this->users->getUserByLogin($article['login']);
							$this->load->helper('mail_helper');
							mail_send($answer['email'],'Новый комментарий', $message);
						}
						elseif($image_id != '')
						{

							$image = $this->gallery->getFoto($image_id,1);
							if($image)
							{
								$url = '/image/'.$image['id'].'/';
								$category = $this->gallery->getCategoryById($image['category_id']);
								if($category)
								{
									$url = '/'.$category['url'].$url;
									while($category['parent_id'] != 0)
									{
										$category = $this->gallery->getCategoryById($category['parent_id']);
										$url = '/'.$category['url'].$url;
									}
									$url = "http://".$_SERVER['SERVER_NAME'].'/gallery'.$url;

									$message = 'К Вашему комментарию к фото "'.$image['name'].'" на сайте <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a> добавлен новый ответ!<br /><br />
									Автор комментария: '.$name.'<br />
									Текст комментария:<br />
									'.$comment.'
									<br /><br />
									<a href="'.$url.'#comments">Перейти к просмотру комментариев</a><br /><br />
									<i>С Уважением, Администрация сайта <a href="http://'.$_SERVER['SERVER_NAME'].'/">'.$_SERVER['SERVER_NAME'].'</a></i>';

									//$user = $this->users->getUserByLogin($article['login']);
									$this->load->helper('mail_helper');
									mail_send($answer['email'],'Новый комментарий', $message);
								}
							}
						}
					}
				}
				/////////////////////////////////////////////////
				*/
			}
			//else $this->session->set_userdata('err_spam','Вы не верно ввели цифры!');

		}

		if (isset($_POST['back'])) {
			redirect($_POST['back']);
		}
	}

	public function answer($id) {
		$comment = $this->comments->getCommentById($id);
		if ($comment) {
			$this->session->set_userdata('commentAnswer', $comment);
		}

		if ($this->session->userdata('last_url') !== false) {
			redirect($this->session->userdata('last_url') . '#add_comment_form');
		}
	}


}