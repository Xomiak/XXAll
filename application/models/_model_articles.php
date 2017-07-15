<?php

class Model_articles extends CI_Model
{

	function getSettings($multilanguage = -1)
	{
		if ($multilanguage != -1) $this->db->where('multilanguage', $multilanguage);
		$this->db->where('is_visible', 1);
		$this->db->order_by('num', 'ASC');
		return $this->db->get('articles_settings')->result_array();
	}


	function getSettingsNewNum()
	{
		$num = $this->db->select_max('num')->get("articles_settings")->result_array();
		if ($num[0]['num'] === NULL)
			return 0;
		else return ($num[0]['num'] + 1);
	}

	function getSettingByNum($num)
	{
		$this->db->where('num', $num);
		$cat = $this->db->get('articles_settings')->result_array();
		if (!$cat)
			return false;
		else
			return $cat[0];
	}

	function getSettingById($id)
	{
		$this->db->where('id', $id);
		$this->db->limit(1);
		$ret = $this->db->get('articles_settings')->result_array();
		if (!$ret)
			return false;
		else return $ret[0];
	}

	function getSettingByName($name)
	{
		$this->db->where('name', $name);
		$this->db->limit(1);
		$ret = $this->db->get('articles_settings')->result_array();
		if (!$ret)
			return false;
		else return $ret[0];
	}

	function isSetting($name){
		$this->db->where('name', $name);
		$this->db->limit(1);
		$this->db->from('articles_settings');
		$count = $this->db->count_all_results();
		if($count > 0) return true;
		return false;
	}

	function getSettingsForAdminTable()
	{
		$this->db->where('admin_in_table', 1);
		$this->db->order_by('num', 'ASC');
		return $this->db->get('articles_settings')->result_array();
	}

	function getSettingsByType($type)
	{
		$this->db->where('is_visible', 1);
		$this->db->where('type', $type);
		$this->db->order_by('num', 'ASC');
		return $this->db->get('articles_settings')->result_array();
	}


	function getArticles($per_page = -1, $from = -1, $order_by = "DESC", $active = -1, $not_in_categories = false)
	{
		if ($active != -1)
			$this->db->where('active', $active);
		if ($not_in_categories) {
			if (is_array($not_in_categories)) {
				$count = count($not_in_categories);
				for ($i = 0; $i < $count; $i++) {
					$this->db->where('category_id <>', $not_in_categories[$i]);
				}
			} else
				$this->db->where('category_id <>', $not_in_categories);
		}
		//$this->db->order_by('id', $order_by);
		if ($per_page != -1 && $from != -1)
			$this->db->limit($per_page, $from);
		$this->db->order_by('num', $order_by);
		return $this->db->get('articles')->result_array();
	}

	function getArticlesByCount($per_page = -1, $from = -1, $active = -1, $not_in_categories = false)
	{
		if ($active != -1)
			$this->db->where('active', $active);
		if ($not_in_categories) {
			if (is_array($not_in_categories)) {
				$count = count($not_in_categories);
				for ($i = 0; $i < $count; $i++) {
					$this->db->where('category_id <>', $not_in_categories[$i]);
				}
			} else
				$this->db->where('category_id <>', $not_in_categories);
		}
		//$this->db->order_by('id', $order_by);
		if ($per_page != -1 && $from != -1)
			$this->db->limit($per_page, $from);
		$this->db->order_by('count', 'DESC');
		return $this->db->get('articles')->result_array();
	}

	function getProductsNewNum()
	{
		$num = $this->db->select_max('num')->get("articles")->result_array();
		if ($num[0]['num'] === NULL)
			return 0;
		else return ($num[0]['num'] + 1);
	}

	function getLastAddedProduct()
	{
		$created_by = userdata('login');
		$this->db->where('created_by', $created_by);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$ret = $this->db->get('articles')->result_array();
		if (!$ret)
			return false;
		else return $ret[0];
	}

	function getArticleById($id)
	{
		$this->db->where('id', $id);
		$this->db->limit(1);
		$ret = $this->db->get('articles')->result_array();
		if (!$ret)
			return false;
		else return $ret[0];
	}

	function getArticleByUrl($url)
	{
		$this->db->where('url', $url);
		$this->db->limit(1);
		$ret = $this->db->get('articles')->result_array();
		if (!$ret)
			return false;
		else return $ret[0];
	}

	function getArticleByName($name)
	{
		$this->db->where('name', $name);
		$this->db->limit(1);
		$ret = $this->db->get('articles')->result_array();
		if (!$ret)
			return false;
		else return $ret[0];
	}

