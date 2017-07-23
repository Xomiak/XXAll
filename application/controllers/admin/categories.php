<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_categories', 'mcats');
        $this->load->model('Model_filters', 'filters');
        beforeOutput();
    }

    function upload_foto()
    { // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/categories';
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
            $ret = $this->upload->data();
            return $ret;
        }
    }

    public function index()
    {
        $type = false;
        if(isset($_GET['type']))
            $type = $_GET['type'];

        $cats = $this->mcats->getCategories(-1, $type);
        $data['title'] = "Разделы";
        $data['type'] = 'categories';
        $data['categories'] = $cats;

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('categories/categories', $data);
    }

    public function add()
    {
        $err = '';
        $langs = array();
        $languages = $this->model_languages->getLanguages();
        $default_lang = $this->model_languages->getDefaultLanguage();
        if ($default_lang) $default_lang = $default_lang['code'];
        for ($i = 0; $i < count($languages); $i++) {
            $langs[$i] = $languages[$i]['code'];
        }

        if (post('action') == 'add') {
            $_POST['name_'.$default_lang] = trim($_POST['name_'.$default_lang]);
            $dbins = array();

            $dbins['name'] = $_POST['name_'.$default_lang ];
            $dbins['title'] = $_POST['title_'.$default_lang];
            $dbins['description'] = $_POST['description_'.$default_lang];
            $dbins['keywords'] = $_POST['keywords_'.$default_lang];
            $dbins['short_content'] = $_POST['short_content_'.$default_lang];
            $dbins['seo'] = $_POST['seo_'.$default_lang];

            for ($i = 0; $i < count($langs); $i++) {
                $lang = $langs[$i];
                //if (isset($_POST['name_'.$lang]) && $_POST['name_'.$lang] != '') {
                        $dbins['name_' . $lang] = $_POST['name_'.$lang ];
                        $dbins['title_' . $lang] = $_POST['title_'.$lang];
                        $dbins['description_' . $lang] = $_POST['description_'.$lang];
                        $dbins['keywords_' . $lang] = $_POST['keywords_'.$lang];
                        $dbins['short_content_' . $lang] = $_POST['short_content_'.$lang];
                        $dbins['seo_' . $lang] = $_POST['seo_'.$lang];

                //}
            }

            $first_in_names = $_POST['name_'.$default_lang];

            if ($_POST['url'] == '') {
                $this->load->helper('translit_helper');
                $dbins['url'] = translitRuToEn((isset($first_in_names) && !empty($first_in_names)) ? $first_in_names : '');
                while ($this->mcats->getCategoryByUrl($dbins['url'])) {
                    $dbins['url'] .= "_1";
                }
            } else {
                $dbins['url'] = $_POST['url'];
            }


            $dbins['active'] = 0;
            if (isset($_POST['active']) && $_POST['active'] == true)
                $dbins['active'] = 1;

            $dbins['slider'] = 0;
            if (isset($_POST['slider']) && $_POST['slider'] == true)
                $dbins['slider'] = 1;

            $dbins['image'] = '';
            if (isset($_POST['image']))
                $dbins['image'] = $_POST['image'];
            if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
                if ($_FILES['userfile']['name'] != '') {
                    //$imagearr = $this->upload_foto();
                    $config = array(
                        'type' => 'categories',
                        'dontResize'    => true
                    );
                    $imagearr = uploadFile($config);
                    $dbins['image'] = $imagearr['file_url'];
                }

            }

            $dbins['show_in_menu'] = 0;
            if (isset($_POST['show_in_menu']) && $_POST['show_in_menu'] == true)
                $dbins['show_in_menu'] = 1;

            $type = post('type');
            if(!$type) $type = 'articles';

            $dbins['num']               = $_POST['num'];
            $dbins['icon_class']        = post('icon_class');
            $dbins['parent']            = $_POST['parent'];
            $dbins['template']          = $_POST['template'];
            $dbins['content_template']  = $_POST['content_template'];
            $dbins['type']              = $type;

  //          vdd($dbins);

            $this->db->insert('categories', $dbins);

            set_userdata('template', $_POST['template']);
            set_userdata('content_template', $_POST['content_template']);

            $this->session->set_userdata('addCategoryParent', $_POST['parent']);
            $this->session->set_userdata('addCategoryTemplate', $_POST['template']);
            redirect("/admin/categories/");

        }
        $data['title'] = "Добавление раздела";
        $data['err'] = $err;
        $data['type'] = 'categories';
        $data['num'] = $this->mcats->getNewNum();
        $data['filters'] = $this->filters->getFilters();
        $data['categories'] = $this->mcats->getCategories();
        $data['action'] = 'add';

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('categories/categories_add_edit', $data);
    }

    public function edit($id)
    {
        $err = '';
        $cat = $this->mcats->getCategoryById($id);
        $langs = array();
        $languages = $this->model_languages->getLanguages();
        $default_lang = $this->model_languages->getDefaultLanguage();
        if ($default_lang) $default_lang = $default_lang['code'];
        for ($i = 0; $i < count($languages); $i++) {
            $langs[$i] = $languages[$i]['code'];
        }

        if (post('action') == 'edit') {
            $dbins = array();
            $dbins['name'] = $_POST['name_'.$default_lang ];
            $dbins['title'] = $_POST['title_'.$default_lang];
            $dbins['description'] = $_POST['description_'.$default_lang];
            $dbins['keywords'] = $_POST['keywords_'.$default_lang];
            $dbins['short_content'] = $_POST['short_content_'.$default_lang];
            $dbins['seo'] = $_POST['seo_'.$default_lang];

            for ($i = 0; $i < count($langs); $i++) {
                $lang = $langs[$i];
                //if (isset($_POST['name_'.$lang]) && $_POST['name_'.$lang] != '') {
                        $dbins['name_' . $lang]    = $_POST['name_'.$lang];
                        $dbins['title_' . $lang]    = $_POST['title_'.$lang];
                        $dbins['description_' . $lang]    = $_POST['description_'.$lang];
                        $dbins['keywords_' . $lang]    = $_POST['keywords_'.$lang];
                        $dbins['short_content_' . $lang]    = $_POST['short_content_'.$lang];
                        $dbins['seo_' . $lang]    = $_POST['seo_'.$lang];
                //}
            }

            $first_in_names = $_POST['name_'.$default_lang];
//vdd($dbins);
            if ($_POST['url'] == '') {
                $this->load->helper('translit_helper');
                $dbins['url'] = translitRuToEn((isset($first_in_names) && !empty($first_in_names)) ? $first_in_names : '');
                while ($this->mcats->getCategoryByUrl($dbins['url'])) {
                    $dbins['url'] .= "_1";
                }
            } else {
                $dbins['url'] = $_POST['url'];
            }


            $dbins['active'] = 0;
            if (isset($_POST['active']) && $_POST['active'] == true)
                $dbins['active'] = 1;

            $dbins['slider'] = 0;
            if (isset($_POST['slider']) && $_POST['slider'] == true)
                $dbins['slider'] = 1;

            $dbins['image'] = '';
            if (isset($_POST['image']))
                $dbins['image'] = $_POST['image'];
            if (isset($_POST['image_del']) && $_POST['image_del'] == true) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $image))
                    unlink($_SERVER['DOCUMENT_ROOT'] . $image);
                $dbins['image'] = '';
            }
            if (isset($_FILES['image'])) { // проверка, выбран ли файл картинки
                if ($_FILES['image']['name'] != '') {
                    /** удаляем старый файл, если он есть */
                    if ($dbins['image'] != '') {
                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $image))
                            unlink($_SERVER['DOCUMENT_ROOT'] . $image);
                    }

                    $watermark = false;
                    if(getOption('categories_watermark') == 1)
                        $watermark = true;
                    $config = array(
                        'file' => 'image',
                        'type' => 'categories',
                        'dontResize'    => true,
                        'name'  => $cat['url'],
                        'watermark' => $watermark
                    );
                    $imagearr = uploadFile($config);
                    $dbins['image'] = $imagearr['file_url'];
                    //var_dump($imagearr); die();
                }
            }

            $dbins['show_in_menu'] = 0;
            if (isset($_POST['show_in_menu']) && $_POST['show_in_menu'] == true)
                $dbins['show_in_menu'] = 1;

            $dbins['icon_class']        = post('icon_class');
            $dbins['num']               = $_POST['num'];
            $dbins['parent']            = $_POST['parent'];
            $dbins['template']          = $_POST['template'];
            $dbins['content_template']  = $_POST['content_template'];
            $dbins['type']              = $_POST['type'];
            $dbins['class']             = $_POST['class'];

            //set_userdata('template', $_POST['template']);
            //set_userdata('content_template', $_POST['content_template']);

            $this->db->where('id', $id);
            $this->db->limit(1);
            $this->db->update('categories', $dbins);
            redirect("/admin/categories/");
        }

        $data['type'] = 'categories';
        $data['cat'] = $cat;
        $data['category'] = $cat;
        $data['title'] = "Редактирование раздела";
        $data['err'] = $err;
        $data['num'] = $this->mcats->getNewNum();
        $data['filters'] = $this->filters->getFilters();
        $data['categories'] = $this->mcats->getCategories();
        $data['cat']['filters'] = $this->filters->getFiltersByCategoryId($data['cat']['id'], array('id'));
        $data['action'] = 'edit';

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('categories/categories_add_edit', $data);
    }

    public function up($id)
    {
        $cat = $this->mcats->getCategoryById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->mcats->getCategoryByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('categories', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('categories', $dbins);
            }
        }
        redirect('/admin/categories/');
    }

    public function down($id)
    {
        $cat = $this->mcats->getCategoryById($id);
        if (($cat) && $cat['num'] < ($this->mcats->getNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->mcats->getCategoryByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('categories', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('categories', $dbins);
            }
        }
        redirect('/admin/categories/');
    }

    public function del($id)
    {
        $this->filters->deleteAllValuesFromProduct($id);
        $this->filters->removeFiltersFromCategory($id);
        $this->db->where('id', $id)->limit(1)->delete('categories');
        redirect("/admin/categories/");
    }

    public function active($id)
    {
        $this->ma->setActive($id, 'categories');
        redirect('/admin/categories/');
    }

}
