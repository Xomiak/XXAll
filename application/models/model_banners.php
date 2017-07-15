<?php
class Model_banners extends CI_Model {
   
    function getBanners($position = false)
    {
        if($position) $this->db->where('position', $position);
        $this->db->order_by('num', 'ASC');
        return $this->db->get('banners')->result_array();
    }
    
    function getNewNum()
    {
        $num = $this->db->select_max('num')->get("banners")->result_array();
        if($num[0]['num'] === NULL) return 0;
        else return ($num[0]['num']+1);
    }
    
    function getByType($type, $active = -1)
    {
        if($active != -1) $this->db->where('active', $active);
        $this->db->where('position', $type);
        $this->db->order_by('num', 'ASC');
        return $this->db->get('banners')->result_array();
    }

    function getByPosition($position, $active = -1)
    {
        if($active != -1) $this->db->where('active', $active);
        $this->db->where('position', $position);
        $this->db->order_by('num', 'ASC');
        return $this->db->get('banners')->result_array();
    }

    
    function getBanner($name)
    {
        $this->db->where('name',$name);
        $cat = $this->db->get('banners')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    
    function getBannerById($id, $active = -1)
    {
        $this->db->where('id',$id);
        if($active != -1) $this->db->where('active', $active);
        $cat = $this->db->get('banners')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    
    function getByNum($num, $active = -1)
    {
        $this->db->where('num',$num);
        if($active != -1) $this->db->where('active', $active);
        $cat = $this->db->get('banners')->result_array();
        if(!$cat) return false;
        else return $cat[0];
    }
    
    function getLink($id)
    {
        $this->db->where('id',$id);
        $this->db->limit(1);
        $banner = $this->db->get('banners')->result_array();
        if($banner) return $banner[0]['url'];
        else return false;
    }
    
    function countPlus($id)
    {
        $this->db->where('id',$id);
        $banner = $this->db->get('banners')->result_array();
        if($banner)
        {
            $banner = $banner[0];
            $count = $banner['count'] + 1;
            $dbins = array('count' => $count);
            $this->db->where('id',$id)->update('banners',$dbins);
        }
    }
}
?>