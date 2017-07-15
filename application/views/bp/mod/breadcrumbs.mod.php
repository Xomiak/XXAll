<?php
$this->load->helper('breadcrumbs_helper');
$bcarr = getBCCache($_SERVER['REQUEST_URI']);
if(!$bcarr){
    $bcarr = getBreadcrumbsArry();
}
if($bcarr && is_array($bcarr)) {
    $count = count($bcarr);
    echo '<div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs">';
    for($i = 0; $i < $count; $i++){
        $bc = $bcarr[$i];
        if($i > 0) echo ' » ';
        if(($i+1) == $count){   // выводим финальную часть
            echo '<span>'.$bc['name'].'</span>';
        } else{     // выводим очередную крошку
            echo '
            <span typeof="v:Breadcrumb">
                <a href="'.$bc['url'].'" rel="v:url" property="v:title"><span itemprop="title">'.$bc['name'].'</span></a>
            </span>
            ';
        }
    }
    echo '</div>';
}