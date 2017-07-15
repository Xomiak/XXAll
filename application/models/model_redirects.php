<?php
class Model_redirects extends CI_Model {

    function getRedirectForThisUrl($active = 1){
        $this->db->where('from', $_SERVER['REQUEST_URI']);
        if($active != -1)
            $this->db->where('active', $active);
        $result = $this->db->get('redirects')->result_array();
        if(isset($result[0]['to'])) return $result[0]['to'];

        return false;
    }
}
?>