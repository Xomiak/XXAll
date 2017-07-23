<?php
//preHead($config);
if(!isset($canonical))
    $canonical = false;
if(!isset($current_lang) && isset($GLOBALS['current_lang'])) $current_lang = $GLOBALS['current_lang'];
if(!isset($default_lang) && isset($GLOBALS['default_lang'])) $default_lang = $GLOBALS['default_lang'];

if((!$canonical) && !isset($article) && isset($category))
{
    if(!strpos($_SERVER['REQUEST_URI'],'!') && !strpos($_SERVER['REQUEST_URI'],'/all/'))
        $canonical = getFullUrl($category);
    else
        $robots = "noindex, follow";
}
elseif((!$canonical) && isset($article) && strpos($_SERVER['REQUEST_URI'],'/user/') === false && !isset($_GET['preview'])) {
    $canonical = getFullUrl($article);
}


$cart_count = (userdata('my_cart_count')) ? userdata('my_cart_count') : 0;
// ВАЛЮТЫ
set_currency();

$title = $description = $keywords = $robots = false;
$main_currency = getMainCurrency();
$currency = userdata('currency');
if ($currency)
    $currency = getCurrencyByCode($currency);
else
    $currency = $main_currency;

if(isset($article['active']) && $article['active'] == 0) {
    $robots = 'noindex, nofollow';
    $title = '[режим предпросмотра] '.$title;
}

if(!isset($config) && isset($GLOBALS['metaArr']))
    $config = $GLOBALS['metaArr'];

if(isset($config['title']))
    $title = $config['title'];
if(isset($config['keywords']))
    $keywords = $config['keywords'];
if(isset($config['description']))
    $description = $config['description'];
if(isset($config['robots']))
    $robots = $config['robots'];


?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Для смартфонов -->
	<title><?= $title ?></title>
	<meta name = "title" content = "<?= htmlspecialchars($title) ?>"/>
	<meta name = "keywords" content = "<?= htmlspecialchars($keywords) ?>"/>
	<meta name = "description" content = "<?= htmlspecialchars($description) ?>"/>
	<meta name = "robots" content = "<?= $robots ?>"/>

	<!-- OPEN GRAPH -->
	<?php //if(isset($article['image']) && $article['image'] != '') echo $article['image']; elseif(isset($category['image']) && $category['image'] != '') echo $category['image']; ?>
	<meta property = "og:image" content = "http://<?=$_SERVER['SERVER_NAME']?><?php if(isset($article) && isset($category)) echo getOgImage($article,'articles'); elseif(isset($category)) echo getOgImage($category,"categories"); else echo '/img/site/logo.png'; ?>"/>
	<meta property = "og:title" content = "<?= htmlspecialchars(getLangText($title)) ?>"/>
	<meta property = "og:description" content = "<?= htmlspecialchars(getLangText($description)) ?>"/>
	
	<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css"/>

	<?php
	$url = request_uri(false, true);
	?>

    <?=getHeadMetaLanguages()?>

	<!-- ПОДКЛЮЧАЕМ НЕОБХОДИМЫЕ СТИЛИ И СКРИПТЫ -->
	<?=getStyles()?>
	<!-- /ПОДКЛЮЧАЕМ НЕОБХОДИМЫЕ СТИЛИ И СКРИПТЫ -->

	<?php
	if(!isset($article) && isset($category))
	{
		$canonical = getFullUrl($category);
	}

	if($canonical)
		echo '<link rel="canonical" href="//'.$_SERVER['SERVER_NAME'].$canonical.'" />';
	?>
</head>