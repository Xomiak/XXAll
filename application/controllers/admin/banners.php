<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Banners extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('login_helper');
		isAdminLogin();
		$this->load->model('Model_admin', 'ma');
		$this->load->model('Model_banners', 'mban');
	}

	function upload_banner($folder = 'slides') {

		//////
		// Функция загрузки и обработки фото
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $folder . '/')) {
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $folder . '/', 0777, true);
		}
		$config['upload_path'] = 'upload/'.$folder;
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

	public function index() {
		$data['title'] = "Баннеры/Слайды";

		$data['type'] = 'banners';
		$data['banners'] = $this->mban->getBanners();
		$banner_positions = getOptionArray('banner_positions', true);
		$count = count($banner_positions);
		for($i = 0; $i < $count; $i++){
		    $banner_positions[$i]['banners'] = $this->mban->getByPosition($banner_positions[$i]['name']);
        }
        //vdd($banner_positions);
		$data['banner_positions'] = $banner_positions;

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

		$this->load->view('banners/banners', $data);
	}

	public function add() {
		$err = '';
        if (isset($_POST['action'])) {
			$num = $this->mban->getNewNum();
			$active = 0;
			if (isset($_POST['active']) && $_POST['active'] == true)
				$active = 1; 

			$image = '';
			if (isset($_POST['image']))
				$image = $_POST['image'];
			if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
				if ($_FILES['userfile']['name'] != '') {
					$imagearr = $this->upload_banner($_POST['position']);
					$image = '/upload/'.$_POST['position'].'/' . $imagearr['file_name'];
				}
			}

			if ($image)
				$_POST['content'] = '<img src="http://' . $_SERVER['SERVER_NAME'] . $image . '" alt="' . $_POST['name'] . '" title="' . $_POST['name'] . '" />';

			$dbins = array(
				'name' => $_POST['name'],
				'format' => $_POST['format'],
			//	'content' => $_POST['content'],
				'url' => $_POST['url'],
				'position' => $_POST['position'],
			//	'frequency' => $_POST['frequency'],
				'count' => 0,
				'image' => $image,
				'active' => $active,
				'num' => $num
			);
			$this->db->insert('banners', $dbins);
			redirect("/admin/banners/");
		}

        $data['banner_positions'] = getOptionArray('banner_positions', true);
        $data['type'] = 'banners';
		$data['action'] = 'add';
		$data['title'] = "Добавление баннера/слайда";

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

		$this->load->view('banners/banners_add_edit', $data);
	}

	public function edit($id) {
		$err = '';
		$banner = $this->mban->getBannerById($id);
		if (isset($_POST['action'])) {
			$active = 0;
			if (isset($_POST['active']) && $_POST['active'] == true)
				$active = 1;

			$is_image_set = false;
			$image = $banner['image'];
			if (isset($_POST['image']))
				$image = $_POST['image'];
			//var_dump("1");die();
			if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
				//var_dump("YES!!");die();
				if ($_FILES['userfile']['name'] != '') {
					$imagearr = $this->upload_banner();
					if ($imagearr['file_name'] !== false && $imagearr['file_name'] != '') {
						@unlink($_SERVER['DOCUMENT_ROOT'] . $image);
						$image = '/upload/banners/' . $imagearr['file_name'];
						$is_image_set = true;
					}
				}
			}

			if ($is_image_set)
				$banner['content'] = '<img src="http://' . $_SERVER['SERVER_NAME'] . $image . '" alt="' . $_POST['name'] . '" title="' . $_POST['name'] . '" />';

			$dbins = array(
				'name' => $_POST['name'],
				'format' => $_POST['format'],
			//	'content' => $banner['content'],
				'url' => $_POST['url'],
				'position' => $_POST['position'],
				'count' => $_POST['count'],
			//	'frequency' => $_POST['frequency'],
				'image' => $image,
				'active' => $active
			);
			$this->db->where('id', $id);
			$this->db->limit(1);
			$this->db->update('banners', $dbins);
			redirect("/admin/banners/");
		}
        $data['banner_positions'] = getOptionArray('banner_positions', true);
		$data['banner'] = $banner;
        $data['action'] = 'edit';
		$data['type'] = 'banners';
		$data['title'] = "Редактирование баннера/слайда";

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

		$this->load->view('banners/banners_add_edit', $data);
	}

	public function del($id) {
		$banner = $this->mban->getBannerById($id);
		if ($banner['image'] != '')
			@unlink($_SERVER['DOCUMENT_ROOT'] . $banner['image']);

		$this->db->where('id', $id)->limit(1)->delete('banners');
		redirect("/admin/banners/");
	}

	public function active($id) {
		$this->ma->setActive($id, 'banners');
		redirect('/admin/banners/');
	}


	public function up($id) {
		$cat = $this->mban->getBannerById($id);
		if (($cat) && $cat['num'] < ($this->mban->getNewNum() - 1)) {
			$num = $cat['num'] + 1;
			$oldcat = $this->mban->getByNum($num);
			$dbins = array('num' => $num);
			$this->db->where('id', $id)->limit(1)->update('banners', $dbins);
			if ($oldcat) {
				$dbins = array('num' => ($num - 1));
				$this->db->where('id', $oldcat['id'])->limit(1)->update('banners', $dbins);
			}
		}
		$url = '/admin/banners/';
		if ($this->session->userdata('articlesFrom') !== false)
			$url .= $this->session->userdata('articlesFrom') . '/';
		redirect($url);

	}

	public function down($id) {
		$cat = $this->mban->getBannerById($id);
		if (($cat) && $cat['num'] > 0) {
			$num = $cat['num'] - 1;
			$oldcat = $this->mban->getByNum($num);
			$dbins = array('num' => $num);
			$this->db->where('id', $id)->limit(1)->update('banners', $dbins);
			if ($oldcat) {
				$dbins = array('num' => ($num + 1));
				$this->db->where('id', $oldcat['id'])->limit(1)->update('banners', $dbins);
			}
		}
		$url = '/admin/banners/';
		if ($this->session->userdata('articlesFrom') !== false)
			$url .= $this->session->userdata('articlesFrom') . '/';
		redirect($url);
	}
}