<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function cache_top_organizations($first_category_id)
{
    $CI = &get_instance();
    $CI->load->library('partialcache');
    $data = '';

    if (($data = $CI->partialcache->get('top_organizations_' . $first_category_id, 60)) === false) {
        $CI->load->model('Model_articles', 'articles');
        $data .= '<ul>';
        $orgs = $CI->articles->getArticlesByTop($first_category_id, 10);

        $i = 1;
        foreach ($orgs as $org) {
            $url = getFullUrl($org);
            $cat = $CI->model_categories->getCategoryById($org['category_id']);
            $title = $org['name'] . ' (' . $cat['name'] . ')';
            $img = $org['image'];
            if ($img == '') $img = $cat['image'];
            if ($img != '') $img = CreateThumb2(48, 48, $img, 'tops');
            $data .= '
<li>
	<h3>' . $i . '</h3>';
            if ($img != '') {
                $data .= '
		<a href="' . getFullUrl($cat) . '" class="wrap-small-org-img">
				<img src="' . $img . '" alt="' . $title . '" title="' . $title . '">
			</a>';
            } else {
                $data .= '
		<a href="' . getFullUrl($cat) . '" class="wrap-small-org-img">
				<img src="/img/site/logo.png" alt="' . $title . '" title="' . $title . '">
			</a>';
            }
            $data .= '
	<div class="wrap-descr">
		<a title="' . $title . '" href="' . $url . '">' . $org['name'] . '</a>
		<p>Вид: <a href="' . getFullUrl($cat) . '">' . $cat['name'] . '</a></p>
	</div>
	<div class="clearfix"></div>
</li>
';
            $i++;
        }

        $data .= '</ul>';
        $CI->partialcache->save('top_organizations_' . $first_category_id, $data);
    }
    return $data;
}

function cache_last_news()
{
    $CI = &get_instance();
    $CI->load->library('partialcache');
    $data = '';

    if (($data = $CI->partialcache->get('last_news', 10)) === false) {
        $CI->load->model('Model_articles', 'articles');
        $news = $CI->articles->getArticlesByCategory(8, 5, 0, 1, 'DESC', 'unix');
        $data .= '<ul>';
        if ($news) {
            foreach ($news as $new) {
                $url = getFullUrl($new);
                $data .= '
<li class="comment">
	<p>' . getWordDate($new['date']) . ' ' . $new['time'] . '</p>
	<a title="' . $new['name'] . '" href="' . $url . '">' . $new['name'] . '</a>
	<div class="wrap-p">
		<p>' . strip_tags($new['short_content']) . '</p>
	</div>
	<div class="read-more">
		<a href="' . $url . '" title="Read more...">Далее...</a>
	</div>
</li>
';
            }
            $data .= '</ul>';
            $CI->partialcache->save('last_news', $data);
        }
    }
    return $data;
}

function cache_last_comments()
{
    $CI = &get_instance();
    $CI->load->library('partialcache');
    $data = '';

    if (($data = $CI->partialcache->get('last_comments', 10)) === false) {
        $CI->load->model('Model_comments', 'comments');
        $CI->load->model('Model_articles', 'articles');
        $comments = $CI->comments->getComments(5, 0);
        $data .= '<ul>';
        foreach ($comments as $comment) {
            $article = $CI->articles->getArticleById($comment['article_id']);
            $url = getFullUrl($article);
            $data .= '
<li class="comment">
	<p>' . getWordDate($comment['date']) . ' ' . $comment['time'] . '</p>
	<a title="' . strip_tags($article['short_content']) . '" href="' . $url . '">' . $article['name'] . '</a>
	<div class="comment-p-wrap">
		<p>' . strip_tags($comment['comment']) . '</p>
	</div>
	<div class="read-more">
		<a href="' . $url . '" title="Read more...">Далее...</a>
	</div>
</li>
';
        }
        $data .= '</ul>';
        $CI->partialcache->save('last_comments', $data);
    }
    return $data;
}

function cache_top($category_id)
{
    $CI = &get_instance();

    $CI->load->library('partialcache');
    $data = '';

    if (($data = $CI->partialcache->get('top_' . $category_id, 60)) === false) {
        $data .= '<ol>';
        $cats = $CI->model_categories->getAllTop();
        foreach ($cats as $cat) {
            $first = $CI->model_categories->getFirstParentId($cat['id']);
            if ($first == $category_id) {
                $data .= '<li><a href="' . getFullUrl($cat) . '">' . $cat['name'] . '</a></li>';
            }
        }
        $data .= '</ol>';
        $CI->partialcache->save('top_' . $category_id, $data);
    }
    return $data;
}


function cache_trennings($first_category_id = 5)
{
    $CI = &get_instance();

    $CI->load->library('partialcache');
    $data = '';

    if (($data = $CI->partialcache->get('top_' . $first_category_id, 60)) === false) {
        $CI->load->model("Model_articles", "articles");
        $data .= '<div class="wrapper-tren"><div id="slider-prev"></div><ul class="bxslider">';
        $articles = $CI->articles->getArticlesByFirstCategory($first_category_id, 10, 0, 1);
        if ($articles) {
            foreach ($articles as $article) {
                //<li><a href="#">01.04.16 “SMM продвижение ...”</a></li>
                $data .= '<li><a title="' . $article['date'] . ' ' . $article['name'] . '" href="' . getFullUrl($article) . '"> - ' . ' ' . $article['name'] . '</a></li>';
            }
        }
        $data .= '</ul><div id="slider-next"></div></div>';
        //$CI->partialcache->save('top_'.$first_category_id, $data);
    }
    return $data;
}

function cache_header()
{
    $CI = &get_instance();

    $CI->load->library('partialcache');
    $data = '';

    if (($data = $CI->partialcache->get('header', 60)) === false) {
        $data = '
		<!-- Социальные кнопки -->
		<div class="social-buttons f-left">
			<a rel="nofollow" href="' . getOption('link_forum') . '" title="Одесский форум" target="_blank"><i class="fa fa-comment" aria-hidden="true"></i></a>
			<a rel="nofollow" href="' . getOption('link_fb') . '" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			<a rel="nofollow" href="' . getOption('link_vk') . '" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i></a>
			<a rel="nofollow" href="' . getOption('link_tw') . '" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<a rel="nofollow" href="' . getOption('link_odn') . '" target="_blank"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
		</div>

		<!-- Форма поиска -->
		<div class="header-search f-left">
			<form method="post" action="/search/">
				<input type="text" name="search" placeholder="Найти">
				<input type="submit" value=" ">
			</form>
		</div>

		<!-- "Мы на связи"" -->
		<div class="header-tel f-left">
			<p>Мы на связи</p>
			<span>' . getOption('phone3') . '</span><br>
			<span>' . getOption('phone4') . '</span><br>
			<span>' . getOption('main_mail') . '</span>
		</div>
		<div class="clearfix"></div>

		<nav class="menu">
			<ul>
				<li><a href="/"><img src="/img/site/home-icon.png" alt="home"></a></li>';
        $CI->load->model('Model_menus', 'menus');
        $menus = $CI->menus->getMenuByType('top', 1);
        foreach ($menus as $menu) {
            $data .= '<li><a href="' . $menu['url'] . '">' . $menu['name'] . '</a></li>';
        }
        $data .= '
			</ul>
		</nav>
		';

        $CI->partialcache->save('header', $data);
    }
    return $data;
}


function cache_mobile_menu()
{
    $CI = &get_instance();

    $CI->load->library('partialcache');
    $data = '';

    if (($data = $CI->partialcache->get('mobile_menu', 60)) === false) {
        $data = '
			<ul class="drawer-menu">
				<li><a class="drawer-brand" href="/">Главная</a></li>';
        $CI->load->model('Model_menus', 'menus');
        $menus = $CI->menus->getMenuByType('top', 1);
        foreach ($menus as $menu) {
            $data .= '<li><a class="drawer-menu-item" href="' . $menu['url'] . '">' . $menu['name'] . '</a></li>';
        }
        $data .= '
			</ul>

			<!-- Социальные кнопки -->
			<div class="social-buttons f-left">
				<a rel="nofollow" href="' . getOption('link_forum') . '" title="Одесский форум" target="_blank"><i class="fa fa-comment" aria-hidden="true"></i></a>
				<a rel="nofollow" href="' . getOption('link_fb') . '"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				<a rel="nofollow" href="' . getOption('link_vk') . '"><i class="fa fa-vk" aria-hidden="true"></i></a>
				<a rel="nofollow" href="' . getOption('link_tw') . '"><i class="fa fa-twitter" aria-hidden="true"></i></a>
				<a rel="nofollow" href="' . getOption('link_odn') . '"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
			</div>
		';


    }
    return $data;
}