<?php

class Model_products extends CI_Model
{

    function getOrdersByUserId($user_id){
        $this->db->where('user_id', $user_id);
        $this->db->order_by('unix', 'DESC');
        return $this->db->get('orders')->result_array();
    }


    // START ** PRODUCTS SETTINGS ** //

    function getSettings($multilanguage = -1)
    {
        if ($multilanguage != -1) $this->db->where('multilanguage', $multilanguage);
        $this->db->where('is_visible', 1);
        $this->db->order_by('num', 'ASC');
        return $this->db->get('products_settings')->result_array();
    }


    function getSettingsNewNum()
    {
        $num = $this->db->select_max('num')->get("products_settings")->result_array();
        if ($num[0]['num'] === NULL)
            return 0;
        else return ($num[0]['num'] + 1);
    }

    function getSettingByNum($num)
    {
        $this->db->where('num', $num);
        $cat = $this->db->get('products_settings')->result_array();
        if (!$cat)
            return false;
        else
            return $cat[0];
    }


    function getSettingById($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $ret = $this->db->get('products_settings')->result_array();
        if (!$ret)
            return false;
        else return $ret[0];
    }

    function getSettingByName($name)
    {
        $this->db->where('name', $name);
        $this->db->limit(1);
        $ret = $this->db->get('products_settings')->result_array();
        if (!$ret)
            return false;
        else return $ret[0];
    }

    function isSetting($name)
    {
        $this->db->where('name', $name);
        $this->db->limit(1);
        $this->db->from('products_settings');
        $count = $this->db->count_all_results();
        if ($count > 0) return true;
        return false;
    }

    function getSettingsForAdminTable()
    {
        $this->db->where('admin_in_table', 1);
        $this->db->order_by('num', 'ASC');
        return $this->db->get('products_settings')->result_array();
    }

    function getSettingsByType($type)
    {
        $this->db->where('is_visible', 1);
        $this->db->where('type', 'Файл');
        $this->db->order_by('num', 'ASC');
        return $this->db->get('products_settings')->result_array();
    }

    // END ** PRODUCTS SETTINGS ** //


    // START ** PRODUCTS SETTINGS ** //

    function getProducts($per_page = -1, $from = -1, $order_by = "DESC", $active = -1, $in_warehouse = -1)
    {
        if ($active != -1)
            $this->db->where('active', $active);
        $this->db->order_by('num', $order_by);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        if ($in_warehouse != -1)
            $this->db->where('in_warehouse', $in_warehouse);
        return $this->db->get('products')->result_array();
    }

    function getProductsNewNum()
    {
        $num = $this->db->select_max('num')->get("products")->result_array();
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
        $ret = $this->db->get('products')->result_array();
        if (!$ret)
            return false;
        else return $ret[0];
    }

    function getLastProducts($per_page = -1, $from = -1, $category_id = -1, $order_by = "DESC", $sort_by = 'id')
    {
        $query = "SELECT * FROM products";
        if ($category_id != -1)
            $query .= "(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\")";

        if ($sort_by != 'name' || $sort_by != 'content')
            $query .= " ORDER BY " . $sort_by . " " . $order_by;

        if ($per_page != -1 && $from != -1)
            $query .= ' LIMIT ' . $from . ',' . $per_page;

        $res = $this->db->query($query)->result_array();

        if ($sort_by == 'name' || $sort_by == 'content')
            $res = $this->sortBySerializedField($res, $sort_by, $order_by);

        return ($res) ? $res : false;
    }

    function getProductById($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $ret = $this->db->get('products')->result_array();
        if (!$ret)
            return false;
        else return $ret[0];
    }

    function checkProductById($id)
    {
        $this->db->select('id');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $ret = $this->db->get('products')->result_array();
        return (isset($ret[0]['id'])) ? true : false;
    }

    function getProductByUrl($url)
    {
        $this->db->where('url', $url);
        $this->db->limit(1);
        $ret = $this->db->get('products')->result_array();
        if (!$ret)
            return false;
        else return $ret[0];
    }

    function getProductByNum($num)
    {
        $this->db->where('num', $num);
        $cat = $this->db->get('products')->result_array();
        if (!$cat)
            return false;
        else
            return $cat[0];
    }

    function getCountProductsInCategory($category_id, $active = -1, $filters = false, $in_warehouse = false)
    {
        $brand_id = $this->session->userdata('filter_brand');
        $article_in_many_categories = 0;
        $this->db->where('name', 'article_in_many_categories');
        $aimc = $this->db->get('options')->result_array();

        if ($aimc)
            $article_in_many_categories = $aimc[0]['value'];

        if ($article_in_many_categories == 1) {
            $query = "* FROM products WHERE";
            if ($active != -1)
                $query .= " active=" . $active . " AND";
            if ($in_warehouse)
                $query .= " in_warehouse " . $in_warehouse . " AND";

            if ($brand_id)
                $query .= " brand_id LIKE '%" . $brand_id . "%' AND";


            $query .= "(category_id=" . $category_id . " or category_id like \"%*" . $category_id . "\" or category_id like \"%*" . $category_id . "*%\" or category_id like \"" . $category_id . "*%\")";
            if ($filters)
                $this->whereFilters($filters);

            $this->db->select($query, FALSE);
            $products = $this->db->get()->result_array();
            return count($products);
        } else {
            $this->db->where('category_id', $category_id);
            if ($filters)
                $this->whereFilters($filters);

            if ($active != -1)
                $this->db->where('active', $active);

            if ($in_warehouse)
                $this->db->where('in_warehouse', $in_warehouse);

            $this->db->from('products');
            $ret = $this->db->count_all_results();
            //var_dump($ret);
            return $ret;
        }
    }

