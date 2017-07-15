<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Model_users', 'users');
		$this->session->set_userdata('last_url', $_SERVER['REQUEST_URI']);
		isLogin();
	}

	function upload_foto() { // Функция загрузки и обработки фото
		$config['upload_path'] = 'upload/avatars';
		$config['allowed_types'] = 'jpg|png|gif|jpe';
		$config['max_size'] = '0';
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$config['encrypt_name'] = true;
		$config['overwrite'] = false;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
			echo $this->upload->display_errors();
			die();
		} else {
			$ret = $this->upload->data();

			$config['image_library'] = 'GD2';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 100;
			$config['height'] = 100;
			$config['source_image'] = $ret["file_path"] . $ret['file_name'];
			$config['new_image'] = $ret["file_path"] . $ret['file_name'];
			$config['thumb_marker'] = '';
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			//$arr = explode('.', $ret['file_name'])

			return $ret;
		}
	}

	function getActiveCode($chars_min = 10, $chars_max = 20, $use_upper_case = false, $include_numbers = true, $include_special_chars = false) {
		$length = rand($chars_min, $chars_max);
		$selection = 'aeuoyibcdfghjklmnpqrstvwxzQWERTYUIOPASDFGHJKLZXCVBNM';
		if ($include_numbers) {
			$selection .= "1234567890";
		}
		if ($include_special_chars) {
			$selection .= "!@\"#$%&[]{}?|";
		}

		$password = "";
		for ($i = 0; $i < $length; $i++) {
			$current_letter = $use_upper_case ? (rand(0, 1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
			$password .= $current_letter;
		}

		return $password;
	}

	public function index() {
		if(isset($_POST['action']) && $_POST['action'] == 'register'){
		    $email = post('email');
		    $name = post('name');
		    $tel = post('tel');
		    $deyatelnost = post('deyatelnost');
		    $city = post('city');
            $comment = post('comment');
            if($email != '' && $name != '' && $tel != '' && $city != '') {
                $pass = getRandCode(5, 7);

                $dbins = array(
                    'login'     => $email,
                    'email'     => $email,
                    'name'     => $name,
                    'tel'       => $tel,
                    'city'      => $city,
                    'pass'      => md5($pass)
                );

                $added = $this->db->insert('users', $dbins);
                if($added) {
                    $message = 'Регистрация нового пользователя!<br/>';
                    $message .= 'Телефон: ' . $tel . '<br/>';
                    $message .= 'e-mail: ' . $email . '<br/>';
                    $message .= 'Деятельность: ' . $deyatelnost . '<br/>';
                    $message .= 'Город: ' . $city . '<br/>';
                    $message .= 'Комментарий: ' . $comment . '<br/><br />';
                    $message .= 'Для пользователя был сгенерирован пароль: ' . $pass . '<br/>';

                    $to = getOption('admin_email');
                    loadHelper('mail');
                    mail_send($to, 'Регистрация нового клиента', $message);
                    set_userdata('msg','<h2>Спасибо за регистрацию!</h2><h2>В скором времени с Вами свяжутся.</h2>');
                } else set_userdata('msg','<h2>Произошла ошибка!</h2><h2>Обратитесь к администратору!</h2>');
                $back = post('back');
                if(!$back) $back = '/';
                redirect($back, 302);
            }
        } else err404();
	}

	public function activation($user_id, $activation_code) {
		$user = $this->users->getUserById($user_id);
		$msg = '';
		$title = '';
		if ($user) {
			if ($user['activation_code'] == '' && $user['activation'] == 1) {
				$msg = "Ваша учётная запись уже активирована!";
				$title = "Активация учётной записи";
			} else if ($user['activation_code'] == $activation_code) {
				$dbins = array(
					'activation_code' => '',
					'activation' => 1,
					'active' => 1
				);
				$this->db->where('id', $user['id'])->limit(1)->update('users', $dbins);

				$this->load->helper('mail_helper');
				$message = '
				Вы успешно активировали свой аккаунт на сайте ' . $_SERVER['SERVER_NAME'] . '!<br />
				Ваш Логин: ' . $user['login'] . '<br />				
				<br />
				
				Благодарим Вас за проявленный интерес к нашему сайту!<br />
				<i>Администрация сайта <a href="http://' . $_SERVER['SERVER_NAME'] . '/">' . $_SERVER['SERVER_NAME'] . '</a>!</i>
				';
				mail_send($user['email'], 'Активация аккаунта на ' . $_SERVER['SERVER_NAME'] . ' прошла успешно!', $message);

				$msg = 'Поздравляем!<br />
					Вы успешно активировали свой аккаунт!<br />
					<a href="http://' . $_SERVER['SERVER_NAME'] . '/">Перейти на главную</a>';
				$title = "Активация выполнена успешно!";
				$this->session->set_userdata('login', $user['login']);
				$this->session->set_userdata('pass', $user['pass']);
				$this->session->set_userdata('type', $user['type']);
			} else {
				$msg = "Не верный код активации!<br />
					Вы можете <a rel=\"nofollow\" href=\"/register/send-activation-code/" . $user['id'] . "/\">запросить код активации</a>.";
				$title = "Ошибка активации";
			}
		} else {
			$msg = "Пользователь не найден в нашей базе!<br />
				Вам необходимо повторить процедуру регистрации.<br />
				<a rel=\"nofollow\" href=\"/register/\">Перейти к регистрации</a>";
			$title = "Ошибка активации";
		}

		$data['title'] = $title . $this->model_options->getOption('global_title');
		$data['keywords'] = $title . $this->model_options->getOption('global_keywords');
		$data['description'] = $title . $this->model_options->getOption('global_description');
		$data['robots'] = "noindex, follow";
		$data['h1'] = $title;
		$data['content'] = $msg;
		$data['breadcrumbs'] = $title;
		$data['seo'] = "";
		$this->load->view('msg.tpl.php', $data);
	}

	public function send_activation_code($user_id) {
		$msg = '';
		$title = '';
		$user = $this->users->getUserById($user_id);
		if ($user) {
			$title = "Повторный запрос кода активации аккаунта";
			$this->load->helper('mail_helper');
			$message = '
			Вы запросили повторный код активации на сайте ' . $_SERVER['SERVER_NAME'] . '!<br />
			Ваш Логин: ' . $user['login'] . '<br />			
			<br />
			Для активации Вашей учётной записи Вам необходимо перейти по следующей ссылке:<br />
			<a href="http://' . $_SERVER['SERVER_NAME'] . '/register/activation/' . $user['id'] . '/' . $user['activation_code'] . '/">
				http://' . $_SERVER['SERVER_NAME'] . '/register/activation/' . $user['id'] . '/' . $user['activation_code'] . '/
			</a><br />
			<br />
			Благодарим Вас за проявленный интерес к нашему сайту!<br />
			<i>Администрация сайта <a href="http://' . $_SERVER['SERVER_NAME'] . '/">' . $_SERVER['SERVER_NAME'] . '</a>!</i>
			';
			mail_send($user['email'], 'Регистрация на ' . $_SERVER['SERVER_NAME'], $message);
			$msg = 'Код активации был успешно отправлен на указанный Вами при регистрации e-mail адрес!';
		} else {
			$msg = "Такого пользователя в базе нет. Возможно он был удалён в связи с тем, что активация не была произведена вовремя.<br />
				Вам необходимо <a rel=\"nofollow\" href=\"/register/\">пройти регистрацию</a> заново.";
			$title = "Повторный запрос кода активации аккаунта";
		}
		$data['title'] = $title . $this->model_options->getOption('global_title');
		$data['keywords'] = $title . $this->model_options->getOption('global_keywords');
		$data['description'] = $title . $this->model_options->getOption('global_description');
		$data['robots'] = "noindex, follow";
		$data['h1'] = $title;
		$data['content'] = $msg;
		$data['breadcrumbs'] = $title;
		$data['seo'] = "";
		$this->load->view('msg.tpl.php', $data);
	}

	public function forgot() { // ЗАБЫЛИ ПАРОЛЬ
		$err = false;

		if (isset($_POST['email']) && isset($_POST['captcha'])) {
			if ($_POST['email'] == '')
				$err['email'] = 'e-mail не может быть пустым!';

			// КАПЧА
			$expiration = time() - 7200; // Two hour limit
			$this->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);

			// Then see if a captcha exists:
			$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
			$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();

			if ($row->count == 0)
				$err['captcha'] = "Вы не верно ввели цифры!";
			/////////////////////////////////

			$user = $this->users->getUserByEmail($_POST['email']);
			if (!$user)
				$msg = "Пользователь с таким e-mail адресом не зарегистрирован!";

			if (!isset($msg)) {
				$forgot = $this->getActiveCode();

				$dbins = array(
					'forgot' => $forgot
				);

				$this->db->where('id', $user['id']);
				$this->db->update('users', $dbins);

				$message = 'Добрый день!<br />
				Вы запросили восстановление логина и пароля на сайте <a href="http://' . $_SERVER['SERVER_NAME'] . '/">' . $_SERVER['SERVER_NAME'] . '</a>.<br /><br />
				Ваш логин на сайте: <strong>' . $user['login'] . '</strong><br />
				Чтобы задать новый пароль, перейдите по ссылке:<br />
				<a href="http://' . $_SERVER['SERVER_NAME'] . '/register/set_password/' . $user['id'] . '/' . $forgot . '/">http://' . $_SERVER['SERVER_NAME'] . '/register/set_password/' . $user['id'] . '/' . $forgot . '/</a><br /><br />
				Желаем Вам не забывать пароли)) Администрация сайта <a href="http://' . $_SERVER['SERVER_NAME'] . '/">' . $_SERVER['SERVER_NAME'] . '</a>';

				$this->load->helper('mail_helper');
				mail_send($user['email'], 'Восстановление логина и пароля на ' . $_SERVER['SERVER_NAME'], $message);

				$msg = "В течении 10 минут на Ваш e-mail адрес будет доставлено письмо с дальнейшими инструкциями.";
			}
			$title = "Востановление пароля";

			$data['title'] = $title . $this->model_options->getOption('global_title');
			$data['keywords'] = $title . $this->model_options->getOption('global_keywords');
			$data['description'] = $title . $this->model_options->getOption('global_description');
			$data['robots'] = "noindex, nofollow";
			$data['content'] = $msg;
			$data['breadcrumbs'] = $title;
			$data['seo'] = "";
			$this->load->view('msg.tpl.php', $data);
		} else {


			$this->load->helper('captcha');
			$vals = array(
				'img_path' => './captcha/',
				'font_path' => './system/fonts/texb.ttf',
				'img_url' => 'http://' . $_SERVER['SERVER_NAME'] . '/captcha/'
			);

			$cap = create_captcha($vals);

			$data = array(
				'captcha_time' => $cap['time'],
				'ip_address' => $this->input->ip_address(),
				'word' => $cap['word']
			);

			$query = $this->db->insert_string('captcha', $data);
			$this->db->query($query);

			$data['cap'] = $cap;
			$title = "Восстановление пароля";
			$data['err'] = $err;
			$data['title'] = $title . $this->model_options->getOption('global_title');
			$data['keywords'] = $title . $this->model_options->getOption('global_keywords');
			$data['description'] = $title . $this->model_options->getOption('global_description');
			$data['robots'] = "noindex, nofollow";
			$data['h1'] = $title;
			$data['breadcrumbs'] = $title;
			$data['seo'] = "";
			$this->load->view('register/forgot.tpl.php', $data);
		}

	}

	public function set_password($id, $forgot) {
		$user = $this->users->getUserById($id);
		if ($user) {
			if (($user['forgot'] != '') && $forgot == $user['forgot']) {
				$err = false;
				if (isset($_POST['pass']) && isset($_POST['pass2'])) {
					if ($_POST['pass'] == '' || $_POST['pass'] == ' ')
						$err['err'] = "Пароль не может быть пустым!";
					if ($_POST['pass'] != $_POST['pass2'])
						$err['err'] = "Введённые Вами пароли не совпадают!";

					if (!$err) {
						$dbins = array(
							'pass' => md5($_POST['pass']),
							'forgot' => ''
						);

						$this->db->where('id', $user['id']);
						$this->db->update('users', $dbins);


						$message = '
						Ваш пароль на сайте <a href="http://' . $_SERVER['SERVER_NAME'] . '/">' . $_SERVER['SERVER_NAME'] . '</a> был успешно изменён.<br /><br />
						Ваш логин: <strong>' . $user['login'] . '</strong><br />
						Ваш новый пароль: <strong>' . $_POST['pass'] . '</strong><br /><br />						
						Благодарим Вас за проявленный интерес к нашему ресурсу!<br />
						Администрация сайта <a href="http://' . $_SERVER['SERVER_NAME'] . '/">' . $_SERVER['SERVER_NAME'] . '</a>';

						unset($_POST);

						$this->load->helper('mail_helper');
						mail_send($user['email'], 'Пароль успешно изменён!', $message);

						$title = "Восстановление пароля";
						$msg = 'Ваш пароль был успешно изменён! Теперь Вы можете зайти на сайт под своим логином и новым паролем!<br /><br />
						<a href="/">На главную</a>';
						$data['title'] = $title . $this->model_options->getOption('global_title');
						$data['keywords'] = $title . $this->model_options->getOption('global_keywords');
						$data['description'] = $title . $this->model_options->getOption('global_description');
						$data['robots'] = "noindex, nofollow";
						$data['h1'] = $title;
						$data['content'] = $msg;
						$data['breadcrumbs'] = $title;
						$data['seo'] = "";
						$this->load->view('msg.tpl.php', $data);
					}
				}

				$title = "Восстановление пароля";
				$data['err'] = $err;
				$data['title'] = $title . $this->model_options->getOption('global_title');
				$data['keywords'] = $title . $this->model_options->getOption('global_keywords');
				$data['description'] = $title . $this->model_options->getOption('global_description');
				$data['robots'] = "noindex, nofollow";
				$data['h1'] = $title;
				$data['breadcrumbs'] = $title;
				$data['seo'] = "";
				$this->load->view('register/set_password.tpl.php', $data);
			} else {
				$title = "Восстановление пароля";
				$msg = 'При попытке восстановить пароль произошла непредвиденная ошибка! Возможно полученная Вами ссылка устарела.<br />
				Попробуйте повторить попытку восстановления пароля с <a rel="nofollow" href="/register/forgot/">самого начала</a>.<br />
				Если Вы неоднократно пробовали восстановить пароль и постоянно видите это сообщение, просим Вас связаться с администрацией сайта!<br /><br />
				<a href="/">На главную</a>';
				$data['title'] = $title . $this->model_options->getOption('global_title');
				$data['keywords'] = $title . $this->model_options->getOption('global_keywords');
				$data['description'] = $title . $this->model_options->getOption('global_description');
				$data['robots'] = "noindex, nofollow";
				$data['h1'] = $title;
				$data['content'] = $msg;
				$data['breadcrumbs'] = $title;
				$data['seo'] = "";
				$this->load->view('msg.tpl.php', $data);
			}
		} else
			err404();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */