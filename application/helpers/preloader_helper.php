<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Подключение и вызов первоочередных необходимых функций
function beforeOutput()
{
    check_redirects();
    initLanguages();    // инициализируем языки

    $GLOBALS['beforeOutput'] = false;

    if(isset($_GET['clear_before_output'])) {
        $GLOBALS['beforeOutput'] = userdata('beforeOutput');
    }
    if ($GLOBALS['beforeOutput'] != true) {
        //log_googlebot();     // проверяем, гугл бот ли это
        initLanguages();    // инициализируем языки
        //ajaxInitLanguages();

        // Получаем значения, которые будем часто использовать
        $GLOBALS['site_name'] = userdata('site_name');
        if(!$GLOBALS['site_name']) {
            $GLOBALS['site_name'] = getOption('site_name');
            set_userdata('site_name', $GLOBALS['site_name']);
        }
        $GLOBALS['breadcrumb_separator'] = userdata('breadcrumb_separator');
        if(!$GLOBALS['breadcrumb_separator']) {
            $GLOBALS['breadcrumb_separator'] = getOption('breadcrumb_separator');
            set_userdata('breadcrumb_separator', $GLOBALS['breadcrumb_separator']);
        }

        $GLOBALS['site_name'] = userdata('site_name');
        if(!$GLOBALS['site_name']) {
            $GLOBALS['site_name'] = getOption('site_name');
            set_userdata('site_name', $GLOBALS['site_name']);
        }

        $GLOBALS['site_name'] = userdata('site_name');
        if(!$GLOBALS['site_name']) {
            $GLOBALS['site_name'] = getOption('site_name');
            set_userdata('site_name', $GLOBALS['site_name']);
        }

        $GLOBALS['site_name'] = userdata('site_name');
        if(!$GLOBALS['site_name']) {
            $GLOBALS['site_name'] = getOption('site_name');
            set_userdata('site_name', $GLOBALS['site_name']);
        }

        $GLOBALS['logo'] = userdata('logo');
        if(!$GLOBALS['logo']) {
            $GLOBALS['logo'] = getOption('logo');
            set_userdata('logo', $GLOBALS['logo']);
        }

        $GLOBALS['comments_on'] = userdata('comments_on');
        if(!$GLOBALS['comments_on']) {
            $GLOBALS['comments_on'] = getOption('comments_on');
            set_userdata('comments_on', $GLOBALS['comments_on']);
        }

        $GLOBALS['template'] = TEMPLATE;

        $GLOBALS['beforeOutput'] = true; // запоминаем, что эта функция уже отработала
    }
}

function check_redirects(){
    $model = getModel('redirects');
    $to = $model->getRedirectForThisUrl();
    //var_dump($to);die();
    if($to)
        redirect($to);
}