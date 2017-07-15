<?php
class Model_quest extends CI_Model {
    
    function getOption($name)
    {
        $this->db->where('name',$name);
        $this->db->limit(1);
        $option = $this->db->get('quest')->result_array();
        if(!$option) return false;
        else return $option[0]['value'];
    }
     
    function getOptionById($id)
    {
        $this->db->where('id',$id);
        $this->db->limit(1);
        $option = $this->db->get('quest')->result_array();
        if(!$option) return false;
        else return $option[0];
    }
    
    function getAllOptions($order_by = 'module', $sort = 'ASC')
    {
        //$this->db->order_by($order_by, $sort);
        return $this->db->get('quest')->result_array();
    }
    
    function getOptionsByModule($module)
    {
        $this->db->where('module', $module);
        return $this->db->get('quest')->result_array();
    }
    
    function getAllModules($active = -1)
    {
        if($active != -1) $this->db->where('active', $active);
        return $this->db->get('modules')->result_array();
    }
    
    function getModule($name, $active = -1)
    {
        if($active != -1) $this->db->where('active', $active);
        $this->db->where('name', $name);
        $module = $this->db->get('modules')->result_array();
        if(!$module) return false;
        else return $module[0];
    }
    
    function getModuleTitle($name)
    {
        $this->db->where('name', $name);
        $module = $this->db->get('modules')->result_array();
        if(!$module) return false;
        else return $module[0]['title'];
    }
}
?>