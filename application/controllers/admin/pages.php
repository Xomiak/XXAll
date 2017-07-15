<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_pages', 'mp');
    }

    function upload_foto($name = 'image') {        // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/pages';
        $config['allowed_types'] = 'jpg|png|gif|jpe';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;
        $config['overwrite'] = false;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($name)) {
            echo $this->upload->display_errors();
            die();
        } else {
            $ret = $this->upload->data();
            return $ret;
        }
    }

    function upload_file($page_id) {        // Функция загрузки и обработки фото
        if (!file_exists('upload/files/' . $page_id))
            mkdir('upload/files/' . $page_id, 0777);
        $config['upload_path'] = 'upload/files/' . $page_id;
        $config['allowed_types'] = 'jpg|png|gif|jpe|zip|rar|doc|docx|xls|xlsx';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = false;
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

    public function index() {
        $data['title'] = "Статические страницы";
        $data['type'] = "pages";
        $data['pages'] = $this->mp->getPages();
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('pages/pages', $data);
    }

    public function add() {
        $err = '';

        $langs = array();
        $languages = $this->model_languages->getLanguages();
        $default_lang = $this->model_languages->getDefaultLanguage();
        if ($default_lang) $default_lang = $default_lang['code'];
        for ($i = 0; $i < count($languages); $i++) {
            $langs[$i] = $languages[$i]['code'];
        }
        if (post('action') == 'add') {
            $dbins = array();

            for ($i = 0; $i < count($langs); $i++) {
                $lang = $langs[$i];
                if($lang == $default_lang) $dbins['name'] = post('name_'.$default_lang);
                elseif(isset($_POST['name_'.$lang])) $dbins['name_'.$lang] = post('name_'.$lang);

                if($lang == $default_lang) $dbins['content'] = post('content_'.$default_lang);
                elseif(isset($_POST['content_'.$lang])) $dbins['content_'.$lang] = post('content_'.$lang);

                if($lang == $default_lang) $dbins['title'] = post('title_'.$default_lang);
                elseif(isset($_POST['title_'.$lang])) $dbins['title_'.$lang] = post('title_'.$lang);

                if($lang == $default_lang) $dbins['keywords'] = post('keywords_'.$default_lang);
                elseif(isset($_POST['keywords_'.$lang])) $dbins['keywords_'.$lang] = post('keywords_'.$lang);

                if($lang == $default_lang) $dbins['description'] = post('description_'.$default_lang);
                elseif(isset($_POST['description_'.$lang])) $dbins['description_'.$lang] = post('description_'.$lang);

                if($lang == $default_lang) $dbins['seo'] = post('seo_'.$default_lang);
                elseif(isset($_POST['seo_'.$lang])) $dbins['seo_'.$lang] = post('seo_'.$lang);
            }

            // Проверяем урл на оригинальность
            $dbins['url'] = createUrl(post('url'));

            $dbins['active'] = 0;
            if (isset($_POST['active']) && $_POST['active'] == true)
                $dbins['active'] = 1;

            $dbins['social_buttons'] = 0;
            if (isset($_POST['social_buttons']) && $_POST['social_buttons'] == true)
                $dbins['social_buttons'] = 1;

            $dbins['image'] = '';
            if (isset($_POST['image']))
                $dbins['image'] = $_POST['image'];
            if (isset($_FILES['image'])) { // проверка, выбран ли файл картинки
                if ($_FILES['image']['name'] != '') {
                    $imagearr = $this->upload_foto();
                    $dbins['image'] = '/upload/pages/' . $imagearr['file_name'];
                }
            }
            $dbins['template']          = $_POST['template'];
            //$dbins['content_template']  = $_POST['content_template'];

            $this->db->insert('pages', $dbins);

            if (isset($_POST['add_and_close']))
                redirect("/admin/pages/");
            else {
                $this->db->where('url',$dbins['url']);
                $this->db->limit(1);
                $ret = $this->db->get('pages')->result_array();
                if(isset($ret[0]['id'])) redirect('/admin/pages/edit/'.$ret[0]['id'].'/');
            }
            redirect("/admin/pages/");
        }

        $data['type'] = "pages";
        $data['action'] = 'add';
        $data['title'] = "Добавление страницы";
        $data['err'] = $err;
        $data['num'] = $this->mp->getNewNum();
        $data['pages'] = $this->mp->getPages();
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('pages/pages_add_edit', $data);
    }

    public function edit($id) {
        $err = '';
        $page = $this->mp->getPageById($id);

        $langs = array();
        $languages = $this->model_languages->getLanguages();
        $default_lang = $this->model_languages->getDefaultLanguage();
        if ($default_lang) $default_lang = $default_lang['code'];
        for ($i = 0; $i < count($languages); $i++) {
            $langs[$i] = $languages[$i]['code'];
        }

        if (post('action') == 'edit') {
            $dbins = array();

            for ($i = 0; $i < count($langs); $i++) {
                $lang = $langs[$i];
                if($lang == $default_lang) $dbins['name'] = post('name_'.$default_lang);
                elseif(isset($_POST['name_'.$lang])) $dbins['name_'.$lang] = post('name_'.$lang);

                if($lang == $default_lang) $dbins['content'] = post('content_'.$default_lang);
                elseif(isset($_POST['content_'.$lang])) $dbins['content_'.$lang] = post('content_'.$lang);

                if($lang == $default_lang) $dbins['title'] = post('title_'.$default_lang);
                elseif(isset($_POST['title_'.$lang])) $dbins['title_'.$lang] = post('title_'.$lang);

                if($lang == $default_lang) $dbins['keywords'] = post('keywords_'.$default_lang);
                elseif(isset($_POST['keywords_'.$lang])) $dbins['keywords_'.$lang] = post('keywords_'.$lang);

                if($lang == $default_lang) $dbins['description'] = post('description_'.$default_lang);
                elseif(isset($_POST['description_'.$lang])) $dbins['description_'.$lang] = post('description_'.$lang);

                if($lang == $default_lang) $dbins['seo'] = post('seo_'.$default_lang);
                elseif(isset($_POST['seo_'.$lang])) $dbins['seo_'.$lang] = post('seo_'.$lang);
            }

            // Проверяем урл на оригинальность
            $config = array(
                'type'  => 'pages',
                'my_id' => $id
            );

            $dbins['url'] = createUrl(post('url'),$config);

            $dbins['template'] = post('template');
            $dbins['num'] = post('num');

            $dbins['active'] = 0;
            if (isset($_POST['active']) && $_POST['active'] == true)
                $dbins['active'] = 1;

            $dbins['social_buttons'] = 0;
            if (isset($_POST['social_buttons']) && $_POST['social_buttons'] == true)
                $dbins['social_buttons'] = 1;

            $dbins['image'] = '';
            if (isset($_POST['image']))
                $dbins['image'] = $_POST['image'];

            // удаляем картинку
            if(isset($_POST['image_del'])){
                @unlink($_SERVER['DOCUMENT_ROOT'].$dbins['image']);
                $dbins['image'] = '';
            }

            if (isset($_FILES['image'])) { // проверка, выбран ли файл картинки
                if ($_FILES['image']['name'] != '') {
                    $imagearr = $this->upload_foto();
                    $dbins['image'] = '/upload/pages/' . $imagearr['file_name'];
                }
            }
            $dbins['image'] = str_replace('//'.$_SERVER['SERVER_NAME'],'',$dbins['image']);
            $dbins['template']          = $_POST['template'];
            //$dbins['content_template']  = $_POST['content_template'];

            $this->db->where('id', $id);
            $this->db->limit(1);
            $this->db->update('pages', $dbins);
            if (isset($_POST['edit_and_close']))
                redirect("/admin/pages/");
            else
                redirect($_SERVER['REQUEST_URI']);
        }

        $data['type'] = "pages";
        $data['action'] = 'edit';
        $data['page'] = $page;
        $data['title'] = "Редактирование страницы";
        $data['err'] = $err;
        $data['num'] = $this->mp->getNewNum();
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('pages/pages_add_edit', $data);
    }

    public function up($id) {
        $cat = $this->mp->getPageById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->mp->getPageByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('pages', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('pages', $dbins);
            }
        }
        redirect('/admin/pages/');
    }

    public function down($id) {
        $cat = $this->mp->getPageById($id);
        if (($cat) && $cat['num'] < ($this->mp->getNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->mp->getPageByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('pages', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('pages', $dbins);
            }
        }
        redirect('/admin/pages/');
    }

    public function del($id) {
        $this->db->where('id', $id)->limit(1)->delete('pages');
        redirect("/admin/pages/");
    }

    public function active($id) {
        $this->ma->setActive($id, 'pages');
        redirect('/admin/pages/');
    }

}
