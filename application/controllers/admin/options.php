<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Options extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('login_helper');
		isAdminLogin();
		$this->load->model('Model_admin', 'ma');
		$this->load->model('Model_fieldtypes', 'ft');
		$this->load->helper('admin_helper');
	}

	public function index() {
	    var_dump($this->session->userdata('options_module_name'));
		if ($this->session->userdata('options_module_name') !== false) {
            $options = $this->model_options->getOptionsByModule($this->session->userdata('options_module_name'));
        } else {
            $options = $this->model_options->getAllOptions();
            vdd($options);
        }
		$data['title'] = "Опции";
		$modules = $this->model_options->getAllModules(1);
		$data['modules'] = $modules;

		$activeModules = array();
		foreach ($modules as $module)
			array_push($activeModules, $module['name']);

		$data['activeModules'] = $activeModules;
		$data['type'] = 'options';

        $data['options'] = $options;
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$this->load->view('options/options', $data);
	}

	public function add() {
		$err = false;
		if (isset($_POST['name'])) {
			$name = trim($_POST['name']);

			$rus = trim($_POST['rus']);
			$value = post('value');
			$adding = trim($_POST['adding']);
			$module = "";
			if (isset($_POST['module']))
				$module = $_POST['module'];
			$type = "";
			if (isset($_POST['type']))
				$type = $_POST['type'];
			$privilege = "";
			if (isset($_POST['privilege']))
				$privilege = $_POST['privilege'];
			if ($name == '')
				$err['name'] = "Название не может быть пустым!";
			if ($rus == '')
				$err['rus'] = "Описание не может быть пустым!";
			if(getOption($name) !== false)
				$err['name'] = "Такое обозначение уже есть!";

			//if($value == '')
			//$err['value'] = "Значение не может быть пустым!";
			if(post('type') == 'Логический'){
				if(post('value') == true) $value = 1;
				else $value = 0;
			} elseif(post('type') == 'Файл'){
				if(isset($_POST['old_value']))
					$value = $_POST['old_value'];

				if(isset($_POST['del_file']) && $_POST['del_file'] == true){
					@unlink('.'.$value);
					$value = "";
				}

				if (isset($_FILES['value'])) { // проверка, выбран ли файл картинки
					if ($_FILES['value']['name'] != '') {
					    $config = array(
					        'name' => $name,
                            'file' => 'value',
                            'type' => 'options',
                            'encrypt_name'  => false
                        );
					    $filearr = uploadFile($config);
						//$filearr = upload_file('options', 'value', false, false, false);
						$file = '/upload/options/' . date("Y-m-d") . '/' . $filearr['file_name'];
						$value = $file;
					}
				}
			}

			if (!$err) {
				$dbins = array(
					'name' => $name,
					'rus' => $rus,
					'value' => $value,
					'adding' => $adding,
					'module' => $module,
					'type' => $type,
					'privilege' => $privilege
				);
				$this->db->insert('options', $dbins);

				if(isset($_POST['add_and_close']))
					redirect('/admin/options/');
				else{
					$option = getOption($name, true);
					redirect('/admin/options/edit/'.$option['id'].'/');
				}
			}
		}
		$data['type'] = 'options';
		$data['err'] = $err;
		$data['modules'] = $this->model_options->getAllModules();
		$data['title'] = "Добавление опции";
		$data['err'] = $err;
		$data['fieldtypes'] = $this->ft->getAll(1);
		$data['action'] = 'add';
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$this->load->view('options/options_add_edit', $data);
	}

	public function edit($id) {
		$err = false;
		if (isset($_POST['name'])) {
			$name = trim($_POST['name']);
			$rus = trim($_POST['rus']);
			if(post('type') == 'Логический'){
				if(isset($_POST['value'])) $value = 1;
				else $value = 0;
			} elseif(post('type') == 'Файл'){
				if(isset($_POST['old_value']))
					$value = $_POST['old_value'];

				if(isset($_POST['del_file']) && $_POST['del_file'] == true){
					@unlink('.'.$value);
					$value = "";
				}

				if (isset($_FILES['value'])) { // проверка, выбран ли файл картинки
					if ($_FILES['value']['name'] != '') {
						$filearr = upload_file('options', 'value', false);
						$file = '/upload/options/' . date("Y-m-d") . '/' . $filearr['file_name'];
						$value = $file;
					}
				}
			} else {
				$value = $_POST['value'];
			}
			//vdd($value);
			$adding = trim($_POST['adding']);
			$module = "";
			if (isset($_POST['module']))
				$module = $_POST['module'];
			$type = "";
			if (isset($_POST['type']))
				$type = $_POST['type'];
			$privilege = "";
			if (isset($_POST['privilege']))
				$privilege = $_POST['privilege'];
			if ($name == '')
				$err['name'] = "Название не может быть пустым!";
			if ($rus == '')
				$err['rus'] = "Описание не может быть пустым!";
			//if($value == '')
			//$err['value'] = "Значение не может быть пустым!";


			if (!$err) {
				$dbins = array(
					'name' => $name,
					'rus' => $rus,
					'value' => $value,
					'adding' => $adding,
					'module' => $module,
					'type' => $type,
					'privilege' => $privilege

				);
				$this->db->where('id', $id)->update('options', $dbins);
				if(isset($_POST['edit_and_close']))
					redirect('/admin/options/');
				else redirect('/admin/options/edit/'.$id.'/');
			}
		}
		$data['type'] = 'options';
		$data['option_type'] = $this->session->userdata('type');
		$data['option'] = $this->model_options->getOptionById($id);
		$data['modules'] = $this->model_options->getAllModules();
		$data['title'] = "Редактирование опции";
		$data['err'] = $err;
		$data['fieldtypes'] = $this->ft->getAll(1);
		$data['action'] = 'edit';
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$this->load->view('options/options_add_edit', $data);
	}

	public function del($id) {
		$this->db->where('id', $id)->limit(1)->delete('options');
		redirect("/admin/options/");
	}

	public function set_module($module = false) {
		if (isset($_POST['module'])) {
			$module = $_POST['module'];
		}
		if ($module) {
			if ($module == 'all') {
				$this->session->unset_userdata('options_module_name');
			} else {
				$mod = $this->model_options->getModule($module);
				if ($mod) {
					$this->session->set_userdata('options_module_name', $module);
				}
			}
		}
		redirect("/admin/options/");
	}

	function clearBreadcrumbs() {
		$this->db->truncate('breadcrumbs_cache');
		redirect("/admin/options/");
	}
}