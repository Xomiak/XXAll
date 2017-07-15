<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shop extends CI_Controller {

    private $langs;

    public function __construct() {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_shop', 'mshop');
        $this->load->model('Model_brands', 'brands');
        $this->load->model('Model_categories', 'mcats');
        $this->load->model('Model_options', 'options');
        $this->load->model('Model_users', 'users');
        $this->load->model('Model_images', 'images');
    }

    function upload_foto() {
        // Проверка наличия папки текущей даты. Если нет, то создать
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/shop/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/shop/' . date("Y-m-d") . '/', 0777);
        }
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/', 0777);
        }

        //////
        // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/shop/' . date("Y-m-d");
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

            $width = $this->options->getOption('article_foto_max_width');
            $height = $this->options->getOption('article_foto_max_height');
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
            $config['width'] = 2000;
            $config['height'] = 2500;
            $config['source_image'] = $ret["file_path"] . $ret['file_name'];
            $config['new_image'] = $ret["file_path"] . $ret['file_name'];
            $config['thumb_marker'] = '';
            //$this->image_lib->initialize($config);
            //$this->image_lib->resize();
            //copy($ret['full_path'],str_replace('/shop/','/original/',$ret['full_path']));
            /*
              // Проверяем нужен ли водяной знак на картинках в статьях
              $article_watermark = $this->options->getOption('article_watermark');
              if($article_watermark === false) $article_watermark = 1;
              if($article_watermark)
              {
              // Получаем файл водяного знака
              $watermark_file = $this->options->getOption('watermark_file');
              if($watermark_file === false) $watermark_file = 'img/logo.png';
              //
              // Получаем вертикальную позицию водяного знака
              $watermark_vertical_alignment = $this->options->getOption('watermark_vertical_alignment');
              if($watermark_vertical_alignment === false) $watermark_vertical_alignment = 'bottom';
              // Получаем горизонтальную водяного знака
              $watermark_horizontal_alignment = $this->options->getOption('watermark_horizontal_alignment');
              if($watermark_horizontal_alignment === false) $watermark_horizontal_alignment = 'center';
              //
              // Получаем прозрачность водяного знака
              $watermark_opacity = $this->options->getOption('watermark_opacity');
              if($watermark_opacity === false) $watermark_opacity = '20';
              //

              $config['source_image'] 	= $ret["file_path"].$ret['file_name'];
              $config['create_thumb'] 	= FALSE;
              $config['wm_type'] 		= 'overlay';
              $config['wm_opacity']	= $watermark_opacity;
              $config['wm_overlay_path'] 	= $watermark_file;
              $config['wm_hor_alignment'] 	= $watermark_horizontal_alignment;
              $config['wm_vrt_alignment'] 	= $watermark_vertical_alignment;
              $this->image_lib->initialize($config);
              $this->image_lib->watermark();
              }
             */


            return $ret;
        }
    }

    function upload_thumb_foto($file) {
        // Проверка наличия папки текущей даты. Если нет, то создать
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/shop/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/shop/' . date("Y-m-d") . '/', 0777);
        }
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/', 0777);
        }

        //////
        // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/shop/' . date("Y-m-d");
        $config['allowed_types'] = 'jpg|png|gif|jpe';
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

            $width = $this->options->getOption('main_image_width');
            $height = $this->options->getOption('main_image_height');
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

            copy($ret['full_path'], str_replace('/shop/', '/original/', $ret['full_path']));

            // Проверяем нужен ли водяной знак на картинках в статьях
            $article_watermark = $this->options->getOption('article_watermark');
            if ($article_watermark === false)
                $article_watermark = 1;
            if ($article_watermark) {
                // Получаем файл водяного знака
                $watermark_file = $this->options->getOption('watermark_file');
                if ($watermark_file === false)
                    $watermark_file = 'img/logo.png';
                //
                // Получаем вертикальную позицию водяного знака
                $watermark_vertical_alignment = $this->options->getOption('watermark_vertical_alignment');
                if ($watermark_vertical_alignment === false)
                    $watermark_vertical_alignment = 'bottom';
                // Получаем горизонтальную водяного знака
                $watermark_horizontal_alignment = $this->options->getOption('watermark_horizontal_alignment');
                if ($watermark_horizontal_alignment === false)
                    $watermark_horizontal_alignment = 'center';
                //			   
                // Получаем прозрачность водяного знака
                $watermark_opacity = $this->options->getOption('watermark_opacity');
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



            return $ret;
        }
    }

    function upload_image_in_category($file) {
        // Проверка наличия папки текущей даты. Если нет, то создать
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/shop/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/shop/' . date("Y-m-d") . '/', 0777);
        }
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/', 0777);
        }

        //////
        // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/shop/' . date("Y-m-d");
        $config['allowed_types'] = 'jpg|png|gif|jpe';
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

            $width = $this->options->getOption('image_in_category_width');
            $height = $this->options->getOption('image_in_category_height');
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

            copy($ret['full_path'], str_replace('/shop/', '/original/', $ret['full_path']));

            // Проверяем нужен ли водяной знак на картинках в статьях
            $articles_watermark = $this->options->getOption('article_watermark');
            if ($article_watermark === false)
                $article_watermark = 1;
            if ($article_watermark) {
                // Получаем файл водяного знака
                $watermark_file = $this->options->getOption('watermark_file');
                if ($watermark_file === false)
                    $watermark_file = 'img/logo.png';
                //
                // Получаем вертикальную позицию водяного знака
                $watermark_vertical_alignment = $this->options->getOption('watermark_vertical_alignment');
                if ($watermark_vertical_alignment === false)
                    $watermark_vertical_alignment = 'bottom';
                // Получаем горизонтальную водяного знака
                $watermark_horizontal_alignment = $this->options->getOption('watermark_horizontal_alignment');
                if ($watermark_horizontal_alignment === false)
                    $watermark_horizontal_alignment = 'center';
                //			   
                // Получаем прозрачность водяного знака
                $watermark_opacity = $this->options->getOption('watermark_opacity');
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



            return $ret;
        }
    }

    function add_image() {
        $image = '';
        if (isset($_POST['image']))
            $image = $_POST['image'];
        if (isset($_FILES['userfile'])) {     // проверка, выбран ли файл картинки 
            if ($_FILES['userfile']['name'] != '') {
                $imagearr = $this->upload_foto();
                $image = '/upload/shop/' . date("Y-m-d") . '/' . $imagearr['file_name'];
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
                'shop_id' => $_POST['shop_id'],
                'show_in_bottom' => $show_in_bottom,
                'active' => $active
            );

            $this->db->insert('images', $dbins);

            redirect('/admin/shop/edit/' . $_POST['shop_id'] . '/#images');
        }
    }

    function edit_image() {
        if (isset($_POST['image_id'])) {
            $image = $this->images->getById($_POST['image_id']);
            if (isset($_POST['delete']) && $_POST['delete'] == true) {
                @unlink($_SERVER['DOCUMENT_ROOT'] . $image['image']);
                $this->db->where('id', $image['id']);
                $this->db->delete('images');
            } else {
                if (isset($_FILES['userfile'])) {     // проверка, выбран ли файл картинки 
                    if ($_FILES['userfile']['name'] != '') {
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $image['image']);
                        $imagearr = $this->upload_foto();
                        $image['image'] = '/upload/shop/' . date("Y-m-d") . '/' . $imagearr['file_name'];
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
            redirect('/admin/shop/edit/' . $_POST['shop_id'] . '/#images');
        }
    }

    public function index() {
        if (isset($_POST['delete']) && isset($_POST['list'])) {
            $list = $_POST['list'];
            $count = count($list);
            for ($i = 0; $i < $count; $i++) {
                $article = $this->mshop->getArticleById($list[$i]);
                if ($article) {
                    if ($article['image'] != '') {
                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $article['image']))
                            unlink($_SERVER['DOCUMENT_ROOT'] . $article['image']);
                    }

                    $images = $this->images->getByShopId($article['id']);
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
                $this->db->delete('shop');
            }

            $url = '/admin/shop/';
            if ($this->session->userdata('shopFrom') !== false)
                $url .= $this->session->userdata('shopFrom') . '/';
            redirect($url);
        }

        $data['title'] = "Товары";

        if (isset($_POST['search'])) {
            $data['shop'] = $this->mshop->search($_POST['search']);

            $data['pager'] = '';
        } else {
            if ($this->session->userdata('category_id') != null)
                $a = $this->mshop->getCountArticlesInCategory($this->session->userdata('category_id'));
            else
                $a = $this->db->count_all('shop');


            // ПАГИНАЦИЯ //
            $this->load->library('pagination');
            $per_page = 35;
            $config['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/shop/';
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
                $this->session->set_userdata('shopFrom', $from);
            else
                $this->session->unset_userdata('shopFrom');
            //////////

            if ($this->session->userdata('category_id') != null)
                $data['shop'] = $this->mshop->getArticlesByCategory($this->session->userdata('category_id'), $per_page, $from);
            else
                $data['shop'] = $this->mshop->getArticles($per_page, $from);
        }
        $data['categories'] = $this->mcats->getCategories(-1, 'shop');
        $this->load->view('Shop.php', $data);
    }

    public function set_category() {
        if (isset($_POST['category_id']) && $_POST['category_id'] == 'all')
            $this->session->unset_userdata('category_id');
        else if (isset($_POST['category_id']))
            $this->session->set_userdata('category_id', $_POST['category_id']);
        redirect("/admin/shop/");
    }

    public function category($id) {
        $this->session->set_userdata('category_id', $id);
        redirect("/admin/shop/");
    }

    public function add() {
        $langs = $this->getLangs();
        $err = '';
        for ($i = 0; $i < count($langs); $i++) {
            if (isset($_POST[$langs[$i] . '_name']) && $_POST[$langs[$i] . '_name'] != '') {
                $names[$langs[$i]] = $_POST[$langs[$i] . '_name'];

                $h1s[$langs[$i]] = $_POST[$langs[$i] . '_name'];
                $titles[$langs[$i]] = $_POST[$langs[$i] . '_name'];
                $keywords[$langs[$i]] = $_POST[$langs[$i] . '_name'];
                $descriptions[$langs[$i]] = $_POST[$langs[$i] . '_name'];
            }
        }
        if (isset($names)) {
            $this->load->helper('translit_helper');
            reset($names);
            $first_is_name = current($names);
            $url = translitRuToEn(( isset($first_is_name) && !empty($first_is_name) )? $first_is_name : '');
            $active = 0;
            if (isset($_POST['active']) && $_POST['active'] == true)
                $active = 1;
            $in_warehouse = 0;
            if (isset($_POST['in_warehouse']) && $_POST['in_warehouse'] == true)
                $in_warehouse = 1;
            $novelty = 0;
            if (isset($_POST['novelty']) && $_POST['novelty'] == true)
                $novelty = 1;


            $category_id = '';
            $cat_ids = $_POST['category_id'];
            $ccount = count($cat_ids);
            for ($i = 0; $i < $ccount; $i++) {
                $category_id .= $cat_ids[$i];
                if (($i + 1) < $ccount)
                    $category_id .= '*';
            }

            $brand_id = '';
            $cat_ids = $_POST['brand_id'];
            $ccount = count($cat_ids);
            for ($i = 0; $i < $ccount; $i++) {
                $brand_id .= $cat_ids[$i];
                if (($i + 1) < $ccount)
                    $brand_id .= '*';
            }

            $parent_category_id = 0;
            $parent_category = $this->mcats->getCategoryById($category_id);
            if (isset($parent_category['parent']))
                $parent_category_id = $parent_category['parent'];

            $youtube = '';
            if ($youtube == '')
                $youtube = $_POST['youtube'];

            $social_buttons = 0;
            if (isset($_POST['social_buttons']) && $_POST['social_buttons'] == true)
                $social_buttons = 1;

            $show_comments = 0;
            if (isset($_POST['show_comments']) && $_POST['show_comments'] == true)
                $show_comments = 1;

            $image = '';
            if (isset($_POST['image']))
                $image = $_POST['image'];
            if (isset($_FILES['userfile'])) {     // проверка, выбран ли файл картинки 
                if ($_FILES['userfile']['name'] != '') {
                    $imagearr = $this->upload_foto();
                    $image = '/upload/shop/' . date("Y-m-d") . '/' . $imagearr['file_name'];
                }
            }
            $glavnoe = 0;
            if (isset($_POST['glavnoe']) && $_POST['glavnoe'] == true)
                $glavnoe = 1;

            $top = 0;
            if (isset($_POST['top']) && $_POST['top'] == true)
                $top = 1;

            for ($i = 0; $i < count($langs); $i++) {
                if (isset($_POST[$langs[$i] . '_short_content']) && $_POST[$langs[$i] . '_short_content'] != '') {
                    $short_contents[$langs[$i]] = $_POST[$langs[$i] . '_short_content'];
                }
                if (isset($_POST[$langs[$i] . '_content']) && $_POST[$langs[$i] . '_content'] != '') {
                    $contents[$langs[$i]] = $_POST[$langs[$i] . '_content'];
                }
                if (isset($_POST[$langs[$i] . '_seo']) && $_POST[$langs[$i] . '_seo'] != '') {
                    $seo[$langs[$i]] = $_POST[$langs[$i] . '_seo'];
                }
            }
            $razmer = '';
            if (isset($_POST['razmer']))
                $razmer = serialize($_POST['razmer']);

            $sezon = '';
            if (isset($_POST['sezon']))
                $sezon = $_POST['sezon'];

            $dbins = array(
                'name' => ( isset($names) && !empty($names) )? serialize($names) : '',
                'url' => $url,
                'category_id' => $category_id,
                'parent_category_id' => $parent_category_id,
                'short_content' =>  ( isset($short_contents) && !empty($short_contents) )? serialize($short_contents) : '',
                'content' => ( isset($contents) && !empty($contents) )? serialize($contents) : '',
                'h1' => ( isset($h1s) && !empty($h1s) )? serialize($h1s) : '',
                'image' => $image,
                'num' => $_POST['num'],
                'time' => date("H:i"),
                'date' => date("Y-m-d"),
                'in_warehouse' => $in_warehouse,
                'active' => $active,
                'novelty' => $novelty,
                'title' => ( isset($titles) && !empty($titles) )? serialize($titles) : '',
                'youtube' => $youtube,
                'keywords' => ( isset($keywords) && !empty($keywords) )? serialize($keywords) : '',
                'description' => ( isset($descriptions) && !empty($descriptions) )? serialize($descriptions) : '',
                'robots' => "index, follow",
                'count' => 0,
                'seo' => '',
                'login' => $this->session->userdata('login'),
                'social_buttons' => $social_buttons,
                'show_comments' => $show_comments,
                'current_price' => $_POST['current_price'],
                'old_price' => $_POST['old_price'],
                'articul' => $_POST['articul'],
                'glavnoe' => $glavnoe,
                'top' => $top,
                'sale' => $_POST['sale'],
                'brand_id' => $brand_id,
                'razmer' => $razmer,
                'sezon' => $sezon,
                'seo' => ( isset($seo) && !empty($seo) )? serialize($seo) : ''
            );
            $this->db->insert('shop', $dbins);
            redirect("/admin/shop/");
            //}
            //else $err = 'Такая страница уже существует!';
        }

        $data['mailer_article_def'] = $this->options->getOption('mailer_article_def');
        if (!$data['mailer_article_def'] === false)
            $data['mailer_article_def'] = 1;
        $data['article_in_many_categories'] = $this->options->getOption('article_in_many_categories');
        if ($data['article_in_many_categories'] === false)
            $data['article_in_many_categories'] = 0;
        //var_dump("asd");die();

        $data['title'] = "Добавление товара";
        $data['brands'] = $this->brands->getBrands();
        $data['err'] = $err;
        $data['num'] = $this->mshop->getNewNum();
        //$data['shop'] = $this->mshop->getArticles();
        $data['categories'] = $this->mcats->getCategories(-1, 'shop');
        $this->load->view('shop_add', $data);
    }

    public function edit($id) {
        $langs = $this->getLangs();
        $err = '';
        for ($i = 0; $i < count($langs); $i++) {
            if (isset($_POST[$langs[$i] . '_name']) && $_POST[$langs[$i] . '_name'] != '') {
                $names[$langs[$i]] = $_POST[$langs[$i] . '_name'];

                $h1s[$langs[$i]] = /*IF*/(isset($POST[$langs[$i] . '_h1']) && !empty($POST[$langs[$i] . '_h1']) )? 
                                        /*THEN*/$POST[$langs[$i] . '_h1'] 
                                        /*ELSE*/: $_POST[$langs[$i] . '_name'];
                $titles[$langs[$i]] = (isset($POST[$langs[$i] . '_title']) && !empty($POST[$langs[$i] . '_title']) )? 
                                        $POST[$langs[$i] . '_title'] 
                                        : $_POST[$langs[$i] . '_name'];
                $keywords[$langs[$i]] = (isset($POST[$langs[$i] . '_keywords']) && !empty($POST[$langs[$i] . '_keywords']) )? 
                                        $POST[$langs[$i] . '_keywords'] 
                                        : $_POST[$langs[$i] . '_name'];
                $descriptions[$langs[$i]] = (isset($POST[$langs[$i] . '_description']) && !empty($POST[$langs[$i] . '_description']) )?
                                        $POST[$langs[$i] . '_description'] 
                                        : $_POST[$langs[$i] . '_name'];
            }
        }
        if (isset($names)) {
            reset($names);
            $first_in_names = current($names);
            if ($_POST['url'] == '') {
                $this->load->helper('translit_helper');
                $url = translitRuToEn(( isset($first_in_names) && !empty($first_in_names) )? $first_in_names : '');
            } else {
                $url = $_POST['url'];
            }

            $active = 0;
            if (isset($_POST['active']) && $_POST['active'] == true)
                $active = 1;
            $in_warehouse = 0;
            if (isset($_POST['in_warehouse']) && $_POST['in_warehouse'] == true)
                $in_warehouse = 1;
            $novelty = 0;
            if (isset($_POST['novelty']) && $_POST['novelty'] == true)
                $novelty = 1;
            
            $category_id = '';
            $cat_ids = $_POST['category_id'];
            $ccount = count($cat_ids);
            for ($i = 0; $i < $ccount; $i++) {
                $category_id .= $cat_ids[$i];
                if (($i + 1) < $ccount)
                    $category_id .= '*';
            }

            $brand_id = '';
            $cat_ids = $_POST['brand_id'];
            $ccount = count($cat_ids);
            for ($i = 0; $i < $ccount; $i++) {
                $brand_id .= $cat_ids[$i];
                if (($i + 1) < $ccount)
                    $brand_id .= '*';
            }
            $parent_category_id = 0;
            $parent_category = $this->mcats->getCategoryById($category_id);
            if (isset($parent_category['parent']))
                $parent_category_id = $parent_category['parent'];

            $youtube = '';
            if ($youtube == '')
                $youtube = $_POST['youtube'];

            $glavnoe = 0;
            if (isset($_POST['glavnoe']) && $_POST['glavnoe'] == true)
                $glavnoe = 1;

            $top = 0;
            if (isset($_POST['top']) && $_POST['top'] == true)
                $top = 1;



            $social_buttons = 0;
            if (isset($_POST['social_buttons']) && $_POST['social_buttons'] == true)
                $social_buttons = 1;
            $show_comments = 0;
            if (isset($_POST['show_comments']) && $_POST['show_comments'] == true)
                $show_comments = 1;

            $image = '';
            if (isset($_POST['image']))
                $image = $_POST['image'];
            if (isset($_POST['image_del']) && $_POST['image_del'] == true) {
                @unlink($_SERVER['DOCUMENT_ROOT'] . $image);
                $image = '';
            }
            if (isset($_FILES['userfile'])) {     // проверка, выбран ли файл картинки			   
                if ($_FILES['userfile']['name'] != '') {
                    $imagearr = $this->upload_foto();
                    if ($image != '')
                        unlink($_SERVER['DOCUMENT_ROOT'] . $image);
                    $image = '/upload/shop/' . date("Y-m-d") . '/' . $imagearr['file_name'];
                }
            }
            //////////////////////////////////////////

            $razmer = '';
            if (isset($_POST['razmer']))
                $razmer = serialize($_POST['razmer']);

            $sezon = '';
            if (isset($_POST['sezon']))
                $sezon = $_POST['sezon'];
                
            for ($i = 0; $i < count($langs); $i++) {
                if (isset($_POST[$langs[$i] . '_short_content']) && $_POST[$langs[$i] . '_short_content'] != '') {
                    $short_contents[$langs[$i]] = $_POST[$langs[$i] . '_short_content'];
                }
                if (isset($_POST[$langs[$i] . '_content']) && $_POST[$langs[$i] . '_content'] != '') {
                    $contents[$langs[$i]] = $_POST[$langs[$i] . '_content'];
                }
                if (isset($_POST[$langs[$i] . '_seo']) && $_POST[$langs[$i] . '_seo'] != '') {
                    $seo[$langs[$i]] = $_POST[$langs[$i] . '_seo'];
                }
            }
            
            $dbins = array(
                'name' => ( isset($names) && !empty($names) )? serialize($names) : '',
                'url' => $url,
                'category_id' => $category_id,
                'parent_category_id' => $parent_category_id,
                'short_content' => $_POST['short_content'],
                'content' => ( isset($contents) && !empty($contents) )? serialize($contents) : '',
                'h1' => ( isset($h1s) && !empty($h1s) )? serialize($h1s) : '',
                'image' => $image,
                'num' => $_POST['num'],
                'youtube' => $youtube,
                'active' => $active,
                'in_warehouse' => $in_warehouse,
                'novelty' => $novelty,
                'title' => ( isset($titles) && !empty($titles) )? serialize($titles) : '',
                'keywords' => ( isset($keywords) && !empty($keywords) )? serialize($keywords) : '',
                'description' => ( isset($descriptions) && !empty($descriptions) )? serialize($descriptions) : '',
                'robots' => $_POST['robots'],
                'count' => $_POST['count'],
                'seo' => ( isset($seo) && !empty($seo) )? serialize($seo) : '',
                'social_buttons' => $social_buttons,
                'show_comments' => $show_comments,
                'old_price' => $_POST['old_price'],
                'current_price' => $_POST['current_price'],
                'articul' => $_POST['articul'],
                'glavnoe' => $glavnoe,
                'top' => $top,
                'brand_id' => $brand_id,
                'razmer' => $razmer,
                'sezon' => $sezon
            );
            $this->db->where('id', $id);
            $this->db->limit(1);
            $this->db->update('shop', $dbins);

            if (isset($_POST['send_about_active']) && $_POST['send_about_active'] == true) {
                $article = $this->mshop->getArticleById($id);
                if ($article) {
                    $user = $this->users->getUserByLogin($article['login']);
                    if ($user) {
                        $this->load->helper('mail_helper');
                        $message = 'Добрый день!<br />
				    Ваша статья "<strong>' . $_POST['name'] . '</strong>" успешно добавлена и одобрена администрацией!<br />
				    Благодарим Вас за проявленный интерес к нашему сайту!<br /><br />
				    С Уважением, Администрация сайта <a href="http://' . $_SERVER['SERVER_NAME'] . '/">' . $_SERVER['SERVER_NAME'] . '</a>';
                        mail_send($user['email'], 'Ваша статья добавлена!', $message);
                    }
                }
            }

            if (isset($_POST['save_and_stay']))
                redirect("/admin/shop/edit/" . $id . "/");
            else
                redirect("/admin/shop/");
        }
        $data['article_in_many_categories'] = $this->options->getOption('article_in_many_categories');
        if ($data['article_in_many_categories'] === false)
            $data['article_in_many_categories'] = 0;

        $data['article'] = $this->mshop->getArticleById($id);
        $data['images'] = $this->images->getByShopId($id);
        $data['title'] = "Редактирование товара";
        $data['err'] = $err;
        $data['brands'] = $this->brands->getBrands();
        $data['num'] = $this->mshop->getNewNum();
        $data['categories'] = $this->mcats->getCategories(-1, 'shop');
        //$data['shop'] = $this->mshop->getArticles();
        $this->load->view('shop_edit', $data);
    }

    public function up($id) {
        $cat = $this->mshop->getArticleById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->mshop->getArticleByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('shop', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('shop', $dbins);
            }
        }
        $url = '/admin/shop/';
        if ($this->session->userdata('shopFrom') !== false)
            $url .= $this->session->userdata('shopFrom') . '/';
        redirect($url);
    }

    public function down($id) {
        $cat = $this->mshop->getArticleById($id);
        if (($cat) && $cat['num'] < ($this->mshop->getNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->mshop->getArticleByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('shop', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('shop', $dbins);
            }
        }
        $url = '/admin/shop/';
        if ($this->session->userdata('shopFrom') !== false)
            $url .= $this->session->userdata('shopFrom') . '/';
        redirect($url);
    }

    public function del($id) {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $art = $this->db->get('shop')->result_array();
        if ($art) {
            $art = $art[0];
            if ($art['image'] != '') {
                unlink($_SERVER['DOCUMENT_ROOT'] . $art['image']);
                unlink(str_replace('/shop/', '/original/', $_SERVER['DOCUMENT_ROOT'] . $art['image']));
            }

            $images = $this->images->getByShopId($art['id']);
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
        $this->db->where('id', $id)->limit(1)->delete('shop');
        $url = '/admin/shop/';
        if ($this->session->userdata('shopFrom') !== false)
            $url .= $this->session->userdata('shopFrom') . '/';
        redirect($url);
    }

    public function active($id) {
        $this->ma->setActive($id, 'shop');
        $url = '/admin/shop/';
        if ($this->session->userdata('shopFrom') !== false)
            $url .= $this->session->userdata('shopFrom') . '/';
        redirect($url);
    }

    public function always_first($id) {
        $this->ma->setAlwaysFirst($id, 'shop');
        $url = '/admin/shop/';
        if ($this->session->userdata('shopFrom') !== false)
            $url .= $this->session->userdata('shopFrom') . '/';
        redirect($url);
    }

    public function export() {

        header("Content-Description: File Transfer\r\n");
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . 'export_' . date("Y-m-d_H-i") . '.csv');
        $fp = fopen('php://output', 'w');
        header("Content-Type: text/csv; charset=CP1251\r\n");

        $dbins = array(
            iconv('UTF-8', 'CP1251', 'ID товара'),
            iconv('UTF-8', 'CP1251', 'ID раздела'),
            iconv('UTF-8', 'CP1251', 'Бренд'),
            iconv('UTF-8', 'CP1251', 'Название товара'),
            iconv('UTF-8', 'CP1251', 'Артикул'),
            iconv('UTF-8', 'CP1251', 'Цена'),
            iconv('UTF-8', 'CP1251', 'Размеры'),
            iconv('UTF-8', 'CP1251', 'Фото (url)'),
            iconv('UTF-8', 'CP1251', 'Youtube'),
            iconv('UTF-8', 'CP1251', 'Краткое описание'),
            iconv('UTF-8', 'CP1251', 'Контент')
        );

        //headers
        fputcsv($fp, $dbins, ';', '"');

        $articles = $this->mshop->getArticles();
        $count = count($articles);
        for ($i = 0; $i < $count; $i++) {
            $p = $articles[$i];
            $brand = $p['brand_id'];
            if ($brand != 0) {
                $brand = $this->brands->getBrandById($brand);
                if ($brand)
                    $brand = $brand['name'];
            }

            //else $brand = '';

            /*
              $images = '';
              $imgs = $this->images->getByShopId($p['id']);
              if($imgs)
              {
              $imgcount = count($imgs);
              for($j = 0; $j < $imgcount; $j++)
              {
              $img = $imgs[$j];
              $images .= $img['id'].':'.$img['image'];
              if(($j+1) < $imgcount)
              {
              $images .= '
              ';
              }
              }
              }
             */

            $razmer = '';
            $razmery = unserialize($p['razmer']);
            $count1 = count($razmery);
            for ($j = 0; $j < $count1; $j++) {
                $razmer .= $razmery[$j];
                if (($j + 1) < $count1)
                    $razmer .= '|';
            }
            $p['razmer'] = $razmer;

            $row = array(
                iconv('UTF-8', 'CP1251', $p['id']),
                iconv('UTF-8', 'CP1251', $p['category_id']),
                iconv('UTF-8', 'CP1251', $brand),
                iconv('UTF-8', 'CP1251', $p['name']),
                iconv('UTF-8', 'CP1251', $p['articul']),
                iconv('UTF-8', 'CP1251', $p['price']),
                iconv('UTF-8', 'CP1251', $p['razmer']),
                iconv('UTF-8', 'CP1251', $p['image']),
                iconv('UTF-8', 'CP1251', $p['youtube']),
                iconv('UTF-8', 'CP1251', $p['short_content']),
                iconv('UTF-8', 'CP1251', $p['content'])
            );

            fputcsv($fp, $row, ';', '"');
        }

        fclose($fp);
    }

    function upload_csv($file = 'userfile') {
        // Проверка наличия папки текущей даты. Если нет, то создать
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/csv/')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/csv/', 0777);
        }


        //////
        // Функция загрузки
        $config['upload_path'] = 'upload/csv/';
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

    public function import() {
        //var_dump(unserialize('a:4:{i:0;s:9:"2013-12/1";i:1;s:9:"2014-01/1";i:2;s:9:"2014-01/2";i:3;s:9:"2014-02/2";} '));
        $data['msg'] = '';
        if (isset($_FILES['userfile'])) {     // проверка, выбран ли файл
            if ($_FILES['userfile']['name'] != '') {
                $imagearr = $this->upload_csv();
                $file = '/upload/csv/' . $imagearr['file_name'];
            }
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) {
                if (isset($_POST['price_only'])) {
                    $f = fopen($_SERVER['DOCUMENT_ROOT'] . $file, "rt") or die("Ошибка чтения подгруженного файла!");
                    $namearr = array();
                    for ($i = 0; $data = fgetcsv($f, 1000, ";"); $i++) {
                        $num = count($data);
                        $this->mshop->setPriceByArticul($data[0], $data[1]);
                    }
                    fclose($handle);
                } else {
                    if (($handle = fopen($_SERVER['DOCUMENT_ROOT'] . $file, "r")) !== FALSE) {
                        $headers = fgetcsv($handle, 0, ';', '"');

                        $old = 0;
                        $new = 0;
                        //var_dump($headers);die();
                        $k = 0;
                        while (($data = fgetcsv($handle, 0, ';', '"')) !== FALSE) {

                            $num = count($data);
                            $id = trim($data[0]);

                            $parr = array();
                            $category_id = iconv('CP1251', 'UTF-8', $data[1]);
                            $brand_name = iconv('CP1251', 'UTF-8', $data[2]);
                            $name = iconv('CP1251', 'UTF-8', $data[3]);
                            $articul = iconv('CP1251', 'UTF-8', $data[4]);
                            $price = iconv('CP1251', 'UTF-8', $data[5]);
                            $razmer = iconv('CP1251', 'UTF-8', $data[6]);
                            $image = iconv('CP1251', 'UTF-8', $data[7]);
                            $youtube = iconv('CP1251', 'UTF-8', $data[8]);
                            $short_content = iconv('CP1251', 'UTF-8', $data[9]);
                            $content = iconv('CP1251', 'UTF-8', $data[10]);

                            $youtube = str_replace('http://youtu.be/', '', $youtube);
                            //$images = iconv('CP1251','UTF-8',$data[14]);

                            if (strpos($image, 'http://') !== false) {
                                $string = file_get_contents($image);
                                if ($string) {
                                    $ipos = strrpos($image, '/');
                                    $iname = substr($image, $ipos + 1);
                                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/shop/' . date("Y-m-d") . '/')) {
                                        mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/shop/' . date("Y-m-d") . '/');
                                    }
                                    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/upload/shop/' . date("Y-m-d") . '/' . $iname, $string);
                                    $image = '/upload/shop/' . date("Y-m-d") . '/' . $iname;
                                }
                            }


                            $rarr = explode('|', $razmer);

                            if (is_array($rarr))
                                $razmer = serialize($rarr);

                            $brand_id = 0;
                            if ($brand_name != '') {
                                $brand = $this->brands->getBrand($brand_name);
                                if ($brand)
                                    $brand_id = $brand['id'];
                                else {
                                    $this->load->helper('translit_helper');
                                    $dbins = array(
                                        'name' => $brand_name,
                                        'title' => $brand_name,
                                        'keywords' => $brand_name,
                                        'description' => $brand_name,
                                        'url' => translitRuToEn($brand_name),
                                        'num' => $this->brands->getNewNum()
                                    );
                                    $this->db->insert('brands', $dbins);

                                    $brand = $this->brands->getBrand($brand_name);
                                    if ($brand)
                                        $brand_id = $brand['id'];
                                }
                            }

                            // echo $bron.'<HR>';

                            $name = trim($name);

                            $keywords = $name . ', купить ' . $name;
                            $description = 'У Нас Вы можете купить ' . $name;

                            $dbins = array(
                                'category_id' => $category_id,
                                'brand_id' => $brand_id,
                                'name' => $name,
                                'articul' => $articul,
                                'razmer' => $razmer,
                                'image' => $image,
                                'youtube' => $youtube,
                                'short_content' => $short_content,
                                'content' => $content,
                                'price' => $price,
                                'title' => $name,
                                'keywords' => $keywords,
                                'description' => $description,
                                'youtube' => $youtube
                            );

                            if ($name != '' && $category_id != '') {
                                $is_new = true;
                                if ($id != '') {
                                    $shop = $this->mshop->getProductById($id);
                                    if ($shop)
                                        $is_new = false;
                                }

                                if (!$is_new) {
                                    $this->db->where('id', $id);
                                    $this->db->limit(1);
                                    $this->db->update('shop', $dbins);
                                    $old++;
                                } else {
                                    $dbins['num'] = $this->mshop->getNewNum();
                                    $this->load->helper('translit_helper');
                                    $dbins['url'] = translitRuToEn($name);

                                    $this->db->insert('shop', $dbins);
                                    //var_dump("add");die();
                                    $new++;
                                }
                            }
                        }
                        fclose($handle);
                        $data['msg'] = '<p class="msg">Импорт успешно завершён!<br />Изменено позиций: ' . $old . '<br />Добавлено позиций: ' . $new . '</p>';
                    } else {
                        die("Ошибка чтения подгруженного файла!");
                    }
                    //////////////////////////////
                    /*
                      $f = fopen($_SERVER['DOCUMENT_ROOT'].$file, "rt") or die("Ошибка чтения подгруженного файла!");
                      $namearr = array();
                      for ($i=0; $data=fgetcsv($f,1000,";"); $i++) {
                      $num = count($data);
                      if($i == 0)
                      {
                      for ($c=0; $c<$num; $c++)
                      {
                      array_push($namearr, iconv('CP1251','UTF-8',$data[$c]));
                      }
                      }
                      else
                      {
                      $id = trim($data[0]);
                      $parr = array();

                      $category_id = iconv('CP1251','UTF-8',$data[1]);
                      $brand = iconv('CP1251','UTF-8',$data[2]);
                      $name = iconv('CP1251','UTF-8',$data[3]);
                      $articul = iconv('CP1251','UTF-8',$data[4]);
                      $price = iconv('CP1251','UTF-8',$data[5]);
                      $image = iconv('CP1251','UTF-8',$data[6]);
                      $youtube = iconv('CP1251','UTF-8',$data[7]);
                      $short_content = iconv('CP1251','UTF-8',$data[8]);
                      $content = iconv('CP1251','UTF-8',$data[9]);
                      $tab2 = iconv('CP1251','UTF-8',$data[10]);
                      $tab3 = iconv('CP1251','UTF-8',$data[11]);
                      $tab4 = iconv('CP1251','UTF-8',$data[12]);


                      $brand_id = 0;
                      if($brand != '')
                      {
                      $brand = $this->brands->getBrand($brand);
                      if($brand) $brand_id = $brand['id'];
                      }

                      // echo $bron.'<HR>';

                      $dbins = array(
                      'category_id'		=> $category_id,
                      'brand_id'		=> $brand_id,
                      'name'		=> $name,
                      'articul'	=> $articul,
                      'image'		=> $image,
                      'content'	=> $content,
                      'tab2'		=> $tab2,
                      'tab3'		=> $tab3,
                      'tab4'		=> $tab4,
                      'price'		=> $price
                      );

                      if($id != '')
                      {
                      $this->db->where('id', $id);
                      $this->db->limit(1);
                      $this->db->update('shop', $dbins);
                      }
                      else
                      {
                      $this->db->insert('shop', $dbins);
                      var_dump("add");die();
                      }

                      //var_dump($data);
                      //echo '<hr>';
                      }
                      }
                     */
                }
            }
        }
        $data['title'] = "Импорт CSV";
        $this->load->view('import_csv', $data);
    }

    private function getLangs() {
        $this->langs = explode('|', $this->model_options->getOption('languages'));
        for ($i = 1; $i < count($this->langs); $i++) {
            $this->langs[$i] = trim($this->langs[$i]);
        }
        return $this->langs;
    }

}
