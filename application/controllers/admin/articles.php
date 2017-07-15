<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Articles extends CI_Controller
{

    private $langs;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_articles', 'articles');
        $this->load->model('Model_users', 'users');
        $this->load->model('Model_adresses', 'adresses');
        $this->load->model('Model_images', 'images');
        $this->load->model('Model_categories', 'categories');
        $this->load->helper('admin_helper');


    }

    public function adress_edit($id)
    {
        // Google Maps //
        $adress = $this->adresses->getById($id);

        // сохраняем изменения
        if (isset($_POST['save']) || isset($_POST['save_and_stay'])) {
            if ($_POST['searchByAdress'] == '') {
                if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
                    if ($_FILES['userfile']['name'] != '') {
                        if ($adress['icon'] != '')
                            @unlink($_SERVER['DOCUMENT_ROOT'] . $adress['icon']);
                        $filearr = $this->upload_file('userfile');
                        $file = '/upload/articles/' . date("Y-m-d") . '/' . $filearr['file_name'];
                        $adress['icon'] = $file;
                    }
                }
                $adress['adress'] = post('adress');
                $adress['city'] = post('city');
                $adress['lat'] = post('lat');
                $adress['lng'] = post('lng');
                $adress['description'] = post('description');
                if (isset($_POST['active']) && $_POST['active'] == true)
                    $adress['active'] = 1;
                else $adress['active'] = 0;

                $this->db->where('id', $id)->limit(1)->update('adresses', $adress);

                if (isset($_POST['save_and_stay']))
                    redirect('/admin/articles/adress_edit/' . $id . '/');
                else redirect('/admin/articles/adresses/');
            }
        }


        $this->load->library('googlemaps');
        $onclick = '
        $("#coordsLat").val(event.latLng.lat());
        $("#coordsLng").val(event.latLng.lng());
        ';
        $config = array(
            'apiKey' => 'AIzaSyDL-ughU0ynX4JHYIU7m32K3zVF_-0fKgQ',
            'region' => 'ua',
            'https' => true,
            'center' => $adress['lat'] . ', ' . $adress['lng'],
            'zoom' => 'auto',
            'map_div_id' => 'googleMap',
            'scrollwheel' => false,
            'geocodeCaching' => TRUE,
            //           'onclick' => $onclick,
            'zoom' => 16,
            'region' => 'ua'


        );

        if (isset($_POST['searchByAdress']) && $_POST['searchByAdress'] != '')
            $config['center'] = $_POST['searchByAdress'];

        $this->googlemaps->initialize($config);
        if ($adress['lat'] != 0 && $adress['lng'] != 0) {
            $marker = array();
            if ($adress['icon'] != NULL)
                $marker['icon'] = CreateThumb2(48, 48, $adress['icon'], 'maps');
            if (isset($_POST['searchByAdress']) && $_POST['searchByAdress'] != '')
                $marker['position'] = $_POST['searchByAdress'];
            else
                $marker['position'] = $adress['lat'] . ',' . $adress['lng'];
            $marker['draggable'] = true;
            $marker['ondragend'] = $onclick;

            $info = "";
            if (isset($adress['description'])) $info .= $adress['description'];
            $info = str_replace("\n", '<br />', $info);
            $marker['infowindow_content'] = $info;
            $this->googlemaps->add_marker($marker);
        }

        $data['map'] = $this->googlemaps->create_map();
        // /Google Maps //

        $data['adress'] = $adress;
        $data['title'] = "Редактирование адреса";
        $this->load->view('articles/adress_edit.tpl.php', $data);
    }

    public function adresses()
    {
        $data['title'] = "Адреса организаций";

        if (isset($_POST['search'])) {
            $data['articles'] = $this->adresses->search($_POST['search']);

            $data['pager'] = '';
        } else {
            $a = $this->db->count_all('adresses');

            // ПАГИНАЦИЯ //
            $this->load->library('pagination');
            $per_page = 35;
            $config['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/articles/adresses/';
            $config['total_rows'] = $a;
            $config['num_links'] = 4;
            $config['first_link'] = 'в начало';
            $config['last_link'] = 'в конец';
            $config['next_link'] = 'далее';
            $config['prev_link'] = 'назад';

            $config['per_page'] = $per_page;
            $config['uri_segment'] = 4;
            $from = intval($this->uri->segment(4));
            $page_number = $from / $per_page + 1;
            $this->pagination->initialize($config);
            $data['pager'] = $this->pagination->create_links();

            if ($page_number > 1)
                $this->session->set_userdata('articlesFrom', $from);
            else $this->session->unset_userdata('articlesFrom');
            //////////
            $data['articles'] = $this->adresses->getAdresses(-1, $per_page, $from);
        }
        $this->load->view('articles/adresses.tpl.php', $data);
    }

    public function index()
    {
        if(isset($_GET['clone_id'])){
            $article = $this->articles->getArticleById($_GET['clone_id']);
            if($article){
                unset($article['id']);
                $article['url'] .= '-1';
                $article['name'] .= ' (2)';
            }
            $this->db->insert('articles', $article);
            $new_id = $this->articles->getLastId();
            redirect('/admin/articles/edit/'.$new_id.'/');
        }

        $settings = $this->articles->getSettings();
        $fieldtypes = $this->ma->getFirldtypes();

        if (isset($_GET['setnums'])) {
            $articles = $this->articles->getArticles();
            $count = count($articles);
            for ($i = 0; $i < $count; $i++) {
                updateItem($articles[$i]['id'],'articles',array('num'=>$i));
            }
        }

        if (isset($_POST['list'])) {
            $action = post('action');
            $list = $_POST['list'];
            foreach ($list as $item) {
                if ($action == 'delete') {
                    $article = $this->articles->getArticleById($item);  // получаем выбранную статью
                    if ($article) {       // статья найдена
                        // START ** МАССОВОЕ УДАЛЕНИЕ СТАТЕЙ ** //

                        // START ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //
                        $s_files = $this->articles->getSettingsByType('Файл');
                        if ($s_files) {
                            $count = count($s_files);
                            for ($i = 0; $i < $count; $i++) {
                                $df = $s_files[$i];
                                //var_dump("asd");die();
                                @unlink($_SERVER['DOCUMENT_ROOT'] . $article[$df['name']]);
                                $dbins[$df['name']] = '';
                            }
                        }
                        // END ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //
                        // START ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ КАРТИНОК ** //
                        $images = $this->images->getByArticleId($article['id']);
                        if ($images) {
                            $icount = count($images);
                            for ($ii = 0; $ii < $icount; $ii++) {
                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $images[$ii]['image']))
                                    unlink($_SERVER['DOCUMENT_ROOT'] . $images[$ii]['image']);

                                $this->db->where('id', $images[$ii]['id']);
                                $this->db->limit(1);
                                $this->db->delete('images');
                            }
                        }
                        // END ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ КАРТИНОК ** //
                        //$this->db->where('article_id', $article['id'])->delete('adresses');
                        $this->db->where('id', $article['id'])->limit(1)->delete('articles'); // удадяем запись
                    }

                } elseif ($action == 'active' || $action == 'not_active') {
                    // START ** МАССОВАЯ АКТИВАЦИЯ / ДЕАКТИВАЦИЯ СТАТЕЙ ** //
                    $dbins = array('active' => 1);
                    if ($action == 'not_active') $dbins['active'] = 0;
                    $this->db->where('id', $item)->limit(1)->update('articles', $dbins);
                }
            }

            $url = '/admin/articles/';
            if (post('back') !== false)
                $url = post('back');
            redirect($url);
        }

        $data['title'] = "Статьи";

        if (isset($_POST['search'])) {
            $data['articles'] = $this->articles->searchByName($_POST['search']);

            $data['pager'] = '';
        } else {
            //vdd("asd");
            if ($this->session->userdata('category_id') != null)
                $a = $this->articles->getCountArticlesInCategory($this->session->userdata('category_id'));
            else
                $a = $this->db->count_all('articles');

            // Кол-во на странице:
            $per_page = 35;
            if(isset($_POST['numb-action'])) {
                vdd(post('numb-action'));
                set_userdata('admin_articles_per_page', post('numb-action'));
                redirect($_SERVER['REQUEST_URI']);
            }

            if(userdata('admin_articles_per_page') !== false) $per_page = userdata('admin_articles_per_page');
            else set_userdata('admin_articles_per_page', $per_page);

            $data['per_page'] = userdata('admin_articles_per_page');

            //vdd($per_page);

            if($per_page == 'all') $per_page = $a;

            // ПАГИНАЦИЯ //
            $this->load->library('pagination');
            //$per_page = 35;
            $config['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/articles/';
            $config['total_rows'] = $a;
            $config['num_links'] = 4;
            $config['first_link'] = 'в начало';
            $config['last_link'] = 'в конец';
            $config['next_link'] = 'далее';
            $config['prev_link'] = 'назад';

            $config['per_page'] = $per_page;
            $config['uri_segment'] = 3;
            $from = intval($this->uri->segment(3));
            $page_number = $from / $per_page + 1;
            $this->pagination->initialize($config);
            $data['pager'] = $this->pagination->create_links();

            if ($page_number > 1)
                $this->session->set_userdata('articlesFrom', $from);
            else $this->session->unset_userdata('articlesFrom');
            //////////

            if ($this->session->userdata('category_id') != null)
                $data['articles'] = $this->articles->getArticlesByCategory($this->session->userdata('category_id'), $per_page, $from, -1, 'DESC', 'num');
            else
                $data['articles'] = $this->articles->getArticles($per_page, $from);
        }

        $data['articlesNewNum'] = $this->articles->getProductsNewNum();
        $data['categories'] = $this->categories->getCategories(-1, 'organizations');
        $data['fieldtypes'] = $fieldtypes;
        $data['settings'] = $settings;
        $data['admin_in_table'] = $this->articles->getSettingsForAdminTable();
        $data['type'] = "articles";

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('articles/articles.tpl.php', $data);
    }


// ФУНКЦИЯ НАПОЛНЕНИЯ МАССИВА ЗНАЧЕНИЯМИ ДЛЯ ДОБАВЛЕНИЯ ИЛИ РЕЛАКТИРОВАНИЯ СТАТЬИ
    function getDbins($action, $item = false, $use_translations = -1)
    {
        $settings = $this->articles->getSettings();

        $dbins = getDbins($settings, $item, 'articles', $action, $use_translations);
        //vdd($dbins);
        return $dbins;
    }

    public function add()
    {
        $use_translations = getOption('use_translations');      // использовать ли отдельную таблицу для хранения языковых версий
        $userId = false;
        if($use_translations)
            $userId = getUserId();

        $settings = $this->articles->getSettings();
        $fieldtypes = $this->ma->getFirldtypes();
        $sNoLang = $this->articles->getSettings(0);
        $sMultiLang = $this->articles->getSettings(1);


        // START ** Обработчик добавления статьи ** //
        if (isset($_POST['add_article']) || isset($_POST['add_article_and_close'])) {
            $unix = time();
            $num = $this->articles->getProductsNewNum();
            $created_date = date("Y-m-d H:i");

            $dbins = $this->getDbins('add', false, $use_translations);
            //vdd($dbins);

            //$url_cache = getFullUrl($dbins, false);

            $dbins['created_by'] = userdata('login');
            $dbins['created_ip'] = getRealIp();
            $dbins['created_date'] = $created_date;
            $dbins['unix'] = $unix;
            $dbins['num'] = $num;
           // $dbins['url_cache'] = $url_cache;

            $ret = $this->db->insert('articles', $dbins);

            $this->db->where('created_by', userdata('login'));
            $this->db->where('unix', $unix);
            //$this->db->where('url_cache', $url_cache);
            $new = $this->db->get('articles')->result_array();
            if ($new) $new = $new[0];
            $id = 0;
            if ($new) $id = $new['id'];

            $article = $this->articles->getLastAddedProduct();

            // Если включена опция хранения языковых версий в отдельной языковой таблице,
            // присваеваем переводам ID статьи
            if(($article) && $use_translations == 1){
                setTrnslatesItemIds($userId, $article['id'], 'articles');
            }

            if($article['image'] == ''){
                $this->load->helper('images_helper');
                $image = createImageForArticle($article, false, true);
                if($image){
                    $this->db->where('id', $article['id'])->limit(1)->update('articles', array('image'=>$image));
                }
            }

            addLog('add_article', 'Добавление статьи ID: ' . $id, 'admin');

            if ($ret) {
                if (isset($_POST['add_article_and_close']))
                    redirect('/admin/articles/');
                else {

                    if ($article)
                        redirect('/admin/articles/edit/' . $article['id'] . '/');
                }
            }
        }
        // END** Обработчик добавления статьи ** //

        $data['action'] = 'add_article';
        $data['title'] = "Добавление статьи";
        $data['fieldtypes'] = $fieldtypes;
        $data['settings'] = $settings;
        $data['noLang'] = $sNoLang;
        $data['multiLang'] = $sMultiLang;
        $data['categories'] = $this->categories->getCategories(1);

        $data['article_in_many_categories'] = getOption('article_in_many_categories');
        $data['type'] = "articles";

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $data['use_translations'] = $use_translations;
        $this->load->view('articles/article_add_edit.tpl.php', $data);
    }

    public function edit($id) {
        $use_translations = getOption('use_translations');      // использовать ли отдельную таблицу для хранения языковых версий
        $userId = false;
        if($use_translations)
            $userId = getUserId();

        $sNoLang = $this->articles->getSettings(0);
        $sMultiLang = $this->articles->getSettings(1);

        $article = $this->articles->getArticleById($id);

        //createOgImage(array('article_id'=> $id,'domain'=>'morskoy-bc.com.ua','domainShow'=>true,'date'=>date("Y-m-d")));

        $adresses = false;
        // START ** Обработчик редактирования статьи ** //
        if (isset($_POST['edit_article']) || isset($_POST['edit_article_and_close'])) {
            $dbins = array();

            $dbins = $this->getDbins('edit', $article);
           // vdd($dbins);

            $dbins['moderated_by'] = userdata('login');
            $dbins['moderated_ip'] = getRealIp();
            $dbins['moderated_date'] = date("Y-m-d H:i");

            // START ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //
            $s_files = $this->articles->getSettingsByType('Картинка');
            //vdd($s_files);

            if ($s_files) {
                $count = count($s_files);
                for ($i = 0; $i < $count; $i++) {
                    $df = $s_files[$i];

                    if (isset($_POST[$df['name'] . '_del'])) {
                        //vdd('file del');
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $article[$df['name']]);
                        $dbins[$df['name']] = '';
                    }
                }
            }

            // END ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //
            if ($article['url'] !== $dbins['url'] || $article['category_id'] !== $dbins['category_id'])
                $dbins['url_cache'] = getFullUrl($dbins, false);
            //var_dump($dbins);die();
            $this->db->where('id', $id);
            $this->db->limit(1);
            $ret = $this->db->update('articles', $dbins);

            addLog('edit_article', 'Редактирование статьи ID: ' . $id, 'admin');

            if ($ret) {
                if (isset($_POST['edit_article']))
                    redirect('/admin/articles/edit/' . $id . '/');
                else
                    redirect('/admin/articles/');
            }
        }
        // END** Обработчик редактирования статьи ** //

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
            'center' => '46.4609, 30.7140',
            'map_div_id' => 'googleMap',
            'scrollwheel' => false,
            'geocodeCaching' => TRUE,
            'onclick' => $onclick,
            'zoom' => 13,
            'region' => 'ua'

        );
        $this->googlemaps->initialize($config);
        if (isset($_POST['searchMap']) && $_POST['coordsAdress'] != '') {
            $coords = $this->googlemaps->get_lat_long_from_address($_POST['coordsAdress']);
            if ($coords[0] != 0 && $coords[1] != 0) {
                $marker['position'] = $coords[0] . ',' . $coords[1];
                $this->googlemaps->add_marker($marker);
                $adresses = $this->adresses->getByArticleId($id);
            }
        } else {
            $adresses = $this->adresses->getByArticleId($id);
            foreach ($adresses as $coordinate) {
                if ($coordinate['lat'] != 0 && $coordinate['lng'] != 0) {
                    $marker = array();
                    if ($coordinate['icon'] != NULL)
                        $marker['icon'] = CreateThumb2(48, 48, $coordinate['icon'], 'maps');
                    $marker['position'] = $coordinate['lat'] . ',' . $coordinate['lng'];

                    $info = "";
                    $info .= '<b>' . $article['name'] . '</b>';
                    if (isset($item['description'])) $info .= $item['description'];
                    $marker['infowindow_content'] = $info;
                    $this->googlemaps->add_marker($marker);
                }
            }
        }
        $data['map'] = $this->googlemaps->create_map();
        // /Google Maps //

        $settings = $this->articles->getSettings();
        $fieldtypes = $this->ma->getFirldtypes();
        $data['article'] = $this->articles->getArticleById($id);

        $data['adresses'] = $adresses;

        $data['use_translations'] = $use_translations;
        $data['action'] = 'edit_article';
        $data['title'] = "Редактирование статьи";
        $data['noLang'] = $sNoLang;
        $data['multiLang'] = $sMultiLang;
        $data['images'] = $this->images->getByArticleId($id);
        $data['fieldtypes'] = $fieldtypes;
        $data['settings'] = $settings;
        $data['categories'] = $this->categories->getCategories(1);

        $data['article_in_many_categories'] = getOption('article_in_many_categories');
        $data['type'] = "articles";

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('articles/article_add_edit.tpl.php', $data);
    }


    public function settings()
    {

        $settingsNewNum = $this->articles->getSettingsNewNum();
        $fieldtypes = $this->ma->getFirldtypes();
        $data = array();

        // START ** Добавление нового поля ** //
        if (isset($_POST['addNewSetting'])) {
            //vdd($_POST);
            $if_exists = $this->articles->getSettingByName($_POST['name']);
            if (!$if_exists) {
                $num = $_POST['num'];

                // если num не последний, то переписываем все num, которые идут после текущего
                if ($num != $settingsNewNum) {
                    //////////////////
                }

                $type = $this->ma->getFieldtypeByName($_POST['type']);

                $this->load->dbforge();
                $type_config = array(
                    'type' => $type['type']
                );
                if ($type['constraint'] > 0)
                    $type_config['constraint'] = $type['constraint'];

                if ($type['type'] == 'int' || $type['type'] == 'double' || $type['type'] == 'float')
                    $type_config['default'] = 0.0;
                else $type_config['null'] = true;

                $fields = array(
                    $_POST['name'] => $type_config
                );
                $if_column_added = $this->dbforge->add_column('articles', $fields);


                if ($if_column_added) {
                    $multilanguage = 0;
                    if (isset($_POST['multilanguage']) && $_POST['multilanguage'] == true) {
                        $this->load->model('Model_languages', 'languages');
                        $multilanguage = 1;
                        $languages = $this->languages->getLanguages();
                        foreach ($languages as $language) {
                            if ($language['default'] != 1) {
                                $fields = array(
                                    $_POST['name'] . "_" . $language['code'] => $type_config
                                );
                                $if_column_added = $this->dbforge->add_column('articles', $fields);
                            }
                        }
                    }
                    $admin_in_table = 0;
                    if (isset($_POST['admin_in_table']) && $_POST['admin_in_table'] == true)
                        $admin_in_table = 1;

                    $dbins = array(
                        'name' => $_POST['name'],
                        'rus' => $_POST['rus'],
                        'type' => $_POST['type'],
                        'multilanguage' => $multilanguage,
                        'num' => $num,
                        'admin_in_table' => $admin_in_table
                    );

                    $this->db->insert('articles_settings', $dbins);

                    redirect($_SERVER['REQUEST_URI']);
                } else $data['msg'] = 'Ошибка создания поля в базе!';
            } else $data['msg'] = 'Поле с таким именем уже существует!';
        }
        // END ** Добавление нового поля ** //

        // START ** Редактирование поля ** //
        if (isset($_POST['saveSetting'])) {
            if ($_POST['name'] != $_POST['cur_name']) {
                $setting = $this->articles->getSettingByName($_POST['cur_name']);
                $type = $this->ma->getFieldtypeByName($_POST['type']);
                $this->load->dbforge();
                $type_config = array(
                    'name' => $_POST['name'],
                    'type' => $type['type'],
                    'null' => TRUE
                );
                if ($type['constraint'] > 0)
                    $type_config['constraint'] = $type['constraint'];
                if ($type['type'] == 'int' || $type['type'] == 'double' || $type['type'] == 'float')
                    $type_config['default'] = 0;

                $fields = array(
                    $_POST['cur_name'] => $type_config
                );
                $if_column_modified = $this->dbforge->modify_column('articles', $fields);

                if (!$if_column_modified)
                    $data['msg'] = 'Ошибка редактирования поля в базе!';
            }

            if (($_POST['name'] == $_POST['cur_name']) || $if_column_modified == true) {
                $num = $_POST['num'];

                // если num изменился, то переписываем все num, которые идут после текущего
                if ($num != $_POST['cur_num']) {
                    //////////////////
                }

                $multilanguage = 0;
                if (isset($_POST['multilanguage']) && $_POST['multilanguage'] == true) {
                    $this->load->model('Model_languages', 'languages');
                    $multilanguage = 1;
                    $languages = $this->languages->getLanguages();
                    foreach ($languages as $language) {
                        if ($language['default'] != 1) {
                            $type_config = array(
                                'name' => $_POST['name'] . "_" . $language['code'],
                                'type' => $type['type'],
                                'null' => TRUE
                            );
                            if ($type['constraint'] > 0)
                                $type_config['constraint'] = $type['constraint'];
                            if ($type['type'] == 'int' || $type['type'] == 'double' || $type['type'] == 'float')
                                $type_config['default'] = 0;
                            $fields = array(
                                $_POST['cur_name'] . "_" . $language['code'] => $type_config
                            );
                            $if_column_added = $this->dbforge->modify_column('articles', $fields);
                        }
                    }
                }
                $admin_in_table = 0;
                if (isset($_POST['admin_in_table']) && $_POST['admin_in_table'] == true)
                    $admin_in_table = 1;

                $dbins = array(
                    'name' => $_POST['name'],
                    'rus' => $_POST['rus'],
                    'type' => $_POST['type'],
                    'multilanguage' => $multilanguage,
                    'num' => $num,
                    'admin_in_table' => $admin_in_table
                );

                $this->db->where('name', $_POST['cur_name']);
                $this->db->limit(1);
                $this->db->update('articles_settings', $dbins);

                redirect('/admin/articles/settings/');
            }
        }
        // END ** Редактирование поля ** //

        $data['settings'] = $this->articles->getSettings();
        $data['type'] = "articles";
        $data['title'] = "Настройки полей статей";
        $data['fieldtypes'] = $fieldtypes;
        $data['settingsNewNum'] = $settingsNewNum;
        $data['settingsType'] = 'articles';
        $data['settingsName'] = 'Статьи';

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('common/settings.tpl.php', $data);
    }

    public function settings_del($name)
    {
        $setting = $this->articles->getSettingByName($name);
        if ($setting['not_edited'] != 1) {
            $this->load->dbforge();
            $this->dbforge->drop_column('articles', $name);
            if($setting['multilanguage']){
                $default = getDefaultLanguageCode();
                $langs = getLanguages();
                foreach ($langs as $lang){
                    if($lang['code'] != $default)
                        $this->dbforge->drop_column('articles', $name.'_'.$lang['code']);
                }
            }

            $this->db->where('name', $name)->limit(1)->delete('articles_settings');
        }

        redirect('/articles/settings/');
    }

    public function del($id)
    {
        $article = $this->articles->getArticleById($id);

        if ($article) {
            $dbins = array();

            // START ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //
            $s_files = $this->articles->getSettingsByType('Файл');
            if ($s_files) {
                $count = count($s_files);
                for ($i = 0; $i < $count; $i++) {
                    $df = $s_files[$i];
                    //var_dump("asd");die();
                    @unlink($_SERVER['DOCUMENT_ROOT'] . $article[$df['name']]);
                    $dbins[$df['name']] = '';
                }
            }
            // END ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //

            $images = $this->images->getByProductId($article['id']);
            if ($images) {
                $icount = count($images);
                for ($ii = 0; $ii < $icount; $ii++) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $images[$ii]['image']))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $images[$ii]['image']);

                    $this->db->where('id', $images[$ii]['id']);
                    $this->db->limit(1);
                    $this->db->delete('images');
                }
            }
        }
        $this->db->where('id', $id)->limit(1)->delete('articles');
        $url = '/admin/articles/';
        if ($this->session->userdata('articlesFrom') !== false)
            $url .= $this->session->userdata('articlesFrom') . '/';
        redirect($url);
    }

    public function active($id)
    {
        $this->ma->setActive($id, 'articles');
        $url = '/admin/articles/';
        if ($this->session->userdata('articlesFrom') !== false)
            $url .= $this->session->userdata('articlesFrom') . '/';
        redirect($url);
    }

    public function up($id)
    {
        $cat = $this->articles->getArticleById($id);
        if (($cat) && $cat['num'] < ($this->articles->getProductsNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->articles->getProductByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('articles', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('articles', $dbins);
            }
        }
        $url = '/admin/articles/';
        if ($this->session->userdata('articlesFrom') !== false)
            $url .= $this->session->userdata('articlesFrom') . '/';
        redirect($url);

    }

    public function down($id)
    {
        $cat = $this->articles->getArticleById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->articles->getProductByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('articles', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('articles', $dbins);
            }
        }
        $url = '/admin/articles/';
        if ($this->session->userdata('articlesFrom') !== false)
            $url .= $this->session->userdata('articlesFrom') . '/';
        redirect($url);
    }

    public function settings_up($id)
    {
        $cat = $this->articles->getSettingById($id);
        if (($cat) && $cat['num'] < ($this->articles->getSettingsNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->articles->getSettingByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('articles_settings', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('articles_settings', $dbins);
            }
        }
        $url = '/admin/articles/settings/';

        redirect($url);

    }

    public function settings_down($id)
    {
        $cat = $this->articles->getSettingById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->articles->getSettingByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('articles_settings', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('articles_settings', $dbins);
            }
        }
        $url = '/admin/articles/settings/';
        redirect($url);
    }

    public function category($id)
    {
        $this->session->set_userdata('category_id', $id);
        redirect("/admin/articles/");
    }

    public function set_category()
    {
        if (isset($_POST['category_id']) && $_POST['category_id'] == 'all')
            $this->session->unset_userdata('category_id');
        else if (isset($_POST['category_id']))
            $this->session->set_userdata('category_id', $_POST['category_id']);
        redirect("/admin/articles/");
    }

    function add_image()
    {
        $image = '';
        if (isset($_POST['image']))
            $image = $_POST['image'];
        if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
            if ($_FILES['userfile']['name'] != '') {
                $imagearr = $this->upload_file();
                $image = '/upload/articles/' . date("Y-m-d") . '/' . $imagearr['file_name'];
            }
        }

        if ($image) {
            $active = 0;
            if (isset($_POST['active']) && $_POST['active'] == true)
                $active = 1;
            $show_in_bottom = 0;
            if (isset($_POST['show_in_bottom']) && $_POST['show_in_bottom'] == true)
                $show_in_bottom = 1;
            $dbins = array(
                'image' => $image,
                'article_id' => $_POST['article_id'],
                'show_in_bottom' => $show_in_bottom,
                'active' => $active
            );

            $this->db->insert('images', $dbins);

            redirect('/admin/articles/edit/' . $_POST['article_id'] . '/#images');
        }
    }

    function upload_file($file = 'userfile')
    {
        // Проверка наличия папки текущей даты. Если нет, то создать
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/', 0777);
        }
        /*
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/', 0777);
        }
        */
        //////
        // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/articles/' . date("Y-m-d");
        $config['allowed_types'] = 'jpg|png|gif|jpe|pdf|doc|docx|xls|xlsx';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;
        $config['overwrite'] = false;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($file)) {
            echo $this->upload->display_errors();
            die();
        } else {
            $ret = $this->upload->data();

            $res = strpos($ret['file_type'], 'image');
            if ($res !== false && $ret['image_type'] != 'png') {
                $width = getOption('article_foto_max_width');
                $height = getOption('article_foto_max_height');
                if (!$width)
                    $width = 200;
                if (!$height)
                    $height = 200;

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
                //copy($ret['full_path'],str_replace('/shop/','/original/',$ret['full_path']));

                // Проверяем нужен ли водяной знак на картинках в статьях
                $article_watermark = getOption('article_watermark');
                if ($article_watermark === false)
                    $article_watermark = 1;
                if ($article_watermark) {
                    // Получаем файл водяного знака
                    $watermark_file = getOption('watermark_file');
                    if ($watermark_file === false)
                        $watermark_file = 'img/logo.png';
                    //
                    // Получаем вертикальную позицию водяного знака
                    $watermark_vertical_alignment = getOption('watermark_vertical_alignment');
                    if ($watermark_vertical_alignment === false)
                        $watermark_vertical_alignment = 'bottom';
                    // Получаем горизонтальную водяного знака
                    $watermark_horizontal_alignment = getOption('watermark_horizontal_alignment');
                    if ($watermark_horizontal_alignment === false)
                        $watermark_horizontal_alignment = 'center';
                    //
                    // Получаем прозрачность водяного знака
                    $watermark_opacity = getOption('watermark_opacity');
                    if ($watermark_opacity === false)
                        $watermark_opacity = '20';
                    //

                    $config['source_image'] = $ret["file_path"] . $ret['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['wm_type'] = 'overlay';
                    $config['wm_opacity'] = $watermark_opacity;
                    $config['wm_overlay_path'] = $watermark_file;
                    $config['wm_hor_alignment'] = $watermark_horizontal_alignment;
                    $config['wm_vrt_alignment'] = $watermark_vertical_alignment;
                    $this->image_lib->initialize($config);
                    $this->image_lib->watermark();
                }
            }

            return $ret;
        }
    }

    function edit_image()
    {
        if (isset($_POST['image_id'])) {
            $image = $this->images->getById($_POST['image_id']);
            if (isset($_POST['delete']) && $_POST['delete'] == true) {
                @unlink($_SERVER['DOCUMENT_ROOT'] . $image['image']);
                $this->db->where('id', $image['id']);
                $this->db->delete('images');
            } else {
                if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
                    if ($_FILES['userfile']['name'] != '') {
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $image['image']);
                        $imagearr = $this->upload_file();
                        $image['image'] = '/upload/articles/' . date("Y-m-d") . '/' . $imagearr['file_name'];
                    }
                }
                $image['active'] = 0;
                if (isset($_POST['active']) && $_POST['active'] == true)
                    $image['active'] = 1;
                $image['show_in_bottom'] = 0;
                if (isset($_POST['show_in_bottom']) && $_POST['show_in_bottom'] == true)
                    $image['show_in_bottom'] = 1;

                $this->db->where('id', $image['id']);
                $this->db->update('images', $image);
            }
            redirect('articles/edit/' . $_POST['shop_id'] . '/#images');
        }
    }

    function backup()
    {
        $this->load->helper('file');
        if (isset($_GET['backup']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/backup/' . $_GET['backup'])) {
            $this->db->query("DROP TABLE articles");
            $sql = file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/upload/backup/' . $_GET['backup']);
            $this->db->query($sql);
        }
        // Загружает класс DB utility
        if (isset($_POST['action']) && $_POST['action'] == 'create') {
            $this->load->dbutil();

            $prefs = array(
                'tables' => array('articles'),  // Array of tables to backup.
                'ignore' => array(),           // List of tables to omit from the backup
                'format' => 'txt',             // gzip, zip, txt
                'filename' => 'upload/backup/' . date("Y-m-d_H-i") . '_mybackup.sql',    // File name — NEEDED ONLY WITH ZIP FILES
                'add_drop' => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert' => TRUE,              // Whether to add INSERT data to backup file
                'newline' => "\n"               // Newline character used in backup file
            );

            // Получает бэкап и пишет его в переменную
            $backup =& $this->dbutil->backup($prefs);

            // Load the file helper and write the file to your server
            write_file('upload/backup/' . date("Y-m-d_H-i") . '_mybackup.sql', $backup);
        }


        $data['files'] = get_filenames('upload/backup/');
        $data['title'] = "Бэкап (резервное копирование)";
        $data['msg'] = '';
        $this->load->view('articles/backup.tpl.php', $data);
    }

    function upload_csv($file = 'userfile', $path = 'upload/csv/')
    {
        // Проверка наличия папки текущей даты. Если нет, то создать
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $path)) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/' . $path, 0777);
        }


        //////
        // Функция загрузки
        $config['upload_path'] = $path;
        $config['overwrite'] = true;
        $config['allowed_types'] = 'csv';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($file)) {
            echo $this->upload->display_errors();
            die();
        } else {
            $ret = $this->upload->data();
            return $ret;
        }
    }

    function importnew()
    {
        $this->load->model('Model_users', 'users');
        $user = $this->users->getUserByLogin(userdata('login'));
        $user_id = 0;
        if (isset($user['id'])) $user_id = $user['id'];
        $msg = '';
        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/import/';
        $file = $user_id . '_importnew.xlsx';

        if (isset($_POST['end_import']) || isset($_GET['end_import'])) {
            if (file_exists($path . $file)) {
                @unlink($path . $file);
                $msg .= '<strong>Импорт отменён!<br />Импортированный файл удалён с сервера.</strong>';
            }
        }

        if (isset($_FILES['userfile'])) {     // проверка, выбран ли файл
            if ($_FILES['userfile']['name'] != '') {
                $imagearr = $this->upload_csv('userfile', 'upload/import');
                $file = $imagearr['file_name'];
                //vdd($imagearr);
                $old_file = $file;
                $ret = rename($_SERVER['DOCUMENT_ROOT'] . '/upload/import/' . $file, $_SERVER['DOCUMENT_ROOT'] . '/upload/import/' . $user_id . '_importnew.xlsx');
                if ($ret) $file = $user_id . '_importnew.xlsx';
                if ($ret)
                    $msg .= 'Файл ' . $old_file . ' загружен на хост и переименован в ' . $path . $file . '<br>';
                else $msg .= 'Возникла проблема с загрузкой файла! Обратитесь к Хомяку!<br />';
            }
            //'vdd($path.$file);
        }

        $data['user_id'] = $user_id;
        $data['msg'] = $msg;
        $data['title'] = "Импорт (новый)";
        $this->load->view('articles/importnew.php', $data);
    }

    function import()
    {

        $msg = '';
        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/csv/';
        $file = 'import.xlsx';
//vdd("zxc");
        if (isset($_POST['end_import']) && isset($_GET['end_import'])) {
            if (file_exists($path . $file)) {
                @unlink($path . $file);
                $msg .= '<strong>Импорт отменён!<br />Импортированный файл удалён с сервера.</strong>';
            }
        }

        if (isset($_FILES['userfile'])) {     // проверка, выбран ли файл
            if ($_FILES['userfile']['name'] != '') {
                $imagearr = $this->upload_csv();
                $file = $imagearr['file_name'];
                $old_file = $file;
                $ret = rename($_SERVER['DOCUMENT_ROOT'] . '/upload/csv/' . $file, $_SERVER['DOCUMENT_ROOT'] . '/upload/csv/import.xlsx');
                if ($ret) $file = 'import.xlsx';
                if ($ret)
                    $msg .= 'Файл ' . $old_file . ' загружен на хост и переименован в ' . $path . $file . '<br>';
                else $msg .= 'Возникла проблема с загрузкой файла! Обратитесь к Хомяку!<br />';
            }
            //'vdd($path.$file);
        }


        if (isset($_GET['question']) && $_GET['question'] == 'finded_name') {
            //$file = 'temp/import.xlsx';
            if (!isset($_POST['action'])) {
                ?>
                <form method="post">
                    <p><strong><?= userdata('import_question') ?></strong></p>
                    <input type="radio" name="action" value="add_id" checked> Да, внести изменения<br/>
                    <!--input type="radio" name="action" value="add_id_all"> Да, внести изменения <b>во все найденные далее</b><br/-->
                    <input type="radio" name="action" value="add_new"> Добавить, как новый<br/>
                    <!--input type="radio" name="action" value="add_new_all"> Добавить, как новый <b>все найденные далее</b><br/-->
                    <input type="submit">
                </form>
                <form action="/admin/articles/import/" method="post">
                    <input type="submit" name="end_import" value="Остановить импорт"/>
                </form>
                <?php
                die();
            }
        }
        if (file_exists($path . $file)) {
            $this->load->helper('translit');
            $filepath = $path . $file;
            //vd($filepath);
            $this->load->library('excel');
            $arr = $this->excel->getExcelArray($filepath);
            // vd($arr);
            $count = count($arr);
            $columns = $arr[0];


            if (isset($_POST['action'])) {
                if ($_POST['action'] == 'add_id') {
                    $arr[1]['id'] = userdata('import_article_id');
                    set_userdata('import_add_id', $arr[1]['id']);
                } elseif ($_POST['action'] == 'add_new')
                    set_userdata('import_add_new', true);

                unset_userdata('import_question');
                unset_userdata('import_finded');
                // redirect('/admin/articles/import/?hash='.getRandCode(),302);
            }
            //vd(userdata('import_add_new'));
            $add_new = userdata('import_add_new');
            unset_userdata('import_add_new');

            //echo "add_new:";
            //vd($add_new);
            //echo '<hr />';

            // Проверяем правильность полей
            $ccount = count($columns);
            for ($i = 0; $i < $ccount; $i++) {
                if ($columns[$i] == '' || $columns[$i] == NULL) unset($columns[$i]);
            }
            //vdd($arr);
            //vdd($columns);
            //vd($arr[0]);
            //vd($count);
            for ($i = 1; $i < $count; $i++) {
                if (userdata('import_start') !== false) {
                    $i = userdata('import_start');
                    unset_userdata('import_start');
                }
//                echo "start:";
//                vd($i);
//                echo '<hr />';
                $dbins = array();
                // перегоняем значения в массив $dbins
                $ccount = count($columns);
//var_dump($arr[1]);die();
                for ($ci = 0; $ci < $ccount; $ci++) {
                    $name = $columns[$ci];
                    $dbins[$name] = $arr[$i][$ci];
                }

                if (userdata('import_add_id') !== false) {
                    $dbins['id'] = userdata('import_add_id');
                    unset_userdata('import_add_id');
                }

                //echo "start:";
                //vd($dbins['id']);
                //echo '<hr />';
                if ($dbins['id'] == '') { // Добавляем новую
                    if (!$add_new) {
                        $search = $this->articles->getArticleByName($dbins['name']);
                        //vdd($search);
                        if ($search) {       // Если в базе найдено такое-же название
                            set_userdata('import_question', 'В базе найдено соответствие по названию: ' . $dbins['name']);
                            set_userdata('import_article_id', $search['id']);
                            //set_userdata('import_finded', $dbins);

//                        $arr = arrayDelRows($arr, 2, $i);
//                        $this->excel->setExcelArray($arr, './upload/temp/import.xlsx');
                            //vdd();
                            //$this->excel->setExcelArray($arr);
                            set_userdata('import_start', $i);
                            redirect('/admin/articles/import/?question=finded_name&hash=' . getRandCode(), 302);
                            die();
                        }
                    }

                    unset($dbins['id']);

                    // Вытаскиваем фото на нащ сервак
                    if ($dbins['image'] != '') {
                        $dbins['image'] = $this->saveImageToUpload($dbins['image'], $dbins['name']);
                        if ($dbins['image'])
                            $msg .= 'Загружено фото: ' . $dbins['name'] . ' - ' . $dbins['image'] . '<br />';
                        else $msg .= '<b style="color:red">Ошибка загрузки фото!</b> ' . $dbins['name'] . '<br />';
                    }

                    $dbins['title'] = $dbins['description'] = $dbins['keywords'] = $dbins['name'];

                    if ($dbins['category_id'] != NULL && $dbins['category_id'] != '') {
                        $cat = $this->model_categories->getCategoryById($dbins['category_id']);
                        $dbins['parent_category_id'] = $cat['parent'];
                        $first = $this->model_categories->getFirstLevelCategory($cat);
                        $dbins['first_category_id'] = $first['id'];

                        $dbins['url'] = translitRuToEn($dbins['name']);
                        $this->db->insert('articles', $dbins);
                        $msg .= $i . ': Добавление новой позиции "' . $dbins['name'] . '" - успешно!<br />';
                    } else {
                        //alert('Ошибка добавления! У ' . $dbins['name'] . ' не указана category_id!');
                        $msg .= $i . ': <strong style="color:red;">Ошибка добавления новой позиции! У ' . $dbins['name'] . ' не указана category_id!</strong><br />';
                    }

                    $add_new = false;
                    //vdd($dbins);
                } else { // изменяем существующую
                    // Вытаскиваем фото на нащ сервак
                    if ($dbins['image'] != '' && substr($dbins['image'], 0, 4) == 'http') {
                        $dbins['image'] = $this->saveImageToUpload($dbins['image'], $dbins['name']);
                        if ($dbins['image'])
                            $msg .= 'Загружено фото: ' . $dbins['name'] . ' - ' . $dbins['image'] . '<br />';
                        else $msg .= '<b style="color:red">Ошибка загрузки фото!</b> ' . $dbins['name'] . '<br />';
                    }
                    if ($dbins['category_id'] != NULL) {
                        $cat = $this->model_categories->getCategoryById($dbins['category_id']);
                        $dbins['parent_category_id'] = $cat['parent'];
                        $first = $this->model_categories->getFirstLevelCategory($cat);
                        $dbins['first_category_id'] = $first['id'];
                    } else $msg .= $i . ': <b style="color:red">Ошибка</b>! Основная категория не присвоена!<br />';
                    $this->db->where('id', $dbins['id']);
                    $this->db->limit(1);
                    $this->db->update('articles', $dbins);
                    $msg .= $i . ': Обновление позиции id=' . $dbins['id'] . ' "' . $dbins['name'] . '" - успешно<br />';
                }

            }
            if (file_exists($filepath)) {
                @unlink($filepath);
                $msg .= '<strong>Импорт успешно завершён!<br />Импортированный файл удалён с сервера.</strong>';
            }
        }

        $data['msg'] = $msg;
        $data['title'] = "Импорт";
        $this->load->view('articles/import', $data);
    }

    function saveImageToUpload($image, $name) // Вытаскиваем фото на нащ сервак
    {
        if ($image != '') {
            $opts = array(
                'http' => array(
                    'protocol_version' => '1.1',
                    'method' => 'GET',
                    'user_agent' => 'prawwwda.com'
                )
            );
            $context = stream_context_create($opts);

            $string = file_get_contents($image, false, $context);
            if ($string) {
                $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/';
                //var_dump($path);die();
                @mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/');
                $ipos = strrpos($image, '/');
                $iname = substr($image, $ipos + 1);
                $rpos = strrpos($iname, '.');
                $razr = substr($iname, $rpos + 1);
                $url = translitRuToEn($name);

                $qpos = strpos($razr, '?');
                if ($qpos !== false) $razr = substr($razr, 0, $qpos);
                $iname = $url . '.' . $razr;

                file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/' . $iname, $string);
                $image = '/upload/articles/' . date("Y-m-d") . '/' . $iname;

                return $image;
            }
        }
        return false;
    }

    public function export()
    {
        $this->load->library('excel');
        $export_rows = getOption('export_rows');
        $export_arr = explode('|', $export_rows);
        $export_rows = str_replace('|', ',', $export_rows);
        $articles = $this->articles->select($export_rows, -1, -1, 1, 'organizations');
        //$columns = getSettings();
        array_unshift($articles, $export_arr);
        //vd($articles);
        $this->excel->setExcelArray($articles);
    }


}