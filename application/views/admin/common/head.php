<?php
$CI = & get_instance();
$langs = array();

$languages = $CI->model_languages->getLanguages();
for($i = 0; $i < count($languages); $i++)
{
    $langs[$i] = $languages[$i]['code'];
}
$default_lang = $CI->model_languages->getDefaultLanguage();
if(isset($default_lang['code'])) $default_lang = $default_lang['code'];

$current_lang = (userdata('language')) ? userdata('language') : trim($default_lang);
if(!isset($title))
    $title = 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title ?> - <?= $CI->config->item('cms_name') ?> <?= $CI->config->item('cms_version') ?> Админ</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenger Admin Theme">
    <meta name="author" content="KaijuThemes">

    <link href='http://fonts.googleapis.com/css?family=RobotoDraft:300,400,400italic,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600,700' rel='stylesheet' type='text/css'>

    <!--[if lt IE 10]>
    <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/js/media.match.min.js"></script>
    <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/js/placeholder.min.js"></script>
    <![endif]-->

    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">        <!-- Font Awesome -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/css/styles.css" rel="stylesheet">                                     <!-- Core CSS with all styles -->
    

    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/jstree/dist/themes/avenger/style.min.css" rel="stylesheet">    <!-- jsTree -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/codeprettifier/prettify.css" rel="stylesheet">                <!-- Code Prettifier -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->

    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/pines-notify/pnotify.css" rel="stylesheet"> 		<!-- PNotify -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/css/ie8.css" rel="stylesheet">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
    <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/charts-flot/excanvas.min.js"></script>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->

    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/form-daterangepicker/daterangepicker-bs3.css" rel="stylesheet"> 	<!-- DateRangePicker -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet"> 					<!-- FullCalendar -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/charts-chartistjs/chartist.min.css" rel="stylesheet"> 				<!-- Chartist -->

    <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->

    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/css/umh.css" rel="stylesheet">

    
    <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/js/admin/list_actions.js"></script>


