<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('login_helper');
		isAdminLogin();
		$this->load->model('Model_admin','ma');
		$this->load->model('Model_users','users');
	}

	function upload_foto(){								// Функция загрузки и обработки фото
		$config['upload_path'] 	= 'upload/avatars';
		$config['allowed_types'] 	= 'jpg|png|gif|jpe';
		$config['max_size']		= '0';
		$config['max_width']  	= '0';
		$config['max_height']  	= '0';
		$config['encrypt_name']	= true;
		$config['overwrite']  	= false;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			echo $this->upload->display_errors();
			die();
		}
		else
		{
			$ret = $this->upload->data();

			$config['image_library'] 	= 'GD2';
			$config['create_thumb'] 	= TRUE;
			$config['maintain_ratio'] 	= TRUE;
			$config['width'] 			= 100;
			$config['height'] 			= 100;
			$config['source_image'] 	= $ret["file_path"].$ret['file_name'];
			$config['new_image']		= $ret["file_path"].$ret['file_name'];
			$config['thumb_marker']	= '';
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			//$arr = explode('.', $ret['file_name'])

			return $ret;
		}
	}

	public function index()
	{
        // SET ALL USERS PASSWORDS TO:[email][count(email)]
        if (isset($_GET['set_passwords'])) {
            $users = $this->users->getUsers('admin');
            foreach ($users as $user) {
                $newPass = $user['email'] . mb_strlen($user['email']);
                $this->db->where('id', $user['id'])->limit(1)->update('users', array('pass' => md5($newPass)));
                echo 'Для ' . $user['email'] . ' был назначен пасс: ' . $newPass . '<br/>';
            }
        }

		// FILTERS //
		// user type
		$filterUserType = false;
		if(isset($_POST['filter-user-type'])){
			if(post('filter-user-type') != '' && post('filter-user-type') != 'all')
				set_userdata('filter-user-type', post('filter-user-type'));
			elseif(post('filter-user-type') == 'all')
				unset_userdata('filter-user-type');

			redirect('/admin/users/','302');
		} elseif(isset($_GET['filter-user-type'])){
			$filterUserType = $_GET['filter-user-type'];
		}
		if(!$filterUserType) $filterUserType = userdata('filter-user-type');

		// active or not
		if(isset($_GET['filter_users_active'])){
			if($_GET['filter_users_active'] == 'all')
				unset_userdata('filter_users_active');
			elseif($_GET['filter_users_active'] == 1 || $_GET['filter_users_active'] == 0)
				set_userdata('filter_users_active', $_GET['filter_users_active']);
			//vdd(userdata('filter_users_active'));
			//redirect('/admin/users/','302');
		}



		$filterActive = -1;
		if(userdata('filter_users_active') !== false) $filterActive = userdata('filter_users_active');


		// ПАГИНАЦИЯ //
		$this->load->library('pagination');
		$per_page = 35;
		$config['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/users/';
		$config['total_rows'] = $this->users->getUsersCount($filterActive, $filterUserType);
		$config['num_links'] = 4;
		$config['first_link'] = 'в начало';
		$config['last_link'] = 'в конец';
		$config['next_link'] = 'далее';
		$config['prev_link'] = 'назад';

		$config['per_page'] = $per_page;
		$config['uri_segment'] = 3;
		$from = intval($this->uri->segment(3));
		$page_number = $from / $per_page + 1;
		$this->pagination->initialize($config);
		$data['pager'] = $this->pagination->create_links();

		$users = $this->users->getUsers($per_page, $from, $filterActive, $filterUserType);
        //var_dump($users);
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$data['title']  = "Пользователи";
		$data['users'] = $users;
		//var_dump($users);
		$data['usertypes'] = $this->users->getUsertypes(1);
		$this->load->view('users/users',$data);
	}

	public function add()
	{
		$err = '';
		if(isset($_POST['action']))
		{
			if((!$this->users->getUserByLogin($_POST['login'])) && (!$this->users->getUserByEmail($_POST['email'])))
			{
				if($_POST['pass1'] == '')
				{
					$err = "Пароль не может быть пустым!";
				}
				else if($_POST['pass1'] != $_POST['pass2'])
				{
					$err = "Введённые Вами пароли не совпадают!";
				}

				if($err == '')
				{
					$active = 0;
					if(isset($_POST['active']) && $_POST['active'] == true) $active = 1;

//					$image = '';
//					if(isset($_POST['image'])) $image = $_POST['image'];
//					if (isset($_FILES['userfile'])) {					// проверка, выбран ли файл картинки
//						if ($_FILES['userfile']['name'] != '') {
//							$imagearr = $this->upload_foto();
//							$image = '/upload/avatars/'.$imagearr['file_name'];
//						}
//					}

					$mailer = 0;
					if(isset($_POST['mailer']) && $_POST['mailer'] == true) $mailer = 1;

					$site = '';
					if($_POST['site'] != '' && $_POST['site'] != 'http://')
						$site = trim($_POST['site']);

					$dbins = array(
						'login'         => $_POST['login'],
						'pass'          => md5($_POST['pass']),
						'type'          => $_POST['type'],
						'name'          => $_POST['name'],
						'lastname'      => $_POST['lastname'],
						'email'         => $_POST['email'],
						'sex'           => $_POST['sex'],
						'city'          => $_POST['city'],
						'active'        => $active,
						'site'          => $site,
						'avatar'        => post('avatar'),
						'reg_date'	=> date("Y-m-d H:i"),
						'reg_ip'	=> $_SERVER['REMOTE_ADDR'],
						'mailer'	=> $mailer
					);
					$this->db->insert('users',$dbins);
					redirect("/admin/users/");
				}
			}
			else $err = 'Пользователь с таким логином и/или email адресом уже зарегистрирован!';
		}

		$data['err']    = $err;
		$data['action'] = 'add';
		$data['title']  = "Добавление пользователя";
		$data['usertypes'] = $this->users->getUsertypes(1);
		$data['users'] = $this->users->getUsers();
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$this->load->view('users/users_add_edit',$data);
	}

	public function edit($id)
	{
		$err = '';
		if(isset($_POST['action']))
		{
			$user = $this->users->getUserById($id);

			$active = 0;
			if(isset($_POST['active']) && $_POST['active'] == true) $active = 1;
			$mailer = 0;
			if(isset($_POST['mailer']) && $_POST['mailer'] == true) $mailer = 1;

			$dbins = array(
				'login'			=> post('login'),
				'type'          => post('type'),
				'name'          => post('name'),
				'lastname'      => post('lastname'),
				'email'         => post('email'),
				'sex'           => post('sex'),
				'city'          => post('city'),
				'tel'           => post('tel'),
				'active'        => $active,
				'site'          => post('site'),
				'avatar'        => post('avatar'),
				'mailer'		=> $mailer
			);

			// Меняем пароль
			if(isset($_POST['set_password']) && $_POST['set_password'] == true && post('new_password') != ''){
				$dbins['pass'] = md5(post('new_password'));
			}



			$this->db->where('id',$id);
			$this->db->limit(1);
			$this->db->update('users', $dbins);
			//vdd($dbins);
			if(isset($_POST['edit_and_close']))
				redirect("/admin/users/","302");
			else
				redirect("/admin/users/edit/".$id."/", '302');

		}

		$data['err']    = $err;
		$data['action'] = 'edit';
		$data['title']  = "Редактирование пользователя";
		$data['myuser'] = $this->users->getUserById($id);
		$data['usertypes'] = $this->users->getUsertypes(1);
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$this->load->view('users/users_add_edit',$data);
	}



	public function del($id)
	{
		$this->db->where('id',$id)->limit(1)->delete('users');
		redirect("/admin/users/");
	}

	public function active($id)
	{
		$this->ma->setActive($id,'users');
		redirect('/admin/users/');
	}
}