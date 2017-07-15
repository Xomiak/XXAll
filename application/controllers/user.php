<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{

    private $current_lang;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_users', 'users');
        $this->load->model('Model_cities', 'cities');
        $this->load->model('Model_shop', 'products');
        $this->load->model('Model_articles', 'articles');
        //$langs = getOptionArray('languages');
        $this->current_lang = getCurrentLanguageCode();
        $this->session->set_userdata('last_url', $_SERVER['REQUEST_URI']);
        isLogin();
    }

    function upload_avatar()
    {
        $config['upload_path'] = 'upload/avatars';
        $config['allowed_types'] = 'jpg|png|gif|jpe';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;
        $config['overwrite'] = false;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('avatar')) {
            echo $this->upload->display_errors();
            die();
        } else {
            $ret = $this->upload->data();

            $config['image_library'] = 'GD2';
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 100;
            $config['height'] = 100;
            $config['source_image'] = $ret["file_path"] . $ret['file_name'];
            $config['new_image'] = $ret["file_path"] . $ret['file_name'];
            $config['thumb_marker'] = '';
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            //$arr = explode('.', $ret['file_name'])

            return $ret;
        }
    }

    function upload_logo($name = 'userfile')
    {
        $config['upload_path'] = 'upload/articles/' . date("Y-m-d");
        if (!file_exists($config['upload_path'])) mkdir($config['upload_path'], 0777);
        $config['allowed_types'] = 'jpg|png|gif';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;
        $config['overwrite'] = false;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($name)) {
            echo $this->upload->display_errors();
            die();
        } else {
            $ret = $this->upload->data();

            $config['image_library'] = 'GD2';
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 600;
            $config['height'] = 600;
            $config['source_image'] = $ret["file_path"] . $ret['file_name'];
            $config['new_image'] = $ret["file_path"] . $ret['file_name'];
            $config['thumb_marker'] = '';
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            //$arr = explode('.', $ret['file_name'])

            return $ret;
        }
    }

    function upload_foto()
    { // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/users/fotos';
        $config['allowed_types'] = 'jpg|png|gif|jpe';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;
        $config['overwrite'] = false;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            echo $this->upload->display_errors();
            die();
        } else {
            $width = $this->model_options->getOption('upload_image_max_width');
            $height = $this->model_options->getOption('upload_image_max_height');

            $ret = $this->upload->data();

            $config['source_image'] = $ret["file_path"] . $ret['file_name'];
            $config['create_thumb'] = FALSE;
            $config['wm_type'] = 'overlay';
            $config['wm_overlay_path'] = 'img/watermark.png';
            $config['wm_hor_alignment'] = 'right';
            $this->image_lib->initialize($config);
            $this->image_lib->watermark();

            if (($ret['image_width'] != '') && $ret['image_width'] < $width)
                $width = $ret['image_width'];
            if (($ret['image_height'] != '') && $ret['image_height'] < $height)
                $height = $ret['image_height'];

            $config['image_library'] = 'GD2';
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = $width;
            $config['height'] = $height;
            $config['source_image'] = $ret["file_path"] . $ret['file_name'];
            $config['new_image'] = $ret["file_path"] . $ret['file_name'];
            $config['thumb_marker'] = '';
            $this->image_lib->initialize($config);
            $this->image_lib->resize();

            $ret = $this->upload->data();

            return $ret;
        }
    }

    private function getMyCart($mod = 'combined')
    {
        return false;
        $user = $this->users->getUserByLogin($this->session->userdata('login'));
        $my_cart = array();
        if ($mod == 'discreted') {
            $my_cart = $this->shop->getOrdersByUserId($user['id'], 1, 10, 0);
        } elseif ($mod == 'combined') {
            $my_orders = $this->shop->getOrdersByUserId($user['id'], 1, 5, 0);
            if ($my_orders) {
                for ($i = 0; $i < count($my_orders); $i++) {
                    $prod = unserialize($my_orders[$i]['products']);

                    for ($j = 0; $j < count($prod); $j++) {
                        $my_cart[] = $prod[$j];
                        $my_cart[count($my_cart) - 1]['status'] = $my_orders[$i]['status'];
                        $my_cart[count($my_cart) - 1]['order_id'] = $my_orders[$i]['id'];
                    }

                }
            }

            if ($this->session->userdata('my_cart') !== false)
                $my_cart_now = $this->session->userdata('my_cart');

            if (isset($my_cart_now) && $my_cart_now && !empty($my_cart_now)) {
                $my_cart = array_merge($my_cart, $my_cart_now);
            }
            $my_cart = array_reverse($my_cart);
        }
        return $my_cart;
    }

    public function adresses($id)
    {
        $this->load->model('Model_adresses', 'adresses');
        $article = $this->articles->getArticleById($id);
        if ($article) {
            $adresses = $this->adresses->getByArticleId($id);
            $data['adresses'] = $adresses;
            $data['article'] = $article;
            $data['title'] = "Адреса организации " . $article['name'] . $this->model_options->getOption('global_title');
            $data['keywords'] = "" . $this->model_options->getOption('global_keywords');
            $data['description'] = "Адреса организации " . $article['name'] . $this->model_options->getOption('global_description');
            $data['robots'] = "noindex, nofollow";
            $data['h1'] = "Адреса организации " . $article['name'];
            $data['seo'] = "";
            $this->load->view('users/adresses.tpl.php', $data);
        } else err404();
    }

    public function delAdress($id){
        $msg = '';
        $this->load->model('Model_adresses', 'adresses');
        $adress = $this->adresses->getById($id);
        $article = $this->articles->getArticleById($adress['article_id']);
        if ($article && $adress && $article['created_by'] == userdata('login')) {
            $this->db->where('id', $id)->limit(1)->delete('adresses');

            redirect('/user/adresses/'.$article['id'].'/');
            //$msg = "Адрес"
            $data['title'] = "Адрес организации " . $article['name'] . ' успешно удалён' . $this->model_options->getOption('global_title');
            $data['keywords'] = "" . $this->model_options->getOption('global_keywords');
            $data['description'] = "Адрес организации " . $article['name'] . ' успешно удалён' . $this->model_options->getOption('global_description');
            $data['robots'] = "noindex, nofollow";
            $data['h1'] = "Адрес организации " . $article['name'] . ' успешно удалён';

            $data['seo'] = "";
            $data['content'] = $msg;
            $this->load->view('msg.tpl.php', $data);
        } else err404();
    }

    public function editAdress($id)
    {
        $msg = '';
        $this->load->model('Model_adresses', 'adresses');
        $adress = $this->adresses->getById($id);
        $article = $this->articles->getArticleById($adress['article_id']);

        if ($article && $adress && $article['created_by'] == userdata('login')) {
            $adrstr = $adress['lat'] . ', ' . $adress['lng'];
            if (isset($_POST['editAdress']))
                $adrstr = post('coordsLat') . ', ' . post('coordsLng');
            // Google Maps //
            $this->load->library('googlemaps');
            $onclick = '
        $("#coordsLat").val(event.latLng.lat());
        $("#coordsLng").val(event.latLng.lng());
        ';
            $config = array(
                'apiKey' => 'AIzaSyDL-ughU0ynX4JHYIU7m32K3zVF_-0fKgQ',
                'region' => 'ua',
                'https' => true,
                'center' => $adrstr,
                'map_div_id' => 'googleMap',
                'scrollwheel' => false,
                'geocodeCaching' => TRUE,
                'onclick' => $onclick,
                'zoom' => 13,
                'region'		=> 'ua'

            );
            $this->googlemaps->initialize($config);

            $coords = $this->googlemaps->get_lat_long_from_address($adrstr);
            $data['coords'] = $coords;
            $marker = array();
            $marker['position'] = $coords[0] . ', ' . $coords[1];
            $marker['draggable'] = true;
            $marker['ondragend'] = $onclick;
            $this->googlemaps->add_marker($marker);
            $data['map'] = $this->googlemaps->create_map();

            if (isset($_POST['editAdress'])) {
                $city = "";
                $adrarr = explode(',', post('adress'));
                if (is_array($adrarr) && isset($adrarr[0]) && count($adrarr) > 2)
                    $city = $adrarr[0];

                $active = 0;
                $icon = "";
                if ($article['type'] != '' && $article['type'] != 'free') {
                    $active = 1;
                    $icon = $article['image'];
                }

                $double = $this->adresses->getByLatLng(post('lat'), post('lng'), post('article_id'));

                $dbins = array(
                    'adress' => post('adress'),
                    'description' => post('description'),
                    'article_id' => post('article_id'),
                    'lat' => post('coordsLat'),
                    'lng' => post('coordsLng'),
                    'city' => $city,
                    'active' => $active,
                    'icon' => $icon
                );

                $this->db->where('id', $id)->limit(1)->update('adresses', $dbins);

                $msg = "Адрес успешно изменён";
                if ($active == 0) $msg .= "!<br />После проверки администратором, адрес появится на станице Вашей организации.";
                else $msg .= " и уже показывается на карте, на странице Вашей организации:<br /><a href='" . getFullUrl($article) . "'>Перейти на страницу организации</a><br /><a href='/user/add-adress/" . $article['id'] . "/'>Добавить ещё один адрес</a><br /><a href='/user/mypage/'>Вернуться в личный кабинет</a>";

                $data['title'] = "Адрес организации " . $article['name'] . ' успешно изменён' . $this->model_options->getOption('global_title');
                $data['keywords'] = "" . $this->model_options->getOption('global_keywords');
                $data['description'] = "Адрес организации " . $article['name'] . ' успешно изменён' . $this->model_options->getOption('global_description');
                $data['robots'] = "noindex, nofollow";
                $data['h1'] = "Адрес организации " . $article['name'] . ' успешно изменён';

                $data['seo'] = "";
                $data['content'] = $msg;
                $this->load->view('msg.tpl.php', $data);
            }
            //$adresses = $this->adresses->getByArticleId($id);
            //$data['adresses'] = $adresses;
            $data['article'] = $article;
            $data['adress'] = $adress;
            $data['title'] = "Изменение адреса организации " . $article['name'] . $this->model_options->getOption('global_title');
            $data['keywords'] = "" . $this->model_options->getOption('global_keywords');
            $data['description'] = "Изменение адреса организации " . $article['name'] . $this->model_options->getOption('global_description');
            $data['robots'] = "noindex, nofollow";
            $data['h1'] = "Изменение адреса организации " . $article['name'];
            $data['seo'] = "";
            $this->load->view('users/add-adress.tpl.php', $data);
        } else err404();
    }

    public
    function addAdress($id)
    {
        $msg = '';
        $this->load->model('Model_adresses', 'adresses');
        $article = $this->articles->getArticleById($id);
        if ($article) {
            if (isset($_POST['adressSearch'])) {
                // Google Maps //
                $this->load->library('googlemaps');
                $onclick = '
        $("#coordsLat").val(event.latLng.lat());
        $("#coordsLng").val(event.latLng.lng());
        ';
                $config = array(
                    'apiKey' => 'AIzaSyDL-ughU0ynX4JHYIU7m32K3zVF_-0fKgQ',
                    'region' => 'ua',
                    'https' => true,
                    'center' => post('adress'),
                    'map_div_id' => 'googleMap',
                    'scrollwheel' => false,
                    'geocodeCaching' => TRUE,
                    'onclick' => $onclick,
                    'zoom' => 13,
                    'region'		=> 'ua'

                );
                $this->googlemaps->initialize($config);

                $coords = $this->googlemaps->get_lat_long_from_address(post('adress'));

                $data['coords'] = $coords;
                $marker = array();
                $marker['position'] = $coords[0] . ', ' . $coords[1];
                $marker['draggable'] = true;
                $marker['ondragend'] = $onclick;
                $this->googlemaps->add_marker($marker);
                $data['map'] = $this->googlemaps->create_map();
            } elseif (isset($_POST['addAdress'])) {
                $city = "";
                $adrarr = explode(',', post('adress'));
                //vdd($adrarr);
                if (is_array($adrarr) && isset($adrarr[0]) && count($adrarr) > 2)
                    $city = $adrarr[0];

                $active = 0;
                $icon = "";
                if ($article['type'] != '' && $article['type'] != 'free') {
                    $active = 1;
                    $icon = $article['image'];
                }

                $double = $this->adresses->getByLatLng(post('lat'), post('lng'), post('article_id'));
                //vd($_POST);
                if (!$double) {
                    $dbins = array(
                        'adress' => post('adress'),
                        'description' => post('description'),
                        'article_id' => post('article_id'),
                        'lat' => post('coordsLat'),
                        'lng' => post('coordsLng'),
                        'city' => $city,
                        'active' => $active,
                        'icon' => $icon
                    );

                    $this->db->insert('adresses', $dbins);

                    $msg = "Новый адрес успешно добавлен в базу";
                    if ($active == 0) $msg .= "!<br />После проверки администратором, новый адрес появится на станице Вашей организации.";
                    else $msg .= " и уже показывается на карте, на странице Вашей организации:<br /><a href='" . getFullUrl($article) . "'>Перейти на страницу организации</a><br /><a href='/user/add-adress/" . $article['id'] . "/'>Добавить ещё один адрес</a><br /><a href='/user/mypage/'>Вернуться в личный кабинет</a>";

                    $data['title'] = "Адрес организации " . $article['name'] . ' успешно добавлен' . $this->model_options->getOption('global_title');
                    $data['keywords'] = "" . $this->model_options->getOption('global_keywords');
                    $data['description'] = "Адрес организации " . $article['name'] . ' успешно добавлен' . $this->model_options->getOption('global_description');
                    $data['robots'] = "noindex, nofollow";
                    $data['h1'] = "Адрес организации " . $article['name'] . ' успешно добавлен';
                } else {
                    $msg = "Адрес не добавлен, т.к. Вы его уже добавляли ранее!";
                    $data['title'] = "Адрес организации " . $article['name'] . ' не добавлен' . $this->model_options->getOption('global_title');
                    $data['keywords'] = "" . $this->model_options->getOption('global_keywords');
                    $data['description'] = "Адрес организации " . $article['name'] . ' не добавлен' . $this->model_options->getOption('global_description');
                    $data['robots'] = "noindex, nofollow";
                    $data['h1'] = "Адрес организации " . $article['name'] . ' не добавлен';
                }
                $data['seo'] = "";
                $data['content'] = $msg;
                $this->load->view('msg.tpl.php', $data);
            }
            //$adresses = $this->adresses->getByArticleId($id);
            //$data['adresses'] = $adresses;
            $data['article'] = $article;
            $data['title'] = "Добавление адреса организации " . $article['name'] . $this->model_options->getOption('global_title');
            $data['keywords'] = "" . $this->model_options->getOption('global_keywords');
            $data['description'] = "Добавление адреса организации " . $article['name'] . $this->model_options->getOption('global_description');
            $data['robots'] = "noindex, nofollow";
            $data['h1'] = "Добавление адреса организации " . $article['name'];
            $data['seo'] = "";
            $this->load->view('users/add-adress.tpl.php', $data);
        } else err404();
    }

    public
    function index()
    {
        $model = getModel('products');
        $orders = false;
        $user = false;
        if (userdata('login') != false)
            $user = getUserData();
        if($user)
            $orders = getOrdersByUserId($user['id']);


        $data['orders'] = $orders;
        $data['title'] = "" . $this->model_options->getOption('global_title');
        $data['keywords'] = "" . $this->model_options->getOption('global_keywords');
        $data['description'] = "" . $this->model_options->getOption('global_description');
        $data['robots'] = "noindex, nofollow";
        $data['h1'] = "";
        $data['seo'] = "";
        $this->load->view('users/mypage.tpl.php', $data);
    }

    public
    function mypage()
    {
        if (userdata('login')) {
            $user = $this->users->getUserByLogin(userdata('login'));
            if ($user) {

                $model = getModel('products');
                $orders = $model->getOrdersByUserId($user['id']);
                $pricePayed = 0;
                $priceAll = 0;
                if($orders){
                    foreach ($orders as $order){
                        $priceAll += $order['price'];
                        if($order['status'] == 'payed')
                            $pricePayed += $order['price'];
                    }
                }
//var_dump($orders);die();
                $data['pricePayed'] = $pricePayed;
                $data['priceAll'] = $priceAll;
                $data['user'] = $user;
                $data['orders'] = $orders;
                $data['title'] = "Личный кабинет";
                $data['keywords'] = "Личный кабинет";
                $data['description'] = "Личный кабинет";
                $data['robots'] = "noindex, nofollow";
                $data['h1'] = "Личный кабинет";
                $data['seo'] = "";
  //              $data['my_cart_and_orders'] = $this->getMyCart('discreted');

    //            $data['articles'] = $this->articles->getArticlesByLogin(userdata('login'));

                $this->load->view('users/mypage.tpl.php', $data);
            } else
                err404();
        } else{

            $data['title'] = "Личный кабинет" . getOption('global_title_' . $this->current_lang);
            $data['keywords'] = "Личный кабинет" . getOption('global_title_' . $this->current_lang);
            $data['description'] = "Личный кабинет" . getOption('global_title_' . $this->current_lang);
            $data['robots'] = "noindex, nofollow";
            $data['h1'] = "Личный кабинет";

            $this->load->view('users/login.tpl.php', $data);
        }
    }

    public
    function showUserPage($id)
    {
        $data['user'] = $this->users->getUserById($id);
        if ($data['user']) {
            $this->load->model('Model_articles', 'articles');
            $this->load->model('Model_categories', 'categories');
            $this->load->model('Model_blogs', 'blogs');

            $login = $data['user']['login'];

            $articles = $this->articles->getUserArticles($login, 1);
            // ПАГИНАЦИЯ //
            $this->load->library('pagination');
            $per_page = 5;

            $config['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/users/' . $data['user']['id'] . '/';
            $config['prefix'] = '!';
            //$config['use_page_numbers']	= TRUE;
            $config['total_rows'] = count($articles);
            $config['num_links'] = 10;
            $config['first_link'] = 'в начало';
            $config['last_link'] = 'в конец';
            $config['next_link'] = 'Следующая →';
            $config['prev_link'] = '← Предыдущая';

            $config['num_tag_open'] = '<span class="pagerNum">';
            $config['num_tag_close'] = '</span>';
            $config['cur_tag_open'] = '<span class="pagerCurNum">';
            $config['cur_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="pagerPrev">';
            $config['prev_tag_close'] = '</span>&nbsp;&nbsp;';
            $config['next_tag_open'] = '&nbsp;&nbsp;<span class="pagerNext">';
            $config['next_tag_close'] = '</span>';
            $config['last_tag_open'] = '&nbsp;&nbsp;<span class="pagerLast">';
            $config['last_tag_close'] = '</span>';
            $config['first_tag_open'] = '<span class="pagerFirst">';
            $config['first_tag_close'] = '</span>&nbsp;&nbsp;';

            $config['per_page'] = $per_page;
            $config['uri_segment'] = 3;
            $from = intval(str_replace('!', '', $this->uri->segment(3)));
            //echo $from;die();
            $page_number = $from / $per_page + 1;
            $this->pagination->initialize($config);
            $data['pager'] = $this->pagination->create_links();
            //////////

            $page_no = '';
            if ($page_number > 1) {
                $page_no = ' (стр. №' . $page_number . ')';
            }

            $data['blog'] = $this->blogs->getBlogByLogin($data['user']['login'], 1);
            $data['articles'] = $this->articles->getUserArticles($login, 1, $per_page, $from);
            $data['articlesCount'] = $this->articles->getUserArticlesCount($data['user']['login']);
            $data['title'] = $this->lang->line('mypage_h1') . $data['user']['name'] . $page_no . $this->model_options->getOption('global_title');
            $data['keywords'] = $this->lang->line('mypage_h1') . $data['user']['name'] . $page_no . $this->model_options->getOption('global_keywords');
            $data['description'] = $this->lang->line('mypage_h1') . $data['user']['name'] . $page_no . $this->model_options->getOption('global_description');
            $data['robots'] = "index, follow";
            $data['h1'] = $this->lang->line('mypage_h1') . $data['user']['name'];
            $data['seo'] = "";
            $this->load->view('users/mypage.tpl.php', $data);
        } else
            err404();
    }

    public
    function edit_mypage()
    {
        if (userdata('login') != false) {
            $data['user'] = $this->users->getUserByLogin(userdata('login'));
            if ($data['user']) {
                if (isset($_POST['save']) && $_POST['save'] == 'ok') {
                    $avatar = '';
                    if (isset($_POST['oldavatar']))
                        $avatar = $_POST['oldavatar'];

                    if (isset($_FILES['avatar'])) { // проверка, выбран ли файл картинки
                        if ($_FILES['avatar']['name'] != '') {
                            $imagearr = $this->upload_avatar();
                            if ($avatar != '') {
                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $avatar))
                                    @unlink($_SERVER['DOCUMENT_ROOT'] . $avatar);
                            }
                            $avatar = '/upload/avatars/' . $imagearr['file_name'];
                        }
                    }

                    $foto = '';
                    if (isset($_POST['oldfoto']))
                        $foto = $_POST['oldfoto'];

                    if (isset($_POST['delfoto']) && $_POST['delfoto'] == true) {
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $foto);
                        $foto = "";
                    }

                    if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
                        if ($_FILES['userfile']['name'] != '') {
                            $imagearr = $this->upload_foto();
                            if ($foto != '') {
                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $foto))
                                    @unlink($_SERVER['DOCUMENT_ROOT'] . $foto);
                            }
                            $foto = '/upload/users/fotos/' . $imagearr['file_name'];
                        }
                    }
                    $site = (isset($_POST['site']) && !empty($_POST['site'])) ? $_POST['site'] : '';
                    if ($site != '' && strpos($site, 'http://') === false)
                        $site = "http://" . $site;
                    $dbins = array(
                        'name' => $_POST['first_name'],
                        'sex' => (isset($_POST['sex']) && !empty($_POST['sex'])) ? $_POST['sex'] : '',
                        'city' => (isset($_POST['city']) && !empty($_POST['city'])) ? $_POST['city'] : '',
                        'adress' => (isset($_POST['adress']) && !empty($_POST['adress'])) ? $_POST['adress'] : '',
                        'age' => (isset($_POST['age']) && !empty($_POST['age'])) ? $_POST['age'] : '',
                        'site' => $site,
                        'about' => (isset($_POST['about']) && !empty($_POST['about'])) ? $_POST['about'] : '',
                        'login' => $_POST['email'],
                        'email' => $_POST['email'],
                        'tel' => (isset($_POST['tel']) && !empty($_POST['tel'])) ? $_POST['tel'] : '',
                        'foto' => $foto,
                        'avatar' => $avatar,
                        'forgot' => ''
                    );
                    if (isset($_POST['change_pass']) && isset($_POST['pass']) && !empty($_POST['pass']))
                        $dbins['pass'] = md5($_POST['pass']);
                    $this->db->where('id', $data['user']['id']);
                    $this->db->limit(1);
                    //vdd($this->db->update('users', $dbins));
                    if ($this->db->update('users', $dbins)) {
                        set_userdata('login', $dbins['email']);
                        set_userdata('pass', $dbins['pass']);
                    }
                    redirect("/user/mypage/");
                } else {
                    $data['title'] = $this->lang->line('mypage_edit_h1') . $data['user']['login'] . $this->model_options->getOption('global_title');
                    $data['keywords'] = $this->lang->line('mypage_edit_h1') . $data['user']['login'] . $this->model_options->getOption('global_keywords');
                    $data['description'] = $this->lang->line('mypage_edit_h1') . $data['user']['login'] . $this->model_options->getOption('global_description');
                    $data['robots'] = "noindex, nofollow";
                    $data['h1'] = $this->lang->line('mypage_edit_h1') . $data['user']['login'];
                    $data['seo'] = "";
                    $data['my_cart_and_orders'] = $this->getMyCart();
                    $data['sort'] = (isset($_POST['sort'])) ? $_POST['sort'] : '';
                    $this->load->view('users/mypage_edit.tpl.php', $data);
                }
            }
        }
        err404();
    }

    public
    function rating($id)
    {
        if ($this->session->userdata('login') !== false) {


            $user = $this->users->getUserById($id);
            $ip = $_SERVER['REMOTE_ADDR'];
            $time = time();
            $user_login = $this->session->userdata('login');
            $rating = $this->users->getRating($user['login'], $ip, $user_login);

            $rating_period = $this->options->getOption('rating_period');
            $all_ok = false;
            if ($rating_period != 0) {
                if (!$rating)
                    $all_ok = true;
                elseif (isset($rating['time'])) {
                    if (($time - $rating['time']) > $rating_period)
                        $all_ok = true;
                }
            } else
                $all_ok = true;

            if ($all_ok) {
                $rat = $user['rating'];
                $rat++;
                $dbins = array(
                    'rating' => $rat
                );
                $this->db->where('id', $user['id']);
                $this->db->update('users', $dbins);

                $dbins = array(
                    'login' => $user['login'],
                    'user_login' => $user_login,
                    'ip' => $ip,
                    'time' => $time
                );
                $this->db->insert('rating', $dbins);

                //var_dump($this->session->userdata('last_url'));die();
                //if($this->session->userdata('last_url') !== false)
                //redirect($this->session->userdata('last_url'));
                //else
                redirect("/user/" . $user['id'] . "/");
            } else {
                $data['title'] = "Вы уже проголосовали за данного участника!";
                $data['keywords'] = "Вы уже проголосовали за данного участника!";
                $data['description'] = "Вы уже проголосовали за данного участника!";
                $data['robots'] = "noindex, nofollow";
                $data['h1'] = "Вы уже проголосовали за данного участника!";
                $data['content'] = 'Вы уже проголосовали за данного участника!<br />
								<a href="/user/' . $user['id'] . '/">Назад</a>';
                $data['breadcrumbs'] = "Голосование";
                $data['seo'] = "";
                $this->load->view('msg.tpl.php', $data);
            }
        } else {
            $data['title'] = "Для голосования Вам необходимо зарегистрироваться!";
            $data['keywords'] = "Для голосования Вам необходимо зарегистрироваться!";
            $data['description'] = "Для голосования Вам необходимо зарегистрироваться!";
            $data['robots'] = "noindex, nofollow";
            $data['h1'] = "Для голосования Вам необходимо зарегистрироваться!";
            $data['content'] = 'Для голосования Вам необходимо <a rel="nofollow" href="/register/">зарегистрироваться</a>!<br />
							<a href="/users/">Назад</a>';
            $data['breadcrumbs'] = "Голосование";
            $data['seo'] = "";
            $this->load->view('msg.tpl.php', $data);
        }
    }

    public
    function users()
    {
        $this->load->model('Model_options', 'options');

        $data['users'] = $this->users->getMemberUsers();
        $data['title'] = "Список зарегистрированных участников конкурса";
        $data['keywords'] = "Список зарегистрированных участников конкурса";
        $data['description'] = "Список зарегистрированных участников конкурса";
        $data['robots'] = "index, follow";
        $data['h1'] = "Список зарегистрированных участников конкурса";
        $data['seo'] = "";
        $this->load->view('users/users.tpl.php', $data);
    }


    public
    function set_type($id)
    {
        $article = $this->articles->getArticleById($id);
        if ($article['created_by'] == userdata('login')) {
            $data['article'] = $article;
            $data['myArticles'] = $this->articles->getArticlesByLogin(userdata('login'));
            $data['title'] = "Изменение тарифа для организации " . $article['name'];
            $data['keywords'] = "Изменение тарифа для организации " . $article['name'];
            $data['description'] = "Изменение тарифа для организации " . $article['name'];
            $data['robots'] = "noindex, nofollow";
            $data['h1'] = "Изменение тарифа для организации " . $article['name'];
            $data['tarifs'] = $this->articles->getTarifs(1, 'DESC');

            $this->load->view('users/set_type.tpl.php', $data);
        } else {
            $msg = "У Вас нет доступа к данной организации!";
        }
    }

    public
    function buy_type($id)
    {
        $article = $this->articles->getArticleById($id);
        if (isset($_GET['tarif'])) {
            $tarif = $this->articles->getTarif($_GET['tarif']);
            if ($article['created_by'] == userdata('login') && $tarif) {
                $data['article'] = $article;
                $data['myArticles'] = $this->articles->getArticlesByLogin(userdata('login'));
                $data['title'] = "Изменение тарифа для организации " . $article['name'];
                $data['keywords'] = "Изменение тарифа для организации " . $article['name'];
                $data['description'] = "Изменение тарифа для организации " . $article['name'];
                $data['robots'] = "noindex, nofollow";
                $data['h1'] = "Изменение тарифа для организации " . $article['name'] . " на <strong>" . $tarif['name'] . "</strong>";
                if (isset($_GET['extend']) && $_GET['extend'] == 'year') $data['h1'] .= ' на год';
                else $data['h1'] .= ' на месяц';
                $data['tarifs'] = $this->articles->getTarifs(1, 'DESC');
                $data['tarif'] = $tarif;

                $this->load->view('users/buy_type.tpl.php', $data);
            } else {
                $msg = "У Вас нет доступа к данной организации!";
            }
        }
    }


    public
    function addOrganization()
    {
        $err = false;
        if (userdata('login') !== false) {
            if (isset($_POST['add_organization'])) {
                $name = trim(post('name'));
                $category_id = post('category_id');
                $short_content = strip_tags(post('short_content'));
                $city_id = post('city_id');
                $city = $this->cities->getCityById($city_id);
                if(isset($city['name'])) $city = $city['name'];
                $city_area_id = post('city_area_id');
                $adress = post('adress');
                $arr = explode("\n", $adress);
                if (is_array($arr)) {
                    $res = "";
                    $count = count($arr);
                    for ($i = 0; $i < $count; $i++) {
                        $item = trim($arr[$i]);
                        $res .= 'adress=' . $item;
                        if (isset($arr[$i + 1])) $res .= '
|
';
                    }
                    $adress = $res;
                } else $adress = "adress=" . $adress;
                $email = post('email');
                $site = post('site');
                $soc = post('soc');
                $arr = explode("\n", $soc);
                if (is_array($arr)) {
                    $res = "";
                    $count = count($arr);
                    for ($i = 0; $i < $count; $i++) {
                        $item = trim($arr[$i]);
                        $res .= $item;
                        if (isset($arr[$i + 1])) $res .= '|';
                    }
                    $soc = $res;
                }
                $tel = post('tel');
                $arr = explode("\n", $tel);
                if (is_array($arr)) {
                    $res = "";
                    $count = count($arr);
                    for ($i = 0; $i < $count; $i++) {
                        $item = trim($arr[$i]);
                        $res .= $item;
                        if (isset($arr[$i + 1])) $res .= '|';
                    }
                    $tel = $res;
                }
                $trener = post('trener');
                $first_category_id = post('first_category_id');
                $sub_category_id = post('sub_category_id');
                $three_category_id = post('three_category_id');
                $parent_category_id = $first_category_id;
                if ($category_id != $sub_category_id)
                    $parent_category_id = $sub_category_id;

                if ($name != '' && $category_id != '' && $short_content != '' && $city != '' && $adress != '' && $email != '' && $tel != '') {
                    $image = "";
                    if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
                        if ($_FILES['userfile']['name'] != '') {
                            $imagearr = $this->upload_logo();
                            $image = '/upload/articles/' . date("Y-m-d") . '/' . $imagearr['file_name'];
                        }
                    }
                    $this->load->helper('translit_helper');

                    $url = createUrl($name);

                    $dbins = array(
                        'name' => $name,
                        'category_id' => $category_id,
                        'short_content' => $short_content,
                        'city_id' => $city_id,
                        'city' => $city,
                        'city_area_id'  => $city_area_id,
                        'adress' => $adress,
                        'email' => $email,
                        'site' => $site,
                        'soc' => $soc,
                        'tel' => $tel,
                        'trener' => $trener,
                        'image' => $image,
                        'created_by' => userdata('login'),
                        'created_ip' => getRealIp(),
                        'created_date' => date("Y-m-d H:i"),
                        'title' => $name . ' - ' . $short_content,
                        'keywords' => $name,
                        'description' => $short_content . ' ' . $name,
                        'url' => $url,
                        'first_category_id' => $first_category_id,
                        'parent_category_id' => $parent_category_id,
                        'active' => 0,
                        'unix' => time(),
                        'date' => date("Y-m-d"),
                        'time' => date("H:i"),
                        'date_unix' => time()
                    );
                    $this->db->insert('articles', $dbins);

                    // Получаем добавленную организацию
                    $this->db->where('created_by', userdata('login'));
                    $this->db->where('name', $name);
                    $this->db->where('url', $url);
                    $this->db->limit(1);
                    $new = $this->db->get('articles')->result_array();
                    if ($new) $new = $new[0];
                    $id = 0;
                    if ($new) $id = $new['id'];

                    addLog('add_article', 'Добавление статьи ID: ' . $id . ' из клиентской части', userdata('type'));

                    $url = getFullUrl($new);
                    $data['msg'] = 'Ваши данные успешно сохранены! Информация появится на сайте после проверки администратором!<br />Ваша организация будет доступна тут: <a href="//' . $_SERVER['SERVER_NAME'] . $url . '">//' . $_SERVER['SERVER_NAME'] . $url . '</a>';
                    $this->load->helper('mail_helper');
                    $to = getOption('admin_email');
                    $admin_url = 'http://' . $_SERVER['SERVER_NAME'] . '/admin/articles/edit/' . $new['id'] . '/';
                    $message = 'Пользователь ' . userdata('login') . ' добавил новую организацию!<br>
					Название: ' . $name . '<br>Для проверки и активации организации зайдите в админку и активируйте: <a href="' . $admin_url . '">' . $admin_url . '</a><br /><br />
					Как Вы о нас узнали: ' . post('for-how') . '
					';
                    if (post('for-how') == 'other') {

                    }
                    mail_send($to, "Добавление новой организации " . $name, $message);
                } else {
                    $err = "Вы не заполнили все обязательные поля!";
                }
            }
            $data['err'] = $err;
            $data['title'] = "Добавление новой организации в справочник";
            $data['keywords'] = "Добавление новой организации в справочник";
            $data['description'] = "Добавление новой организации в справочник hobby.od.ua";
            $data['robots'] = "index, follow";
            $data['h1'] = "Добавление новой организации в справочник";

            $categories = $this->model_categories->getCategories(1, 'organizations');
            $data['categories'] = $categories;
            $data['user'] = $this->users->getUserByLogin(userdata('login'));

            $this->load->view('users/add_organization.tpl.php', $data);
        } else {
            $data['title'] = "Добавление новой организации в справочник";
            $data['keywords'] = "Добавление новой организации в справочник";
            $data['description'] = "Добавление новой организации в справочник hobby.od.ua";
            $data['robots'] = "index, follow";
            $data['h1'] = "Добавление новой организации в справочник";
            $data['content'] = 'Для того, чтобы добавить новую организацию в справочник ' . $_SERVER['SERVER_NAME'] . ' Вам необходимо авторизироваться через любую для Вас удобную соц. сеть, либо почтовую службу:
			<script src="//ulogin.ru/js/ulogin.js"></script>
        <div id="uLogin05b61546" data-ulogin="display=panel;fields=first_name,last_name,email;optional=phone,city,country,photo_big,photo,nickname,bdate,sex;verify=1;providers=google,vkontakte,odnoklassniki,facebook,mailru,yandex,twitter,livejournal,openid,lastfm,linkedin,youtube,googleplus,instagram,uid,wargaming,webmoney;hidden=liveid,soundcloud,steam,flickr,foursquare,tumblr,vimeo;redirect_uri=%2F%2F' . $_SERVER['SERVER_NAME'] . '%2Flogin%2F"></div>';

            $data['seo'] = "";
            $this->load->view('msg.tpl.php', $data);
        }
    }

    public
    function editOrganization($id)
    {
        $err = false;
        $article = $this->articles->getArticleById($id);

        $user_type = userdata('type');

        if (($article['created_by'] != userdata('login') && $user_type != 'admin' && $user_type != 'moder') || userdata('login') == false) err404(); // проверяем права на редактирование

        $cat = $this->model_categories->getCategoryById($article['category_id']);
        $parent_cat = $this->model_categories->getCategoryById($article['parent_category_id']);
        $first_cat = $this->model_categories->getCategoryById($article['first_category_id']);
        $parent_categories = $this->model_categories->getSubCategories($article['first_category_id']);
        $three_categories = false;
        if ($article['parent_category_id'] != $article['first_category_id'])
            $three_categories = $this->model_categories->getSubCategories($parent_cat['id']);
        if ($cat['parent'] != 0)


            if (isset($_POST['edit_organization'])) {
                $name = trim(post('name'));
                $category_id = post('category_id');
                $short_content = strip_tags(post('short_content'));
                $city_id = post('city_id');
                $city = $this->cities->getCityById($city_id, 1);
                if(isset($city['name'])) $city = $city['name'];
                $city_area_id = post('city_area_id');
                $adress = post('adress');
                $arr = explode("\n", $adress);
                if (is_array($arr)) {
                    $res = "";
                    $count = count($arr);
                    for ($i = 0; $i < $count; $i++) {
                        $item = trim($arr[$i]);
                        $res .= 'adress=' . $item;
                        if (isset($arr[$i + 1])) $res .= '
|
';
                    }
                    $adress = $res;
                } else $adress = "adress=" . $adress;
                $email = post('email');
                $site = post('site');
                $soc = post('soc');
                $arr = explode("\n", $soc);
                if (is_array($arr)) {
                    $res = "";
                    $count = count($arr);
                    for ($i = 0; $i < $count; $i++) {
                        $item = trim($arr[$i]);
                        $res .= $item;
                        if (isset($arr[$i + 1])) $res .= '|';
                    }
                    $soc = $res;
                }
                $tel = post('tel');
                $arr = explode("\n", $tel);
                if (is_array($arr)) {
                    $res = "";
                    $count = count($arr);
                    for ($i = 0; $i < $count; $i++) {
                        $item = trim($arr[$i]);
                        $res .= $item;
                        if (isset($arr[$i + 1])) $res .= '|';
                    }
                    $tel = $res;
                }
                $trener = post('trener');
                $first_category_id = post('first_category_id');
                $sub_category_id = post('sub_category_id');
                $three_category_id = post('three_category_id');
                $parent_category_id = $first_category_id;
                if ($category_id != $sub_category_id)
                    $parent_category_id = $sub_category_id;


                if ($name != '' && $category_id != '' && $short_content != '' && $city != '' && $adress != '' && $email != '' && $tel != '') {
                    $image = $article['image'];
                    if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
                        if ($_FILES['userfile']['name'] != '') {
                            if ($article['image'] != '') {    // удаление старой картинки
                                @unlink($_SERVER['DOCUMENT_ROOT'] . $article['image']);
                                $image = "";
                            }
                            $imagearr = $this->upload_logo();
                            $image = '/upload/articles/' . date("Y-m-d") . '/' . $imagearr['file_name'];
                        }
                    }
                    $this->load->helper('translit_helper');

                    $url = $article['url'];
                    if ($url == '')
                        $url = createUrl($name);

                    $active = 0;
                    if ($article['type'] != '' && $article['type'] != 'free') $active = 1;

                    $dbins = array(
                        'name' => $name,
                        'category_id' => $category_id,
                        'short_content' => $short_content,
                        'city' => $city,
                        'city_id' => $city_id,
                        'city_area_id' => $city_area_id,
                        'adress' => $adress,
                        'email' => $email,
                        'site' => $site,
                        'soc' => $soc,
                        'tel' => $tel,
                        'trener' => $trener,
                        'image' => $image,
                        'title' => $name . ' - ' . $short_content,
                        'keywords' => $name,
                        'description' => $short_content . ' ' . $name,
                        'url' => $url,
                        'first_category_id' => $first_category_id,
                        'parent_category_id' => $parent_category_id,
                        'active' => $active,
                        'unix' => time(),
                        'date' => date("Y-m-d"),
                        'time' => date("H:i"),
                        'date_unix' => time(),
                        'moderated_by' => userdata('login'),
                        'moderated_ip' => getRealIp(),
                        'moderated_date' => date("Y-m-d H:i")
                    );
                    $this->db->where('id', $id)->limit(1)->update('articles', $dbins);

                    addLog('edit_article', 'Редактирование статьи ID: ' . $id . ' из клиентской части', userdata('type'));

                    $data['msg'] = 'Ваши данные успешно сохранены!';
                    if ($active == 0) $data['msg'] .= ' Информация появится на сайте после проверки администратором!';
                    $data['msg'] .= '<br /><a href="/user/mypage/">Вернуться в личный кабинет</a>';
                    $this->load->helper('mail_helper');
                    $to = getOption('admin_email');
                    $admin_url = 'http://' . $_SERVER['SERVER_NAME'] . '/admin/articles/edit/' . $id . '/';
                    $message = 'Пользователь ' . userdata('login') . ' отредактировал организацию!<br>
					Название: ' . $name . '<br>Для проверки изменений зайдите в админку';
                    if ($active == 0) $message .= '<b>и активируйте</b>';
                    $message .= ': <a href="' . $admin_url . '">' . $admin_url . '</a>';
                    mail_send($to, "Изминение данных об организации " . $name, $message);
                } else {
                    $err = "Вы не заполнили все обязательные поля!";
                }
            }

        $data['cat'] = $cat;
        $data['parent_categories'] = $parent_categories;
        $data['three_categories'] = $three_categories;
        $data['parent_cat'] = $parent_cat;
        $data['first_cat'] = $first_cat;
        $data['err'] = $err;
        $data['article'] = $article;
        $data['title'] = "Редактирование организации " . $article['name'];
        $data['keywords'] = "Редактирование организации " . $article['name'];
        $data['description'] = "Редактирование организации " . $article['name'];
        $data['robots'] = "noindex, nofollow";
        $data['h1'] = "Редактирование организации " . $article['name'];

        $categories = $this->model_categories->getCategories(1, 'organizations');
        $data['categories'] = $categories;
        $data['user'] = $this->users->getUserByLogin(userdata('login'));

        $this->load->view('users/edit_organization.tpl.php', $data);
    }

    public
    function delOrganization($id)
    {
        echo 'Удаление временно невозможно...';
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */