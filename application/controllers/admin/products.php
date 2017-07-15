<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller
{

    private $langs;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_products', 'products');
        $this->load->model('Model_users', 'users');
        $this->load->model('Model_images', 'images');
        $this->load->model('Model_categories', 'categories');
        $this->load->model('Model_filters', 'filters');
        $this->load->helper('admin_helper');
        //$this->load->model('Model_wishlist', 'wishlist');

    }

    public function index($category_id = false)
    {
        $products = false;
        $settings = $this->products->getSettings();
        $fieldtypes = $this->ma->getFirldtypes();

        if (isset($_POST['delete']) && isset($_POST['list'])) {
            $list = $_POST['list'];

            $count = count($list);
            for ($i = 0; $i < $count; $i++) {
                $product = $this->products->getProductById($list[$i]);
                if ($product) {
                    // START ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //
                    $s_files = $this->products->getSettingsByType('Файл');
                    if ($s_files) {
                        $count = count($s_files);
                        for ($i = 0; $i < $count; $i++) {
                            $df = $s_files[$i];
                            //var_dump("asd");die();
                            @unlink($_SERVER['DOCUMENT_ROOT'] . $product[$df['name']]);
                            $dbins[$df['name']] = '';
                        }
                    }
                    // END ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //

                    $images = $this->images->getByProductId($product['id']);
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

                $this->db->where('id', $list[$i]);
                $this->db->limit(1);
                $this->db->delete('products');
            }

            $url = '/admin/products/';
            if ($this->session->userdata('productsFrom') !== false)
                $url .= $this->session->userdata('productsFrom') . '/';
            redirect($url);
        }

        $data['title'] = "Товары";

        if (isset($_POST['search'])) {
            $data['products'] = $this->products->searchByName($_POST['search']);

            $data['pager'] = '';
        } else {
            if ($this->session->userdata('category_id') != null)
                $a = $this->products->getCountProductsInCategory($this->session->userdata('category_id'));
            else
                $a = $this->db->count_all('products');


            // ПАГИНАЦИЯ //
            $this->load->library('pagination');
            $per_page = 35;
            $config['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/products/';
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


            if (($category_id = validate($category_id, 'number')))
                $products = $this->products->getProductsByCategory($category_id, $per_page, $from);
            /*else
            if ($this->session->userdata('category_id'))
                $data['products'] = $this->products->getProductsByCategory($this->session->userdata('category_id'), $per_page, $from);*/
            else
                $products = $this->products->getProducts($per_page, $from);
        }
        $data['type'] = "products";
        $data['articles'] = $products;
        $data['articlesNewNum'] = $this->products->getProductsNewNum();
        $data['categories'] = $this->categories->getCategories(-1, 'products');
        $data['fieldtypes'] = $fieldtypes;
        $data['settings'] = $settings;
        $data['admin_in_table'] = $this->products->getSettingsForAdminTable();
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('products/products.tpl.php', $data);
    }


    function getDbInsFilters()
    {
        if (!empty($_POST['filters']) && is_array($_POST['filters'])) {
            $filter_values = $_POST['filters'];
            //var_dump($filter_values);
            foreach ($filter_values as $name => $arr_val) {
                $dbins['filter_' . $name] = '|';
                for ($i = 0; $i < count($arr_val); $i++) {
                    $dbins['filter_' . $name] .= $arr_val[$i] . '|';
                }
            }
            /*$filter_values = $_POST['filter_values'];
            sort($filter_values); reset($filter_values);
            $txt_filter_val = '';
            for($i = 0; $i < count($filter_values); $i++) {
                $txt_filter_val .= $filter_values[$i].';';
            }
            */
            return $dbins;
        }
    }

    // ФУНКЦИЯ НАПОЛНЕНИЯ МАССИВА ЗНАЧЕНИЯМИ ДЛЯ ДОБАВЛЕНИЯ ИЛИ РЕЛАКТИРОВАНИЯ ТОВАРА
    function getDbins($action, $itemId = false)
    {
        //var_dump($_POST['start_date']);die();
        $settings = $this->products->getSettings();
        $dbins = getDbins($settings, $itemId, 'products', $action);
//        $startDate = post('start_date');
//        $endDate = post('end_date');
//        if($startDate){
//            $sdArr = explode('-', $startDate);
//            if(isset($sdArr[0]) && isset($sdArr[1]) && isset($sdArr[2])){
//                $dbins['start_unix'] = mktime(0,0,0,$sdArr[1],$sdArr[2], $sdArr[0]);
//            }
//        }
//        if($endDate){
//            $sdArr = explode('-', $endDate);
//            if(isset($sdArr[0]) && isset($sdArr[1]) && isset($sdArr[2])){
//                $dbins['end_unix'] = mktime(0,0,0,$sdArr[1],$sdArr[2], $sdArr[0]);
//            }
//        }

        return $dbins;
    }

    public function add()
    {
        $use_translations = getOption('use_translations');      // использовать ли отдельную таблицу для хранения языковых версий
        $userId = false;
        if($use_translations)
            $userId = getUserId();

        // START ** Обработчик добавления товара ** //
        if (isset($_POST['add_product']) || isset($_POST['add_product_and_close'])) {
            //vdd($_POST);
            $dbins = $this->getDbins();
            $dbins['created_by'] = userdata('login');
            $dbins['unix'] = time();
            $dbins['num'] = $this->products->getProductsNewNum();
            if (isset($_POST['brand_id']))
                $dbins['brand_id'] = $_POST['brand_id'];
            //var_dump($dbins);die();
            //$dbins['url_cache'] = getFullUrl($dbins, false);
            $ret = $this->db->insert('products', $dbins);
            if ($ret) {
                $product = $this->products->getLastAddedProduct();
                // Если включена опция хранения языковых версий в отдельной языковой таблице,
                // присваеваем переводам ID статьи
                if(($product) && $use_translations == 1){
                    setTrnslatesItemIds($userId, $product['id'], 'products');
                }

                if (isset($_POST['add_product_and_close']))
                    redirect('/admin/products/');
                else {
                    $product = $this->products->getLastAddedProduct();
                    if ($product)
                        redirect('/admin/products/edit/' . $product['id'] . '/');
                }
            }
        }
        // END** Обработчик добавления товара ** //
        $settings = $this->products->getSettings();
        $fieldtypes = $this->ma->getFirldtypes();
        $sNoLang = $this->products->getSettings(0);
        $sMultiLang = $this->products->getSettings(1);

        $data['action'] = "add_product";
        $data['noLang'] = $sNoLang;
        $data['multiLang'] = $sMultiLang;
        $data['use_translations'] = $use_translations;

        $data['brands'] = $this->products->getBrands();
        $data['action'] = 'add_product';
        $data['title'] = "Добавление товара";
        $data['fieldtypes'] = $fieldtypes;
        $data['settings'] = $settings;
        $data['categories'] = $this->categories->getCategories(1, 'products');

        $data['article_in_many_categories'] = getOption('article_in_many_categories');
        $data['type'] = "products";

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['adding_images'] = $this->load->view('products/adding-images.inc.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('products/product_add_edit.tpl.php', $data);
    }

    public function edit($id)
    {
        $use_translations = getOption('use_translations');      // использовать ли отдельную таблицу для хранения языковых версий
        $userId = false;
        if($use_translations)
            $userId = getUserId();

        $sNoLang = $this->products->getSettings(0);
        $sMultiLang = $this->products->getSettings(1);

        $product = $this->products->getProductById($id);
        // START ** Обработчик редактирования товара ** //
        if (isset($_POST['edit_product']) || isset($_POST['edit_product_and_close'])) {

            $dbins = array();

            $dbins = $this->getDbins($id);
            if (isset($_POST['brand_id']))
                $dbins['brand_id'] = $_POST['brand_id'];
            // START ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //
            $s_files = $this->products->getSettingsByType('Файл');
            if ($s_files) {
                $count = count($s_files);
                for ($i = 0; $i < $count; $i++) {
                    $df = $s_files[$i];

                    if (isset($_POST[$df['name'] . '_del'])) {
                        //var_dump("asd");die();
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $product[$df['name']]);
                        $dbins[$df['name']] = '';
                    }
                }
            }

            // END ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //

            //var_dump($dbins);die();
            if ($product['url'] !== $dbins['url'] || $product['category_id'] !== $dbins['category_id'])
                $dbins['url_cache'] = getFullUrl($dbins, false);

            $this->db->where('id', $id);
            $this->db->limit(1);
            $ret = $this->db->update('products', $dbins);
            if ($ret) {
                if (isset($_POST['edit_product']))
                    redirect('/admin/products/edit/' . $id . '/');
                else
                    redirect('/admin/products/');
            }
        }
        // END** Обработчик редактирования товара ** //


        $data['brands'] = $this->products->getBrands();

        $settings = $this->products->getSettings();
        $fieldtypes = $this->ma->getFirldtypes();

        $data['action'] = "add_product";
        $data['noLang'] = $sNoLang;
        $data['multiLang'] = $sMultiLang;
        $data['article'] = $product;
//        $data['product']['filter_values'] = $this->filters->getProductFiltersValuesId($data['product']['id']);
        $data['action'] = 'edit_product';
        $data['title'] = "Редактирование товара";
        $data['images'] = $this->images->getByProductId($id);
        //var_dump($data['images']);
        $data['fieldtypes'] = $fieldtypes;
        $data['settings'] = $settings;
        $data['categories'] = $this->categories->getCategories(1, 'products');
       // $data['filters'] = $this->filters->getFiltersByCategoryId($data['product']['category_id'], -1, true);
        $data['article_in_many_categories'] = getOption('article_in_many_categories');
        $data['type'] = "products";

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $data['adding_images'] = $this->load->view('products/adding-images.inc.php',$data, true);
        $this->load->view('products/product_add_edit.tpl.php', $data);
    }


    public function settings()
    {

        $settingsNewNum = $this->products->getSettingsNewNum();
        $fieldtypes = $this->ma->getFirldtypes();
        $data = array();

        // START ** Добавление нового поля ** //
        if (isset($_POST['addNewSetting'])) {
            $if_exists = $this->products->getSettingByName($_POST['name']);
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
                $if_column_added = $this->dbforge->add_column('products', $fields);


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
                                $if_column_added = $this->dbforge->add_column('products', $fields);
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
                        'admin_in_table' => $admin_in_table,
                        'access'    => '*'.userdata('type').'*'
                    );

                    $this->db->insert('products_settings', $dbins);

                    redirect($_SERVER['REQUEST_URI']);
                } else $data['msg'] = 'Ошибка создания поля в базе!';
            } else $data['msg'] = 'Поле с таким именем уже существует!';
        }
        // END ** Добавление нового поля ** //

        // START ** Редактирование поля ** //
        if (isset($_POST['saveSetting'])) {
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

            if ($_POST['name'] != $_POST['cur_name']) {
                $setting = $this->products->getSettingByName($_POST['cur_name']);

                $if_column_modified = $this->dbforge->modify_column('products', $fields);

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
                $this->db->update('products_settings', $dbins);

                redirect('/admin/products/settings/');
            }
        }
        // END ** Редактирование поля ** //

        $data['settings'] = $this->products->getSettings();
        $data['type'] = "products";
        $data['title'] = "Настройки полей товаров";
        $data['fieldtypes'] = $fieldtypes;
        $data['settingsNewNum'] = $settingsNewNum;
        $data['settingsType'] = 'products';
        $data['settingsName'] = 'Товары';

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('common/settings.tpl.php', $data);
    }

    public function settings_del($name)
    {
        $setting = $this->products->getSettingByName($name);
        if ($setting['not_edited'] != 1) {
            $this->load->dbforge();
            $this->dbforge->drop_column('products', $name);

            $this->db->where('name', $name)->limit(1)->delete('products_settings');
        }

        redirect('/admin/products/settings/');
    }

    public function del($id)
    {
        $product = $this->products->getProductById($id);

        if ($product) {
            $dbins = array();

            // START ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //
            $s_files = $this->products->getSettingsByType('Файл');
            if ($s_files) {
                $count = count($s_files);
                for ($i = 0; $i < $count; $i++) {
                    $df = $s_files[$i];
                    //var_dump("asd");die();
                    @unlink($_SERVER['DOCUMENT_ROOT'] . $product[$df['name']]);
                    $dbins[$df['name']] = '';
                }
            }
            // END ** УДАЛЕНИЕ НЕНУЖНЫХ ЗАГРУЖЕННЫХ РАНЕЕ ФАЙЛОВ ** //

            $images = $this->images->getByProductId($product['id']);
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
        $this->filters->removeValuesFromProduct($id);
        $this->db->where('id', $id)->limit(1)->delete('products');
        $url = '/admin/products/';
        if ($this->session->userdata('productsFrom') !== false)
            $url .= $this->session->userdata('productsFrom') . '/';
        redirect($url);
    }

    public function active($id)
    {
        $this->ma->setActive($id, 'products');
        $url = '/admin/products/';
        if ($this->session->userdata('productsFrom') !== false)
            $url .= $this->session->userdata('productsFrom') . '/';
        redirect($url);
    }

    public function up($id)
    {
        $cat = $this->products->getProductById($id);
        if (($cat) && $cat['num'] < ($this->products->getProductsNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->products->getProductByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('products', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('products', $dbins);
            }
        }
        $url = '/admin/products/';
        if ($this->session->userdata('productsFrom') !== false)
            $url .= $this->session->userdata('productsFrom') . '/';
        redirect($url);

    }

    public function down($id)
    {
        $cat = $this->products->getProductById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->products->getProductByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('products', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('products', $dbins);
            }
        }
        $url = '/admin/products/';
        if ($this->session->userdata('productsFrom') !== false)
            $url .= $this->session->userdata('productsFrom') . '/';
        redirect($url);
    }

    public function settings_up($id)
    {
        $cat = $this->products->getSettingById($id);
        if (($cat) && $cat['num'] < ($this->products->getSettingsNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->products->getSettingByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('products_settings', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('products_settings', $dbins);
            }
        }
        $url = '/admin/products/settings/';

        redirect($url);

    }

    public function settings_down($id)
    {
        $cat = $this->products->getSettingById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->products->getSettingByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('products_settings', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('products_settings', $dbins);
            }
        }
        $url = '/admin/products/settings/';
        redirect($url);
    }

    public function category($id)
    {
        $this->session->set_userdata('category_id', $id);
        redirect("/admin/products/");
    }

    public function set_category()
    {
        if (isset($_POST['category_id']) && $_POST['category_id'] == 'all')
            $this->session->unset_userdata('category_id');
        else if (isset($_POST['category_id']))
            $this->session->set_userdata('category_id', $_POST['category_id']);
        redirect("/admin/products/");
    }

    function add_image()
    {
        $image = '';
        if (isset($_POST['image']))
            $image = $_POST['image'];
        if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
            if ($_FILES['userfile']['name'] != '') {
                $imagearr = $this->upload_file();
                $image = '/upload/products/' . date("Y-m-d") . '/' . $imagearr['file_name'];
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
                'product_id' => $_POST['product_id'],
                'show_in_bottom' => $show_in_bottom,
                'active' => $active
            );

            $this->db->insert('images', $dbins);
        }
        redirect('/admin/products/edit/' . $_POST['product_id'] . '/#images');
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
                        $imagearr = $this->upload_foto();
                        $image['image'] = '/upload/products/' . date("Y-m-d") . '/' . $imagearr['file_name'];
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
            redirect('/admin/products/edit/' . $_POST['shop_id'] . '/#images');
        }
    }

    function upload_file($file = 'userfile')
    {
        // Проверка наличия папки текущей даты. Если нет, то создать
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/products/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/products/' . date("Y-m-d") . '/', 0777);
        }
        /*
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/', 0777);
        }
        */
        //////
        // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/products/' . date("Y-m-d");
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
            if ($res !== false) {
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

}