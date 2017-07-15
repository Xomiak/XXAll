<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function err404()
{
    /*header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $c = file_get_contents("http://".$_SERVER['SERVER_NAME']."/err404/");
    $c = str_replace('index, follow', 'noindex, nofollow', $c);
    echo $c;
    die();*/
    //redirect('/err404/');
    show_404($_SERVER['REQUEST_URI']);
}