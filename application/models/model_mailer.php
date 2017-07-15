<?php
class Model_mailer extends CI_Model {
    
    function getOption($name)
    {
        $this->db->where('name', $name);
        $this->db->limit(1);
        $opt = $this->db->get('mailer_options')->result_array();
        if(!$opt) return false;
        else return $opt[0]['value'];
    }
    
    function getAllOptions()
    {
        return $this->db->get('mailer_options')->result_array();
    }
    
    function getOptionById($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $opt = $this->db->get('mailer_options')->result_array();
        if(!$opt) return false;
        else return $opt[0];
    }
    
    function getLastMailer()
    {
        $this->db->limit(1);
        $this->db->order_by('id','DESC');
        $last = $this->db->get('mailer')->result_array();
        if(!$last) return false;
        else return $last[0];
    }

    function getById($id){
        $this->db->where('id',$id);
        $this->db->limit(1);
        $ret = $this->db->get('mailer')->result_array();
        if(isset($ret[0])) return $ret[0];

        return false;
    }

    function getAll($per_page = -1, $from = -1, $status = -1){

        if($status != -1)
            $this->db->where('status', $status);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);

        return $this->db->get('mailer')->result_array();
    }
    
}
?>