	function getProductByNum($num)
	{
		$this->db->where('num', $num);
		$cat = $this->db->get('articles')->result_array();
		if (!$cat)
			return false;
		else
			return $cat[0];
	}

	function searchByName($search, $category_id = -1, $per_page = -1, $from = -1, $order_by = "ASC", $sort_by = "name")
	{
		if ($category_id != -1)
			$this->db->where('category_id', $category_id);
		$this->db->like('name', $search);
		$this->db->or_like('short_content', $search);
		$this->db->or_like('content', $search);
		$this->db->or_like('adress', $search);
		$this->db->order_by($sort_by, $order_by);
		if ($per_page != -1 && $from != -1)
			$this->db->limit($per_page, $from);
		$ret = $this->db->get('articles')->result_array();

		return $ret;
	}

	function searchByNameCount($search, $category_id = -1)
	{
		if ($category_id != -1)
			$this->db->where('category_id', $category_id);
		$this->db->like('name', $search);
		$this->db->or_like('short_content', $search);
		$this->db->or_like('content', $search);
		$this->db->or_like('adress', $search);
		$this->db->from('articles');
		return $this->db->count_all_results();
	}

	function getCountArticlesInCategory($category_id, $active = -1, $not_in_category_id = false)
	{
		$article_in_many_categories = 0;
		$this->db->where('name', 'article_in_many_categories');
		$aimc = $this->db->get('options')->result_array();

		if ($aimc)
			$article_in_many_categories = $aimc[0]['value'];

		if ($article_in_many_categories == 1) {
			$query = "* FROM articles WHERE";
			if ($active != -1)
				$query .= " active=" . $active . " AND";


			if ($category_id != -1)
				$query .= "(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\")";

			$this->db->select($query, FALSE);
			$articles = $this->db->get()->result_array();
			return count($articles);
		} else {
			$this->db->like('category_id', $category_id);
			if ($active != -1)
				$this->db->where('active', $active);

			if ($not_in_category_id)
				$this->db->where('category_id <>', $not_in_category_id);


			$this->db->from('articles');
			$ret = $this->db->count_all_results();
			//var_dump($ret);
			return $ret;
		}
	}


	function getArticlesByCategory($category_id = -1, $per_page = -1, $from = -1, $active = -1, $order_by = "DESC", $sort_by = 'num', $not_in_category_id = false)
	{
		$article_in_many_categories = 0;
		$this->db->where('name', 'article_in_many_categories');
		$aimc = $this->db->get('options')->result_array();


			if ($active != -1) {
				$this->db->where('active', $active);
			}



			if ($not_in_category_id)
				$this->db->where('category_id <>', $not_in_category_id);

		if ($category_id != -1) {
			$this->db->like('category_id', '*'.$category_id.'*');
		}

			$this->db->order_by($sort_by, $order_by);
			if ($per_page != -1 && $from != -1)
				$this->db->limit($per_page, $from);
			$articles = $this->db->get('articles')->result_array();


		if (!$articles)
			return false;
		else
			return $articles;
	}

	function getCountArticlesInSubCategories($parent_category_id, $active = -1, $type = false)
	{
		$this->db->where('parent_category_id', $parent_category_id);
		if ($type)
			$this->db->where('mneniya_type', $type);
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->from('articles');
		return $this->db->count_all_results();
	}

	function getArticlesByParentCategory($parent_category_id, $per_page = -1, $from = -1, $active = -1, $order_by = "DESC", $type = false)
	{
		if ($active != -1)
			$this->db->where('active', $active);
		if ($type)
			$this->db->where('type', $type);
		$this->db->where('parent_category_id', $parent_category_id);
		if ($per_page != -1 && $from != -1)
			$this->db->limit($per_page, $from);
		$this->db->order_by('type', 'DESC');
		$this->db->order_by('id', $order_by);
		$articles = $this->db->get('articles')->result_array();
		//vd($articles);
		if (!$articles)
			return false;
		else return $articles;
	}

	function getCountArticlesInFirstCategory($parent_category_id, $active = -1, $type = false){
		$this->db->where('first_category_id', $parent_category_id);
		if ($type)
			$this->db->where('type', $type);
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->from('articles');
		return $this->db->count_all_results();
	}

