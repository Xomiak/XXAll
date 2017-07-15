<?php

class Model_shop extends CI_Model {

    function getNewNum() {
        $num = $this->db->select_max('num')->get("shop")->result_array();
        if ($num[0]['num'] === NULL)
            return 0;
        else
            return ($num[0]['num'] + 1);
    }

    function getArticles($per_page = -1, $from = -1, $order_by = "DESC", $active = -1, $novelty = -1, $in_warehouse = -1) {
        if ($active != -1)
            $this->db->where('active', $active);
        if ($novelty != -1)
            $this->db->where('novelty', $novelty);;
        if ($in_warehouse != -1)
            $this->db->where('in_warehouse', $in_warehouse);
        $this->db->order_by('num', $order_by);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        return $this->db->get('shop')->result_array();
    }

    function getArticleByName($name) {
        $this->db->like('name', $name);
        $cat = $this->db->get('shop')->result_array();
        if (!$cat)
            return false;
        else
            return $cat[0];
    }

    function getRandomArticles($count, $category_id) {
        $query = $this->db->query("SELECT * FROM `shop` WHERE active=1 AND category_id=" . $category_id . " AND id >= (SELECT FLOOR( MAX(id) * RAND()) FROM `shop` ) ORDER BY id LIMIT " . $count . ";")->result_array();
        return $query;
    }

    function getArticleById($id) {
        $this->db->where('id', $id);
        $cat = $this->db->get('shop')->result_array();
        if (!$cat)
            return false;
        else
            return $cat[0];
    }

    function getArticleByNum($num) {
        $this->db->where('num', $num);
        $cat = $this->db->get('shop')->result_array();
        if (!$cat)
            return false;
        else
            return $cat[0];
    }

    function getCountArticlesInBrand($brand_id, $active = -1) {
        $max_price = $this->session->userdata('f_price_max');
        $this->db->like('brand_id', $brand_id);
        if ($active != -1)
            $this->db->where('active', $active);
        if ($max_price)
            $this->db->where('current_price <=', $max_price);

        $this->db->from('shop');
        return $this->db->count_all_results();
    }

    function getArticlesByBrand($brand_id, $per_page = -1, $from = -1, $active = -1, $order_by = "DESC", $sort_by = 'num') {
        $max_price = $this->session->userdata('f_price_max');

        if ($active != -1)
            $this->db->where('active', $active);
        $this->db->where('brand_id', $brand_id);
        if ($max_price)
            $this->db->where('current_price <=', $max_price);

        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $this->db->order_by($sort_by, $order_by);
        $shop = $this->db->get('shop')->result_array();

        if (!$shop)
            return false;
        else
            return $shop;
    }

    function searchByName($search, $category_id = -1) {
        if ($category_id != -1)
            $this->db->where('category_id', $category_id);
        $this->db->like('name', $search);
        return $this->db->get('shop')->result_array();
    }

    function getCountAllArticles($active = -1) {
        if ($active != -1)
            $this->db->where('active', $active);
        return $this->db->count_all_results();
    }

    function getCountArticlesInCategory($category_id, $active = -1, $size = false, $sezon = false, $filter_price_array = false, $in_warehouse = false) {
        $brand_id = $this->session->userdata('f_brand_id');
        $max_price = $this->session->userdata('f_price_max');
        $article_in_many_categories = 0;
        $this->db->where('name', 'article_in_many_categories');
        $aimc = $this->db->get('options')->result_array();

        if ($aimc)
            $article_in_many_categories = $aimc[0]['value'];

        if ($article_in_many_categories == 1) {
            $query = "* FROM shop WHERE";
            if ($active != -1)
                $query .= " active=" . $active . " AND";
            if ($in_warehouse)
                $query .= " in_warehouse " . $in_warehouse . " AND";

            if ($max_price)
                $query .= " current_price <= " . $max_price . "' AND";
            if ($brand_id)
                $query .= " brand_id LIKE '%" . $brand_id . "%' AND";



            $query .= "(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\")";
            if ($filter_price_array) {
                $query .= " current_price BETWEEN " . $filter_price_array['min'] . " AND " . $filter_price_array['max'];
            }
            //$query .= " ORDER BY ".$sort_by." ".$order_by;
            //if ($per_page != -1 && $from != -1) $query .= ' LIMIT '.$from.','.$per_page;

            $this->db->select($query, FALSE);
            $shop = $this->db->get()->result_array();
            return count($shop);
        } else {
            $this->db->like('category_id', $category_id);
            if ($active != -1)
                $this->db->where('active', $active);

            if ($in_warehouse)
                $this->db->where('in_warehouse', $in_warehouse);

            if ($sezon)
                $this->db->where('sezon', $sezon);
            if ($size) {
                $count = count($size);
                $this->db->like('razmer', $size[0]);
                for ($i = 1; $i < $count; $i++) {
                    $this->db->or_like('razmer', $size[$i]);
                }
            }
            if ($filter_price_array)
                $this->db->where("current_price BETWEEN " . $filter_price_array['min'] . " AND " . $filter_price_array['max'], NULL, FALSE);

            $this->db->from('shop');
            $ret = $this->db->count_all_results();
            //var_dump($ret);
            return $ret;
        }
    }

    function getArticlesByCategory($category_id = -1, $per_page = -1, $from = -1, $active = -1, $order_by = "ASC", $sort_by = 'name', $size = false, $sezon = false, $filter_price_array = false, $in_warehouse = false) {
        
        if ($filter_price_array) {
            $filter_price_array['min'] = get_price($filter_price_array['min'], true);
            $filter_price_array['max'] = get_price($filter_price_array['max'], true);
            //var_dump($filter_price_array['min']);var_dump($filter_price_array['max']);
        }
        $brand_id = $this->session->userdata('f_brand_id');
        $max_price = $this->session->userdata('f_price_max');
        //var_dump("asd");die();
        // Получаем настройки, будет ли одна статья находиться в нескольких разделах
        $article_in_many_categories = 0;
        $this->db->where('name', 'article_in_many_categories');
        $aimc = $this->db->get('options')->result_array();

        if ($aimc)
            $article_in_many_categories = $aimc[0]['value'];

        if ($article_in_many_categories == 1) {
            $query = "* FROM shop WHERE";
            if ($active != -1)
                $query .= " active=" . $active . " AND";
            if ($in_warehouse)
                $query .= " in_warehouse " . $in_warehouse . " AND";

            if ($max_price)
                $query .= " current_price <= " . $max_price . "' AND";
            if ($brand_id)
                $query .= " brand_id LIKE '%" . $brand_id . "%' AND";


            if ($category_id != -1)
                $query .= "(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\")";
            
            $query .= " ORDER BY " . $sort_by . " " . $order_by;
            if ($per_page != -1 && $from != -1)
                $query .= ' LIMIT ' . $from . ',' . $per_page;

            $this->db->select($query, FALSE);
            $shop = $this->db->get()->result_array();
        }
        else {
            if ($active != -1){
                $this->db->where('active', $active);
            }
            if ($in_warehouse) {;
               $this->db->where('in_warehouse', $in_warehouse);
            }

            if ($category_id != -1) { 
                $this->db->where('category_id', $category_id);
            }

            if ($brand_id) {
                $this->db->where('brand_id', $brand_id);
            }
            if ($max_price){
                $this->db->where('current_price <=', $max_price);
            }

            if ($sezon) {
                $this->db->where('sezon', $sezon);
            }
            if ($size) {
                $count = count($size);
                $this->db->like('( razmer', $size[0]);
                for ($i = 1; $i < $count; $i++) {
                    $this->db->or_like('razmer', $size[$i]);
                    
                   
                }
                $this->db->ar_like[count($this->db->ar_like)-1] .= ')';
            }
             //var_dump($this->db->ar_like); var_dump($this->db);
            if ($filter_price_array)
                $this->db->where("current_price BETWEEN " . $filter_price_array['min'] . " AND " . $filter_price_array['max'], NULL, FALSE);


            $this->db->order_by($sort_by, $order_by);
            if ($per_page != -1 && $from != -1)
                $this->db->limit($per_page, $from);
            $shop = $this->db->get('shop')->result_array();
        }

        if (!$shop)
            return false;
        else
            return $shop;
    }

    function getCountArticlesByParentCategory($parent_category_id, $active, $size = false, $sezon = false) {
        $this->db->where('parent_category_id', $parent_category_id);
        if ($active != -1)
            $this->db->where('active', $active);
        if ($sezon)
            $this->db->where('sezon', $sezon);
        if ($size)
            $this->db->like('razmer', $size);
        $this->db->from('shop');
        return $this->db->count_all_results();
    }

    function getArticlesByParentCategory($parent_category_id, $per_page = -1, $from = -1, $active = -1, $order_by = "DESC", $sort_by = 'date', $size = false, $sezon = false) {
        $this->db->where('parent_category_id', $parent_category_id);
        if ($active != -1)
            $this->db->where('active', $active);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);

        if ($sezon)
            $this->db->where('sezon', $sezon);
        if ($size)
            $this->db->like('razmer', $size);

        $this->db->order_by($sort_by, $order_by);
        $shop = $this->db->get('shop')->result_array();

        if (!$shop)
            return false;
        else
            return $shop;
    }

    // CLIENT //

    function getGlavnoe($count = -1, $per_page = -1, $from = -1, $active = -1, $category_id = -1) {
        $this->db->where('glavnoe', '1');
        if ($active != -1)
            $this->db->where('active', $active);
        if ($category_id != -1)
            $this->db->where('category_id', $category_id);

        $this->db->order_by('num', 'DESC');
        if ($count != -1) {
            $this->db->limit($count);
        } else
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $g = $this->db->get('shop')->result_array();

        if (!$g)
            return false;
        else
            return $g;
    }

    function getPodGlavnoe($category_id) {
        // Получаем настройки, будет ли одна статья находиться в нескольких разделах
        $article_in_many_categories = 0;
        $this->db->where('name', 'article_in_many_categories');
        $aimc = $this->db->get('options')->result_array();

        if ($aimc)
            $article_in_many_categories = $aimc[0]['value'];

        if ($article_in_many_categories == 1) {
            $query = "* FROM shop WHERE";
            $query .= " active=1 AND podglavnoe=1 AND";

            $query .= "(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\")";
            $query .= " ORDER BY num DESC";
            $query .= ' LIMIT 1';

            $this->db->select($query, FALSE);
            $shop = $this->db->get()->result_array();
        } else {
            $this->db->where('active', '1');
            $this->db->where('category_id', $category_id);
            $shop = $this->db->get('shop')->result_array();
        }
        if (!$shop)
            return false;
        else
            return $shop[0];
    }

    function getArticlesByDate($date) {
        $this->db->where('date', $date);
        $this->db->where('active', '1');
        $this->db->order_by('num', 'DESC');
        $art = $this->db->get('shop')->result_array();
        if (!$art)
            return false;
        else
            return $art;
    }

    function getProductById($id) {
        $this->db->where('id', $id);
        $cat = $this->db->get('shop')->result_array();
        if (!$cat)
            return false;
        else
            return $cat[0];
    }

    function getLastArticleFromCategory($category_id, $limit = 1) {
        $this->db->where('category_id', $category_id);
        $this->db->order_by('num', 'DESC');
        $this->db->limit($limit);
        $art = $this->db->get('shop')->result_array();
        if (!$art)
            return false;
        elseif ($limit == 1)
            return $art[0];
        else
            return $art;
    }

    function getLastArticles($count) {
        $this->db->where('parent', '7');
        $cats = $this->db->get('categories')->result_array();

        $this->db->where('active', '1');

        if ($cats) {
            $count = count($cats);
            for ($i = 0; $i < $count; $i++) {
                $this->db->where('category_id <> ', $cats[$i]['id']);
            }
        }

        $this->db->order_by('num', 'DESC');
        $this->db->limit($count);
        $art = $this->db->get('shop')->result_array();
        if (!$art)
            return false;
        else
            return $art;
    }

    function getLastArticlesAuthor($count) {
        $this->db->where('author', '1');
        $this->db->order_by('num', 'DESC');
        $this->db->limit($count);
        $art = $this->db->get('shop')->result_array();
        if (!$art)
            return false;
        else
            return $art;
    }

    function getLastArticlesFromCategory($count, $category_id) {
        // Получаем настройки, будет ли одна статья находиться в нескольких разделах
        $article_in_many_categories = 0;
        $this->db->where('name', 'article_in_many_categories');
        $aimc = $this->db->get('options')->result_array();

        if ($aimc)
            $article_in_many_categories = $aimc[0]['value'];

        if ($article_in_many_categories == 1) {
            $query = "* FROM shop WHERE";
            $query .= " active=1 AND";

            $query .= "(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\")";
            $query .= " ORDER BY num DESC";
            $query .= ' LIMIT ' . $count;

            $this->db->select($query, FALSE);
            $shop = $this->db->get()->result_array();
        } else {
            $this->db->where('active', '1');
            $this->db->where('category_id', $category_id);
            $this->db->limit($count);
            $shop = $this->db->get('shop')->result_array();
        }
        if (!$shop)
            return false;
        else
            return $shop;
    }

    function getArticlesByDateAndCategoryId($date, $category_id) {
        // Получаем настройки, будет ли одна статья находиться в нескольких разделах
        $article_in_many_categories = 0;
        $this->db->where('name', 'article_in_many_categories');
        $aimc = $this->db->get('options')->result_array();

        if ($aimc)
            $article_in_many_categories = $aimc[0]['value'];

        if ($article_in_many_categories == 1) {
            $this->db->select("* FROM shop WHERE date='" . $date . "' AND active=1 AND(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\")", FALSE);
            $art = $this->db->get()->result_array();
        } else {
            $this->db->where('date', $date);
            $this->db->where('category_id', $category_id);
            $this->db->where('active', '1');
            $this->db->order_by('num', 'DESC');
            $art = $this->db->get('shop')->result_array();
        }

        if (!$art)
            return false;
        else
            return $art;
    }

    function getArticleByUrlAndCategoryId($url, $category_id) {
        $this->db->where('id', $category_id);
        $this->db->where('active', 1);
        $this->db->limit(1);
        $cat = $this->db->get('categories')->result_array();
        if (!$cat)
            return false;
        $cat = $cat[0];
        if ($cat['parent'] != 0) {
            $this->db->where('id', $cat['parent']);
            $this->db->where('active', 1);
            $this->db->limit(1);
            $cat = $this->db->get('categories')->result_array();
            if (!$cat)
                return false;
            //$cat = $cat[0];
        }
        // Получаем настройки, будет ли одна статья находиться в нескольких разделах
        $article_in_many_categories = 0;
        $this->db->where('name', 'article_in_many_categories');
        $aimc = $this->db->get('options')->result_array();

        if ($aimc)
            $article_in_many_categories = $aimc[0]['value'];

        if ($article_in_many_categories == 1) {
            $this->db->select("* FROM shop WHERE url='" . $url . "' AND active=1 AND(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\") LIMIT 1", FALSE);
            $art = $this->db->get()->result_array();
        } else {
            $this->db->where('category_id', $category_id);
            $this->db->where('url', $url);
            $this->db->where('active', '1');
            $this->db->order_by('num', 'DESC');
            $art = $this->db->get('shop')->result_array();
        }


        if (!$art)
            return false;
        else
            return $art[0];
    }

    function getArticleByUrl($url, $active = -1) {
        $this->db->where('url', $url);
        $this->db->where('active', 1);
        $this->db->limit(1);
        $article = $this->db->get('shop')->result_array();
        if (!$article)
            return false;
        else
            return $article[0];
    }

    function getArticlesByUrl($url, $active = -1) {
        $this->db->where('url', $url);
        $this->db->where('active', 1);
        $article = $this->db->get('shop')->result_array();
        if (!$article)
            return false;
        else
            return $article;
    }

    function Search($key, $per_page = -1, $from = -1) {
        $this->db->where('active', 1);
        $this->db->like('name', $key);
        $this->db->or_like('content', $key);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $shop = $this->db->get('shop')->result_array();
        if (!$shop)
            return false;
        else
            return $shop;
    }

    function Archive($date) {
        $this->db->where('active', 1);
        $this->db->where('date', $date);
        $shop = $this->db->get('shop')->result_array();
        if (!$shop)
            return false;
        else
            return $shop;
    }

    function countPlus($id) {
        $this->db->where('id', $id);
        $shop = $this->db->get('shop')->result_array();
        if ($shop) {
            $shop = $shop[0];
            $count = $shop['count'] + 1;
            $dbins = array('count' => $count);
            $this->db->where('id', $id)->update('shop', $dbins);
        }
    }

    function getUserArticles($login, $active = -1, $per_page = -1, $from = -1) {
        $this->db->where('login', $login);
        if ($active != -1)
            $this->db->where('active', $active);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $this->db->order_by('num', 'DESC');
        $shop = $this->db->get('shop')->result_array();
        if (!$shop)
            return false;
        else
            return $shop;
    }

    function getUserArticlesCount($login) {
        $this->db->where('login', $login);
        $this->db->where('active', 1);
        $shop = $this->db->get('shop')->result_array();
        if (!$shop)
            return 0;
        else
            return count($shop);
    }

    function getLastImportant($active = -1, $category_id = -1, $count = 1) {
        $this->db->where('important', 1);
        if ($active != -1)
            $this->db->where('active', $active);
        if ($category_id != -1)
            $this->db->where('category_id', $category_id);
        $this->db->limit($count);
        $this->db->order_by('num', 'DESC');
        $li = $this->db->get('shop')->result_array();
        if ($count != 1)
            return $li;
        else {
            if (!$li)
                return false;
            else
                return $li[0];
        }
    }

    //////////////////////////////////////

    function getBottom($bottom, $limit) {
        $this->db->where('bottom' . $bottom, 1);
        $this->db->where('active', 1);
        $this->db->limit($limit);
        $this->db->order_by('num', 'DESC');
        return $this->db->get('shop')->result_array();
    }

    ///////
    // ORDERS - ОБРАБОТКА ЗАКАЗОВ
    function getOrders($per_page = -1, $from = -1, $status = -1) {
        if ($status != -1)
            $this->db->where('status', $status);
        $this->db->order_by('id', 'DESC');
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        return $this->db->get('orders')->result_array();
    }

    function getOrderById($id) {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $order = $this->db->get('orders')->result_array();
        if ($order)
            return $order[0];
        else
            return false;
    }

    function getOrdersByUserId($user_id, $active = -1, $per_page = -1, $from = -1, $status = -1) {
        $this->db->where('user_id', $user_id);
        if ($active != -1)
            $this->db->where('active', $active);
        if ($status != -1)
            $this->db->where('status', $status);
        $this->db->order_by('unix', 'DESC');
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $orders = $this->db->get('orders')->result_array();
        if ($orders)
            return $orders;
        else
            return false;
    }

    /////////////
}
?>