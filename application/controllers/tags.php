<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(X_PATH.'/application/thumbs/ThumbLib.inc.php');

class Tags extends CI_Controller
{

    private $current_lang;

    public function __construct()
    {
        parent::__construct();

        beforeOutput();

        $this->load->helper('login');
        $this->load->helper('captcha_img');
        $this->load->model('Model_articles', 'articles');
        $this->load->model('Model_categories', 'categories');
        $this->load->model('Model_tags', 'tags');

        $langs = getOptionArray('languages');
        $this->current_lang = (userdata('language')) ? userdata('language') : trim($langs[0]);
        if (isset($_GET['lang'])) {
            $this->current_lang = $_GET['lang'];
            if (userdata('language') != $this->current_lang)
                if (userdata('language') != $this->current_lang)
                    set_userdata('language', $this->current_lang);
        }

        set_userdata('last_url', $_SERVER['REQUEST_URI']);
        isLogin();

       // $this->load->library('googlemaps');
    }

    public function index()
    {
        // Страница со всеми тэгами
        $this->load->helper('menu_helper');
        $tkdzst = $this->main->getMain();
        $data['title'] = $tkdzst['title'];
        $data['keywords'] = $tkdzst['keywords'];
        $data['description'] = $tkdzst['description'];
        $data['robots'] = "index, follow";
        $data['h1'] = $tkdzst['h1'];
        $data['seo'] = $tkdzst['seo'];
        //$data['glavnoe'] = $this->art->getGlavnoe();
        $data['sections'] = $this->model_categories->getCategoryById(1, 1);
        $data['courses'] = $this->model_categories->getCategoryById(4, 1);
        $data['studios'] = $this->model_categories->getCategoryById(6, 1);
        $data['trennings'] = $this->model_categories->getCategoryById(5, 1);
        $this->load->view('main', $data);
        //$this->output->cache(15);
    }

    public function showByTag($url){
        $per_page = getOption('articles_pagination');
        $from = 0;
        $tags = false;
        $tag = $this->tags->getByUrl($url);
        if($tag) {
            $config = array(
                'type'  => 'tags'
            );
            $data['pager'] = $pager = getPaginator($tag, $config);
            //vdd($pager);
            $tags = $this->articles->getArticlesByTag($tag['name'], $pager['per_page'], $pager['from'], 1);

            if(isset($pager['next']) && $pager['next']) $data['meta']['next'] = $pager['next'];
            if(isset($pager['prev']) && $pager['prev']) $data['meta']['prev'] = $pager['prev'];

            $data['articles'] = $tags;
            $data['tag'] = $tag;
            //$data['articlesCount'] = $this->articles->getCountArticlesByTag($tag['name'], 1);

            $data['category']['name'] = "Материалы с тэгом: ".$tag['name'];
            $data['title'] = "Материалы с тэгом: ".$tag['name'];
            $data['keywords'] = "Материалы с тэгом: ".$tag['name'];
            $data['description'] = "Материалы с тэгом: ".$tag['name'];
            $data['robots'] = "index, follow";
            $data['h1'] = "Материалы с тэгом: ".$tag['name'];
            $data['seo'] = "";

            $this->load->view('templates/tags/tag.tpl.php', $data);
        } else err404();
    }

}