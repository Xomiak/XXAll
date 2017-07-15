<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function isAdminLogin()
{
    $CI = & get_instance();
    if(!$CI->session->userdata('login'))
    {
        if(GetRealIp() != '195.138.64.78')
            err404();
        else
        {
            echo "Вы не авторизированы!<br/><br /><a href='/a'>Авторизироваться</a> ";
            die();
        }
//          redirect('/admin/login/');
    }
    else
    {
        $login = $CI->session->userdata('login');
        $user = $CI->db->where('login',$login)->get('users')->result_array();
        if(!$user) redirect('/admin/login/','location',302);
        else $user = $user[0];
        if($CI->session->userdata('type') != 'admin' && $CI->session->userdata('type') != 'moder') redirect('/admin/login/');
        if($CI->session->userdata('type') != $user['type']) redirect('/admin/login/');
        if($CI->session->userdata('pass') != $user['pass']) redirect('/admin/login/');
    }
}

function isAdmin()
{
    $CI = & get_instance();
    if($CI->session->userdata('login') != false)
    {
        $login = $CI->session->userdata('login');
        $user = $CI->db->where('login',$login)->get('users')->result_array();
        if(isset($user[0]))
        {
            $user = $user[0];
            if($user['type'] == 'admin') return true;
        }
    }
    return false;
}

function isClientAdmin()
{
    $CI = & get_instance();
    
    if($CI->session->userdata('login'))
    {
        $login = $CI->session->userdata('login');
        $user = $CI->db->where('login',$login)->get('users')->result_array();
        if(!$user) return false;
        else $user = $user[0];
        if($CI->session->userdata('type') != 'admin' && $CI->session->userdata('type') != 'moder') return false;
        if($CI->session->userdata('type') != $user['type']) return false;
        if($CI->session->userdata('pass') != $user['pass']) return false;
        
        return true;
    }
    else return false;
}

function isLogin()
{
    if(userdata('social') == true)
        isSocialLogin();
    else
    {
        $CI = & get_instance();
        if($CI->session->userdata('login') != null && $CI->session->userdata('pass') != null && $CI->session->userdata('type') != null)
        {
            $login  = $CI->session->userdata('login');
            $pass   = $CI->session->userdata('pass');
            $type   = $CI->session->userdata('type');
            $CI->db->where('login',$login);
            $CI->db->limit(1);
            $user = $CI->db->get('users')->result_array();
            if(!$user)
            {
                $CI->session->unset_userdata('login');
                $CI->session->unset_userdata('pass');
                $CI->session->unset_userdata('type');
                $CI->session->set_userdata('login_err','������� ������!');
            }
            else
            {
                $user = $user[0];
                if($user['pass'] != $pass)
                {
                    $CI->session->unset_userdata('login');
                    $CI->session->unset_userdata('pass');
                    $CI->session->unset_userdata('type');
                    $CI->session->set_userdata('login_err','������� ������!');
                }
                elseif($user['type'] != $type)
                {
                    $CI->session->unset_userdata('login');
                    $CI->session->unset_userdata('pass');
                    $CI->session->unset_userdata('type');
                    $CI->session->set_userdata('login_err','������� ������!');
                }
                elseif($user['activation'] == 0)
                {
                    $CI->session->unset_userdata('login');
                    $CI->session->unset_userdata('pass');
                    $CI->session->unset_userdata('type');
                    $CI->session->set_userdata('login_err','������������ �� ����������� �������!');
                }
            }
        }
    }
}

function isSocialLogin()
{
    $CI = & get_instance();

    if($CI->session->userdata('login') != null && $CI->session->userdata('pass') != null && $CI->session->userdata('type') != null)
    {
        $login  = $CI->session->userdata('login');
        $pass   = $CI->session->userdata('pass');
        $type   = $CI->session->userdata('type');
        $CI->db->where('login',$login);
        $CI->db->limit(1);
        $user = $CI->db->get('users')->result_array();
        if(!$user)
        {
            $CI->session->unset_userdata('login');
            $CI->session->unset_userdata('pass');
            $CI->session->unset_userdata('type');
            $CI->session->set_userdata('login_err','Social: User Not Found!');
        }
        else
        {
            $user = $user[0];
            if($user['pass'] != $pass)
            {
                $CI->session->unset_userdata('login');
                $CI->session->unset_userdata('pass');
                $CI->session->unset_userdata('type');
                $CI->session->set_userdata('login_err','Social: Подбор пароля');
            }
            elseif($user['type'] != $type)
            {
                $CI->session->unset_userdata('login');
                $CI->session->unset_userdata('pass');
                $CI->session->unset_userdata('type');
                $CI->session->set_userdata('login_err','Social: подмена типа пользователя!');
            }
            elseif($user['activation'] == 0)
            {
                $CI->session->unset_userdata('login');
                $CI->session->unset_userdata('pass');
                $CI->session->unset_userdata('type');
                $CI->session->set_userdata('login_err','Social: User Not Acive!');
            }
        }
    }
}

function getUserData(){
    $login = userdata('login');
    $user = false;
    if($login) {
        $model = getModel('users');
        $user = $model->getUserByLogin($login);
    }
    return $user;
}

function getUserId($login = false){
    if(!$login) $login = userdata('login');
    $model = getModel('users');
    $user = $model->getUserByLogin($login);
    if(isset($user['id'])) return $user['id'];

    return false;
}

function getUserAuthorize(){
    ob_start();
    ?>
    <script src="//ulogin.ru/js/ulogin.js"></script>
    <div id="uLogin4e0fd86a" data-ulogin="display=panel;fields=first_name,email;optional=last_name,phone,city,country,photo,sex,bdate,photo_big,nickname;providers=google,facebook,instagram,twitter,vkontakte,odnoklassniki,linkedin,yandex,mailru;hidden=livejournal,openid,lastfm,liveid,soundcloud,steam,flickr,uid,youtube,webmoney,foursquare,tumblr,googleplus,vimeo,wargaming;redirect_uri=%2F%2F<?=$_SERVER['SERVER_NAME']?><?=$_SERVER['REQUEST_URI']?>;callback=callback_login"></div>
    <script>
        function callback_login(token) {
            //        Обработка авторизации
            $.ajax({
                url: 'http://ulogin.ru/token.php',
                type: 'GET',
                async: false,
                dataType:'jsonp',
                data: {'token': token, 'host': encodeURIComponent(location.toString())},
                success: function (jqXHR){

                    var jString = jqXHR.toString();
                    //alert("1: "+jString);
                    authorize(jString);
                },
//                complete: function(jqXHR,status){
//                    alert(jqXHR);
//                    if(status == 'success')
//                        authorize(jqXHR);
//                    else alert(status);
//                },
                error: function () {
                    alert("error!");
                }
            });
        }

        function authorize(data) {
            //alert("2: "+data);
            $.ajax({
                url: '/ajax/login/',
                type: 'POST',
                async: false,
                data: {'json': data},
                success: function(data){
                    console.log('authorized: '+data);
                    //alert(data);
                    if(data == 'auth_success'){
                        get_comment_form();
                    } else alert(data);
                }
            });


        }
    </script>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function addOrEditUser($s_user, $ajax = false){
    $CI = & get_instance();
    $user = false;
    $back = (userdata('last_url')) ? userdata('last_url') : '/user/mypage/';
    $CI->load->model('Model_users','users');
    //$back = '/user/mypage/';
    if ($s_user) {
        $CI->db->where('profile', $s_user['profile']);
        $CI->db->or_where('email', $s_user['email']);
        $CI->db->limit(1);
        $user = $CI->db->get('users')->result_array();

        if (!$user) {
            $dbins = array(
                'login' => $s_user['email'],
                'email' => $s_user['email'],
                'type' => 'user',
                'active' => 1,
                'city' => $s_user['city'],
                'country' => $s_user['country'],
                'name' => $s_user['first_name'] . ' ' . $s_user['last_name'],
                'avatar' => $s_user['photo'],
                'reg_date' => date("Y-m-d H:i"),
                'reg_ip' => $_SERVER['REMOTE_ADDR'],
                'pass' => md5(getActiveCode()),
                'activation' => 1,
                'network' => $s_user['network'],
                'photo' => $s_user['photo_big'],
                'profile' => $s_user['profile'],
                'uid' => $s_user['uid']
            );

            $CI->db->insert('users', $dbins);

            $user = $CI->users->getUserByLogin($s_user['email']);

            if ($user) {
                set_userdata('user_id', $user['id']);
                set_userdata('login', $user['login']);
                set_userdata('name', $user['name']);
                set_userdata('pass', $user['pass']);
                set_userdata('type', $user['type']);
                $CI->users->setLastDateAndIp($user['login']);
            }

        } else {
            $user = $user[0];
            set_userdata('user_id', $user['id']);
            set_userdata('login', $user['login']);
            set_userdata('name', $user['name']);
            set_userdata('pass', $user['pass']);
            set_userdata('type', $user['type']);
            $CI->users->setLastDateAndIp($user['login']);
            if($ajax)
                return $user;
            else redirect($back,'302');

        }
        set_userdata("msg",getLine('Вы успешно авторизировались в системе!'));
        if(!$ajax)
            redirect($back,'302');
    } elseif (isset($_POST['email']) && isset($_POST['pass'])) {
        //vdd($_POST);
        $user = $CI->users->getUserByEmail($_POST['email']);
        if (!$user) {
            set_userdata('login_err', 'login_incorrect');
        } else {
            if ($user['pass'] != md5($_POST['pass'])) {
                set_userdata('login_err', 'pass_incorrect');
            } else {

                if ($user['activation'] == 0) {
                    set_userdata('login_err', "Вы не активировали свой аккаунт!", $user['id']);
                    unset($user);
                } else {
                    echo 'else';
                    set_userdata('user_id', $user['id']);
                    set_userdata('login', $user['login']);
                    set_userdata('name', $user['name']);
                    set_userdata('pass', $user['pass']);
                    set_userdata('type', $user['type']);
                    $CI->users->setLastDateAndIp($user['login']);

                    set_userdata("msg",getLine('Вы успешно авторизировались в системе!'));
                    //vdd($back);
                    if ($ajax) {
                        var_dump($user);
                        //return $user;
                        exit();
                    } else {
                        redirect($back,'302');
                    }
                }
            }
        }
    }

    return $user;
}

function getAdminPanelForFrontend($type, $currentId){
    ob_start();
    if(isClientAdmin()) {
        loadHelper('admin');
        showAdminPanelOnFrontend($type, $currentId);
    }
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getUserByLoginAndPassword($login, $password){
    $model = getModel('users');
    return $model->getUserByLoginAndPassword($login, $password);
}