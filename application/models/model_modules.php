<?php
class Model_modules extends CI_Model
{
    function getModulesByLogin($login){
        $this->db->where('login', $login);
        return $this->db->get('admin_main')->result_array();
    }

    function getTodoList($login, $status = false, $type = 'private'){
        $this->db->where('login', $login);
        if($type !== false)
            $this->db->where('type',$type);
       // else $this->db->or_where('type','public');

        if($status !== false)
            $this->db->where('status',$status);
        $ret =  $this->db->get('module_todo_list')->result_array();
        //echo $this->db->last_query();
        return $ret;
    }

    function getPublicTodoList($loginNot, $status = false){
        $this->db->where('login <>',$loginNot);
        $this->db->where('type','public');
        if($status !== false)
            $this->db->where('status',$status);

        return $this->db->get('module_todo_list')->result_array();
    }
}