<?php
$sub = '';
$template = 'ro';
define(SITE, $template);
if (isset ($_SERVER['HTTP_HOST'])) {

    $url_path = explode('.', $_SERVER['HTTP_HOST']);
    if(is_array($url_path) && $url_path[0] != 'new'){
        $sub = $url_path[0];
        $template = $sub;
    }

    unset($url_path);
}

if(strpos($_SERVER['REQUEST_URI'],'admin/') !== false) {
    $template = 'admin';
}

define('SUB', $sub);
define('TEMPLATE', $template);

$path = $_SERVER['DOCUMENT_ROOT'];

if(SUB != 'new')
    $path = str_replace(SUB,'new',$path);

define(GENERAL_DOMAIN, '//new.xx.org.ua');
define(X_PATH, $path);
define(ENGINE_PATH, '//'.$_SERVER['SERVER_NAME']);
$templatePath = X_PATH.'/application/views/'.TEMPLATE;
//if(strpos($_SERVER['REQUEST_URI'],'admin/') !== false)
//    $templatePath =  X_PATH.'/applications/views/'.TEMPLATE;

define('TEMPLATE_PATH', $templatePath);