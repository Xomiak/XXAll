<?php
class Model_cities extends CI_Model
{
    function getRegions($active = -1){
        if($active != -1) $this->db->where('active', $active);
        $this->db->order_by('name','ASC');
        return $this->db->get('regions')->result_array();
    }

    function getCityById($id, $active = -1){
        if($active != -1) $this->db->where('active', $active);
        $this->db->where('id', $id);
        $this->db->limit(1);
        $ret = $this->db->get('cities')->result_array();
        if($ret) return $ret[0];

        return false;
    }

    function getCitiesByRegionId($region_id, $active = -1){
        if($active != -1) $this->db->where('active', $active);
        $this->db->where('region_id', $region_id);
        $this->db->order_by('primary_city','DESC');
        $this->db->order_by('name','ASC');
        return $this->db->get('cities')->result_array();
    }

    function getAreasByCityId($city_id, $active = -1){
        if($active != -1) $this->db->where('active', $active);
        $this->db->where('city_id', $city_id);
        $this->db->order_by('name','ASC');
        return $this->db->get('cities_areas')->result_array();
    }
}