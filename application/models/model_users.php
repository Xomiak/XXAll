<?php
class Model_users extends CI_Model {

    function getUsers($per_page = -1, $from = -1, $active = NULL, $type = false, $order_by = "DESC")
    {
        if($active != NULL)
            $this->db->where('active', $active);
        if($type)
            $this->db->where('type', $type);
        if ($per_page != -1 && $from != -1)
            $this->db->limit($per_page, $from);
        $this->db->order_by('id',$order_by);
        $result = $this->db->get('users')->result_array();
        //echo $this->db->last_query();
        return $result;
    }

    function getUsersCount($active = -1, $type = false)
    {
        if($active != -1)
            $this->db->where('active', $active);
        if($type)
            $this->db->where('type', $type);

        $this->db->from('users');
        return $this->db->count_all_results();
    }
    
    function getUserById($id)
    {
        $this->db->where('id',$id);
        $this->db->limit(1);
        $user = $this->db->get('users')->result_array();
        if(!$user) return false;
        else return $user[0];
    }
    
    function getUserByLogin($login)
    {
        $this->db->where('login',$login);
        $this->db->limit(1);
        $user = $this->db->get('users')->result_array();
        if(!$user) return false;
        else return $user[0];
    }

    function getUserByLoginAndPassword($login, $password)
    {
        $this->db->where('login',$login);
        $this->db->where('password',md5($password));
        $this->db->limit(1);
        $user = $this->db->get('users')->result_array();
        if(!$user) return false;
        else return $user[0];
    }

    function getUserByEmail($email)
    {
        $this->db->where('email',$email);
        $this->db->limit(1);
        $user = $this->db->get('users')->result_array();
        if(!$user) return false;
        else return $user[0];
    }
    
    function setLastDateAndIp($login)
    {
        $this->db->where('login',$login);
        $dbins = array(
            'last_login_date'       => date("Y-m-d H:i"),
            'last_login_ip'         => $_SERVER['REMOTE_ADDR']
           );
        $this->db->limit(1);
	$this->db->update('users',$dbins);
    }

    function editSocialUserDetails($user, $s_user)
    {
        $dbins = array();
        if(isset($s_user['network'])) {
            $res = strpos($user['network'], $s_user['network']);
            if($res === false)
                $dbins['network'] = $user['network'].'|'.$s_user['network'];
        }

        if(isset($s_user['profile'])) {
            $res = strpos($user['profile'], $s_user['profile']);
            if($res === false)
                $dbins['profile'] = $user['profile'].'|'.$s_user['profile'];
        }
        if(isset($s_user['uid']) && $user['uid'] != $s_user['uid']) $dbins['uid'] = $s_user['uid'];
        if(isset($s_user['sex']) && $user['sex'] != $s_user['sex']) $dbins['sex'] = $s_user['sex'];
        if(isset($s_user['identity']) && $user['identity'] != $s_user['identity']) $dbins['identity'] = $s_user['identity'];
        if(isset($s_user['nikname']) && $user['nikname'] != $s_user['nikname']) $dbins['nikname'] = $s_user['nikname'];
        if(isset($s_user['first_name']) && $user['name'] != $s_user['first_name']) $dbins['name'] = $s_user['first_name'];
        if(isset($s_user['last_name']) && $user['lastname'] != $s_user['last_name']) $dbins['lastname'] = $s_user['last_name'];
        if(isset($s_user['photo_big']) && $user['photo'] != $s_user['photo_big']) $dbins['photo'] = $s_user['photo_big'];
        if(isset($s_user['bdate']) && $user['bdate'] != $s_user['bdate']) $dbins['bdate'] = $s_user['bdate'];
        if(isset($s_user['photo']) && $user['avatar'] != $s_user['photo']) $dbins['avatar'] = $s_user['photo'];
        if(isset($s_user['city']) && $user['city'] != $s_user['city']) $dbins['city'] = $s_user['city'];
        if(isset($s_user['country']) && $user['country'] != $s_user['country']) $dbins['country'] = $s_user['country'];

        if($dbins)
            return $this->db->where('id',$user['id'])->limit(1)->update('users', $dbins);

        return false;
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////  USERTYPES /////////////////////////////////////////////////////////////////////////////////

    function getUsertypes($active = -1){
        if($active != -1)
            $this->db->where('active', $active);
        $this->db->order_by('id','ASC');
        return $this->db->get('usertypes')->result_array();
    }
}
?>