	function getArticlesByFirstCategory($parent_category_id, $per_page = -1, $from = -1, $active = -1, $order_by = "DESC", $type = false)
	{
		if ($active != -1)
			$this->db->where('active', $active);
		if ($type)
			$this->db->where('type', $type);
		$this->db->where('first_category_id', $parent_category_id);
		if ($per_page != -1 && $from != -1)
			$this->db->limit($per_page, $from);
		$this->db->order_by('type', 'DESC');
		$this->db->order_by('id', $order_by);
		$articles = $this->db->get('articles')->result_array();
		//vd($articles);
		if (!$articles)
			return false;
		else return $articles;
	}

	function getPodGlavnoe($category_id)
	{
		$article_in_many_categories = 0;
		$this->db->where('name', 'article_in_many_categories');
		$aimc = $this->db->get('options')->result_array();

		if ($aimc)
			$article_in_many_categories = $aimc[0]['value'];

		if ($article_in_many_categories == 1) {
			$query = "* FROM articles WHERE";
			$query .= " active=1 AND podglavnoe=1 AND";

			$query .= "(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\")";
			$query .= " ORDER BY num DESC";
			$query .= ' LIMIT 1';

			$this->db->select($query, FALSE);
			$articles = $this->db->get()->result_array();
		} else {
			$this->db->where('active', '1');
			$this->db->where('category_id', $category_id);
			$articles = $this->db->get('articles')->result_array();
		}
		if (!$articles)
			return false;
		else return $articles[0];
	}

	function getArticleByUrlAndCategoryId($url, $category_id, $active = 1)
	{
		$this->db->where('url', $url);
		if($active != -1)
			$this->db->where('active', $active);
		$this->db->like('category_id', '*'.$category_id.'*');
		$this->db->limit(1);
		$ret = $this->db->get('articles')->result_array();
		if(isset($ret[0])) return $ret[0];

		return false;
//		$this->db->where('id', $category_id);
//		if($active != -1)
//			$this->db->where('active', $active);
//		$this->db->limit(1);
//		$cat = $this->db->get('categories')->result_array();
//		if (!$cat)
//			return false;
//		$cat = $cat[0];
//		if ($cat['parent'] != 0) {
//			$this->db->where('id', $cat['parent']);
//			if($active != -1)
//				$this->db->where('active', $active);
//			$this->db->limit(1);
//			$cat = $this->db->get('categories')->result_array();
//			if (!$cat)
//				return false;
//			//$cat = $cat[0];
//		}
//		$article_in_many_categories = 0;
//		$this->db->where('name', 'article_in_many_categories');
//		$aimc = $this->db->get('options')->result_array();
//
//		if ($aimc)
//			$article_in_many_categories = $aimc[0]['value'];
//
//		if ($article_in_many_categories == 1) {
//			$query = "* FROM articles WHERE url='" . $url . "'";
//			if($active != -1) $query .= " AND active=1";
//			$query .= " AND(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\") LIMIT 1";
//			$this->db->select($query, FALSE);
//			$art = $this->db->get()->result_array();
//		} else {
//			$this->db->where('category_id', $category_id);
//			$this->db->where('url', $url);
//			if($active != -1)
//				$this->db->where('active', $active);
//			$this->db->order_by('num', 'DESC');
//			$art = $this->db->get('articles')->result_array();
//		}
//		if (!$art)
//			return false;
//		else return $art[0];
	}

	function getLastArticles($count, $onlyFromCategoryId = false)
	{
		if ($onlyFromCategoryId)
			$this->db->where('category_id', $onlyFromCategoryId);
		$this->db->order_by('num', 'DESC');
		$this->db->limit($count);
		$art = $this->db->get('articles')->result_array();
		if (!$art)
			return false;
		else return $art;
	}

	function countPlus($id)
	{
		$this->db->where('id', $id);
		$articles = $this->db->get('articles')->result_array();
		if ($articles) {
			$articles = $articles[0];
			$count = $articles['count'] + 1;
			$dbins = array('count' => $count);
			$this->db->where('id', $id)->update('articles', $dbins);
		}
	}

	function Search($key)
	{
		//$this->db->select("* FROM articles, shop WHERE articles.name LIKE '%".$key."%'");

		$this->db->like('name', $key);
		$this->db->or_like('content', $key);
		$articles = $this->db->get('articles')->result_array();
		if (!$articles)
			return false;
		else return $articles;
	}

	function getArticlesByUrl($url, $active = 1, $created_by = false)
	{
		$this->db->where('url', $url);
		if($active != -1)
			$this->db->where('active', $active);
		if($created_by)
			$this->db->where('created_by', $created_by);
		$article = $this->db->get('articles')->result_array();
		if (!$article)
			return false;
		else
			return $article;
	}

