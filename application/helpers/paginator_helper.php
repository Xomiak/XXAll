<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


function createPaginator($url, $per_page, $totalCount, $segment = 2)
{
//		debug($url);
    $CI = &get_instance();
    $CI->load->library('pagination');
    $config['base_url'] = getProtocol() . '://' . $_SERVER['HTTP_HOST'] . '/' . $url;
    $config['prefix'] = $CI->config->item('pagination-prefix');
    $config['total_rows'] = $totalCount;
    $config['num_links'] = 4;
    if (check_smartphone()) $config['num_links'] = 1;
    $config['first_link'] = '<i></i>';
    $config['last_link'] = '<i></i>';
    $config['next_link'] = '&#8658;';
    $config['prev_link'] = '&#8656;';
    $config['page_query_string'] = FALSE;

    $config['use_page_numbers'] = TRUE;

    $config['num_tag_open'] = '<li class="active-pg">';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class=""><a class="active">';
    $config['cur_tag_close'] = '</a></li>';
    $config['prev_tag_open'] = '<li class="second-pg">';
    $config['prev_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li class="penult-pg">';
    $config['next_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li class="last-pg">';
    $config['last_tag_close'] = '</li>';
    $config['first_tag_open'] = '<li class="first-pg">';
    $config['first_tag_close'] = '</li>';

    $config['per_page'] = $per_page;
    $config['uri_segment'] = $segment;
    $CI->pagination->initialize($config);
    return $CI->pagination->create_links();
}

//function getPaginator($item, $url = false, $filters = false, $segment = false, $showAll = false)
function getPaginator($item, $config = array())
{
    $CI = &get_instance();
    $type = $segment = $filters = $showAll = $url = $per_page = $page_number = $pagesCount = $totalRows = false;

    if(isset($config['segment'])) $segment = $config['segment'];
    if(isset($config['per_page'])) $per_page = $config['per_page'];
    if(isset($config['type'])) $type = $config['type'];
    if(isset($config['url'])) $url = $config['url'];
    if(isset($config['filters'])) $filters = $config['filters'];
    if(isset($config['showAll'])) $showAll = $config['showAll'];

    //vdd(request_uri(true));
    if (!$url)
        $url = request_uri(true);


    if ($type == 'tags') {
        $model = false;
        if(! isset($item['tag_for']) || $item['tag_for'] == 'articles')
            $model = getModel('articles');
        elseif(isset($item['tag_for']) && $item['tag_for'] == 'products')
            $model = getModel('products');

        if(!$model)
            die('Не определён тип объектов тэга!');

        if (!$per_page)// TAGS
            $per_page = userdata('per_page');
        if (!$per_page)
            $per_page = getOption('articles_pagination');
        if (!$per_page)
            $per_page = 10;

        $totalRows = $model->getCountArticlesByTag($item['name'], -1, -1, 1);
        //vd($totalRows);

    } else {
        $url = getFullUrl($item, false);
        if ($showAll) $url .= 'all/';

        if(! $per_page)
            $per_page = userdata('per_page');
        if (!$per_page)
            $per_page = $item['per_page'];
        if (!$per_page)
            $per_page = 10;
        if ($item['type'] == 'articles') {                                                      // ARTICLES
            $model = getModel('articles');
            if ($showAll) {
                if ($item['parent'] != 0) { // если это подкатегория
                    $totalRows = $model->getCountArticlesInSubCategories($item['id'], 1);
                } else {    // если это родительская категория
                    $totalRows = $model->getCountArticlesInFirstCategory($item['id'], 1);
                }
            } else {
                $totalRows = $model->getCountArticlesInCategory($item['id'], 1);
            }
        } elseif ($item['type'] == 'gallery') {                                                 // GALLERY
            $model = getModel('gallery');
            $totalRows = $model->getCountImagesByCategory($item['id'], 1);
    } elseif ($item['type'] == 'products') {                                                    // PRODUCTS
            $model = getModel('products');
            //var_dump($size);die();
            if (isset($_POST['filters'])) {
                $modelFilters = getModel('filters');
                $totalRows = $modelFilters->getCountFilteredProductsInCategory($_POST['filters'], $item['id'], 1);
            }
            else
                $totalRows = $model->getCountProductsInCategory($item['id'], 1, (isset($_POST['filters']) ? $_POST['filters'] : false));
            if ($totalRows == 0) {
                $totalRows = $model->getCountProductsByParentCategory($item['id'], 1);
                if ($totalRows > 0) {
                    $subs_show = true;
                }
            }
            if (!$per_page)
                $per_page = 6;
        }
    }
    // Получаем номер сегмента
    if ($segment == 0)
        $segment = substr_count($_SERVER['REQUEST_URI'], '/') - 1;

    $page = intval(str_replace('page-', '', $CI->uri->segment($segment)));
    //vdd($page);
    if(! $page) $page = 1;
    $page = intval($page);

    $from = ($page * $per_page) - $per_page;
    $pagesCount = ceil($totalRows / $per_page);
    $page_number = ceil(($from / $per_page) + 1);
//vdd($url);
    $prev = $next = false;

    if($page_number > 1) {
        $prev = request_uri(true) . $CI->config->item('pagination-prefix') . ($page_number - 1) . '/';
        $prev = str_replace('page-1/','',$prev);
    }
    if(($page_number + 1) <= $pagesCount) {
        $next = request_uri(true) . $CI->config->item('pagination-prefix') . ($page_number + 1) . '/';
    }

    $result = array('html' => createPaginator($url, $per_page, $totalRows, $segment),
        'per_page' => $per_page,
        'from' => $from,
        'total_rows' => $totalRows,
        'pages_count' => $pagesCount,
        'page_number' => $page_number,
        'next'          => $next,
        'prev'      => $prev
    );
    //vdd($result);
    return $result;

}