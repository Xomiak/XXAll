<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function getBreadcrumbsArry(){
    $CI = & get_instance();
    $sgmStr = '';
    $bcarr = array();
    $bccount = 0;
    for ($s = 1; $CI->uri->segment($s) !== NULL; $s++) {
        $sgmNow = $CI->uri->segment($s);
        $sgm[] = $sgmNow;
        $sgmStr .= '/' . $CI->uri->segment($s);
    }
    if (!empty($sgmStr)) {
        $brdcrbs = false;
        $needUpdate = false;
        $bc_id = false;
        if (isset($brdcrbs[0]) && $brdcrbs[0]['date'] != date("Y-m-d")) {
            $needUpdate = true;
            $bc_id = $brdcrbs[0]['id'];
            $brdcrbs = false;
        }
        $bcarr[$bccount]['name'] = getLine('Главная');
        $bcarr[$bccount]['url'] = getUrl('/');
        $bccount++;

        if (request_uri(false,true) == '/user/add-organization/') {
            $bcarr[$bccount]['name'] = getLine('Личный кабинет');
            $bcarr[$bccount]['url'] = '/user/mypage/';
            $bccount++;
            $bcarr[$bccount]['name'] = 'Добавление новой организации в справочник';
            $bcarr[$bccount]['url'] = '/user/add-organization/';
            $bccount++;

        } elseif ($_SERVER['REQUEST_URI'] == '/user/mypage/') {
            $bcarr[$bccount]['name'] = 'Личный кабинет';
            $bcarr[$bccount]['url'] = '/user/mypage/';
            $bccount++;

        } elseif (strpos($_SERVER['REQUEST_URI'], '/user/edit-organization/') !== false) {
            $bcarr[$bccount]['name'] = 'Личный кабинет';
            $bcarr[$bccount]['url'] = '/user/mypage/';
            $bccount++;
            $bcarr[$bccount]['name'] = 'Редактирование организации';
            $bcarr[$bccount]['url'] = $_SERVER['REQUEST_URI'];
            $bccount++;

        } elseif (strpos($_SERVER['REQUEST_URI'], '/user/buy-type/') !== false) {
            $bcarr[$bccount]['name'] = 'Личный кабинет';
            $bcarr[$bccount]['url'] = '/user/mypage/';
            $bccount++;
            $bcarr[$bccount]['name'] = 'Оплата тарифа';
            $bcarr[$bccount]['url'] = $_SERVER['REQUEST_URI'];
            $bccount++;

        } elseif (strpos($_SERVER['REQUEST_URI'], '/user/set-type/') !== false) {
            $bcarr[$bccount]['name'] = 'Личный кабинет';
            $bcarr[$bccount]['url'] = '/user/mypage/';
            $bccount++;
            $bcarr[$bccount]['name'] = 'Изменение тарифа';
            $bcarr[$bccount]['url'] = $_SERVER['REQUEST_URI'];
            $bccount++;

        } elseif (strpos($_SERVER['REQUEST_URI'], '/user/adresses/') !== false) {
            $bcarr[$bccount]['name'] = 'Личный кабинет';
            $bcarr[$bccount]['url'] = '/user/mypage/';
            $bccount++;
            $bcarr[$bccount]['name'] = 'Адреса организации';
            $bcarr[$bccount]['url'] = $_SERVER['REQUEST_URI'];
            $bccount++;

        } elseif (strpos($_SERVER['REQUEST_URI'], '/user/add-adress/') !== false) {
            $bcarr[$bccount]['name'] = 'Личный кабинет';
            $bcarr[$bccount]['url'] = '/user/mypage/';
            $bccount++;
            $bcarr[$bccount]['name'] = 'Добавить адрес организации';
            $bcarr[$bccount]['url'] = $_SERVER['REQUEST_URI'];
            $bccount++;

        }
        elseif (strpos($_SERVER['REQUEST_URI'], '/tags/') !== false) {
            $bcarr[$bccount]['name'] = 'Тэги';
            $bcarr[$bccount]['url'] = '/';
            $bccount++;
        }
        if (!$brdcrbs) {
            $url = '';
            for ($s = 0; $s < count($sgm); $s++) {
                $query = "SELECT %s FROM %s WHERE url = '%s' OR url LIKE '/%s/' LIMIT 1";
                $success = false;
                $tables = array('menus', 'categories', 'pages', 'articles', 'products', 'tags');
                //ob_start();
                foreach ($tables as $table) {
                    $name = "name";
                    $curLang = getCurrentLanguageCode();
                    if ($curLang != getDefaultLanguageCode())
                        $name .= "_" . $curLang;
                    $brdcrbs = $CI->db->query(sprintf($query, $name . ', url', $table, $sgm[$s], $sgm[$s]))->result_array();
                    //vd($brdcrbs);
                    if ($brdcrbs) {
                        $url .= (($brdcrbs[0]['url'][0] != '/') ? '/' : '') . $brdcrbs[0]['url'] . (($brdcrbs[0]['url'][strlen($brdcrbs[0]['url']) - 1] != '/') ? '/' : '');
                        $url = str_replace('//', '/', $url);

                        $bcarr[$bccount]['name'] = getLangText($brdcrbs[0][$name]);
                        $bcarr[$bccount]['url'] = getUrl($url);
                        $bccount++;

                        break;
                    }
                }
            }
        }

        if (strpos($_SERVER['REQUEST_URI'], '/all/') !== false) {
            $bcarr[$bccount]['name'] = 'Все '.mb_strtolower($bcarr[$bccount-1]['name']);
            $bcarr[$bccount]['url'] = $bcarr[$bccount-1]['url'].'all/';
            $bccount++;
        }
        return $bcarr;
    }
}

