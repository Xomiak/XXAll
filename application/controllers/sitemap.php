<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sitemap extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        beforeOutput();
        $this->load->model('Model_articles','articles');
        $this->load->model('Model_categories','categories');
        $this->load->model('Model_pages','pages');
        $this->load->model('Model_gallery','gallery');

        //$this->load->model('Model_users','users');

        isLogin();
    }

    public function index()
    {
        err404();
        $this->load->model('Model_main','main');
        $this->load->helper('menu_helper');

        $tkdzst = $this->main->getMain();
        $data = $tkdzst;

        $data['title']          = "Карта сайта ".getLangText($tkdzst['title']);
        $data['keywords']       = "Карта сайта ".getLangText($tkdzst['keywords']);
        $data['description']    = "Карта сайта ".getLangText($tkdzst['description']);
        $data['robots']         = "index, follow";
        $data['h1']             = "Карта сайта: ".getLangText($tkdzst['h1']);
        //$data['seo']            = $tkdzst['seo'];

        $categories = $this->categories->getCategories(1);
        $pages = $this->pages->getPages(1);
        //$gallery = $this->gallery->getCategories(1);

        //$data['gallery']     = $gallery;

        $data['categories'] = $categories;

        $data['pages']      = $pages;

        $this->load->view('sitemap/sitemap_main', $data);
    }

    public function category($id)
    {
        err404();
        $category = $this->categories->getCategoryById($id);

        $this->session->set_userdata('last_url', $_SERVER['REQUEST_URI']);

        $this->load->model('Model_main','main');
        $this->load->helper('menu_helper');

        $tkdzst = $this->main->getMain();
        $data = $tkdzst;


        // ПАГИНАЦИЯ //
        $this->load->library('pagination');
        //$per_page = $options['pagination'];


        $per_page = 100;
        $config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/sitemap/'.$category['url'].'/';
        $config['prefix']	= '!';
        //$config['use_page_numbers']	= TRUE;
        $config['total_rows'] = $this->articles->getCountArticlesInCategory($id,1);
        $config['num_links'] = 10;
        $config['first_link'] = 'в начало';
        $config['last_link'] = 'в конец';
        $config['next_link'] = 'Следующая >';
        $config['prev_link'] = '< Предыдущая';

        $config['num_tag_open'] = '<span class="pagerNum">';
        $config['num_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="active-pag">';
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
        $config['uri_segment']     = 3;
        $from = intval(str_replace('!','',$this->uri->segment(3)));
        //echo $from;die();
        $page_number=$from/$per_page+1;
        $this->pagination->initialize($config);
        $data['pager']	= $this->pagination->create_links();
        //////////

        $data['articles'] = $this->articles->getArticlesByCategory($id,$per_page,$from,1, $category['order_by']);

        $page_no = '';
        if($page_number > 1)
            $page_no = ' (стр. '.$page_number.')';


        $data['title']          = "Карта сайта - Раздел: ".$category['name'].$page_no.$tkdzst['title'];
        $data['keywords']       = "Карта сайта - Раздел: ".$category['name'].$page_no.$tkdzst['keywords'];
        $data['description']    = "Карта сайта - Раздел: ".$category['name'].$page_no.$tkdzst['description'];
        $data['robots']         = "index, follow";
        $data['h1']             = "Раздел: ".$category['name'];


        $data['category'] = $category;

        $this->load->view('sitemap/sitemap_category', $data);
    }

    public function gallery()
    {
        err404();
        $categories = $this->gallery->getCategories(1);
        $data['categories']     = $categories;

        $data['title']          = "Карта сайта: Фото";
        $data['keywords']       = "Карта сайта: Фото";
        $data['description']    = "Карта сайта: Фото";
        $data['robots']         = "index, follow";
        $data['h1']             = "Карта сайта: Фото";
        $this->load->view('sitemap/sitemap_gallery', $data);
    }

    public function xml()
    {
        $categories     = $this->categories->getCategories(1);
        $subcategories  = $this->categories->getAllSubcategories(1);
        $pages          = $this->pages->getPages(1);
        $articles       = $this->articles->getArticles(-1, -1, "DESC", 1);


        $data['categories'] = $categories;
        $data['subcategories'] = $subcategories;
        $data['pages']      = $pages;
        $data['articles']   = $articles;
        if(isset($GLOBALS['multilanguage']) && $GLOBALS['multilanguage'] == 1){
            $data['languages'] = getLanguages(1);
        }



        $this->load->view('sitemap/sitemap_xml', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */