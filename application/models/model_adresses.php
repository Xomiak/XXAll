<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_adresses extends CI_Model
{

    function getAdresses($active = -1, $per_page = -1, $from = -1, $sort_by ='a.article_id', $order_by = 'DESC'){
        $query = "SELECT a.id, art.name, a.city, a.adress, a.lat, a.lng, a.icon, a.description, a.article_id, a.active FROM articles art, adresses a WHERE a.article_id=art.id";
        if ($active != -1)
            $query .= ' AND a.active=1 AND art.active=1';
        $query .= " ORDER BY " . $sort_by . " " . $order_by;
        if ($per_page != -1 && $from != -1)
            $query .= ' LIMIT ' . $from . ',' . $per_page;
        $ret = $this->db->query($query)->result_array();
        //vd($this->db->last_query());
        return $ret;
    }

    function getAdressesByCategory($category_id, $active = -1, $per_page = -1, $from = -1, $sort_by ='article_id', $order_by = 'DESC'){
        $level = $this->model_categories->getCategoryLevel($category_id);
        $where = 'category_id';
        if($level == 1) $where = 'first_category_id';
        elseif($level == 2) $where = 'parent_category_id';
        $query = "SELECT a.adress, a.lat, a.lng, a.icon, a.description, art.name FROM adresses a, articles art WHERE art.".$where."=".$category_id." AND a.article_id=art.id";
        $this->db->where($where, $category_id);
        if ($active != -1)
            $query .= " AND a.active=1 AND art.active=1";
        $query .= " ORDER BY " . $sort_by . " " . $order_by;
        if ($per_page != -1 && $from != -1)
            $query .= ' LIMIT ' . $from . ',' . $per_page;
        $ret = $this->db->query($query)->result_array();
        //vd($this->db->last_query());
//vd($ret);
        return $ret;
    }

    function getById($id){
        $ret = $this->db->where('id', $id)->limit(1)->get('adresses')->result_array();
        if(isset($ret[0])) return $ret[0];

        return false;
    }

    function search($search, $per_page = -1, $from = -1, $sort_by ='article_id', $order_by = 'DESC'){
        $this->db->like('adress', $search);
        $this->db->or_like('description', $search);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $this->db->order_by($sort_by,$order_by);
        $ret = $this->db->get('adresses')->result_array();

        return $ret;
    }

   function getByArticleId($article_id, $active = -1){
       $this->db->where('article_id', $article_id);
       if($active != -1)
           $this->db->where('active', $active);
       return $this->db->get('adresses')->result_array();
   }

    function getOrganizations($per_page = -1, $from = -1){
        $query = 'SELECT a.name, a.adress, a.id
         FROM articles a, categories c
         WHERE a.category_id = c.id
         AND c.type=\'organizations\'';
        if($per_page != -1 && $from != -1){
            $query .= ' LIMIT ' . $from . ',' . $per_page;
        }
        $results = $this->db->query($query)->result_array();

        return $results;
    }

    function getOrganizationsByFirstCategory($first_category_id, $per_page = -1, $from = -1){
        $query = 'SELECT a.name, a.adress, a.id
         FROM articles a, categories c
         WHERE a.category_id = c.id
         AND c.type=\'organizations\'';
        if($per_page != -1 && $from != -1){
            $query .= ' LIMIT ' . $from . ',' . $per_page;
        }
        $results = $this->db->query($query)->result_array();

        return $results;
    }

    function getByLatLng($lat, $lng, $article_id = -1){
        $this->db->where('lat', $lat);
        $this->db->where('lng', $lng);
        if($article_id != -1)
            $this->db->where('article_id', $article_id);

        return $this->db->get('adresses')->result_array();
    }

    function getAdressesByArticleId($article_id, $active = -1){
        $this->db->where('article_id', $article_id);
        if($active != -1)
            $this->db->where('active', $active);

        return $this->db->get('adresses')->result_array();
    }

    function get_coordinates()
    {
        $return = array();
        $this->db->select("*");
        $this->db->from("adresses");
        $this->db->where('lat <>',0);
        $this->db->where('lng <>',0);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            foreach ($query->result() as $row) {
                array_push($return, $row);
            }
        }
        return $return;
    }
}