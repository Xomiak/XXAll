<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Menus extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('login_helper');
		isAdminLogin();
		$this->load->model('Model_admin', 'ma');
		$this->load->model('Model_menus', 'mp');
		$this->load->model('Model_categories', 'categories');
		$this->load->model('Model_pages', 'pages');
	}

	public function index()
	{
		$mp = $this->mp->getMenusPositions();

		$data['mp'] = $mp;
		$data['title'] = "Меню";
		$data['type'] = "menus";
		//$data['menus'] = $this->mp->getMenusWithParentId(0);
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$this->load->view('menus/menus', $data);
	}

	public function add()
	{
		$err = '';
		$action = 'add';
		$langs = array();
		$languages = $this->model_languages->getLanguages();
		$default_lang = $this->model_languages->getDefaultLanguage();
		$languagesCount = $this->model_languages->languagesCount(1);

		if ($default_lang) $default_lang = $default_lang['code'];
		for ($i = 0; $i < count($languages); $i++) {
			$langs[$i] = $languages[$i]['code'];
		}

		if(post('action') == 'add'){
//vdd($langs);
			$dbins = array();
			if($languagesCount > 1) {
				for ($i = 0; $i < count($langs); $i++) {
					$lang = $langs[$i];

					if (isset($_POST['name_' . $lang]) && $_POST['name_'. $lang]  != '') {
						if ($lang == $default_lang) {
							$dbins['name'] = $_POST['name_' . $lang];
						} else {
							$dbins['name_' . $lang] = $_POST['name_' . $lang];
						}
					}
				}
			} else{
				$dbins['name'] = $_POST['name'];
			}

			if ($_POST['url'] == '') {
				$this->load->helper('translit_helper');
				reset($names);
				$dbins['url'] = translitRuToEn($dbins['name']);
			} else {
				$dbins['url'] = $_POST['url'];
			}

			$dbins['icon'] = '';
			if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
				if ($_FILES['userfile']['name'] != '') {
					$imagearr = $this->upload_foto();
					$dbins['icon'] = '/upload/menu_icons/' . $imagearr['file_name'];
				}
			}

			$dbins['active'] = 0;
			if (isset($_POST['active']) && $_POST['active'] == true)
				$dbins['active'] = 1;
			$dbins['no_click'] = 0;
			if (isset($_POST['no_click']) && $_POST['no_click'] == true)
				$dbins['no_click'] = 1;

			$dbins['show_type'] = $_POST['show_type'];

			$dbins['num'] = $_POST['num'];
			$dbins['parent_id'] = $_POST['parent_id'];
			$dbins['type'] = $_POST['type'];
			$dbins['params'] = $_POST['params'];
			$dbins['position'] = post('position');

			$dbins['category_id'] = post('category_id');
			$dbins['page_id']	= post('page_id');

			$this->db->insert('menus', $dbins);

			if(isset($_POST[$action.'_and_close']))
				redirect("/admin/menus/");
			else {
				$this->db->limit(1);
				$this->db->order_by('id','DESC');
				$m = $this->db->get('menus')->result_array();
				$id = $m[0]['id'];

				redirect("/admin/menus/edit/".$id."/");
			}
		}

		if(isset($_GET['from']) && isset($_GET['id'])){
			$from = $_GET['from'];
			$id = $_GET['id'];
			if($from == 'page'){
				$page = $this->pages->getPageById($id);
				$data['from'] = $page;
				$data['url'] = '/'.$page['url'].'/';
				$data['name'] = $page['name'];
				$data['type'] = 'page';
				$data['page_id'] = $id;
			} elseif($from = 'category'){
				$category = $this->model_categories->getCategoryById($id);
				$data['from'] = $category;
				$data['url'] = getFullUrl($category);
				$data['name'] = $category['name'];
				$data['type'] = 'category';
				$data['category_id'] = $id;
			}
		}
		$data['type'] = "menus";
		$data['mp'] = $this->mp->getMenusPositions();
		$data['categories'] = $this->categories->getCategories(1);
		$data['pages'] = $this->pages->getPages(1, true);
		$data['err'] = $err;
		$data['title'] = "Добавление пункта меню";
		$data['num'] = $this->mp->getNewNum();
		$data['menus'] = $this->mp->getMenusWithParentId(0);
		$data['action'] = $action;
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$this->load->view('menus/menus_add_edit', $data);
	}

	public function edit($id)
	{
		$action = 'edit';
		$err = '';
		$langs = array();
		$languages = $this->model_languages->getLanguages();
		$default_lang = $this->model_languages->getDefaultLanguage();
		$languagesCount = $this->model_languages->languagesCount(1);

		if ($default_lang) $default_lang = $default_lang['code'];
		for ($i = 0; $i < count($languages); $i++) {
			$langs[$i] = $languages[$i]['code'];
		}

		if(post('action') == 'edit'){

			$dbins = array();
			if($languagesCount > 1) {
				for ($i = 0; $i < count($langs); $i++) {
					$lang = $langs[$i];

					if (isset($_POST['name_' . $lang]) && $_POST['name_'. $lang]  != '') {
						if ($lang == $default_lang) {
							$dbins['name'] = $_POST['name_' . $lang];
						} else {
							$dbins['name_' . $lang] = $_POST['name_' . $lang];
						}
					}
				}
			} else{
				$dbins['name'] = $_POST['name'];
			}

			if ($_POST['url'] == '') {
				$this->load->helper('translit_helper');
				reset($names);
				$dbins['url'] = translitRuToEn($dbins['name']);
			} else {
				$dbins['url'] = $_POST['url'];
			}

			$dbins['icon'] = '';
			if (isset($_POST['image']))
				$dbins['icon'] = $_POST['image'];
			if (isset($_POST['image_del']) && $_POST['image_del'] == true) {
				if (file_exists($_SERVER['DOCUMENT_ROOT'] . $dbins['icon']))
					unlink($_SERVER['DOCUMENT_ROOT'] . $dbins['icon']);
				$dbins['icon'] = '';
			}
			if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
				if ($_FILES['userfile']['name'] != '') {
					$imagearr = $this->upload_foto();
					if ($image != '') {
						if (file_exists($_SERVER['DOCUMENT_ROOT'] . $image))
							unlink($_SERVER['DOCUMENT_ROOT'] . $image);
					}
					$dbins['icon'] = '/upload/menu_icons/' . $imagearr['file_name'];
				}
			}

			$dbins['active'] = 0;
			if (isset($_POST['active']) && $_POST['active'] == true)
				$dbins['active'] = 1;
			$dbins['no_click'] = 0;
			if (isset($_POST['no_click']) && $_POST['no_click'] == true)
				$dbins['no_click'] = 1;

			$dbins['show_type'] = $_POST['show_type'];

			$dbins['num'] = $_POST['num'];
			$dbins['parent_id'] = $_POST['parent_id'];
			$dbins['type'] = $_POST['type'];
			$dbins['params'] = $_POST['params'];
			$dbins['position'] = post('position');

			$dbins['category_id'] = post('category_id');
			$dbins['page_id']	= post('page_id');

			$this->db->where('id', $id)->limit(1)->update('menus', $dbins);
			if(isset($_POST[$action.'_and_close']))
				redirect("/admin/menus/");
			else redirect("/admin/menus/edit/".$id."/");
		}
		$data['type'] = "menus";
		$data['mp'] = $this->mp->getMenusPositions();
		$data['categories'] = $this->categories->getCategories(1);
		$data['pages'] = $this->pages->getPages(1, true);
		$data['action'] = $action;
		$data['menu'] = $this->mp->getMenuById($id);
		$data['title'] = "Редактирование пункта меню";
		$data['err'] = $err;
		$data['num'] = $this->mp->getNewNum();
		$data['menus'] = $this->mp->getMenusWithParentId(0);
		$data['action'] = $action;
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$this->load->view('menus/menus_add_edit', $data);
	}

	public function create()
	{
		$err = '';
		$action = 'add';
		$langs = array();
		$languages = $this->model_languages->getLanguages();
		$default_lang = $this->model_languages->getDefaultLanguage();
		$languagesCount = $this->model_languages->languagesCount(1);

		if ($default_lang) $default_lang = $default_lang['code'];
		for ($i = 0; $i < count($languages); $i++) {
			$langs[$i] = $languages[$i]['code'];
		}

		if(post('action') == 'add'){
//vdd($langs);
			$dbins = array();
			if($languagesCount > 1) {
				for ($i = 0; $i < count($langs); $i++) {
					$lang = $langs[$i];

					if (isset($_POST['name_' . $lang]) && $_POST['name_'. $lang]  != '') {
						if ($lang == $default_lang) {
							$dbins['name'] = $_POST['name_' . $lang];
						} else {
							$dbins['name_' . $lang] = $_POST['name_' . $lang];
						}
					}
				}
			} else{
				$dbins['name'] = $_POST['name'];
			}

			if ($_POST['url'] == '') {
				$this->load->helper('translit_helper');
				reset($names);
				$dbins['url'] = translitRuToEn($dbins['name']);
			} else {
				$dbins['url'] = $_POST['url'];
			}

			$dbins['icon'] = '';
			if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
				if ($_FILES['userfile']['name'] != '') {
					$imagearr = $this->upload_foto();
					$dbins['icon'] = '/upload/menu_icons/' . $imagearr['file_name'];
				}
			}

			$dbins['active'] = 0;
			if (isset($_POST['active']) && $_POST['active'] == true)
				$dbins['active'] = 1;
			$dbins['no_click'] = 0;
			if (isset($_POST['no_click']) && $_POST['no_click'] == true)
				$dbins['no_click'] = 1;

			$dbins['show_type'] = $_POST['show_type'];

			$dbins['num'] = $_POST['num'];
			$dbins['parent_id'] = $_POST['parent_id'];
			$dbins['type'] = $_POST['type'];
			$dbins['params'] = $_POST['params'];
			$dbins['position'] = post('position');

			$dbins['category_id'] = post('category_id');
			$dbins['page_id']	= post('page_id');

			$this->db->insert('menus', $dbins);

			if(isset($_POST[$action.'_and_close']))
				redirect("/admin/menus/");
			else {
				$this->db->limit(1);
				$this->db->order_by('id','DESC');
				$m = $this->db->get('menus')->result_array();
				$id = $m[0]['id'];

				redirect("/admin/menus/edit/".$id."/");
			}
		}

		if(isset($_GET['from']) && isset($_GET['id'])){
			$from = $_GET['from'];
			$id = $_GET['id'];
			if($from == 'page'){
				$page = $this->pages->getPageById($id);
				$data['from'] = $page;
				$data['url'] = '/'.$page['url'].'/';
				$data['name'] = $page['name'];
				$data['type'] = 'page';
				$data['page_id'] = $id;
			} elseif($from = 'category'){
				$category = $this->model_categories->getCategoryById($id);
				$data['from'] = $category;
				$data['url'] = getFullUrl($category);
				$data['name'] = $category['name'];
				$data['type'] = 'category';
				$data['category_id'] = $id;
			}
		}

		$data['type'] = "menus";
		$data['categories'] = $this->categories->getCategories(1);
		$data['pages'] = $this->pages->getPages(1, true);
		$data['err'] = $err;
		$data['title'] = "Добавление пункта меню";
		$data['num'] = $this->mp->getNewNum();
		$data['menus'] = $this->mp->getMenusWithParentId(0);
		$data['action'] = $action;

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
		$this->load->view('menus/menu_create_edit', $data);
	}

	
	public function up($id)
	{
		$cat = $this->mp->getMenuById($id);
		if (($cat) && $cat['num'] > 0) {
			$num = $cat['num'] - 1;
			$oldcat = $this->mp->getMenuByNum($num);
			$dbins = array('num' => $num);
			$this->db->where('id', $id)->limit(1)->update('menus', $dbins);
			if ($oldcat) {
				$dbins = array('num' => ($num + 1));
				$this->db->where('id', $oldcat['id'])->limit(1)->update('menus', $dbins);
			}
		}
		redirect('/admin/menus/');
	}

	public function down($id)
	{
		$cat = $this->mp->getMenuById($id);
		if (($cat) && $cat['num'] < ($this->mp->getNewNum() - 1)) {
			$num = $cat['num'] + 1;
			$oldcat = $this->mp->getMenuByNum($num);
			$dbins = array('num' => $num);
			$this->db->where('id', $id)->limit(1)->update('menus', $dbins);
			if ($oldcat) {
				$dbins = array('num' => ($num - 1));
				$this->db->where('id', $oldcat['id'])->limit(1)->update('menus', $dbins);
			}
		}
		redirect('/admin/menus/');
	}

	public function del($id)
	{
		$this->db->where('id', $id)->limit(1)->delete('menus');
		redirect("/admin/menus/");
	}

	public function del_all_post()
	{
		echo $_POST['type'];
		if (isset($_POST['type']) && $_POST['type'] != '') {
			$this->db->where('type', $_POST['type'])->delete('menus');
		}
		redirect("/admin/menus/");
	}

	public function active($id)
	{
		$this->ma->setActive($id, 'menus');
		redirect('/admin/menus/');
	}

	function upload_foto()
	{ // Функция загрузки и обработки фото
		$config['upload_path'] = 'upload/menu_icons';
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
			return $ret;
		}
	}

}