	function getVagno($count, $active = false)
	{
		$this->db->where('vagno', 1);
		if ($active)
			$this->db->where('active', $active);
		$this->db->order_by('id', 'DESC');
		$this->db->limit($count);

		return $this->db->get('articles')->result_array();
	}

	function getGlavnoe($count, $active = false)
	{
		$this->db->where('glavnoe', 1);
		if ($active)
			$this->db->where('active', $active);
		$this->db->order_by('id', 'DESC');
		$this->db->limit($count);

		return $this->db->get('articles')->result_array();
	}

	function checkArticleById($id)
	{
		$this->db->select('id');
		$this->db->where('id', $id);
		$this->db->limit(1);
		$ret = $this->db->get('articles')->result_array();
		return (isset($ret[0]['id'])) ? true : false;
	}

	public function updateUrlCache($id, $url)
	{
		if ($this->checkArticleById($id)) {
			$this->db->where('id', $id);
			$this->db->limit(1);
			$this->db->update('articles', array('url_cache' => $url));
		}
	}

//	public function getArticlesByFirstCategory($first_category_id, $per_page = -1, $from = -1, $active = -1, $sort_by = 'date_unix', $order_by = 'ASC')
//	{
//		$this->db->where('first_category_id', $first_category_id);
//		$this->db->where('date_unix >', time());
//		if ($active != -1) {
//			$this->db->where('active', $active);
//		}
//		if ($per_page != -1 && $from != -1)
//			$this->db->limit($per_page, $from);
//		$this->db->order_by($sort_by, $order_by);
//		return $this->db->get('articles')->result_array();
//	}

	public function select($select, $per_page = -1, $from = -1, $active = -1, $type = false)
	{


		if ($type) {
			$cats = $this->model_categories->getCategories(1, $type);
			foreach ($cats as $cat) {
				$this->db->or_like('category_id', $cat['id']);
			}
		}

		$this->db->select($select);

		if ($per_page != -1 && $from != -1)
			$this->db->limit($per_page, $from);
		if ($active != -1)
			$this->db->where('active', $active);

		return $this->db->get('articles')->result_array();
	}

	public function getArticlesByTop($first_category_id, $count = 10)
	{
		$this->db->where('first_category_id', $first_category_id);
		$this->db->where('active', 1);
		$this->db->where('top <>', 0);
		$this->db->order_by('top', 'ASC');
		$this->db->limit($count);
		return $this->db->get('articles')->result_array();
	}

	public function getArticlesWithEmails()
	{
		$this->db->where('email <>', '');
		return $this->db->get('articles')->result_array();
	}

	public function isRaited($article_id, $login)
	{
		$this->db->where('article_id', $article_id);
		$this->db->where('login', $login);
		$this->db->limit(1);
		$ret = $this->db->get('rating_logs')->result_array();
		if ($ret) return true;
		return false;
	}

	public function getArticlesByLogin($login, $active = -1){
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->where('created_by', $login);
		$this->db->order_by('id','DESC');
		$ret = $this->db->get('articles')->result_array();
		return $ret;
	}

	public function getTarifs($active = -1, $order_by = 'ASC'){
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->order_by('id', $order_by);
		return $this->db->get('tarifs')->result_array();
	}

	public function getTarif($name){
//		if ($active != -1)
//			$this->db->where('active', $active);
		$this->db->where('name', $name);
		$ret = $this->db->get('tarifs')->result_array();
		if($ret) return $ret[0];
		return false;
	}

	public function getNameOfArticle($article_id){
		$ret = $this->db->query("SELECT name FROM articles WHERE id=".$article_id." LIMIT 1")->result_array();
		if(isset($ret[0]['name'])) return $ret[0]['name'];

		return false;
	}

	public function getCountArticlesByTag($tag,  $active = -1){
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->like('tags', $tag);
		$this->db->from('articles');
		return $this->db->count_all_results();
	}

	public function getArticlesByTag($tag, $per_page = -1, $from = -1, $active = -1){
		if ($active != -1)
			$this->db->where('active', $active);
		$this->db->like('tags', $tag);
		if ($per_page != -1 && $from != -1)
			$this->db->limit($per_page, $from);
		$this->db->order_by('unix', 'DESC');
		return $this->db->get('articles')->result_array();
	}

	public function getLastId(){
		$this->db->select('id');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$ret = $this->db->get('articles')->result_array();
		if(isset($ret[0])) return $ret[0]['id'];

		return false;
	}

}