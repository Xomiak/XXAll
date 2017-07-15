<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function translitRuToEn($string, $allowed = false)
{
    $r_trans = array(
        "а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к", "л", "м",
        "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "э",
        "ю", "я", "ъ", "ы", "ь", " ", ",", "(", ")", "\"", "А", "Б", "В", "Г",
        "Д", "Е", "Ё", "Ж", "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р",
        "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Э", "Ю", "Я", "Ъ", "Ы",
        "Ъ", "/", ".", "«", "»", "!", "&", "'", ":", "#", "$", "№", "?", "…", "+", "@", "%", "*",
        "і", "І", "є", "Є", "Ь"
    );

    $e_trans = array(
        "a", "b", "v", "g", "d", "e", "e", "j", "z", "i", "i", "k", "l", "m",
        "n", "o", "p", "r", "s", "t", "u", "f", "h", "c", "ch", "sh", "sch",
        "e", "yu", "ya", "", "i", "", "-", "-", "-", "", "", "a", "b", "v", "g",
        "d", "e", "Yo", "g", "z", "i", "i", "k", "l", "m", "n", "o", "p", "r",
        "s", "t", "u", "f", "h", "c", "Ch", "Sh", "Sch", "e", "Yu", "Ya", "",
        "i", "", "-", "", "", "", "", "ft", "", "", "no", "s", "nomber", "", "", "-plus-", "", "", "",
        "i", "i", "e", "e", ""
    );

    $string = str_replace($r_trans, $e_trans, $string);

    $string = str_replace('--', '-', $string);
    $string = str_replace('--', '-', $string);
    $string = str_replace('--', '-', $string);
    $string = str_replace('--', '-', $string);
    $string = str_replace('--', '-', $string);


    $string = preg_replace('/[^a-z0-9-]+/is', '', $string);

    return $string;
}


function createUrl($name, $config = false)
{
    if (!isset($config['max_chars']))
        $config['max_chars'] = 20;

    $name = trim(mb_strtolower($name));
    $CI = &get_instance();
    $url = translitRuToEn($name);


    if ($config['max_chars']) $url = substr($url, 0, $config['max_chars']);


    // Проверяем существование урла
    // Categories
    $CI->db->where('url', $url);
    if (isset($config['type']) && $config['type'] == 'categories' && isset($config['my_id']))
        $CI->db->where('id <>', $config['my_id']);
    $CI->db->limit(1);
    $res = $CI->db->get('categories')->result_array();
    $resc = 1;
    $url2 = $url;
    while ($res) {
        $url2 = $url . '-' . $resc;
        $CI->db->where('url', $url2);
        if (isset($config['type']) && $config['type'] == 'categories' && isset($config['my_id']))
            $CI->db->where('id <>', $config['my_id']);
        $CI->db->limit(1);
        $res = $CI->db->get('categories')->result_array();
        $resc++;
    }
    $url = $url2;

    // Articles
    $CI->db->where('url', $url);
    if (isset($config['type']) && $config['type'] == 'categories' && isset($config['my_id']))
        $CI->db->where('id <>', $config['my_id']);
    $CI->db->limit(1);
    $res = $CI->db->get('articles')->result_array();
    $resc = 1;
    $url2 = $url;
    while ($res) {
        $url2 = $url . '-' . $resc;
        $CI->db->where('url', $url2);
        if (isset($config['type']) && $config['type'] == 'articles' && isset($config['my_id']))
            $CI->db->where('id <>', $config['my_id']);
        $CI->db->limit(1);
        $res = $CI->db->get('articles')->result_array();
        $resc++;
    }
    $url = $url2;

    // Products
    $CI->db->where('url', $url);
    if (isset($config['type']) && $config['type'] == 'products' && isset($config['my_id']))
        $CI->db->where('id <>', $config['my_id']);
    $CI->db->limit(1);
    $res = $CI->db->get('products')->result_array();
    $resc = 1;
    $url2 = $url;
    while ($res) {
        $url2 = $url . '-' . $resc;
        $CI->db->where('url', $url2);
        if (isset($config['type']) && $config['type'] == 'products' && isset($config['my_id']))
            $CI->db->where('id <>', $config['my_id']);
        $CI->db->limit(1);
        $res = $CI->db->get('products')->result_array();
        $resc++;
    }

    /// Pages
    $CI->db->where('url', $url);
    if (isset($config['type']) && $config['type'] == 'pages' && isset($config['my_id']))
        $CI->db->where('id <>', $config['my_id']);
    $CI->db->limit(1);
    $res = $CI->db->get('pages')->result_array();
    $resc = 1;
    $url2 = $url;
    while ($res) {
        $url2 = $url . '-' . $resc;
        $CI->db->where('url', $url2);
        if (isset($config['type']) && $config['type'] == 'pages' && isset($config['my_id']))
            $CI->db->where('id <>', $config['my_id']);
        $CI->db->limit(1);
        $res = $CI->db->get('pages')->result_array();
        $resc++;
    }
    $url = $url2;

    return $url;
}

