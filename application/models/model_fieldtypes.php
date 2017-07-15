<?php
class Model_fieldtypes extends CI_Model {
    function getByName($name)
    {
        $this->db->where('name', $name);
        $this->db->limit(1);
        $ret = $this->db->get('fieldtypes')->result_array();
        if(!$ret) return false;
        else return $ret[0];
    }

    function getAll($to_options = -1){
        if($to_options != -1) $this->db->where('to_options', $to_options);
        return $this->db->get('fieldtypes')->result_array();
    }

}