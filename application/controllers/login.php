<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('login_helper');
		$this->load->model('Model_users', 'users');
	}

	public function index() {
	    if(post('action') == 'authByPass'){
	        var_dump("asd");
            $login = post('login');
            $pass = post('password');
            if($login != '' && $pass != '') {
                $user = $this->users->getUserByLogin($login);
                if($user){
                    if($user['pass'] == md5($pass)){
                        set_userdata('login', $login);
                        set_userdata('type', $user['type']);
                        set_userdata('pass', md5($pass));
                        set_userdata('msg','<h2>Вы успешно авторизировались!</h2>');
                    } else set_userdata('msg','<h2>Логин или пароль введены не верно!</h2>');
                } else set_userdata('msg','<h2>Логин или пароль введены не верно!</h2>');
            } else set_userdata('msg','<h2>Логин или пароль введены не верно!</h2>');
        } else {
            $this->load->library('uauth');
            $this->load->library('ulogin');
            $s_user = $this->ulogin->userdata();

            addOrEditUser($s_user);

            if ($_POST['ajax']) {
                echo json_encode(array('done' => false, 'err' => userdata('login_err')));
                exit();
            }


        }
        if (userdata('last_url')) {
            redirect(userdata('last_url'), '302');
        } else redirect('/', '302');
	}

	function getActiveCode($chars_min = 10, $chars_max = 20, $use_upper_case = false, $include_numbers = true, $include_special_chars = false) {
		getRandCode($chars_min, $chars_max, $use_upper_case, $include_numbers, $include_special_chars);
	}

	public function iframeLogin(){
        $this->load->view('users/login.tpl.php');
    }

	public function logout() {
	    echo 'Выходим из аккаунта...';
		unset_userdata('login');
		unset_userdata('name');
		unset_userdata('pass');
		unset_userdata('type');
		unset_userdata('user_id');

		set_userdata("msg",getLine('Вы успешно вышли из системы!'));


		if(userdata('last_url') != null)
		{
			redirect(userdata('last_url'),'302');
		}

		else
		redirect('/','302');

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */