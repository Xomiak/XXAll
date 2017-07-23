<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        ajaxInitLanguages();
        $this->load->helper('login_helper');
        $this->load->model('Model_products', 'products');
        $this->load->model('Model_articles', 'articles');
        $this->load->model('Model_users', 'users');
    }

    function send_mail_form(){
        $message = '';
        vd($_POST);
        $to = getOption('admin_email');
        if(isset($_POST['to']))
            $to = post('to');
        $subject = 'Письмо с сайта '.$_SERVER['SERVER_NAME'];
        if(isset($_POST['subject']))
            $subject = post('subject');
        $params = post('params');
        if($_POST){
            foreach ($_POST as $key => $value){
                if($key != 'params' && $key != 'to' && $key != 'subject'){
                    $name = $key;
                    if(isset($params[$name]))
                        $name = $params[$name];
                    $message .= '<strong>'.$name.'</strong>: '.post($key).'<br/>';
                }
            }
            if($message){
                loadHelper('mail');
                echo $message;
                //$result = mail_send($to, $subject, $message);
                //if($result) echo 'ok';
                //else echo 'error';
            }
        }
    }

    public function login(){
        if(isset($_POST['json'])){              // ПРОБУЕМ АВТОРИЗИРОВАТЬСЯ, ЕСЛИ ПЕРЕДАНЫ ЗНАЧЕНИЯ
            $s_user = json_decode($_POST['json'], true);
            $user = addOrEditUser($s_user, true);
            if($user){
                echo 'auth_success';
            } else echo 'auth_error';
        }
        elseif(isset($_GET['logout'])){         // РАЗЛОГИНИВАЕМСЯ, ЕСЛИ ПЕРЕДАНА КОМАНДА
            unset_userdata('user_id');
            unset_userdata('login');
            unset_userdata('name');
            unset_userdata('pass');
            unset_userdata('type');

            echo 'auth_logout';
        }elseif(isset($_POST['local_login'])){
            $login = post('login');
            $pass = post('pass');
            loadHelper('login');
            $user = getUserByLoginAndPassword($login, $pass);
        } elseif(isset($_POST['new_user'])){

        }
        else echo 'unknown_error';
    }

    public function getAjaxBlock($name, $id = false){
        $data = false;
        if($id){
            $article = $this->articles->getArticleById($id);
            if($article)
                $data['article'] = $article;
        }
        $this->load->view('ajax/'.$name.'.tpl.php', $data);
    }

    public function comment($action){
        if($action == 'add'){
            if(!userdata('login')) echo 'Вы не авторизированы!';
            else{
                $user_id = getUserId();
                $text = post('text');
                $text = nl2br($text);
                $reply_to = post('reply_to');
                $dbins = array(
                    'user_id'   => $user_id,
                    'login'     => userdata('login'),
                    'comment'   => $text,
                    'article_id'    => post('article_id'),
                    'ip'        => getRealIp(),
                    'active'    => 0,
                    'date'      => date("Y-m-d"),
                    'time'      => date("H:i"),
                    'date_unix'      => time(),
                    'reply_to'      => $reply_to
                );

                $this->db->insert('comments', $dbins);
                echo 'Ваш комментарий успешно добавлен и вскоре появится на сайте!';
            }
        }
        elseif($action == 'reply_to'){
            $comment_id = post('comment_id');
            if($comment_id){
                $mComments = getModel('comments');
                $mUsers = getModel('users');
                $comment = $mComments->getCommentById($comment_id);
                $user = $mUsers->getUserById($comment['user_id']);
                if($comment && $user){
                    loadHelper('comments');
                    $name = $user['name'];
                    if($user['lastname'] != '')
                        $name = $name .' '.$user['lastname'];
                    ?>
                    <div class="title-section">
                        <h1><span>Ответить на комментарий:</span></h1>
                    </div>
                    <div class="comment-area-box">
                        <ul class="comment-tree">';
                            <?=getComment($comment, $user, false, true)?>
                        </ul>
                    </div>
                    <?php
                }
            }
        }
    }

    public function getBlock($name){
        if($name == 'comment_block' && post('article_id') != false){
            loadHelper('comments');
            echo getNewCommentForm(post('article_id'));
        }
    }

    public function send_mail()
    {
        //vdd($_POST);
        $answer = array();
//        if(isset($_GET['email'])) $_POST['email'] = $_GET['email'];
//        if(isset($_GET['name'])) $_POST['name'] = $_GET['name'];
//        if(isset($_GET['massage'])) $_POST['massage'] = $_GET['massage'];
        $to = post('to');
        if ($to == 'admin_email')
            $to = getOption('admin_email');
            $tel = post('tel');
            $name = post('name');
        $subject = "Заказ с сайта";
        $message = 'Имя: '.$name.'<br>Тел:'.$tel.'<br>Сообщение:<br>'.post('message');
        //vd($_POST);
        if ($subject != '' && $message != '') {

            $this->load->helper('mail_helper');
            $ret = mail_send($to, $subject, $message);
            if ($ret) {
                echo "sended";
            } else {
                echo 'server_error';
            }
        } else {
            echo 'form_error';
        }
    }

    public function adresses($category_id)
    {
        $this->generateXMLMarker($category_id);
    }

    function generateXMLMarker($categoey_id = false)
    {
        $this->load->model('Model_adresses', 'adresses');
        $file = $categoey_id;
        if (!$categoey_id) $file = 'all';
        $results = false;
        if (!$categoey_id) {
            $results = $this->adresses->getAdresses(1);
        } else {
            $results = $this->adresses->getAdressesByCategory($categoey_id, 1);
        }
        if ($results) {
            $html = '<?xml version="1.0"?>
            <markers>';
            foreach ($results as $result) {
                //$result['description'] = str_replace("\n","<br />",$result['description']);
                $html .= '
                <marker>
                <name>' . trim(strip_tags($result['name'])) . '</name>
                <address>' . trim(strip_tags($result['adress'])) . '</address>
                <lat>' . $result['lat'] . '</lat>
                <lng>' . $result['lng'] . '</lng>
                <description>' . $result['description'] . '</description>';
                if ($result['icon'] != '') {
                    $html .= '
                <icon>' . CreateThumb2(32, 32, $result['icon'], 'maps') . '</icon>
                <logo>' . CreateThumb2(64, 64, $result['icon'], 'maps') . '</logo>';
                }
                $html .= '
                </marker>
                ';
            }
            $html .= '
            </markers>';
            file_put_contents('./maps/' . $file . '.xml', $html);
            //echo $html;
        }
    }

    public function cities($type)
    {
        $this->load->model('Model_cities', 'cities');
        if ($type == 'city_areas') {
            $city_id = post('city_id');
            if (isset($_GET['city_id'])) $city_id = $_GET['city_id'];
            if (!$city_id) err404();
            $city_areas = $this->cities->getAreasByCityId($city_id, 1);
            if (!$city_areas) echo 'no';
            else {
                echo '<option></option>';
                foreach ($city_areas as $area) {
                    echo '<option value="' . $area['id'] . '">' . $area['name'] . '</option>';
                }
            }
        }
    }

    public function getSubcategories($category_id)
    {
        $html = "";
        $html .= '<option></option>';
        $subs = $this->model_categories->getSubCategories($category_id, 1);
        if ($subs) {
            foreach ($subs as $sub) {
                $html .= '<option value="' . $sub['id'] . '">' . $sub['name'] . '</option>';
            }
            echo $html;
        } else echo "no";
    }

    public function rate($type)
    {
        $user = $this->users->getUserByLogin(userdata('login'));
        $rating = post('rating');
        //if(!$user) err404();
        if ($type == 'articles') {
            $article_id = post('article_id');
            if ($this->articles->isRaited($article_id, userdata('login')) !== false) {
                echo "Вы уже голосовали!";
                die();
            }
            $article = $this->articles->getArticleById($article_id);
            if (!$article) {
                echo "Статья не найдена!";
                die();
            }

            $dbins = array(
                'rating' => ($article['rating'] + $rating),
                'rating_count' => ($article['rating_count'] + 1)
            );
            $this->db->where('id', $article_id)->limit(1)->update('articles', $dbins);

            $dbins = array(
                'article_id' => $article_id,
                'rating' => $rating,
                'login' => userdata('login'),
                'user_id' => $user['id'],
                'date' => date("Y-m-d"),
                'time' => date("H:i"),
                'unix' => time()
            );
            $this->db->insert('rating_logs', $dbins);

            echo 'Спасибо, Ваш голос учтён!';
        }
    }

//    public function comment($action)
//    {
//        if ($action == 'add' && isset($_POST['comment'])) {
//            $answ_comm_id = 0;
//            if (isset($_POST['answ_comm_id'])) $answ_comm_id = post('answ_comm_id');
//            $comment = post('comment');
//            $comments_new_active = getOption('comments_new_active');
//            $user = $this->users->getUserByLogin(userdata('login'));
//            if (!$user) exit_status("Ошибка авторизации: комментарий не добавлен, т.к. не пройдена авторизация!");
//            $dbins = array(
//                'article_id' => post('article_id'),
//                'comment' => trim($comment),
//                'login' => $user['login'],
//                'user_id' => $user['id'],
//                'ip' => GetRealIp(),
//                'active' => $comments_new_active,
//                'date' => date("Y-m-d"),
//                'time' => date("H:i"),
//                'date_unix' => time(),
//                'answ_comm_id' => $answ_comm_id
//            );
//            $ret = $this->db->insert('comments', $dbins);
//            if ($ret) {
//                if ($comments_new_active == 1)
//                    exit_status('Комментарий успешно добавлен!');
//                else
//                    exit_status('Комментарий успешно добавлен и после проверки модератором появится на сайте!');
//            } else exit_status('Ошибка добавления комментария в базу');
//        } elseif ($action == 'get_for_article') {
//            if (isset($_POST['article_id'])) {
//                $this->load->helper('comments_helper');
//                echo getArticleComments($_POST['article_id']);
//            } else exit_status('Не найден id статьи!');
//        } else exit_status('no data');
//        //err404();
//    }

    public function form()
    {

        $usluga = $message = $type = $name = $tel = $email = false;

        //if(isset($_GET)) $_POST = $_GET;

        $dbins = array();
        if (isset($_POST['type'])) {
            $type = $_POST['type'];
            $dbins['type'] = $type;
        }
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $dbins['name'] = $name;
        }
        if (isset($_POST['tel'])) {
            $tel = $_POST['tel'];
            $dbins['tel'] = $tel;
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $dbins['email'] = $email;
        }
        if (isset($_POST['message'])) {
            $message = $_POST['message'];
            $dbins['message'] = $message;
        }
        if (isset($_POST['usluga'])) {
            $usluga = $_POST['usluga'];
            $dbins['usluga'] = $usluga;
        }

        if ($dbins) {
            $dbins['date'] = date('Y-m-d H:i');
            $dbins['url'] = "http://" . $_SERVER['SERVER_NAME'] . $_POST['url'];

            $this->db->insert('forms', $dbins);
        }

        if ($type == 'callme') {
            $message = 'Заказ обратного звонка:<br />Имя: ' . $name . '<br />' . 'Тел: ' . $tel . '<br />' . "http://" . $_SERVER['SERVER_NAME'] . $_POST['url'];
            $to = getOption('admin_email');
            $this->load->helper('mail_helper');
            //$to = 'xomiak@rap.org.ua';
            mail_send($to, "Заказ обратного звонка", $message);
            echo "OK";
        } elseif ($type == 'order') {
            $message = 'Заказ услуги: <b>' . $usluga . '</b><br />Имя: ' . $name . '<br />E-mail: ' . $email . '<br />' . 'Тел: ' . $tel . '<br />' . "http://" . $_SERVER['SERVER_NAME'] . $_POST['url'] . '<br />Комментарий:<br />' . $message;
            $to = getOption('admin_email');
            $this->load->helper('mail_helper');
            //$to = 'xomiak@rap.org.ua';
            mail_send($to, 'Заказ услуги: ' . $usluga, $message);
            echo "OK";
        }
    }


    public function like()
    {
        $this->db->where('comment_id', $_POST['commId']);
        $this->db->where('login', $_POST['login']);
        $val = $this->db->get('opinions')->result_array();
        if (count($val) == 0) {
            $this->db->where('id', $_POST['commId']);
            $this->db->set('likes', 'likes+1', FALSE);
            if ($this->db->update('comments')) {
                $dbins = array(
                    'comment_id' => $_POST['commId'],
                    'login' => $_POST['login'],
                    'choice' => '+'
                );
                $this->db->insert('opinions', $dbins);
            }
        }
        $this->db->where('id', $_POST['commId']);
        $this->db->limit(1);
        $res = $this->db->get('comments')->result_array();
        echo $res[0]['likes'];
    }

    public function dislike()
    {
        $this->db->where('comment_id', $_POST['commId']);
        $this->db->where('login', $_POST['login']);
        $val = $this->db->get('opinions')->result_array();
        if (count($val) == 0) {
            $this->db->where('id', $_POST['commId']);
            $this->db->set('dislikes', 'dislikes+1', FALSE);
            if ($this->db->update('comments')) {
                $dbins = array(
                    'comment_id' => $_POST['commId'],
                    'login' => $_POST['login'],
                    'choice' => '-'
                );
                $this->db->insert('opinions', $dbins);
            }
        }
        $this->db->where('id', $_POST['commId']);
        $this->db->limit(1);
        $res = $this->db->get('comments')->result_array();
        echo $res[0]['dislikes'];
    }

    public function setka($id)
    {
        $data['id'] = $id;
        $this->load->view($GLOBALS['template'].'/ajax/setka.Ajax.php', $data);
    }


    function umnog($a, $b)
    {
        echo $a * $b;
    }

    function cart_save()
    {
        $this->load->model('Model_products', 'products');
        $index = validate($_POST['index'], 'number', '', true);
        $name = validate($_POST['name'], 'string');
        if (strstr($name, 'filter_') !== false) {
            $name = str_replace('[]', '', $name);
            $filterName = substr($name, strlen('filter_'), strlen($name));
            $name = "filters";
        }
        if (is_array($_POST['value'])) {
            foreach ($_POST['value'] as $val) {
                $value[] = validate($val, 'string');
            }
        } else {
            $value = validate($_POST['value'], 'string');
        }
        /*
                var_dump($index);
                var_dump($name);
                var_dump($filterName);
                var_dump($value);
                die();*/
        $result['done'] = true;
        $my_cart = array();
        if (userdata('my_cart')) {
            $my_cart = @unserialize(userdata('my_cart'));
            if (!$my_cart)
                $my_cart = userdata('my_cart');
        } else {
            $result['done'] = false;
            $result['msg'] = "Не найдена корзина, возможно истекло время сессии.";
        }
        if ($index === false || !isset($my_cart[$index])) {
            $result['done'] = false;
            $result['msg'] = "Не указан индекс продукта в корзине";
        }
        if ($name === false || !isset($my_cart[$index][$name])
            || ($name == 'filters' && !isset($my_cart[$index][$name][$filterName]))
        ) {

            $result['done'] = false;
            $result['msg'] = "Не найден параметр";
        }
        if ($name == 'kolvo')
            $value = validate($value, 'number');
        if ($value === false) {
            $result['done'] = false;
            $result['msg'] = "Не задано значение для параметра";
        }

        if ($result['done']) {
            if ($name == 'kolvo') {
                $result['total'] = 0;
                $my_cart_count = 0;
                for ($i = 0; $i < count($my_cart); $i++) {
                    $product = $this->products->getProductById($my_cart[$i]['product_id']);
                    if ($i == $index) {
                        $my_cart[$i]['kolvo'] = $value;
                        $result['prod_summ'] = get_price($product['price']) * $value;
                    }
                    $my_cart_count += $my_cart[$i]['kolvo'];
                    $res = get_price($product['price']) * $my_cart[$i]['kolvo'];
                    $result['total'] += $res;
                }
                set_userdata('my_cart_count', $my_cart_count);
                $result['my_cart_count'] = $my_cart_count;
            } else {
                if (!isset($filterName))
                    $my_cart[$index][$name] = $value;
                else {
                    if (is_array($value)) {
                        foreach ($value as $val) {
                            unset($my_cart[$index][$name][$filterName]['values']);
                            $my_cart[$index][$name][$filterName]['values'][]['id'] = $val;
                        }
                    } else {
                        unset($my_cart[$index][$name][$filterName]['values']);
                        $my_cart[$index][$name][$filterName]['values'][]['id'] = $value;
                    }

                }


            }
            $my_cart = serialize($my_cart);
            set_userdata('my_cart', $my_cart);

        }
        echo json_encode($result);
    }

    function to_cart()
    {
        set_currency();
        $langs = getOptionArray('languages');
        $current_lang = (userdata('language')) ? userdata('language') : trim($langs[0]);
        $main_currency = $this->model_options->getOption('main_currency');
        $currency = $this->session->userdata('currency');

        if (!$currency)
            $currency = $main_currency;

        if (isset($_POST['product_id'])) {

            if (!isset($_POST['kolvo']))
                $_POST['kolvo'] = 1;
            $my_cart = array();
            if ($this->session->userdata('my_cart') !== false)
                $my_cart = $this->session->userdata('my_cart');

            $products = $this->products->getArticleById($_POST['product_id']);
            $razmer = unserialize($products['razmer']);

            $is_new = true;
            $count = count($my_cart);
            for ($i = 0; $i < $count; $i++) {
                if ($my_cart[$i]['product_id'] == $_POST['product_id']) {
                    $rcount = count($razmer);
                    $kolvo = $my_cart[$i]['kolvo'];
                    for ($i2 = 0; $i2 < $rcount; $i2++) {
                        /*
                        if(isset($_POST['chk_kolvo']))
                        {
                            $my_cart[$i]['kolvo'] = $_POST['kolvo'];
                            $kolvo = $kolvo + $_POST['kolvo'];
                        }
                        */
                    }
                    $my_cart[$i]['kolvo'] = $kolvo + $_POST['kolvo'];
                    $is_new = false;
                }
            }

            if ($is_new) {
                $new = array(
                    'product_id' => $_POST['product_id']
                );
                $rcount = count($razmer);
                $kolvo = $_POST['kolvo'];
                for ($i2 = 0; $i2 < $rcount; $i2++) {
                    /*
                    if(isset($_POST['chk_kolvo']))
                    {
                        $new['kolvo'] = $_POST['kolvo'];
                        $kolvo = $kolvo + $_POST['kolvo'];
                    }
                    */
                }
                $new['kolvo'] = $kolvo;

                array_push($my_cart, $new);
            }

            $this->session->set_userdata('my_cart', $my_cart);

            $my_cart = $this->session->userdata('my_cart');
            $cart_count = count($my_cart);
            ?>
            <div class="empty_cart"<?php if ($cart_count > 0)
                echo ' style="display:none;"'; ?>>Корзина пуста
            </div>
            <div class="cart_wrap">
                <?php
                if ($cart_count > 0) {
                    for ($i = 0; $i < $cart_count; $i++) {
                        $mc = $my_cart[$i];
                        $product = $this->products->getProductById($mc['product_id']);
                        if ($product) {
                            $product['name'] = unserialize($product['name']);
                            ?>
                            <div class="cart_item">
                                <div class="cart_photo">
                                    <img
                                            src="<?= CreateThumb(95, 100, $product['image'], 'products_product_mini_cart') ?>"/>
                                </div>
                                <div class="cart_desc">
                                    <div class="cart_price"><?= get_price($product['price']) ?>
                                        &nbsp;<?= $currency ?></div>
                                    <div class="cart_title"><?= $product['name'][$current_lang] ?></div>
                                    <div class="cart_size">Размер: 46</div>
                                    <div class="cart_kol">Кол-во: <?= $mc['kolvo'] ?> шт.</div>
                                    <a class="delete_item" href="#">х</a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>

                <div class="create_zakaz">
                    <a style="text-decoration: none" href="/my_cart/"><input type="submit" value="Оформить заказ"/></a>
                </div>
            </div>
            <?php
        }
    }

    function cart_actions()
    {
        $my_cart = $this->session->userdata('my_cart');
        $cart_count = 0;
        if ($my_cart)
            $cart_count = count($my_cart);

        if (isset($_POST['cart_count'])) {
            $my_cart = array();
            if ($this->session->userdata('my_cart') !== false)
                $my_cart = $this->session->userdata('my_cart');
            if (!$my_cart)
                echo 0;
            else echo count($my_cart);
        }
        if (isset($_POST['del_from_cart'])) {
            $newarr = array();
            for ($i = 0; $i < $cart_count; $i++) {
                if ($my_cart[$i]['product_id'] != $_POST['del_from_cart']) {
                    array_push($newarr, $my_cart[$i]);
                }
            }
            $my_cart = $newarr;

            $this->session->set_userdata('my_cart', $my_cart);

            echo count($my_cart);
        }
    }

    public function getNextRows($type)
    {
        loadHelper(TEMPLATE);
        if (!isset($_POST['category_id'])) $_POST['category_id'] = 1;
        if (!isset($_POST['startFrom'])) $_POST['startFrom'] = 0;
        if (isset($_GET['per_page'])) $_POST['per_page'] = $_GET['per_page'];
        if (isset($_GET['search'])) $_POST['search'] = $_GET['search'];
        if (isset($_GET['category_id'])) $_POST['category_id'] = $_GET['category_id'];
        if (isset($_GET['startFrom'])) $_POST['startFrom'] = $_GET['startFrom'];
        if (isset($_GET['tag'])) $_POST['tag'] = $_GET['tag'];
        if (isset($_GET['type'])) $_POST['type'] = $_GET['type'];
       // if (isset($_GET['future'])) $_POST['future'] = $_GET['future'];
        $category_id = post('category_id');

        $colMd = true;
        if (isset($_GET['noColMd'])) $_POST['noColMd'] = $_GET['noColMd'];
        if (isset($_POST['noColMd'])) $colMd = false;
        //vd($colMd);
        // alert($colMd);

        $orderBy = 'DESC';
        $sortBy = 'num';

        if ($category_id) {
            $cat = $this->model_categories->getCategoryById($category_id);
            $orderBy = $cat['order_by'];
            $sortBy = $cat['sort_by'];
        }

        if (isset($_POST['per_page'])) $per_page = $_POST['per_page'];
        else $per_page = getOption('articles_pagination');

        if ($type == 'search') {
            $rows = $this->articles->Search(post('search'), true, $per_page, post('startFrom'), false, 'category_id', 'ASC');
            if ($rows) {
                $articles = getSearchResultLine($rows);

                $json = json_encode($articles);
                echo $json;
            }
        } elseif ($type == 'articles') {
            if (post('show_by_first_category') == true)
                $rows = $this->articles->getArticlesByFirstCategory(post('category_id'), $per_page, post('startFrom'), 1, $orderBy, $sortBy);
            else
                $rows = $this->articles->getArticlesByCategory(post('category_id'), $per_page, post('startFrom'), 1, $orderBy, $sortBy);

            if ($rows) {
                foreach ($rows as $row) {
                    if(function_exists('getArticleBlock'))
                        echo getArticleBlock($row);
                    else echo modules_getNewBlock($row);
                }
            } else echo 'end';
        } elseif ($type == 'products') {
            $future = post('future');
            $rows = $this->products->getProductsByCategory(post('category_id'), $per_page, post('startFrom'), 1, $orderBy, $sortBy, $future);

            if ($rows) {
                foreach ($rows as $row) {
                    echo modules_getNewBlock($row);
                }
            } else echo 'end';
        } elseif ($type == 'tags') {
            $rows = $this->articles->getArticlesByTag(post('tag'), $per_page, post('startFrom'), 1);

            if ($rows) {
                foreach ($rows as $row) {
                    if(function_exists('getArticleBlock'))
                        echo getArticleBlock($row);
                    else
                        echo modules_getArticleBlock($row, $colMd);
                }
            }
        }

    }
}