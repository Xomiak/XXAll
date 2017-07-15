<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Translations extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('login_helper');
		isAdminLogin();
		$this->load->model('Model_admin', 'ma');
		$this->load->model('Model_filters', 'filters');
	}

	public function index($needleLang = false, $filename = false) {
		$langs_dir = $_SERVER['DOCUMENT_ROOT'] . '/application/language/';
		$data['optionLangs'] = getOptionArray('languages');
		$langsDir = scandir($langs_dir);
		//vd($dir_list);
		foreach ($langsDir as $dir)
			if ($dir != '.' AND $dir != '..')
				if (is_dir($langs_dir . $dir)) {
					$langFiles = scandir($langs_dir . $dir);
					foreach ($langFiles as $langFile)
						if ($langFile != '.' AND $langFile != '..')
							$data['langsFolders'][$dir][] = $langFile;
				}
		if (!$filename)
			$data['title'] = "Языковые файлы";
		else {
			$data['title'] = "Языковые файлы - переводы";
			require_once($langs_dir . $needleLang . '/' . $filename);
			$data['translations'] = (isset($lang)) ? $lang : 'файл пуст';

		}
		$this->load->view('translations', $data);
	}

}