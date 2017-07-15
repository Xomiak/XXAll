<?php
class Model_map extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    function get_coordinates()
    {
        $return = array();
        $this->db->select("*");
        $this->db->from("coords");
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

    function getByAdress($adress){
        $this->db->where('adress', $adress);
        $this->db->limit(1);
        return $this->db->get('coords')->result_array();
    }
}
