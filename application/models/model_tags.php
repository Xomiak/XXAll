<?php

class Model_tags extends CI_Model
{
    function search($tag, $limit = false){
        $this->db->like('name',$tag);
        if($limit != false)
            $this->db->limit($limit);
        return $this->db->get('tags')->result_array();
    }

    function getByName($name){
        $this->db->where('name', $name);
        $this->db->limit(1);
        $tag = $this->db->get('tags')->result_array();
        if(isset($tag[0])) return $tag[0];

        return false;
    }

    function getById($id){
        $this->db->where('id', $id);
        $this->db->limit(1);
        $tag = $this->db->get('tags')->result_array();
        if(isset($tag[0])) return $tag[0];

        return false;
    }

    function getByUrl($url){
        $this->db->where('url', $url);
        $this->db->limit(1);
        $tag = $this->db->get('tags')->result_array();
        if(isset($tag[0])) return $tag[0];

        return false;
    }

    function getTagsCount(){
        $this->db->from('tags');
        return $this->db->count_all_results();
    }

    function getTags($per_page = -1, $from = -1, $order_by = 'ASC', $sort_by = 'name'){
        if($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $this->db->order_by($sort_by, $order_by);
        return $this->db->get('tags')->result_array();
    }

    function getCountOfUses($tag){
        $this->db->like('tags',$tag);
        $this->db->from('articles');
        $artCount = $this->db->count_all_results();
        $this->db->like('tags',$tag);
        $this->db->from('products');
        $prodCount = $this->db->count_all_results();
        return ($artCount + $prodCount);
    }
}