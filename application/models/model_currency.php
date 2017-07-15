<?php
class Model_currency extends CI_Model {
    
    function getNewNum()
    {
        $num = $this->db->select_max('num')->get("currency")->result_array();
        if($num[0]['num'] === NULL) return 0;
        else return ($num[0]['num']+1);
    }
    
    function getCurrencies()
    {
        $this->db->order_by('num','ASC');
        return $this->db->get('currency')->result_array();
    }
    
    function getByName($name)
    {
        $this->db->like('name','"'.$name.'"');
        $cat = $this->db->get('currency')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    function getById($id)
    {
        $this->db->where('id',$id);
        $cat = $this->db->get('currency')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    function getByCode($code)
    {
        $this->db->where('code',$code);
        $cat = $this->db->get('currency')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    function getByNum($num)
    {
        $this->db->where('num',$num);
        $cat = $this->db->get('currency')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    
    function getMainCurrency()
    {
        $this->db->where('main', 1);
        $this->db->limit(1);
        $cur = $this->db->get('currency')->result_array();
        if($cur) return $cur[0];
        else return false;
    }
}
?>