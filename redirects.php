<?php

if ( ! function_exists('redirect'))
{
    function redirect($uri = '', $method = 'location', $http_response_code = 301)
    {
        if ( ! preg_match('#^https?://#i', $uri))
        {
            $uri = $uri;
        }

        switch($method)
        {
            case 'refresh'	: header("Refresh:0;url=".$uri);
                break;
            default			: header("Location: ".$uri, TRUE, $http_response_code);
                break;
        }
        exit;
    }
}
$url = $_SERVER['REQUEST_URI'];




// For admin login
if($url == '/a/') redirect('/admin/login/soc/');
if($url == '/sa/') redirect('/admin/login/');








?>