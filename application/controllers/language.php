<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Language extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	function index() {
		if (isset($_POST['toggle'])) {
			$this->setLang($_POST['toggle'], $_POST['back']);
			exit();
		} else {
			redirect($_POST['back']);
		}

	}

	function setLang($lang) {
		$langs = explode('|', $this->model_options->getOption('languages'));
		for ($i = 0; $i < count($langs); $i++)
			$langs[$i] = trim($langs[$i]);
		$pos_arg = strpos($_GET['back'], '?');
		$back = (isset($_GET['back'])) ? substr($_GET['back'], 0, (($pos_arg) ? $pos_arg : strlen($_GET['back']))) : '/';
		if (in_array($lang, $langs)) {
			set_userdata('language', $lang);
			redirect($back . '?lang=' . $lang);
		} else {
			set_userdata('language', $langs[0]);
			redirect($back . '?lang=' . $langs[0]);
		}

	}
}