<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function getLinkedTags($tags, $showCommas = false){
    $html = "";
    if($tags != ''){
        $arr = explode(',',$tags);
        if(is_array($arr)){
            foreach ($arr as $item){
                $tag = getTag(trim($item));
                if($tag){
                    if($html != '' && $showCommas == true)
                        $html .= ', ';
                    $html .= '<a href="/tags/'.$tag['url'].'/">'.$tag['name'].'</a>';
                }
            }
        }
    }
//vdd($tags);
    return $html;
}

function getTag($value){
    $CI = & get_instance();
    $CI->load->model('Model_tags', 'tags');
    return $CI->tags->getByName($value);
}

function getRandomTags($count = 10){
    $html = '';
    $CI = & get_instance();
    $CI->load->model('Model_tags', 'tags');
    $tags = $CI->db->query("SELECT name, url FROM tags WHERE count > 0")->result_array();

    if($tags){
        shuffle($tags);
        $tagsCount = count($tags);
        if($tagsCount < $count) $count = $tagsCount;
        for($i = 0; $i < $count; $i++){
            $html .= '<a href="/tags/'.$tags[$i]['url'].'/">'.$tags[$i]['name'].'</a> ';
        }
    }
    return $html;
}

function getTags($str){
    $tagsArr = explode(',',$str);
    if(is_array($tagsArr)){
        $count = count($tagsArr);
        for($i = 0; $i < $count; $i++){
            $tagsArr[$i] = trim($tagsArr[$i]);
        }
    } elseif($str != '')
        $tagsArr[0] = $str;
    return $tagsArr;
}