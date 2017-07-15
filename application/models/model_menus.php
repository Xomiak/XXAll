<?php
class Model_menus extends CI_Model {
    
    function getNewNum()
    {
        $num = $this->db->select_max('num')->get("menus")->result_array();
        if($num[0]['num'] === NULL) return 0;
        else return ($num[0]['num']+1);
    }
    
    function getNewSectionNum($parent_id)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('num', 'DESC');
        $this->db->limit(1);
        $ret = $this->db->get('menus')->result_array();
        if(!$ret) return 0;
        else
        {
            $ret = $ret[0]['num'] + 1;
            return $ret;
        }
    }
    
    function getMenus()
    {
        $this->db->order_by('num','ASC');
        return $this->db->get('menus')->result_array();
    }
    
    function getMenusWithParentId($parent_id)
    {
        $this->db->where('parent_id', $parent_id);
        //$this->db->order_by('position','ASC');
        $this->db->order_by('num','ASC');
        
        return $this->db->get('menus')->result_array();
    }
    
    function getMenu($name)
    {
        $this->db->like('name',$name);
        $cat = $this->db->get('menus')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    function getMenuById($id)
    {
        $this->db->where('id',$id);
        $cat = $this->db->get('menus')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    function getMenuByType($type, $active = -1)
    {
        $this->db->where('type',$type);
        if($active != -1) $this->db->where('active',$active);
        return $this->db->get('menus')->result_array();

    }
    function getMenuByPosition($position, $active = -1, $parentOnly = false)
    {
        $this->db->where('position',$position);
        if($parentOnly) $this->db->where('parent_id',0);
        if($active != -1) $this->db->where('active',$active);
        $this->db->order_by('num','ASC');
        return $this->db->get('menus')->result_array();

    }
    function getMenuByNum($num)
    {
        $this->db->where('num',$num);
        $cat = $this->db->get('menus')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }

    function getMenusPositions($active = -1){
        if($active != -1) $this->db->where('active', $active);
        return $this->db->get('menus_positions')->result_array();
    }
}
?>