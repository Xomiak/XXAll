<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function string_limit_words($string, $word_limit, $from = 0)
{
       $words = explode(' ', $string);
       $return = array_slice($words, $from, $word_limit);
       if(count($words) > $word_limit)
       array_pop($words);
       return implode(' ', $return);
}

function string_words_count($string)
{
    $words = explode(' ', $string);
    return count($words);
}

function getRowsText($text, $max_width, $max_height, $separator = "\n", $font_size = 16, $font = "/fonts/Bebas/Bebas Neue Regular.ttf"){
    $arr = explode(' ', $text);
    $arrCount = count($arr);
    $ret = "";
    $rowsCount = 1;
    for($i = 0; $i < $arrCount; $i++)
    {
        $word = $arr[$i];
        // Временная строка, добавляем в нее слово
        $tmp_string = $ret.' '.$word;

        // Получение параметров рамки обрамляющей текст, т.е. размер временной строки
        $textbox = imagettfbbox($font_size, 0, $_SERVER['DOCUMENT_ROOT'].$font, $tmp_string);

        // Если временная строка не укладывается в нужные нам границы, то делаем перенос строки, иначе добавляем еще одно слово
        if($textbox[2] > $max_width) {
            $ret .= ($ret == "" ? "" : $separator) . $word;
            $rowsCount++;
        }
        else
            $ret.=($ret==""?"":" ").$word;

        // Проверяем высоту
        if($textbox[3] > $max_height){
            $font_size = $font_size - 2;
            //      vd($textbox[3]);
            $ret = "";
            $i = -1;
        }
    }
    return $ret;
}