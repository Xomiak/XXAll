<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Сохраняем информацию о посещении страницы Гугл Ботом
function log_googlebot(){
    if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Googlebot' ) !== false )
    {
        $log_googlebot = getOption('log_googlebot');
        if($log_googlebot == 1){
            $CI = & get_instance();
            $log_path = $CI->config->item('log_path');
            $log_date_format = $CI->config->item('log_date_format');
            if($log_path == '') $log_path = $_SERVER['DOCUMENT_ROOT'].'/application/logs/';
            $log_msg = date($log_date_format).' Google Bot посетил страницу: '.$_SERVER['REQUEST_URI'];
            file_put_contents($log_path, PHP_EOL . $log_msg, FILE_APPEND);
        }
    }
}