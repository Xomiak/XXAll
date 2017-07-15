<?php

class Model_categories extends CI_Model {

	function getNewNum() {
		$num = $this->db->select_max('num')->get("categories")->result_array();
		if ($num[0]['num'] === NULL)
			return 0;
		else return ($num[0]['num'] + 1);
	}

	function getCategories($active = -1, $type = false, $parentOnly = true, $idIsBiggerThat = -1) {
		if($parentOnly)
			$this->db->where('parent', 0);
		if ($active != -1)
			$this->db->where('active', $active);
		if ($idIsBiggerThat != -1)
			$this->db->where('id >', $idIsBiggerThat);
		if ($type)
			$this->db->where('type', $type);
		$this->db->order_by('num', 'ASC');
		$ret = $this->db->get('categories')->result_array();
		if (!$ret)
			return false;
		else return $ret;
	}

	function getCategoriesIds($active = -1, $type = false, $parentOnly = true, $idIsBiggerThat = -1) {
		$from = 0;
		$per_page = 2;
		$query = 'SELECT id, name FROM categories WHERE type=\'organizations\'';
		if($parentOnly)
			$query .= ' AND parent=0';
		if ($active != -1)
			$query .= ' AND active='.$active;

		//$query .= ' LIMIT ' . $from . ',' . $per_page;

		$ret = $this->db->query($query)->result_array();
		if (!$ret)
			return false;
		else return $ret;
	}

	function getAllSubcategories($active = -1, $type = false){
		$this->db->where('parent <>', 0);
		if ($active != -1)
			$this->db->where('active', $active);
		if ($type)
			$this->db->where('type', $type);
		$this->db->order_by('name', 'ASC');
		$ret = $this->db->get('categories')->result_array();
		if (!$ret)
			return false;
		else return $ret;
	}

	function getSubCategories($parent_id, $active = -1) {
		$this->db->where('parent', $parent_id);
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->order_by('name', 'ASC');
		$ret = $this->db->get('categories')->result_array();
		if (!$ret)
			return false;
		else return $ret;
	}

	function getFirstLevelCategory($category)
	{
		$first = $category;
		while ($category['parent'] != 0){
			$category = $this->getCategoryById($category['parent']);
			if($category) $first = $category;
			else return false;
		}
		return $first;
	}

	function getWithSlider() {
		$this->db->where('active', 1);
		$this->db->where('slider', 1);
		return $this->db->get('categories')->result_array();
	}

	function getAllCategories($active = -1) {
		$this->db->order_by('name', 'ASC');
		if ($active != -1)
			$this->db->where('active', $active);
		$ret = $this->db->get('categories')->result_array();
		if (!$ret)
			return false;
		else return $ret;
	}

	function getCategory($name, $active = -1) {
		$this->db->where('name', $name);
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->limit(1);
		$cat = $this->db->get('categories')->result_array();
		if (!$cat)
			return false;
		else return $cat[0];
	}

	function getCategoryById($id, $active = -1) {
		if(strpos($id, '|') !== false){	// если категорий несколько
			$carr = explode('|', $id);
			if(isset($carr[0]['id'])) $id = $carr[0]['id'];
		}
		if(strpos($id,'*') !== false)
			$id = str_replace('*','', $id);
		
		$this->db->where('id', $id);
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->limit(1);
		$cat = $this->db->get('categories')->result_array();
		if (!$cat)
			return false;
		else return $cat[0];
	}

	function getParentById($id) {
		$this->db->where('id', $id);
		$this->db->limit(1);
		$cat = $this->db->get('categories')->result_array();
		//var_dump($cat);
		if (!$cat)
			return false;
		else {
			if ($cat[0]['parent'] == 0)
				return false;
			else {
				$this->db->where('id', $cat[0]['parent']);
				$this->db->limit(1);
				$parent = $this->db->get('categories')->result_array();
				if (!$parent)
					return false;
				else return $parent[0];
			}
		}
	}

	function getCategoryByNum($num, $active = -1) {
		$this->db->where('num', $num);
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->limit(1);
		$cat = $this->db->get('categories')->result_array();
		if (!$cat)
			return false;
		else return $cat[0];
	}

	function getCategoryByUrl($url, $active = -1) {
		$this->db->where('url', $url);
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->limit(1);
		$cat = $this->db->get('categories')->result_array();
		//vdd($this->db->last_query());
		if (!$cat)
			return false;
		else return $cat[0];
	}

	function getFirstParentId($id)
	{
		$cat = $this->getCategoryById($id);
		while($cat['parent'] != 0){
			$cat = $this->getCategoryById($cat['parent']);
		}
		return $cat['id'];
	}

	function getAllTop(){
		$this->db->where('top', 1);
		$this->db->where('active', 1);
		$this->db->order_by('top_position', 'ASC');
		return $this->db->get('categories')->result_array();
	}

	function getCategoryLevel($category_id){
		$level = 0;
		$first = false;
		while(!$first){
			$level++;
			$query = 'SELECT id,parent FROM categories WHERE id='.$category_id.' LIMIT 1';
			//$cat = $this->getCategoryById($category_id);
			$cat = $this->db->query($query)->result_array();

			if($cat[0]['parent'] == 0 || !$cat)
				$first = true;
			elseif(isset($cat[0]['parent']))
				$category_id = $cat[0]['parent'];
		}
		return $level;
	}
}

?>