    function getProductsByFirstCategory($parent_category_id, $per_page = -1, $from = -1, $active = -1, $order_by = "DESC", $sort_by = 'num', $future = -1)
    {
        $this->db->where('first_category_id', $parent_category_id);

        if ($active != -1)
            $this->db->where('active', $active);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);

        $this->db->order_by($sort_by, $order_by);
        $articles = $this->db->get('products')->result_array();
        //vd($articles);
        if (!$articles)
            return false;
        else return $articles;
    }


    function getProductsByCategory($category_id = -1, $per_page = -1, $from = -1, $active = -1, $order_by = "DESC", $sort_by = 'num', $future = -1)
    {

        if ($active != -1) {
            $this->db->where('active', $active);
        }


        if ($future == 1)
            $this->db->where('end_date_unix >', time());
        elseif ($future == 0)
            $this->db->where('end_date_unix <', time());

        if ($category_id != -1) {
            $this->db->like('category_id', '*' . $category_id . '*');
        }

        $this->db->order_by($sort_by, $order_by);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $articles = $this->db->get('products')->result_array();


        if (!$articles)
            return false;
        else
            return $articles;
    }

    function getProductsByParentCategory($parent_category_id, $per_page = -1, $from = -1, $active = -1, $order_by = "DESC", $sort_by = 'id', $filters = false)
    {
        $this->db->where('parent_category_id', $parent_category_id);
        if ($active != -1)
            $this->db->where('active', $active);

        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        if ($filters)
            $this->whereFilters($filters);

        if ($sort_by != 'name' || $sort_by != 'content')
            $this->db->order_by($sort_by, $order_by);

        $products = $this->db->get('products')->result_array();

        if ($sort_by == 'name' || $sort_by == 'content')
            $products = $this->sortBySerializedField($products, $sort_by, $order_by);

        if (!$products)
            return false;
        else
            return $products;
    }

    function getProductByUrlAndCategoryId($url, $category_id, $active = 1)
    {
        $result = false;
        $this->db->where('url', $url);
        if ($active != -1)
            $this->db->where('active', $active);
        $this->db->like('category_id', '*' . $category_id . '*');
        $this->db->limit(1);
        $ret = $this->db->get('products')->result_array();
        if (isset($ret[0])) $result = $ret[0];
        //echo $this->db->last_query();
        return $result;

    }

    function getProductsByUrl($url, $active = 1, $created_by = false)
    {
        $this->db->where('url', $url);
        if ($active != -1)
            $this->db->where('active', $active);
//        if ($created_by)
//            $this->db->where('created_by', $created_by);
        $article = $this->db->get('products')->result_array();
        if (!$article)
            return false;
        else
            return $article;
    }

    function searchByName($search, $category_id = -1, $per_page = -1, $from = -1, $order_by = "DESC", $sort_by = 'id', $only_count = false)
    {
        if ($only_count)
            $this->db->select('count(*) AS count');

        if ($category_id != -1)
            $this->db->where('category_id', $category_id);

        $this->db->like('name', $search);

        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);

        if ($sort_by != 'name' || $sort_by != 'content')
            $this->db->order_by($sort_by, $order_by);

        $ret = $this->db->get('products')->result_array();

        if ($sort_by == 'name' || $sort_by == 'content')
            $ret = $this->sortBySerializedField($ret, $sort_by, $order_by);

        //var_dump($this->db->last_query());die();
        return $ret;
    }



    function getCountProductsByParentCategory($parent_category_id, $active, $filters = false, $in_warehouse = false)
    {
        $this->db->where('parent_category_id', $parent_category_id);
        if ($active != -1)
            $this->db->where('active', $active);

        if ($in_warehouse)
            $this->db->where('in_warehouse', $in_warehouse);

        if ($filters)
            $this->whereFilters($filters);

        $this->db->from('products');
        return $this->db->count_all_results();
    }



    function getByParams($params = false)
    {
        if ($params) {
            foreach ($params as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        return $this->db->get('products')->result_array();
    }

    //////////////////////////////////////
    // BRANDS

    function getBrandsCount($active = -1)
    {
        if ($active != -1)
            $this->db->where('active', $active);

        $this->db->from('brands');
        $ret = $this->db->count_all_results();

        return $ret;
    }

    function getBrands($active = -1, $per_page = -1, $from = -1, $order_by = 'ASC')
    {
        if ($active != -1)
            $this->db->where('active', $active);
        $this->db->order_by('name', $order_by);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $ret = $this->db->get('brands')->result_array();
        return $ret;
    }

    function getCountProductsInBrand($brand_id, $active = -1)
    {
        $this->db->where('brand_id', $brand_id);
        if ($active != -1)
            $this->db->where('active', $active);

        $this->db->from('products');
        return $this->db->count_all_results();
    }

    function getProductsByBrand($brand_id, $per_page = -1, $from = -1, $active = -1, $order_by = "DESC", $sort_by = 'num', $filters = false, $in_warehouse = false)
    {
        if ($active != -1)
            $this->db->where('active', $active);

        $this->db->where('brand_id', $brand_id);

        if ($filters)
            $this->whereFilters($filters);

        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);

        if ($sort_by != 'name' || $sort_by != 'content')
            $this->db->order_by($sort_by, $order_by);

        $shop = $this->db->get('products')->result_array();

        if ($sort_by == 'name' || $sort_by == 'content')
            $products = $this->sortBySerializedField($shop, $sort_by, $order_by);

        if (!$shop)
            return false;
        else
            return $shop;
    }

    private function whereFilters($filters)
    {
        foreach ($filters as $key => $vals) {
            if ($key == 'price') {
                if (isset($filters[$key]['max_price']) && isset($filters[$key]['min_price']))
                    $this->db->where("price BETWEEN " . $filters[$key]['min_price'] . " AND " . $filters[$key]['max_price'], NULL, FALSE);
            } else {
                if (is_array($vals)) {
                    if (count($this->db->ar_like) > 0)
                        $this->db->ar_like[] = ' AND (';
                    else
                        $this->db->ar_like[] = ' (';
                    $indx = count($this->db->ar_like) - 1;

                    $this->db->ar_like[$indx] .= "filter_" . $key . " LIKE '%|" . $vals[0] . "|%' ";
                    for ($v = 1; $v < count($vals); $v++)
                        $this->db->ar_like[$indx] .= " OR filter_" . $key . " LIKE '%|" . $vals[0] . "|%' ";
                    $this->db->ar_like[$indx] .= ') ';
                } else
                    $this->db->like('filter_' . $key, '|' . $vals . '|');
            }
            //var_dump($this->db->ar_like);die();
        }
    }

    private function sortBySerializedField($products, $sort_by, $order_by)
    {
        /*сортировка по сериализованному полю*/
        $control_arr = array();
        for ($i = 0; $i < count($products); $i++) {
            $control_arr[] = getLangText($products[$i][$sort_by]);
        }
        //var_dump($control_arr);
        if (strtoupper($order_by) == 'ASC') {
            array_multisort($control_arr, SORT_ASC, SORT_STRING, $products);
        } else {
            array_multisort($control_arr, SORT_DESC, SORT_STRING, $products);
        }
        return $products;
    }

    public function updateUrlCache($id, $url)
    {
        if ($this->checkProductById($id)) {
            $this->db->where('id', $id);
            $this->db->limit(1);
            return $this->db->update('products', array('url_cache' => $url));
        }
        return false;
    }

    // TAGS //
    public function getCountProductsByTag($tag, $active = -1, $noProductIds = false, $inCatsOnly = false)
    {
        // НЕ БЕРЁМ ТОВАРЫ С ПЕРЕДАННЫМИ ID
        if($noProductIds){
            if(is_array($noProductIds)){
                foreach ($noProductIds as $id)
                    $this->db->where('id <>', $id);
            } else $this->db->where('id <>', $noProductIds);
        }
        // БЕРЁМ ТОВАРЫ ТОЛЬКО ИЗ КОНКРЕТНЫХ КАТЕГОРИЙ ID
        if($inCatsOnly){
            if(is_array($inCatsOnly)){
                foreach ($inCatsOnly as $id)
                    $this->db->like('category_id', '*'.$id.'*');
            } else $this->db->like('category_id', '*'.$inCatsOnly.'*');
        }

        if ($active != -1)
            $this->db->where('active', $active);
        $this->db->like('tags', $tag);
        $this->db->from('products');
        return $this->db->count_all_results();
    }

    public function getProductsByTag($tag, $per_page = -1, $from = -1, $active = -1, $noProductIds = false, $inCatsOnly = false)
    {
        // НЕ БЕРЁМ ТОВАРЫ С ПЕРЕДАННЫМИ ID
        if($noProductIds){
            if(is_array($noProductIds)){
                foreach ($noProductIds as $id)
                    $this->db->where('id <>', $id);
            } else $this->db->where('id <>', $noProductIds);
        }
        // БЕРЁМ ТОВАРЫ ТОЛЬКО ИЗ КОНКРЕТНЫХ КАТЕГОРИЙ ID
        if($inCatsOnly){
            if(is_array($inCatsOnly)){
                foreach ($inCatsOnly as $id)
                    $this->db->like('category_id', '*'.$id.'*');
            } else $this->db->like('category_id', '*'.$inCatsOnly.'*');
        }

        if ($active != -1)
            $this->db->where('active', $active);
        $this->db->like('tags', $tag);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $this->db->order_by('unix', 'DESC');
        return $this->db->get('products')->result_array();
    }

}