<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Filters extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Model_products', 'prod');
		$this->load->model('Model_categories', 'cat');
		$this->load->model('Model_filters', 'filters');
		$langs = getOptionArray('languages');
		$current_lang = (userdata('language')) ? userdata('language') : trim($langs[0]);
		$this->lang->load('compare', $current_lang);
	}

	function compare() {
		if (userdata('compare')) {
			$compare = userdata('compare');
			$cats = array();
			for ($i = 0; $i < count($compare); $i++) {
				$prod = $this->prod->getProductById($compare[$i]);
				$prod['filters'] = $this->filters->getProductFiltersValuesId($prod['id']);
				if (!isset($cats[$prod['category_id']])) {
					$cats[$prod['category_id']] = $this->cat->getCategoryById($prod['category_id']);
					$cats[$prod['category_id']]['filters'] = $this->filters->getFiltersByCategoryId($prod['category_id'], array('name', 'title'));
				}
				$cats[$prod['category_id']]['products'][] = $prod;

			}
			//vdd($cats);
			$data['cmprProducts'] = $cats;
		}
		$data['title'] = $this->lang->line('compare_title');
		$data['keywords'] = '';
		$data['description'] = '';
		$data['robots'] = 'noindex, follow';
		$this->load->view('templates/compare.tpl.php', $data);
	}

	function addToCompare($id) {
		$id = validate($id, 'number');
		if ($id !== false && $this->prod->checkProductById($id)) {
			if (userdata('compare')) {
				$compare = userdata('compare');
				if (in_array($id, $compare))
					redirect(userdata('last_url'));
				$compare[] = $id;
				set_userdata('compare', $compare);
			} else {
				set_userdata('compare', array($id));
			}
			redirect(userdata('last_url'));
			echo json_encode(array('done' => true, 'msg' => 'добавлено'));
		} else
			echo json_encode(array('done' => false, 'msg' => 'не найден товар'));
	}

	function deleteFromCompare($id) {
		$id = validate($id, 'number');
		if ($id !== false && $this->prod->checkProductById($id)) {
			if (userdata('compare')) {
				$compare = userdata('compare');
				if (($indx = array_search($id, $compare)) !== false) {
					unset($compare[$indx]);
					$compare = array_values($compare);
				}
				set_userdata('compare', $compare);
			}
			redirect('/compare/');
			echo json_encode(array('done' => true, 'msg' => 'убрано'));
		} else
			echo json_encode(array('done' => false, 'msg' => 'не найден товар'));
	}

	function clearCompare(){
		unset_userdata('compare');
		redirect('/katalog/');
	}

}