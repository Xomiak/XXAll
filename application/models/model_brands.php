<?php
class Model_brands extends CI_Model {
    
    function getNewNum()
    {
        $num = $this->db->select_max('num')->get("brands")->result_array();
        if($num[0]['num'] === NULL) return 0;
        else return ($num[0]['num']+1);
    }
    
    function getBrands($active = -1)
    {
        $this->db->order_by('num','ASC');
        if($active != -1) $this->db->where('active',$active);
        return $this->db->get('brands')->result_array();
    }
    
    function getBrand($name)
    {
        $this->db->where('name',$name);
        $cat = $this->db->get('brands')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    function getBrandById($id)
    {
        $this->db->where('id',$id);
        $cat = $this->db->get('brands')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    function getBrandByNum($num)
    {
        $this->db->where('num',$num);
        $cat = $this->db->get('brands')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    function getBrandByUrl($url, $active = -1)
    {
        $this->db->where('url',$url);
        if($active != -1) $this->db->where('active',$active);
        $cat = $this->db->get('brands')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
}
?>