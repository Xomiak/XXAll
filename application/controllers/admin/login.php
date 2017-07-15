<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	function GetRealIp()
	{
	 if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
	 {
	   $ip=$_SERVER['HTTP_CLIENT_IP'];
	 }
	 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	 {
	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	 }
	 else
	 {
	   $ip=$_SERVER['REMOTE_ADDR'];
	 }
	 return $ip;
	}

	public function soc()
	{

		$user = false;
		$isAuth = false;
		$this->load->library('Uauth');
		//$this->load->library('Ulogin');
        require_once X_PATH."/application/libraries/Ulogin.php";
        $ulogin = new Ulogin();
		$this->load->model('Model_users','users');
		$s_user = $ulogin->userdata();
        if($_POST)vd($_POST);
        if($_GET)vd($_GET);
		if($s_user)
		{
            			//vd($s_user);
			$this->db->where('profile', $s_user['profile']);
			$this->db->or_where('email', $s_user['email']);
			$this->db->limit(1);
			$user = $this->db->get('users')->result_array();

			if(!$user)
			{
				if($s_user['sex'] == 1) $s_user['sex'] = 'w';
				elseif($s_user['sex'] == 2) $s_user['sex'] = 'm';

				$dbins = array(
					'login' 	=> $s_user['email'],
					'email' 	=> $s_user['email'],
					'type' 		=> 'admin',
					'active'	=> 0,
					'reg_date'	=> date("Y-m-d H:i"),
					'reg_ip'	=> $_SERVER['REMOTE_ADDR'],
					'pass'		=> md5(getRandCode()),
					'activation'	=> 1
				);

				if(isset($s_user['uid'])) $dbins['uid'] = $s_user['uid'];
				if(isset($s_user['sex'])) $dbins['sex'] = $s_user['sex'];
				if(isset($s_user['identity'])) $dbins['identity'] = $s_user['identity'];
				if(isset($s_user['network'])) $dbins['network'] = $s_user['network'];
				if(isset($s_user['nikname'])) $dbins['nikname'] = $s_user['nikname'];
				if(isset($s_user['first_name'])) $dbins['name'] = $s_user['first_name'];
				if(isset($s_user['last_name'])) $dbins['lastname'] = $s_user['last_name'];
				if(isset($s_user['photo_big'])) $dbins['photo'] = $s_user['photo_big'];
				if(isset($s_user['bdate'])) $dbins['bdate'] = $s_user['bdate'];
				if(isset($s_user['photo'])) $dbins['avatar'] = $s_user['photo'];
				if(isset($s_user['profile'])) $dbins['profile'] = $s_user['profile'];
				if(isset($s_user['city'])) $dbins['city'] = $s_user['city'];
				if(isset($s_user['country'])) $dbins['country'] = $s_user['country'];

				$this->db->insert('users', $dbins);


				$user = $this->users->getUserByLogin($s_user['email']);
				//vdd($dbins);
				if($user)
				{
					$isAuth = $this->authorization($user);
				}
			}
			else
			{
				$user = $user[0];
				$this->users->editSocialUserDetails($user, $s_user);
				$isAuth = $this->authorization($user);
			}

			if($isAuth) redirect('/admin/');
			else
				redirect('/admin/login/soc/');
		}
		$data['title']  = "Авторизация";
//vdd(TEMPLATE_PATH);
        //$this->load->view('admin/modules/head',$data);
        //vdd("END");
        //$this->load->view('admin/modules/header',$data);
        $this->load->view('login_soc.php', $data);
        //$this->load->view('admin/main/footer', $data);
	}

	private function authorization($user)
	{
		if($user['active'] == 1){
			$this->session->set_userdata('user_id',$user['id']);
			$this->session->set_userdata('login',$user['login']);
			$this->session->set_userdata('pass',$user['pass']);
			$this->session->set_userdata('type',$user['type']);
			//vdd($user);
			$this->session->set_userdata('social', true);

			$this->users->setLastDateAndIp($user['login']);
			return true;
		}
		else set_userdata('login_err','Ваш профиль не активирован главным администратором!');
		//vdd(userdata('login_err'));
		return false;
	}
	
	public function index()
	{
            if(isset($_POST['login']) && isset($_POST['pass']))
            {
		$logs = $this->model_options->getOption('logs');
                $this->load->model('Model_admin','ma');
                $user = $this->ma->getUser($_POST['login']);
                if(!$user){
                    set_userdata('login_err','Логин либо пароль введены не верно!');
		    if($logs)
		    {
			$dbins = array(
			    'date'		=> date("Y-m-d"),
			    'time'		=> date("H:i"),
			    'text'		=> "Пользователь не существует: попытка входа в админку",
			    'ip'		=> $this->GetRealIp(),
			    'login'		=> $_POST['login'],
			    'type'		=> "admin",
			    'error'		=> "1"
			);
			$this->db->insert('logs', $dbins);
		    }
		    redirect('/admin');
                }
                else if($user['pass'] != md5($_POST['pass']))
		{
		    set_userdata('login_err','Логин либо пароль введены не верно!');
		    if($logs)
		    {
			$dbins = array(
			    'date'		=> date("Y-m-d"),
			    'time'		=> date("H:i"),
			    'text'		=> "Не верный пароль: попытка входа в админку. Логин: ".$_POST['login']." Пароль: ".$_POST['pass'],
			    'ip'		=> $this->GetRealIp(),
			    'login'		=> $_POST['login'],
			    'type'		=> "admin",
			    'error'		=> "1"
			);
			$this->db->insert('logs', $dbins);
		    }
		    redirect('/admin');
		}
		else if($user['type'] != 'admin' && $user['type'] != 'moder')
		{
		    set_userdata('login_err','У Вас не достаточно прав для доступа в админпанель!');
		    if($logs)
		    {
			$dbins = array(
			    'date'		=> date("Y-m-d"),
			    'time'		=> date("H:i"),
			    'text'		=> "Недостаточно прав: попытка входа в админку. Логин: ".$_POST['login'],
			    'ip'		=> $this->GetRealIp(),
			    'login'		=> $_POST['login'],
			    'type'		=> "admin",
			    'error'		=> "1"
			);
			$this->db->insert('logs', $dbins);
		    }
		    redirect('/admin');
		}
		else
		{
		    set_userdata('login',$user['login']);
		    set_userdata('pass',$user['pass']);
		    set_userdata('type',$user['type']);
		    set_userdata('name',$user['login']);
		    if($logs)
		    {
			$dbins = array(
			    'date'		=> date("Y-m-d"),
			    'time'		=> date("H:i"),
			    'text'		=> "Авторизация в админпанели успешна. Логин: ".$_POST['login'],
			    'ip'		=> $this->GetRealIp(),
			    'login'		=> $_POST['login'],
			    'type'		=> "admin",
			    'error'		=> "0"
			);
			$this->db->insert('logs', $dbins);
		    }
		    redirect("/admin/");
		}
            }
            else
            {
                $data['title']  = "Авторизация";
                $this->load->view('login',$data);
            }
	}
	
	public function logoff()
	{
	    $logs = $this->model_options->getOption('logs');
	    if($logs)
	    {
		$dbins = array(
		    'date'		=> date("Y-m-d"),
		    'time'		=> date("H:i"),
		    'text'		=> "Выход из админпанели",
		    'ip'		=> $this->GetRealIp(),
		    'login'		=> userdata("login"),
		    'type'		=> "admin",
		    'error'		=> "0"
		);
		$this->db->insert('logs', $dbins);
	    }
	    
	    unset_userdata('login');
	    unset_userdata('pass');
	    unset_userdata('type');
	    unset_userdata('name');
	    
	    redirect("/");
	}

	public function test()
    {
        $data['title'] = "Posts List";

        $this->load->view('my_test.php', $data);
    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */