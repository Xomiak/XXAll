<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//require_once(X_PATH . '/application/thumbs/ThumbLib.inc.php');

class Categories extends CI_Controller
{

    private $current_lang;

    public function __construct()
    {
        parent::__construct();

        beforeOutput();

        $this->load->helper('login');
        $this->load->helper('captcha_img');
        $this->load->model('Model_articles', 'art');
        $this->load->model('Model_categories', 'cat');
        $this->load->model('Model_brands', 'brands');
        $this->load->model('Model_pages', 'pages');
        $this->load->model('Model_options', 'options');
        $this->load->model('model_users', 'users');
        $this->load->model('Model_comments', 'comments');
        $this->load->model('Model_main', 'main');
        $this->load->model('Model_shop', 'shop');
        $this->load->model('Model_gallery', 'gallery');
        $this->load->model('Model_filters', 'filters');
        $this->load->model('Model_products', 'products');
        $this->load->model('Model_images', 'images');
        $this->load->model('Model_interactive', 'inter');

        //include('redirects.php');

        $langs = getOptionArray('languages');
        $this->current_lang = getCurrentLanguageCode();
        if (isset($_GET['lang'])) {
            $this->current_lang = $_GET['lang'];
            if (userdata('language') != $this->current_lang)
                if (userdata('language') != $this->current_lang)
                    set_userdata('language', $this->current_lang);
        }

        set_userdata('last_url', $_SERVER['REQUEST_URI']);
        isLogin();

//        $this->load->library('googlemaps');
    }

    public function index()
    {
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
        $this->load->view($GLOBALS['template'] . '/main', $data);
        //$this->output->cache(15);
    }

    private function resetFilters()
    {
        if (isset($_GET['filters_reset'])) {
            unset_userdata('min_price');
            unset_userdata('max_price');
            unset_userdata('filter_brand');
            unset_userdata('filter_color');
            unset_userdata('in_warehouse');

            back_no_get();
        }
    }

    private function setSortParam()
    {

        $sort = (isset($_GET['sort'])) ?
            validate(strtoupper($_GET['sort']), 'string', array('ASC', 'DESC')) :
            ((isset($_POST['sort'])) ?
                validate(strtoupper($_POST['sort']), 'string', array('ASC', 'DESC')) :
                false);
        if ($sort !== false)
            set_userdata('sort', $sort);

        $sort_by = (isset($_GET['sort_by'])) ?
            validate($_GET['sort_by'], 'string') :
            ((isset($_POST['sort_by'])) ?
                validate($_POST['sort_by'], 'string') :
                false);
        if ($sort_by !== false)
            set_userdata('sort_by', $sort_by);

        $per_page = (isset($_POST['per_page'])) ?
            validate($_POST['per_page'], 'string', array('12', '36', 'all')) :
            ((isset($_GET['per_page'])) ?
                validate($_GET['per_page'], 'string', array('12', '36', 'all')) :
                false);
        if ($per_page !== false)
            set_userdata('per_page', $per_page);

        if (isset($_GET['filter_brand']))
            set_userdata('filter_brand', $_GET['filter_brand']);

        if (isset($_GET['back']))
            redirect(urldecode($_GET['back']));
        elseif (isset($_POST['back']))
            redirect($_POST['back']);
    }

    private function setListView()
    {
        if (isset($_GET['view'])) {
            if ($_GET['view'] == 'h')
                $this->session->set_userdata('view', 'h');
            else
                $this->session->unset_userdata('view');
            /*
            $back = $_SERVER['REQUEST_URI'];
            $strpos = strpos($back, '?');
            if ($strpos) {
                $back = substr($back, 0, $strpos);
            }
            if (!$back)
                $back = '/';
                */
            redirect(getUrl(request_uri()));
        }
    }

//    private function getPaginator($category, $url, $filters = false, $segment = false, $showAll = false)
//    {
//        $url = getFullUrl($category, false);
//        if ($showAll) $url .= 'all/';
//        if(!$segment)
//            $segment = substr_count($url, '/');
//
//        $per_page = userdata('per_page');
//        if (!$per_page)
//            $per_page = $category['per_page'];
//        if (!$per_page)
//            $per_page = 10;
//        if ($category['type'] == 'articles' || $category['type'] == 'organizations') {
//            if ($showAll) {
//                if ($category['parent'] != 0) { // если это подкатегория
//                    $totalRows = $this->art->getCountArticlesInSubCategories($category['id'], 1);
//                } else {    // если это родительская категория
//                    $totalRows = $this->art->getCountArticlesInFirstCategory($category['id'], 1);
//                }
//            } else {
//                $totalRows = $this->art->getCountArticlesInCategory($category['id'], 1);
//            }
//        } elseif ($category['type'] == 'gallery') {
//            $totalRows = $this->gallery->getCountImagesByCategory($category['id'], 1);
//        } elseif ($category['type'] == 'products') {
//            //var_dump($size);die();
//            if (isset($_POST['filters']))
//                $totalRows = $this->filters->getCountFilteredProductsInCategory($_POST['filters'], $category['id'], 1);
//            else
//                $totalRows = $this->products->getCountProductsInCategory($category['id'], 1, (isset($_POST['filters']) ? $_POST['filters'] : false));
//            if ($totalRows == 0) {
//                $totalRows = $this->products->getCountProductsByParentCategory($category['id'], 1);
//                if ($totalRows > 0) {
//                    $subs_show = true;
//                }
//            }
//            if (!$per_page)
//                $per_page = 6;
//        }
//        //vd($totalRows);
//        $from = intval(str_replace('!', '', $this->uri->segment($segment)));
//
//        $pagesCount = ceil($totalRows / $per_page);
//
//        $page_number = ceil(($from / $per_page) + 1);
//
//
//        return array('html' => createPaginator($url, $per_page, $totalRows, $segment),
//            'per_page' => $per_page,
//            'from' => $from,
//            'total_rows' => $totalRows,
//            'pages_count' => $pagesCount,
//            'page_number'   => $page_number
//        );
//
//    }

    private function getElements($category, $pager, $filters = false, $order_by, $sort_by, $showAll = false)
    {
        //vd($sort_by);
        if ($category['type'] == 'articles' || $category['type'] == 'organizations') {
            $category['id'] = getPrimaryCategory($category['id']);

            if ($showAll) {
                if ($category['parent'] != 0) { // если это подкатегория
                    return $this->art->getArticlesByParentCategory($category['id'], $pager['per_page'], $pager['from'], 1, $category['order_by']);
                } else {    // если это родительская категория
                    return $this->art->getArticlesByFirstCategory($category['id'], $pager['per_page'], $pager['from'], 1, $category['order_by']);
                }
            } else
                return $this->art->getArticlesByCategory($category['id'], $pager['per_page'], $pager['from'], 1, $order_by, $sort_by);
        } elseif ($category['type'] == 'gallery')
            return $this->gallery->getImagesByCategory($category['id'], 1, $pager['per_page'], $pager['from']);
        else {
            if ($category['type'] == 'products')
                if ($filters)
                    return $this->filters->getFilteredProductsInCategory('p.*', $filters, $category['id'], $pager['per_page'], $pager['from'], 1, $order_by, $sort_by);
                else
                    return $this->products->getProductsByCategory($category['id'], $pager['per_page'], $pager['from'], 1, $order_by, $sort_by);
        }
    }

    public function category($url)
    {
        $category = $this->cat->getCategoryByUrl($url, 1);


        if (isset($_GET['future']) && $_GET['future'] == 'all') {
            set_userdata('future', -1);
        } elseif (isset($_GET['future']) && $_GET['future'] == 'yes') {
            set_userdata('future', 1);
        } elseif (isset($_GET['future']) && $_GET['future'] == 'no') {
            set_userdata('future', 0);
        } else set_userdata('future', 1);
        $future = userdata('future');


        if ($category) {
            $category = translateCategory($category);
            $this->resetFilters();
            $this->setSortParam();
            $this->setListView();

            $order_by = (userdata('sort')) ? userdata('sort') : $category['order_by'];
            $sort_by = (userdata('sort_by')) ? userdata('sort_by') : $category['sort_by'];

            if ($category['per_page'] == NULL)
                $category['per_page'] = getOption('articles_pagination');

            $pager = getPaginator($category, array('url' => $url));
            if ($pager['per_page'])
                $data['page_number'] = $page_number = $pager['page_number'];
            $data['pager'] = $pager;

            //var_dump($pager);
            $page_no = '';
            if ($page_number > 1)
                $page_no = ' (' . $this->lang->line('category_paginator_page') . ' ' . $page_number . ')';

//			$data['articles'] = $this->getElements($category, $pager, ((isset($_POST['filters'])) ? $_POST['filters'] : false), $order_by, $sort_by);
            //vdd($data['articles']);
            if ($category['type'] == 'articles') {
                $articles = $this->art->getArticlesByCategory($category['id'], $pager['per_page'], $pager['from'], 1, $category['order_by'], $category['sort_by']);
                if (!$articles) {
                    $articles = $this->art->getArticlesByFirstCategory($category['id'], $pager['per_page'], $pager['from'], 1, $category['order_by'], $category['sort_by']);
                    /// var_dump($articles);die();
                }
                $data['articles'] = $articles;

            } elseif ($category['type'] == 'products') {
                $articles = $this->products->getProductsByCategory($category['id'], $pager['per_page'], $pager['from'], 1, $category['order_by'], $category['sort_by'], $future);
                if (!$articles) {
                    $articles = $this->products->getProductsByFirstCategory($category['id'], $pager['per_page'], $pager['from'], 1, $category['order_by'], $category['sort_by'], $future);
                    /// var_dump($articles);die();
                }
                $data['articles'] = $articles;
            }
//			if (emptY($data['articles']))
//				$data['articles'] = $this->products->getProductsByParentCategory($category['id'], $pager['per_page'], $pager['from'], 1, $order_by, $sort_by, ((isset($_POST['filters'])) ? $_POST['filters'] : false));
//			$data['art_count'] = (!empty($data['articles'][0])) ? count($data['articles']) : 0;
            /*
              $data['subcategories_cols_count'] 	= $this->options->getOption('subcategories_cols_count');
              if(!$data['subcategories_cols_count']) 	$data['subcategories_cols_count'] = 3;
              $data['subcategories_image_width'] 	= $this->options->getOption('subcategories_image_width');
              if(!$data['subcategories_image_width'])	$data['subcategories_image_width'] = 200;

              $data['razmer']		= $razmer;
              $data['color']		= $color;
              $data['sostav']		= $sostav;
             *
            if (userdata('login')) {
                $wishlist = $this->wishlist->getWishlistByLogin(userdata('login'));
                for ($i = 0; $i < count($wishlist); $i++) {
                    $prod_in_wish[] = $wishlist[$i]['product_id'];
                }
                $data['in_wishlist'] = $prod_in_wish;
                //var_dump($wishlist);die();
            }
*/

            $page_no = "";

            $metaArr['robots'] = $category['robots'];
            $metaArr = generateMeta($category);
            //vdd($metaArr['title']);
            $GLOBALS['type'] = 'categories';
            $GLOBALS['currentId'] = $category['id'];

            $data['meta'] = $metaArr;

            $data['category'] = $category;
            $data['sort_by'] = $sort_by;
            $data['order_by'] = $order_by;
            $data['category'] = $category;
            $data['title'] = $metaArr['title'];
            //vdd($data);
            $data['brands'] = $this->brands->getBrands(1);
            //	$data['page_number'] = $page_number;
            $data['categoryLevel'] = $categoryLevel = getCategoryLevel($category);
            $data['subcategories'] = $this->cat->getSubCategories($category['id'], 1);
            $data['firstCategories'] = $this->cat->getCategories(1, 'organizations');
            //$data['bottom_banners'] = $this->model_banners->getByType('bottom', 1);
            //$data['glavnoe'] = $this->art->getPodGlavnoe($category['id']);
            $data['seo'] = getLangText($category['seo']);

            $template = 'templates/categories/' . $category['type'] . '/' . $category['template'];
            if(isset($pager['next']) && $pager['next']) $data['meta']['next'] = $pager['next'];
            if(isset($pager['prev']) && $pager['prev']) $data['meta']['prev'] = $pager['prev'];
            //if($pager['page_number'] > 1) $data['meta']['robots'] = 'noindex, follow';
            //avdd($data);
            $this->load->view($template, $data);
            //$this->output->cache(15);
        } else { // Если не категория, то страница
            $page = $this->pages->getPageByUrl($url);
            $page = translatePage($page);
            if ($page) {
                $this->load->library('pagination');
                if ($page['active'] != '1')
                    err404();
                else {
                    $data['adding_scripts'] = $page['adding_scripts'];

                    $metaArr['robots'] = $page['robots'];
                    $metaArr = generateMeta($page);

                    $data['meta'] = $metaArr;
                    $data['page'] = $page;

                    $GLOBALS['type'] = 'pages';
                    $GLOBALS['currentId'] = $page['id'];

                    $data['server_name'] = $this->model_options->getOption('server_name');
                    $data['brands'] = $this->brands->getBrands(1);
                    $data['seo'] = getLangText($page['seo']);
                    $data['bottom_banners'] = $this->model_banners->getByType('bottom', 1);
                    if ($page['template'] != '')
                        $this->load->view('templates/pages/' . $page['template'], $data);
                    else
                        $this->load->view('templates/pages/page.tpl.php', $data);
                    //$this->output->cache(15);
                }
            } else
                err404();
        }
    }

    public function subcategory($url, $parent_url)
    {
        $type = false;
        $GLOBALS['type'] = false;
        $GLOBALS['currentId'] = false;

        if (isset($_GET['future']) && $_GET['future'] == 'all') {
            set_userdata('future', -1);
        } elseif (isset($_GET['future']) && $_GET['future'] == 'yes') {
            set_userdata('future', 1);
        } elseif (isset($_GET['future']) && $_GET['future'] == 'no') {
            set_userdata('future', 0);
        } else set_userdata('future', 1);
        $future = userdata('future');

        $this->resetFilters();
        $this->setSortParam();
        $this->setListView();

        $order_by = (userdata('sort')) ? userdata('sort') : 'ASC';
        $sort_by = (userdata('sort_by')) ? userdata('sort_by') : 'price';

        if ($parent_url == 'brands') {
            $this->brands($url);
        } else {
            $category = $this->cat->getCategoryByUrl($url, 1);
            $parent = $this->cat->getCategoryByUrl($parent_url, 1);

            $order_by = (userdata('sort')) ? userdata('sort') : $category['order_by'];
            $sort_by = (userdata('sort_by')) ? userdata('sort_by') : $category['sort_by'];

            $metaArr = array();
            if ($url == 'all') {
                $category = $parent;
                $name = "Все " . mb_strtolower($category['name']);
                $metaArr['name'] = str_replace($category['name'], $name, $category['name']);
                $metaArr['title'] = str_replace($category['title'], $name, $category['title']);
                $metaArr['keywords'] = str_replace($category['keywords'], $name, $category['keywords']);
                $metaArr['description'] = str_replace($category['description'], $name, $category['description']);
            }

            if (($category) && ($parent)) {

                $category = translateCategory($category);
                $parent = translateCategory($parent);

                $articles_pagination = getOption('articles_pagination');
                if ($category['type'] == 'articles')
                    $data['articles'] = $this->art->getArticlesByCategory($category['id'], $articles_pagination, 0, 1, $category['order_by'], $category['sort_by']);
                elseif ($category['type'] == 'products')
                    $articles = $this->products->getProductsByCategory($category['id'], $articles_pagination, 0, 1, $category['order_by'], $category['sort_by'], $future);

                if ($data['articles']) {
                    $count = count($data['articles']);
                    for ($i = 0; $i < $count; $i++)
                        translateArticle($data['articles'][$i]);
                }

                $metaArr['robots'] = $category['robots'];
                $metaArr = generateMeta($category);
                $data['meta'] = $metaArr;

                $data['sort_by'] = $sort_by;
                $data['order_by'] = $order_by;

                $data['categoryLevel'] = $categoryLevel = getCategoryLevel($category);
                $data['category'] = $category;
                $data['firstCategory'] = $this->cat->getFirstLevelCategory($category);
                $data['firstCategories'] = $this->cat->getCategories(1, 'organizations');
                if ($categoryLevel >= 1) {
                    //vd($categoryLevel);
                    $data['secondCategory'] = $secondCategory = getCategoryByLevel(1, $category);
                    $data['secondCategories'] = $this->model_categories->getSubcategories($secondCategory['parent'], 1);
                }
                if ($categoryLevel == 2) {
                    $data['surroundingCategories'] = $this->model_categories->getSubcategories($category['parent'], 1);
                }

                $data['subcategories'] = $this->cat->getSubCategories($category['id'], 1);
                $data['parent'] = $parent;
                $data['seo'] = getLangText($category['seo']);

                $template = '/templates/categories/' . $category['type'] . '/' . $category['template'];

                $GLOBALS['type'] = 'categories';
                $GLOBALS['currentId'] = $category['id'];
                $this->load->view($template, $data);
            } else {
                $GLOBALS['type'] = $type = 'articles';
                $active = 1;
                if (userdata("type") == 'admin' || userdata("type") == 'moder')
                    $active = -1;

                $article = $this->art->getArticleByUrlAndCategoryId($url, $parent['id'], $active);

                if (!$article) {
                    $articles = $this->art->getArticlesByUrl($url);
                    if ($articles) {
                        $count = count($articles);
                        for ($i = 0; $i < $count; $i++) {
                            $article = $articles[$i];
                            if ($article) {
                                $category = $this->cat->getCategoryById($article['category_id']);
                                if ($category['parent'] != 0) {
                                    $p = $this->cat->getCategoryById($category['parent']);
                                    //var_dump($p);
                                    if ($p['id'] != $parent['id'])
                                        $article = false;
                                    else
                                        break;
                                } else
                                    $article = false;
                            }
                        }
                    }
                }
                if (!$article) {
                    $GLOBALS['type'] = 'products';
                    $article = $this->products->getProductByUrlAndCategoryId($url, $parent['id']);

                    if (!$article) {
                        $articles = $this->products->getProductsByUrl($url);
                        if ($articles) {
                            $count = count($articles);
                            for ($i = 0; $i < $count; $i++) {
                                $article = $articles[$i];
                                if ($article) {
                                    $category = $this->cat->getCategoryById($article['category_id']);

                                    if ($category['parent'] != 0) {
                                        $p = $this->cat->getCategoryById($category['parent']);
                                        //var_dump($p);
                                        if ($p['id'] != $parent['id'])
                                            $article = false;
                                        else
                                            break;
                                    } elseif (strpos($article['category_id'], '*' . $category['id'] . '*') !== false) {
                                        break;
                                    } else $article = false;
                                }
                            }
                        }
                    }
                }

                if (!$article && userdata('login') != false) {
                    // Режим предпросмотра
                    $noActive = $this->art->getArticlesByUrl($url, -1, userdata('login'));
                    //vd($noActive);
                    if (isset($noActive[0])) {
                        $article = $noActive[0];
                        $article['preview'] = true;
                    }
                }

                if (!$article)
                    err404();


                $category = $this->cat->getCategoryById($article['category_id']);

                $comments = false;

                ///////////////////////////////////
                /// НАСТРАИВАЕМ ВЫВОД КАРТЫ		///
//                if ($category['type'] == 'organizations') {
//
//                    $adress = getAdressArray($article['adress']);
//                    $this->load->model('Model_adresses', 'adresses');
//                    $adractive = 1;
//                    if ($article['created_by'] == userdata('login') || userdata('type') == 'admin' || userdata('type') == 'moder')
//                        $adractive = -1;
//                    $adresses = $this->adresses->getAdressesByArticleId($article['id'], $adractive);
//
//
//                    if (is_array($adresses) && $article['type'] != NULL && $article['type'] != "" && $article['type'] != 'free') {
//                        $this->load->library('googlemaps');
//                        $config = array(
//                            'apiKey' => 'AIzaSyDL-ughU0ynX4JHYIU7m32K3zVF_-0fKgQ',
//                            'region' => 'ua',
//                            'https' => true,
//                            //'center'	=> $article['city'].', '.$article['adress'],
//                            'zoom' => 'auto',
//                            'map_div_id' => 'googleMap',
//                            'scrollwheel' => false,
//                            'geocodeCaching' => TRUE,
//                            'region' => 'ua'
//                        );
//                        if (count($adresses) == 1) {
//                            $config['zoom'] = 16;
//                            $config['center'] = $adresses[0]['lat'] . ', ' . $adresses[0]['lng'];
//                        }
//                        $this->googlemaps->initialize($config);
//
//                        $city = $article['city'];
//
//                        foreach ($adresses as $item) {
//                            $marker = array();
//                            $marker['position'] = $item['lat'] . ", " . $item['lng'];
//                            $marker['animation'] = 'DROP';
//                            //$marker['cursor']	= 'Ты меня поймал)';
//
//                            if ($article['image'] != '')
//                                $marker['icon'] = CreateThumb2(45, 45, $article['image'], 'icons');
//                            elseif ($category['image'] != '')
//                                $marker['icon'] = CreateThumb2(45, 45, $category['image'], 'icons');
//
//                            $marker['clickable'] = TRUE;
//                            $descr = strip_tags($article['short_content']);
//                            $descr = str_replace("\n", '<br />', $descr);
//                            $info = "";
//                            $info .= '<b>' . $article['name'] . '</b>';
//                            if (isset($item['description'])) $info .= str_replace("\n", '<br />', $item['description']);
//                            $marker['infowindow_content'] = $info;
//                            //vd($marker);
//                            $this->googlemaps->add_marker($marker);
//                        }
//
//                        $data['adresses'] = $adresses;
//                        $data['map'] = $this->googlemaps->create_map();
//                    }
//                }
                /// /НАСТРАИВАЕМ ВЫВОД КАРТЫ	///
                ///////////////////////////////////

                $data['cap'] = createCaptcha();
                //$article = parseFilters($article, true, false, array('id', 'title', 'name', 'show_type', 'classes'), array('id', 'value'));
                if (isset($article['brand_id'])) {
                    $article['brand'] = $this->brands->getBrandById($article['brand_id']);
                    unset($article['brand_id']);
                }

                $article['filters'] = $this->filters->getProductFiltersValuesId($article['id'], 'val');
                foreach ($article['filters'] as $f_key => $vals) {
                    $f = $this->filters->getFilterByName($f_key, false, -1, array('title'));
                    $v = $article['filters'][$f_key];
                    unset($article['filters'][$f_key]);
                    $article['filters'][$f_key]['values'] = $v;
                    $article['filters'][$f_key]['title'] = $f['title'];
                }
                //$data['articles'] = $this->art->getLastArticles(3, 1);
                $article = translateArticle($article, $type);


                $GLOBALS['currentId'] = $article['id'];
                $data['article'] = $article;
                $data['category'] = translateCategory($category);
                $data['brands'] = $this->brands->getBrands(1);
                $data['comments'] = $comments;
                $data['parent'] = $parent;
                if ($type == 'products') {
                    $data['images'] = $this->images->getByProductId($article['id'], 1);
                } else {
                    $data['images'] = $this->images->getByArticleId($article['id'], 1);
                }

                //
                $metaArr['robots'] = $article['robots'];
                $metaArr = generateMeta($article);

                $data['meta'] = $metaArr;
                $data['title'] = $article['title'];
                $data['keywords'] = $article['keywords'];
                $data['description'] = $article['description'];
                $data['robots'] = $article['robots'];
                $data['parent'] = $this->cat->getCategoryById($category['parent']);
                $data['bottom_banners'] = $this->model_banners->getByType('bottom', 1);
                //$data['h1']             = $category['h1'];
                $data['seo'] = getLangText($category['seo']);
                //$data['glavnoe']	    = $this->art->getGlavnoe();
                if ($type == 'shop')
                    $this->shop->countPlus($article['id']);
                else
                    $this->art->countPlus($article['id']);

                if ($parent['content_template'] != '') {
                    if ($category['type'] == 'organizations' && $article['type'] != NULL && $article['type'] != "" && $article['type'] != 'free') {
                        $parent['content_template'] = str_replace('.tpl.php', '_' . $article['type'] . '.tpl.php', $category['content_template']);
                    }
                    $this->load->view('templates/' . $parent['type'] . '/' . $parent['content_template'], $data);
                } else
                    $this->load->view('templates/articles/new.tpl.php', $data);
                //$this->output->cache(15);
            }
            $this->db->close();
        }
    }