function showBreadCrumbs(){
    echo  getBreadcrumbs();
}

function getBreadcrumbs(){
    ob_start();

    $bcarr = getBCCache($_SERVER['REQUEST_URI']);
    if(!$bcarr){
        $bcarr = getBreadcrumbsArry();
    }
    if($bcarr && is_array($bcarr)) {
        $count = count($bcarr);
        echo '<div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs">';
        for($i = 0; $i < $count; $i++){
            $bc = $bcarr[$i];
            if($i > 0) echo '<span class="breadcrumb-separator"> '.$GLOBALS['breadcrumb_separator'].' </span>';
            if(($i+1) == $count){   // выводим финальную часть
                echo '<span class="breadcrumb-final">'.$bc['name'].'</span>';
            } else{     // выводим очередную крошку
                echo '
            <span typeof="v:Breadcrumb" class="breadcrumb-link">
                <a href="'.$bc['url'].'" rel="v:url" property="v:title"><span itemprop="title">'.$bc['name'].'</span></a>
            </span>
            ';
            }
        }
        echo '</div>';
    }

    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getBCCache($url){
    $CI = & get_instance();
    $CI->db->where('url', $url);
    $CI->db->limit(1);
    $bc = $CI->db->get('breadcrumbs_cache')->result_array();
    $bcarr = false;
    if(!$bc){
        $bcarr = getBreadcrumbsArry();
        saveBCCache($url, $bcarr, 0);
    } elseif (isset($bc[0]['date']) && $bc[0]['date'] != date("Y-m-d")){
        $bcarr = getBreadcrumbsArry();
        saveBCCache($url, $bcarr, 1);
    } elseif(isset($bc[0]['breadcrumbs']) && $bc[0]['breadcrumbs'] != ''){
        $bcarr = json_decode($bc[0]['breadcrumbs'], true);
    }

    return $bcarr;
}

function saveBCCache($url, $bcarr, $needUpdate = -1){
    $CI = & get_instance();
    $bcjson = json_encode($bcarr);
    if($needUpdate == -1){
        $CI->db->select('id, breadcrumbs, date, time, unix');
        $CI->db->where('url', $url);
        
        $brdcrbs = $CI->db->get('breadcrumbs_cache')->result_array();
        if (isset($brdcrbs[0]) && $brdcrbs[0]['date'] != date("Y-m-d")) {
            $needUpdate = 1;
        }
    }

    // сохраняем крошки в кэш
    if($needUpdate){
        $CI->db->where('url', $url)->limit(1)->update("breadcrumbs_cache", array('url' => $_SERVER['REQUEST_URI'], 'breadcrumbs' => $bcjson, 'date' => date("Y-m-d"), 'time' => date("H:i"), 'unix' => time()));
    } else {
        $CI->db->insert('breadcrumbs_cache', array('url' => $_SERVER['REQUEST_URI'], 'breadcrumbs' => $bcjson, 'date' => date("Y-m-d"), 'time' => date("H:i"), 'unix' => time()));
    }
}