function createFilename($name, $extention = '', $type = 'articles', $date = false)
{
    //return date("Y-m-d-H-i-s");
    if (!$date)
        $date = date("Y-m-d");

    $name = translitRuToEn($name);
    $newName = $name;
    $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $type . '/' . $date . '/' . $name;
    if ($extention != '') $path .= '.' . $extention;


    $newPath = $path;

    $i = 1;

    /** проверяем, нет ли у нас уже файла с таким названием и если есть, добавляем номер в название */
    while (file_exists($newPath) == true) {
        $newPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $type . '/' . $date . '/' . $name . '-' . $i;
        if ($extention != '') $newPath .= '.' . $extention;
        $newName = $name . '-' . $i;
        $i++;
    }

    return $newName;
}

//function getNewFileName($config = array('name' => false, 'extention' => '', 'type' => 'articles', 'date' => date("Y-m-d-H-i-s"), 'rewrite' => false)){
//    $name = false;
//    $extention
//}

function testingUrl($url, $config = false)
{

}

function encodeSymbs($str)
{
    $tag_url = $str;
    $tag_url = str_replace('\'', '--kav--', $tag_url);
    $tag_url = str_replace('’', '--kav2--', $tag_url);
    $tag_url = str_replace('`', '--kav3--', $tag_url);
    $tag_url = str_replace('"', '--2kav--', $tag_url);
    $tag_url = str_replace('!', '--voskl--', $tag_url);
    $tag_url = str_replace('*', '--zvezda--', $tag_url);
    $tag_url = str_replace('@', '--sobaka--', $tag_url);
    $tag_url = str_replace('#', '--resh--', $tag_url);
    $tag_url = str_replace('№', '--no--', $tag_url);
    $tag_url = str_replace('%', '--proc--', $tag_url);
    $tag_url = str_replace('&', '--amp--', $tag_url);
    $tag_url = str_replace('?', '--vopr--', $tag_url);
    $tag_url = str_replace('(', '--lskob--', $tag_url);
    $tag_url = str_replace(')', '--rskob--', $tag_url);
    $tag_url = str_replace('+', '--plus--', $tag_url);
    $tag_url = str_replace('=', '--ravno--', $tag_url);
    $tag_url = str_replace('\\', '--lslesh--', $tag_url);
    $tag_url = str_replace('/', '--rslesh--', $tag_url);
    $tag_url = str_replace('|', '--I--', $tag_url);
    $tag_url = str_replace('[', '--lkskob--', $tag_url);
    $tag_url = str_replace(']', '--rkskob--', $tag_url);
    $tag_url = str_replace('$', '--baks--', $tag_url);

    return $tag_url;
}

function decodeSymbs($str)
{
    $tag_url = $str;
    $tag_url = str_replace('--kav--', '\'', $tag_url);
    $tag_url = str_replace('--kav2--', '’', $tag_url);
    $tag_url = str_replace('--kav3--', '`', $tag_url);
    $tag_url = str_replace('--2kav--', '"', $tag_url);
    $tag_url = str_replace('--voskl--', '!', $tag_url);
    $tag_url = str_replace('--zvezda--', '*', $tag_url);
    $tag_url = str_replace('--sobaka--', '@', $tag_url);
    $tag_url = str_replace('--resh--', '#', $tag_url);
    $tag_url = str_replace('--no--', '№', $tag_url);
    $tag_url = str_replace('--proc--', '%', $tag_url);
    $tag_url = str_replace('--amp--', '&', $tag_url);
    $tag_url = str_replace('--vopr--', '?', $tag_url);
    $tag_url = str_replace('--lskob--', '(', $tag_url);
    $tag_url = str_replace('--rskob--', ')', $tag_url);
    $tag_url = str_replace('--plus--', '+', $tag_url);
    $tag_url = str_replace('--ravno--', '=', $tag_url);
    $tag_url = str_replace('--lslesh--', '\\', $tag_url);
    $tag_url = str_replace('--rslesh--', '/', $tag_url);
    $tag_url = str_replace('--I--', '|', $tag_url);
    $tag_url = str_replace('--lkskob--', '[', $tag_url);
    $tag_url = str_replace('--rkskob--', ']', $tag_url);
    $tag_url = str_replace('--baks--', '$', $tag_url);

    return $tag_url;
}

function BBCodesToHtml($str)
{
    $str = str_replace('[b]', '<b>', $str);
    $str = str_replace('[/b]', '</b>', $str);
    $str = str_replace('[i]', '<i>', $str);
    $str = str_replace('[/i]', '</i>', $str);
    $str = str_replace('[br]', '<br />', $str);
    $str = str_replace('[quote]', '<div class="comments_quote">', $str);
    $str = str_replace('[/quote]', '</div><br />', $str);
    return $str;
}

function getLetterByNum($num)
{
    $abc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return $abc[$num];
}

?>