    function all_brands()
    {

        if (isset($_POST['per_page'])) {

            set_userdata('per_page', $_POST['per_page']);
            if (isset($_POST['back']))
                redirect($_POST['back']);
            else
                redirect('/brands/');
        }
        if (isset($_GET['sort'])) {

            set_userdata('sort', $_GET['sort']);
            if (isset($_GET['back']))
                redirect(urldecode($_GET['back']));
            else
                redirect('/brands/');
        }


        $config['total_rows'] = $this->products->getBrandsCount(1);

        $per_page = userdata('per_page');
        if (!$per_page)
            $per_page = $this->model_options->getOption('pagination_shop');
        if (!$per_page)
            $per_page = 10;


        $sort = userdata('sort');
        if (!$sort)
            $sort = 'ASC';


        $this->load->library('pagination');

        $config['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/brands/';

        $config['num_links'] = 2;
        $config['prefix'] = '!';
        $config['first_link'] = $this->lang->line('category_first_link');
        $config['last_link'] = $this->lang->line('category_last_link');
        $config['next_link'] = $this->lang->line('category_next_link') . '>';
        $config['prev_link'] = '<' . $this->lang->line('category_prev_link');
        $config['last_link'] = '>>' . $this->lang->line('category_prev_link');
        $config['first_link'] = '<<' . $this->lang->line('category_prev_link');

        $config['num_tag_open'] = '<span class="pagerNum">';
        $config['num_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="pagerCurNum">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_tag_open'] = '<span class="pagerPrev">';
        $config['prev_tag_close'] = '</span>&nbsp;&nbsp;';
        $config['next_tag_open'] = '&nbsp;&nbsp;<span class="pagerNext">';
        $config['next_tag_close'] = '</span>';
        $config['last_tag_open'] = '&nbsp;&nbsp;<span class="pagerLast">В конец';
        $config['last_tag_close'] = '</span>';
        $config['first_tag_open'] = '<span class="pagerFirst">В начало';
        $config['first_tag_close'] = '</span>&nbsp;&nbsp;';

        $config['per_page'] = $per_page;
        $config['uri_segment'] = 2;
        $from = intval(str_replace('!', '', $this->uri->segment(2)));
        $page_number = $from / $per_page + 1;
        $this->pagination->initialize($config);
        $data['from'] = $from;
        $data['pager'] = $this->pagination->create_links();
        //////////


        $data['articles'] = $this->products->getBrands(1, $per_page, $from, $sort);


        $page_no = '';
        if ($page_number > 1)
            $page_no = ' (' . $this->lang->line('category_paginator_page') . ' ' . $page_number . ')';

        $data['subcategories_cols_count'] = $this->options->getOption('subcategories_cols_count');
        if (!$data['subcategories_cols_count'])
            $data['subcategories_cols_count'] = 3;
        $data['subcategories_image_width'] = $this->options->getOption('subcategories_image_width');
        if (!$data['subcategories_image_width'])
            $data['subcategories_image_width'] = 200;


        $data['brands'] = $this->products->getBrands(1);

        $data['title'] = "Все бренды" . $page_no . getOption('global_title_' . $this->current_lang);
        $data['keywords'] = "Все бренды" . ', ' . $page_no . getOption('global_keywords_' . $this->current_lang);
        $data['description'] = "Все бренды" . $page_no . getOption('global_description_' . $this->current_lang);

        $data['robots'] = "index, follow";
        //$data['category'] = $brand;
        //$data['brands'] = $this->brands->getBrands(1);
        $data['page_number'] = $page_number;
        //$data['h1']             = $category['h1'];
        $data['is_brand'] = true;
        //$data['glavnoe']	    = $this->art->getGlavnoe();
        $this->load->view('templates/brands.tpl.php', $data);
    }

    function brands($url)
    {
        // СОРТИРОВКА //
        if (isset($_POST['per_page'])) {
            set_userdata('per_page', $_POST['per_page']);
            if (isset($_POST['back']))
                redirect($_POST['back']);
            else
                redirect('/');
        }
        //vd($_GET['sort']); die();
        if (isset($_GET['sort']) && isset($_GET['sort_by'])) {

            set_userdata('sort', $_GET['sort']);
            set_userdata('sort_by', $_GET['sort_by']);
            if (isset($_GET['back']))
                redirect(urldecode($_GET['back']));
            else
                redirect('/');
        }
        // ** //


        $order_by = (userdata('sort')) ? userdata('sort') : 'DESC';
        $sort_by = (userdata('sort_by')) ? userdata('sort') : 'id';

        $brand = $this->brands->getBrandByUrl($url, 1);

        //var_dump($brand);
        if (!$brand)
            err404();
        else {
            $pager = $this->getPaginator($brand, $url);
            $page_number = $pager['from'] / $pager['per_page'] + 1;
            $data['pager'] = $pager['pager'];
            $page_no = '';
            if ($page_number > 1)
                $page_no = ' (' . $this->lang->line('category_paginator_page') . ' ' . $page_number . ')';

            $data['articles'] = $this->products->getProductsByBrand($brand['id'], $pager['per_page'], $pager['from'], 1, $order_by, $sort_by);
            /*
              $data['subcategories_cols_count'] = $this->options->getOption('subcategories_cols_count');
              if (!$data['subcategories_cols_count'])
              $data['subcategories_cols_count'] = 3;
              $data['subcategories_image_width'] = $this->options->getOption('subcategories_image_width');
              if (!$data['subcategories_image_width'])
              $data['subcategories_image_width'] = 200;
             */
            $data['title'] = $brand['title'] . $page_no . getOption('global_title_' . $this->current_lang);
            $data['keywords'] = $brand['keywords'] . ', ' . $page_no . getOption('global_keywords_' . $this->current_lang);
            $data['description'] = $brand['description'] . $page_no . getOption('global_description_' . $this->current_lang);
            $data['robots'] = $brand['robots'];
            $data['category'] = $brand;
            $data['brands'] = $this->brands->getBrands(1);
            $data['page_number'] = $page_number;
            //$data['h1']             = $category['h1'];
            $data['is_brand'] = true;
            //$data['glavnoe']	    = $this->art->getGlavnoe();
            $this->load->view('templates/brand.tpl.php', $data);
        }
    }


    public function search()
    { // поиск
        $search_google = $this->model_options->getOption('search_google');
        if ($search_google === false)
            $search_google = 0;

        $search = false;
        if (isset($_POST['search'])) {
            set_userdata('search', trim($_POST['search']));
        }

        $search = userdata('search');
        if (!empty($search)) {
            if ($search_google == 0) {
                $this->setSortParam();
                $order_by = userdata('sort');
                if (!$order_by)
                    $order_by = 'DESC';
                $sort_by = userdata('sort_by');

                if (!$sort_by)
                    $sort_by = 'id';
                //$data['articles'] = $this->art->Search(trim($search));
                //$per_page = $this->model_options->getOption('pagination_shop');
                //if (!$per_page)
                $per_page = 10;
                $from = intval(str_replace('!', '', $this->uri->segment(2)));
                $page_number = $from / $per_page + 1;
                $count = $this->art->searchByNameCount($search);
                //$data['all_articles'] = ($count[0]['count']) ? $count[0]['count'] : 0;
                $data['pager'] = createPaginator('/search/', $per_page, $count);
                //vdd($this->products->searchByName($search, -1, -1, -1, $order_by, 'id', 1));
                $data['articles'] = $this->art->searchByName($search, -1, $per_page, $from, $order_by, $sort_by);
                $data['search'] = $search;
                $data['title'] = $this->lang->line('category_search') . $search . getOption('global_title_' . $this->current_lang);
                $data['keywords'] = '';
                $data['description'] = '';
                $data['robots'] = "noindex, follow";
                $data['seo'] = "";
                //unset_userdata('search');
                $this->load->view('search/search.tpl.php', $data);
            } else {
                $data['title'] = $this->lang->line('category_search') . $_GET['sa'] . getOption('global_title_' . $this->current_lang);
                $data['keywords'] = '';
                $data['description'] = '';
                $data['robots'] = "noindex, nofollow";
                $data['seo'] = "";
                $data['bottom_banners'] = $this->model_banners->getByType('bottom', 1);
                $this->load->view('search/google_search.tpl.php', $data);
            }
            $this->db->close();
        } else {
            $data['search'] = $search;
            $data['title'] = $this->lang->line('category_search') . $search . getOption('global_title_' . $this->current_lang);
            $data['keywords'] = '';
            $data['description'] = '';
            $data['robots'] = "noindex, follow";
            $data['seo'] = "";
            $this->load->view('search/search.tpl.php', $data);
        }
    }

    public function archive()
    { // архив
        if (isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year'])) {
            $day = $_POST['day'];
            if ($day == '1')
                $day = '01';
            if ($day == '2')
                $day = '02';
            if ($day == '3')
                $day = '03';
            if ($day == '4')
                $day = '04';
            if ($day == '5')
                $day = '05';
            if ($day == '6')
                $day = '06';
            if ($day == '7')
                $day = '07';
            if ($day == '8')
                $day = '08';
            if ($day == '9')
                $day = '09';

            $month = $_POST['month'];
            if ($month == '1')
                $month = '01';
            if ($month == '2')
                $month = '02';
            if ($month == '3')
                $month = '03';
            if ($month == '4')
                $month = '04';
            if ($month == '5')
                $month = '05';
            if ($month == '6')
                $month = '06';
            if ($month == '7')
                $month = '07';
            if ($month == '8')
                $month = '08';
            if ($month == '9')
                $month = '09';

            $year = $_POST['year'];


            $data['articles'] = $this->art->Archive($year . '-' . $month . '-' . $day);
            $_POST['search'] = $year . '-' . $month . '-' . $day;
            $data['title'] = $this->lang->line('category_search') . $_POST['search'] . getOption('global_title_' . $this->current_lang);
            $data['keywords'] = $_POST['search'] . getOption('global_keywords_' . $this->current_lang);
            $data['description'] = $this->lang->line('category_search') . $_POST['search'] . getOption('global_description_' . $this->current_lang);
            $data['robots'] = "noindex, follow";
            $data['seo'] = "";
            $this->load->view($GLOBALS['template'] . '/archive.tpl.php', $data);
        }
    }

    function banner($id)
    {
        $this->load->model('Model_banners', 'banners');
        $banner = $this->banners->getBannerById($id);
        if ($banner) {
            $this->banners->countPlus($id);
            redirect($banner['url']);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */