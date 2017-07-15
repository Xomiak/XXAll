<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Main extends CI_Controller
{

    private $current_lang;

    public function __construct()
    {
        parent::__construct();
        beforeOutput();

        $this->load->model('Model_articles', 'art');
        $this->load->model('Model_categories', 'cat');
        $this->load->model('Model_comments', 'comments');
        $this->load->model('Model_brands', 'brands');
        $this->load->model('Model_products', 'products');
        $this->load->model('Model_adresses', 'adresses');
        //beforeOutput();

        set_userdata('last_url', $_SERVER['REQUEST_URI']);

        isLogin();
    }

    public function index()
    {

        $this->session->set_userdata('last_url', $_SERVER['REQUEST_URI']);

        $data = array();


        $this->load->model('Model_main', 'main');
        $this->load->helper('menu_helper');

//        $tkdzst = $this->main->getMain();
//        $tkdzst = translateMain($tkdzst);
//        //vd($tkdzst);

//        if (isset($_GET['redirect'])) {
//
//            $url = urldecode($_GET['redirect']);
//            $data['title'] = $data['description'] = $data['keywords'] = "Перенаправление на сторонний ресурс: " . $url;
//            $data['robots'] = "noindex, nofollow";
//            $data['h1'] = "Перенаправление на сторонний ресурс...";
//            $data['url'] = $url;
//            $this->load->view('redirect.tpl.php', $data);
//            return;
//        }

        //var_dump($GLOBALS);
        

        $meta = getOptionsByModule('meta');
       // vdd($meta);
        $data = array();
        $defPostfix = $postfix = "_ru";

        if (isset($GLOBALS['multilanguage']) && $GLOBALS['multilanguage'] == TRUE) {            // Если включена мультиязычность
            $current_lang = 'ru';
            $default_lang =  'ru';

            //if ($current_lang != $default_lang) {
            $postfix = '_' . $current_lang;
            $defPostfix = '_'.$default_lang;
            //vdd($postfix);
            //}
        }

       // var_dump($meta['main_title' . $postfix]);

        $metaArr = array();

        if (isset($meta['main_title' . $postfix])) $metaArr['title'] = $meta['main_title' . $postfix];
        else $metaArr['title'] = $meta['main_title'.$defPostfix];
        if (isset($meta['main_keywords' . $postfix])) $metaArr['keywords'] = $meta['main_keywords' . $postfix]; else $metaArr['keywords'] = $meta['main_keywords'.$defPostfix];
        if (isset($meta['main_description' . $postfix])) $metaArr['description'] = $meta['main_description' . $postfix]; else $metaArr['description'] = $meta['main_description'.$defPostfix];
        if (isset($meta['main_robots' . $postfix])) $metaArr['robots'] = $meta['main_robots' . $postfix]; else $metaArr['robots'] = $meta['main_robots'.$defPostfix];
        if (isset($meta['main_h1' . $postfix])) $metaArr['h1'] = $meta['main_h1' . $postfix]; else $metaArr['h1'] = $meta['main_h1'.$defPostfix];
        //if (isset($meta['seo' . $postfix])) $data['seo'] = $meta['main_seo' . $postfix]; else $data['seo'] = $meta['main_seo'.$defPostfix];
     //   if (isset($meta['content' . $postfix])) $data['content'] = $meta['main_content' . $postfix]; else $data['content'] = $meta['main_content'];


        if (!isset($meta['adding_scripts'])) $data['adding_scripts'] = $metaArr['adding_scripts'] = '';
        else $data['adding_scripts'] = $meta['adding_scripts'];

        //$data['news'] = $this->art->getArticlesByCategory(1,2,0,1);
        //vdd($metaArr);
        $data['meta'] = $metaArr;

        $per_page = getOption('articles_pagination');
        $per_page = 1;
        $data['meta'] = $metaArr;

        $params = array(
            'active'    => 1,
            'category_id'   => '*5*',
            'end_date_unix >' =>  time()
        );

        $GLOBALS['type'] = 'main';
        $GLOBALS['currentId'] = false;

        $data['products'] = $this->products->getProductsByCategory(1);
//var_dump(TEMPLATE_PATH);
        //$mainPath = TEMPLATE_PATH.'/common/Main.php';
        $mainPath = '/common/Main.php';
        $this->load->view($mainPath, $data);
    }


    public function test(){
        loadLibrary('Translate');

        $tr = new Translate(); // Default is from 'auto' to 'en'
        $tr->setSource('en'); // Translate from English
        $tr->setTarget('ru'); // Translate to Georgian
        $tr->setUrlBase('http://translate.google.cn/translate_a/single'); // Set Google Translate URL base (This is not necessary, only for some countries)
        echo $tr->translate('Hello World!');
    }


    public function banner_redirect($id)
    {
        $link = $this->model_banners->getLink($id);
        $this->model_banners->countPlus($id);
        redirect($link);
    }

    public function subscription()
    {
        if (isset($_POST['email']) && $_POST['email'] != '') {
            $this->db->where('email', $_POST['email']);
            $this->db->limit(1);
            $subs = $this->db->get('subscription')->result_array();

            if (!$subs) {
                $dbins = array(
                    'email' => $_POST['email'],
                    'date' => date("Y-m-d H:i")
                );

                $this->db->insert('subscription', $dbins);
            }

            $this->session->set_userdata('subscription', true);
        }

        $redirect = '/';
        if ($this->session->userdata('last_url') !== false)
            $redirect = $this->session->userdata('last_url');

        redirect($redirect);
    }

    public function add_to_cart()
    {
        //$this->session->unset_userdata('my_cart');
        if (isset($_POST['shop_id'])) {
            $my_cart = array();
            if ($this->session->userdata('my_cart') !== false)
                $my_cart = $this->session->userdata('my_cart');

            $is_new = true;
            $count = count($my_cart);
            for ($i = 0; $i < $count; $i++) {
                if ($my_cart[$i]['shop_id'] == $_POST['shop_id']) {
                    $my_cart[$i]['kolvo'] = $my_cart[$i]['kolvo'] + $_POST['kolvo'];
                    $is_new = false;
                }
            }

            if ($is_new) {
                $new = array(
                    'shop_id' => $_POST['shop_id'],
                    'kolvo' => $_POST['kolvo']
                );

                array_push($my_cart, $new);
            }

            $this->session->set_userdata('my_cart', $my_cart);

            //var_dump($my_cart);
        }
        $redirect = '/my_cart/';
        if (isset($_POST['back']))
            $redirect = $_POST['back'];
        redirect($redirect);
    }


    public function map()
    {
        $data['main_title'] = "Поиск на карте" . getOption('global_main_title_' . $this->current_lang);
        $data['keywords'] = "Поиск на карте" . getOption('global_keywords_' . $this->current_lang);
        $data['description'] = "Поиск на карте" . getOption('global_description_' . $this->current_lang);
        $data['robots'] = "index, follow";
        $data['h1'] = "Поиск на карте";

//        $this->load->library('googlemaps');
//        $config = array(
//            'apiKey' => 'AIzaSyDL-ughU0ynX4JHYIU7m32K3zVF_-0fKgQ',
//            'region' => 'ua',
//            'https' => true,
//            //'center'	=> $article['city'].', '.$article['adress'],
//            'zoom' => 'auto',
//            'map_div_id' => 'googleMap',
//            'scrollwheel' => false,
//            'geocodeCaching'    => FALSE
//
//        );
//
//        $this->googlemaps->initialize($config);

        $city = "Одесса";

        $articles = $this->art->select('', -1, -1, 1, 'organizations');
        // vd(count($articles));
        $adress = array();

        //echo count($articles);

        $this->load->model('Model_adresses', 'adresses');

        /*
        foreach ($articles as $article) {
            $adr = getAdressArray($article['adress']);
            if(is_array($adr)){
                foreach ($adr as $item){
                    if(isset($item['adress'])){
                        $item['adress'] = strip_tags($item['adress']);
                        $old = $this->map->getByAdress($item['adress']);
                        if(!$old){
                            $res = $this->googlemaps->get_lat_long_from_address($item['adress']);
                            if($res){
                                $item['lat'] = $res[0];
                                $item['lng'] = $res[1];
                                if($article['image'] != '')
                                    $item['icon']   = CreateThumb2(45, 45, $article['image'], 'icons');
                                $cat = $this->model_categories->getFirstLevelCategory($article['category_id']);
                                if($cat['image'] != '')
                                    $item['icon_category'] = CreateThumb2(45, 45, $cat['image'], 'icons');
                                $item['article_id'] = $article['id'];

                                $this->db->insert('coords', $item);
                            }
                        }
                    }

                }
            }
            vd($adr);
        }

        vd($adress);
*/
        $coords = $this->adresses->get_coordinates();
        //vd($coords);

        /*
        foreach ($adress as $item) {
            $marker = array();
            $marker['position'] = $city . ", " . $item['adress'];
            $marker['animation'] = 'BOUNCE';
            //$marker['cursor']	= 'Ты меня поймал)';

            if ($article['image'] != '')
                $marker['icon'] = CreateThumb2(45, 45, $article['image'], 'icons');
            elseif ($category['image'] != '')
                $marker['icon'] = CreateThumb2(45, 45, $category['image'], 'icons');

            $marker['clickable'] = TRUE;
            $info = "";
            if (isset($item['name'])) $info .= '<b>' . $item['name'] . '</b>';
            if (isset($item['comment'])) $info .= $item['comment'];
            $marker['infowindow_content'] = $info;
            //vd($marker);
            $this->googlemaps->add_marker($marker);
        }
*/
//        $coords = $this->adresses->get_coordinates();
//        foreach ($coords as $coordinate) {
//            if($coordinate->lat != 0 && $coordinate->lng != 0) {
//                $marker = array();
//                if($coordinate->icon != NULL)
//                    $marker['icon'] = CreateThumb2(32,32,$coordinate->icon,'maps');
//                $marker['position'] = $coordinate->lat . ',' . $coordinate->lng;
//
//                $marker['animation'] = 'DROP';
//                $marker['clickable'] = TRUE;
//                $info = "";
//                $article = $this->art->getNameOfArticle($coordinate->article_id);
//
//                if (isset($article)) $info .= '<b>' . $article . '</b>';
//                $info .= $coordinate->description;
//               //$marker['infowindow_content'] = $info;
//                //vd($marker['infowindow_content']);
//                $marker['infowindow_content'] = '<strong>'.$article.'</strong>';
//
//                $this->googlemaps->add_marker($marker);
//            }
//        }

        //  $data['map'] = $this->googlemaps->create_map();


        $this->load->view('map.tpl.php', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */