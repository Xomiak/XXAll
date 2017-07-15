<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function initLanguages()
{
    $multilanguage = 0;
    if(!userdata('miltilanguage')){
        $multilanguage = getOption('multilanguage');
        set_userdata('multilanguage', $multilanguage);
    }

    if ($multilanguage == 1) {
        // список языков
        $sites = array();
        $GLOBALS['multilanguage'] = TRUE;
        $langs = array();
        $languages = getLanguages(1);
        $GLOBALS['default_lang'] = $default_lang = getDefaultLanguageCode();
        $GLOBALS['current_lang'] = $current_lang = getCurrentLanguageCode();

        //if ($default_lang) $default_lang = $default_lang['code'];
        for ($i = 0; $i < count($languages); $i++) {
            $langs[$i] = $languages[$i]['code'];
        }

        if(isset($_GET['clear'])) {
            unset_userdata('im_back');
            unset_userdata('language');
            die();
        }

        if(itsFirstVisit()){
            set_userdata('im_back', true);
            $browser_lang = getBrowserLanguage();
            if(isLanguageExists($browser_lang) && $browser_lang != $default_lang && $browser_lang != $current_lang && !isBot()){
                setLanguage($browser_lang);
                //vd($browser_lang);
                redirect("http://".$_SERVER['SERVER_NAME'].request_uri(false,true).'?lang='.$browser_lang,302);
                //vdd($browser_lang);
            }
        }


        //vdd($lang);

      //  $GLOBALS['current_lang'] = $current_lang = getCurrentLanguageCode();

        setLanguage();

        $lang = '';
        //vd($default_lang);
        if ($default_lang != $current_lang) $lang = '_' . $current_lang;
        /* сортировка массива языков */
        $key = array_search($current_lang, $langs);
        $tmp = $langs[0];
        $langs[0] = $langs[$key];
        $langs[$key] = $tmp;
        ////
        loadLanguage('client', $current_lang);
    } else $GLOBALS['multilanguage'] = FALSE;
}

function getHeadMetaLanguages(){
    $html = '<!--	Языковые версии-->'."\r\n";
    $langs = getLanguages(1);
    if($langs){
        $url = request_uri(false, true);
        foreach ($langs as $lang){
            $urlAdd = '?lang='.$lang['code'];
            if($lang['default'] == 1) $urlAdd = '';
            $html .= '<link rel="alternate" href="//'.$_SERVER['SERVER_NAME'].$url.$urlAdd.'" hreflang="'.$lang['code'].'">'."\r\n";
        }
    }
    return $html;
}

function getBrowserLanguage(){
    if(!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) return 'ru';
    return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

function ajaxInitLanguages()
{
    $default_lang = $current_lang = false;
    if (!isset($GLOBALS['default_lang']))
        $default_lang = $GLOBALS['default_lang'] = getDefaultLanguageCode();
    else $default_lang = $GLOBALS['default_lang'];

    if (!isset($GLOBALS['current_lang']))
        $current_lang = $GLOBALS['current_lang'] = getCurrentLanguageCode();
    else $current_lang = $GLOBALS['current_lang'];

    loadLanguage('client', $current_lang);
}

function getLanguagesPanel()
{
    $languages = getLanguages(1);
    $default_language = getDefaultLanguage();
    $current_language = getCurrentLanguage();

    $html = "";
    foreach ($languages as $language) {
        $html .= '
		<a href="' . request_uri() . '?lang=' . $language['code'] . '">
			<img src="' . $language['icon'] . '" alt="' . $language['name'] . '" title="' . $language['name'] . '"';
        if ($language['code'] == $current_language) $html .= ' class="active"';
        $html .= '/>
		</a>';
    }

    return $html;
}

function isColumnExists($table, $column)
{
    $CI = &get_instance();
    $ret = $CI->db->query("SHOW COLUMNS FROM `" . $table . "` WHERE `Field` = '" . $column . "'")->result_array();
    if ($ret) return true;
    else false;
}

function setLanguage($language = false)
{
    if ($language != false) $_GET['lang'] = $language;
    if (isset($_GET['lang'])) {
        if($_GET['lang'] == 'uk') {
            $_GET['lang'] = 'ua';
            redirect(request_uri(false,true).'?lang=ua');
        }
//        $language = getLanguageByCode($_GET['lang']);
//        if ($language) {
            $GLOBALS['current_lang'] = $_GET['lang'];
            if (userdata('language') != $GLOBALS['current_lang']) {
                $language = getLanguageByCode($_GET['lang'],1);
                if(!$language) {
                    set_userdata('language', $GLOBALS['default_lang']);
                    setLanguage($GLOBALS['default_lang']);
                    loadLanguage('client', $GLOBALS['default_lang']);
                } else {
                    set_userdata('language', $GLOBALS['current_lang']);
                    loadLanguage('client', $GLOBALS['current_lang']);
                }
                //redirect(request_uri());
            }
            if ($_GET['lang'] == $GLOBALS['default_lang']) {
                $GLOBALS['current_lang'] = $GLOBALS['default_lang'];
                redirect(request_uri());
            }
        } else {
            if ($GLOBALS['current_lang'] != $GLOBALS['default_lang']) {
                $GLOBALS['current_lang'] = $GLOBALS['default_lang'];
                set_userdata('language', $GLOBALS['current_lang']);
                redirect(request_uri());
            }
        }
    //} else err404();
}

function isLanguageExists($lang){
    $languages = getLanguages(1);
    foreach ($languages as $language){
        if($language['code'] == $lang)
            return true;
    }

    return false;
}

function getLanguages($active = -1, $noCurrent = false)
{
    $CI = &get_instance();
    return $CI->model_languages->getLanguages($active, $noCurrent);
}

function getDefaultLanguage()
{
    $CI = &get_instance();
    return $CI->model_languages->getDefaultLanguage();
}

function getDefaultLanguageCode()
{
    $default_language_code = userdata('default_language_code');
    if (!$default_language_code) {
        $CI = &get_instance();
        $default_language_code = $CI->model_languages->getDefaultLanguageCode();
    }

    return $default_language_code;
}

function getCurrentLanguage()
{
    $current = false;
    if (userdata('language') !== false) {
        $current = userdata('language');
    } else {
        $current = getDefaultLanguageCode();
    }
    $CI = &get_instance();
    return $CI->model_languages->getByCode($current);
}

function getCurrentLanguageCode()
{
    $current = false;
    if (userdata('language') !== false) {
        $current = userdata('language');
    } else {
        $current = getDefaultLanguageCode();
    }
    return $current;
}

function getLanguageByCode($code, $active){
    $CI = &get_instance();
    return $CI->model_languages->getByCode($code, $active);
}

function loadLanguage($lang, $current_lang)
{
    $CI = &get_instance();
    $CI->lang->load($lang, $current_lang);
}

function getMainCurrency()
{
    $CI = &get_instance();
    return $CI->model_currency->getMainCurrency();
}

function getLine($name)
{
    $CI = &get_instance();
    $ret = $CI->lang->line($name);
    if (!$ret) $ret = $name;
    return $ret;
}

function getCurrencyByCode($currency)
{
    $CI = &get_instance();
    return $CI->model_currency->getByCode($currency);
}

function getUrl($url)
{
    $CI = &get_instance();
    //$langs = getLanguages(1);
    $current_lang = getCurrentLanguageCode();
    $default_lang = getDefaultLanguageCode();
    if ($current_lang !=$default_lang) {
        $url = str_replace("?lang=" . $current_lang, '', $url);
        $url = str_replace("//", '/', $url);
        /*if (substr($url, count($url) - 1, count($url)) == '/')
            $url = substr($url, 0, count($url)-1);*/
        if (strpos($url, '?'))
            $url .= "&lang=" . $current_lang;
        else
            $url .= "?lang=" . $current_lang;

    }
    //alert($url);
    return $url;
}

function getTranslating($original, $table, $col, $value_id = false, $lang = false)
{
    $CI = &get_instance();
    if (!$lang) {
        $langs = getOptionArray('languages');
        $lang = (userdata('language')) ? userdata('language') : trim($langs[0]);
    }

    $CI->db->where('table', $table);
    $CI->db->where('col', $col);
    $CI->db->where('lang', $lang);
    if ($value_id)
        $CI->db->where('value_id', $value_id);
    else
        $CI->db->where('original', $original);

    $CI->db->limit(1);
    $ret = $CI->db->get('langs')->result_array();

    if (!$ret) return $original;
    else return $ret[0]['value'];

    //return $original;
}

function translateMain($main)
{
    $CI = &get_instance();
    $langs = array();
    $languages = $CI->model_languages->getLanguages(1);
    $default_lang = $CI->model_languages->getDefaultLanguage();
    if ($default_lang) $default_lang = $default_lang['code'];
    for ($i = 0; $i < count($languages); $i++) {
        $langs[$i] = $languages[$i]['code'];
    }
    $current_lang = (userdata('language')) ? userdata('language') : trim($langs[0]);

    if ($default_lang != $current_lang) {
        $CI->load->model('Model_main', 'main');

        if (isset($main['h1_' . $current_lang]) && $main['h1_' . $current_lang] != '') $main['h1'] = $main['h1_' . $current_lang];
        if (isset($main['title_' . $current_lang]) && $main['title_' . $current_lang] != '') $main['title'] = $main['title_' . $current_lang];
        if (isset($main['description_' . $current_lang]) && $main['description_' . $current_lang] != '') $main['description'] = $main['description_' . $current_lang];
        if (isset($main['keywords_' . $current_lang]) && $main['keywords_' . $current_lang] != '') $main['keywords'] = $main['keywords_' . $current_lang];
        if (isset($main['content_' . $current_lang]) && $main['content_' . $current_lang] != '') $main['content'] = $main['content_' . $current_lang];
        if (isset($main['seo_' . $current_lang]) && $main['seo_' . $current_lang] != '') $main['seo'] = $main['seo_' . $current_lang];
    }

    return $main;
}

function translateCategory($cat)
{
    $CI = &get_instance();
    $langs = array();
    $languages = $CI->model_languages->getLanguages(1);
    $default_lang = $CI->model_languages->getDefaultLanguage();
    if ($default_lang) $default_lang = $default_lang['code'];
    for ($i = 0; $i < count($languages); $i++) {
        $langs[$i] = $languages[$i]['code'];
    }
    $current_lang = (userdata('language')) ? userdata('language') : trim($langs[0]);

    if ($default_lang != $current_lang) {
        if (isset($cat['name_' . $current_lang]) && $cat['name_' . $current_lang] != '') $cat['name'] = $cat['name_' . $current_lang];
        if (isset($cat['title_' . $current_lang]) && $cat['title_' . $current_lang] != '') $cat['title'] = $cat['title_' . $current_lang];
        if (isset($cat['description_' . $current_lang]) && $cat['description_' . $current_lang] != '') $cat['description'] = $cat['description_' . $current_lang];
        if (isset($cat['keywords_' . $current_lang]) && $cat['keywords_' . $current_lang] != '') $cat['keywords'] = $cat['keywords_' . $current_lang];
        if (isset($cat['short_content_' . $current_lang]) && $cat['short_content_' . $current_lang] != '') $cat['short_content'] = $cat['short_content_' . $current_lang];
        if (isset($cat['seo_' . $current_lang]) && $cat['seo_' . $current_lang] != '') $cat['seo'] = $cat['seo_' . $current_lang];
    }

    return $cat;
}

function translatePage($page)
{
    $CI = &get_instance();
    $langs = array();
    $languages = $CI->model_languages->getLanguages(1);
    $default_lang = $CI->model_languages->getDefaultLanguage();
    if ($default_lang) $default_lang = $default_lang['code'];
    for ($i = 0; $i < count($languages); $i++) {
        $langs[$i] = $languages[$i]['code'];
    }
    $current_lang = (userdata('language')) ? userdata('language') : trim($langs[0]);

    if ($default_lang != $current_lang) {
        if (isset($page['name_' . $current_lang]) && $page['name_' . $current_lang] != '') $page['name'] = $page['name_' . $current_lang];
        if (isset($page['title_' . $current_lang]) && $page['title_' . $current_lang] != '') $page['title'] = $page['title_' . $current_lang];
        if (isset($page['description_' . $current_lang]) && $page['description_' . $current_lang] != '') $page['description'] = $page['description_' . $current_lang];
        if (isset($page['keywords_' . $current_lang]) && $page['keywords_' . $current_lang] != '') $page['keywords'] = $page['keywords_' . $current_lang];
        if (isset($page['content_' . $current_lang]) && $page['content_' . $current_lang] != '') $page['content'] = $page['content_' . $current_lang];
        if (isset($page['seo_' . $current_lang]) && $page['seo_' . $current_lang] != '') $page['seo'] = $page['seo_' . $current_lang];
    }

    return $page;
}

function translateArticle($article, $type = 'articles', $loadClierntLanguage = false)
{
    $CI = &get_instance();
    $langs = array();
    $languages = getLanguages(1);
    $default_lang = $current_lang = false;
    if (!isset($GLOBALS['default_lang']))
        $default_lang = $GLOBALS['default_lang'] = getDefaultLanguageCode();
    else $default_lang = $GLOBALS['default_lang'];

    if (!isset($GLOBALS['current_lang']))
        $current_lang = $GLOBALS['current_lang'] = getCurrentLanguageCode();
    else $current_lang = $GLOBALS['current_lang'];

    if ($loadClierntLanguage)
        loadLanguage('client', $current_lang);

//	for ($i = 0; $i < count($languages); $i++) {
//		$langs[$i] = $languages[$i]['code'];
//	}

    if ($default_lang != $current_lang) {
        $CI->load->model('Model_' . $type, 'articles');
        $settings = $CI->articles->getSettings(1);
        foreach ($settings as $setting) {
            $article[$setting['name']] = $article[$setting['name'] . "_" . $current_lang];
            //vd($article[$setting['name']]);
        }
    }

    return $article;
}

function getLangText($value, $lang = -1)
{

    $v = @unserialize($value);
    if ($v !== false) {
        if ($lang == -1) {
            $CI = &get_instance();
            $languages = $CI->model_languages->getLanguages(1);
            $default_lang = $CI->model_languages->getDefaultLanguage();
            $current_lang = (userdata('language')) ? userdata('language') : trim($default_lang['code']);
            if ($current_lang == $default_lang['code'])
                return (isset($v[$current_lang]) && !empty($v[$current_lang])) ? $v[$current_lang] : current($v);
            return (isset($v[$current_lang]) && !empty($v[$current_lang])) ? $v[$current_lang] : current($v);
        } else
            return (isset($v[$lang]) && !empty($v[$lang])) ? $v[$lang] : '';

    } else
        return $value;

}

function getMultilangHtmlTags($value, $tag, $name = '', $tagInputType = 'text', $additionalAttributes = '', $text = '', $requiredType = '', $arrToSelect = '')
{ //$value a:2:{s:3:"rus";s:12:"Страны";s:3:"english";s:8:"Countres";}
    $langs = getOptionArray('languages');
    switch ($tag) {
        case 'input':
            switch ($tagInputType) {
                case 'text':
                    if (($val = @unserialize($value)) !== false) {
                        ?>
                        <input type="text" class="form-control multilang <?= $langs[0] ?> editable"
                               name="<?= $name . '[' . $langs[0] . ']' ?>"
                               value="<?= (!empty($val[$langs[0]])) ? $val[$langs[0]] : '' ?>" <?= $additionalAttributes ?> <?= ($requiredType == 'all' || $requiredType == 'first') ? 'required' : '' ?> /> <?= $text ?>
                        <?php
                        for ($l = 1; $l < count($langs); $l++) {
                            ?>
                            <input type="text" class="form-control hidden multilang <?= $langs[$l] ?> editable"
                                   name="<?= $name . '[' . $langs[$l] . ']' ?>"
                                   value="<?= (isset($val[$langs[$l]]) && !empty($val[$langs[$l]])) ? $val[$langs[$l]] : '' ?>" <?= $additionalAttributes ?> <?= ($requiredType == 'all') ? 'required' : '' ?> /> <?= $text ?>
                            <?php
                        }
                    } else {
                        ?>
                        <input class="form-control" type="text" name="<?= $name ?>"
                               value="<?= $value ?>" <?= $additionalAttributes ?> <?= ($requiredType == 'all' || $requiredType == 'first') ? 'required' : '' ?> /> <?= $text ?>
                        <?php
                    }
                    break;
                case 'checkbox':
                    if (($val = @unserialize($value)) !== false) {
                        ?>
                        <label><input type="checkbox" class="form-control multilang <?= $langs[0] ?> editable"
                                      name="<?= $name ?>"
                                      value="<?= $text ?>" <?= $additionalAttributes ?> /><?= $val[$langs[0]] ?>
                        </label>
                        <?php
                        for ($l = 1; $l < count($langs); $l++) {
                            if (isset($val[$langs[$l]])) {
                                ?>

                                <label><input type="checkbox"
                                              class="form-control hidden multilang <?= $langs[$l] ?> editable"
                                              name="<?= $name ?>"
                                              value="<?= $text ?>" <?= $additionalAttributes ?> /><?= $val[$langs[$l]] ?>
                                </label>
                                <?php
                            }
                        }
                    } else {
                        ?>
                        <label><input class="form-control" type="checkbox" name="<?= $name ?>"
                                      value="<?= $text ?>" <?= $additionalAttributes ?> /><?= $value ?>
                        </label>
                        <?php
                    }
                    break;
            }
        case 'textarea':
            break;
        case 'select':
            if (is_array($value)) {
                ?>
                <select class="form-control" name="<?= $name ?>" <?= $additionalAttributes ?> >
                    <option value="NULL"></option>
                    <?php
                    if (($val = @unserialize($value[0]['value'])) !== false) {
                        for ($l = 1; $l < count($langs); $l++) {
                            for ($i = 0; $i < count($value); $i++) {
                                $val = @unserialize($value[$i]['value']);
                                if ($l == 0) {
                                    ?>
                                    <option class="form-control multilang <?= $langs[$l] ?>"
                                            value="<?= $value[$i]['id'] ?>" <?= (!empty($arrToSelect) && in_array($value[$i]['id'], $arrToSelect)) ? 'selected' : '' ?> ><?= stripcslashes($val[$langs[$l]]) ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option class="form-control hidden multilang <?= $langs[$i] ?>"
                                            value="<?= $value[$i]['id'] ?>" <?= (!empty($arrToSelect) && in_array($value[$i]['id'], $arrToSelect)) ? 'selected' : '' ?> ><?= stripcslashes($val[$langs[$l]]) ?></option>
                                    <?php
                                }
                            }
                        }
                    } else {
                        for ($i = 0; $i < count($value); $i++) {
                            ?>
                            <option
                                value="<?= $value[$i]['id'] ?>" <?= (!empty($arrToSelect) && in_array($value[$i]['id'], $arrToSelect)) ? 'selected' : '' ?> ><?= stripcslashes($value[$i]['value']) ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <?php
            } ?>

            <?php
            break;
        case 'custom-select':
            if (is_array($value)) {
                ?>
                <div class="form-control custom-select" <?= $additionalAttributes ?> >
                    <?php
                    if (($val = @unserialize($value[0]['value'])) !== false) {
                        for ($l = 1; $l < count($langs); $l++) {
                            for ($i = 0; $i < count($value); $i++) {
                                $val = @unserialize($value[$i]['value']);
                                if (!isset($val[$langs[$l]]) || empty($val[$langs[$l]]))
                                    $val[$langs[$l]] = $val[$langs[0]];
                                if ($l == 0) {
                                    ?>
                                    <div
                                        class="custom-select-val <?= (!empty($arrToSelect) && in_array($value[$i]['id'], $arrToSelect)) ? 'selected' : '' ?> multilang <?= $langs[$l] ?>"
                                        data-value="<?= $value[$i]['id'] ?>"><?= stripcslashes($val[$langs[$l]]) ?></div>
                                    <?php
                                } else {
                                    ?>
                                    <div
                                        class="custom-select-val <?= (!empty($arrToSelect) && in_array($value[$i]['id'], $arrToSelect)) ? 'selected' : '' ?> hidden multilang <?= $langs[$i] ?>"
                                        data-value="<?= $value[$i]['id'] ?>"><?= stripcslashes($val[$langs[$l]]) ?></div>
                                    <?php
                                }
                            }
                        }
                    } else {
                        for ($i = 0; $i < count($value); $i++) {
                            ?>
                            <div
                                class="custom-select-val <?= (!empty($arrToSelect) && in_array($value[$i]['id'], $arrToSelect)) ? 'selected' : '' ?>"
                                data-value="<?= $value[$i]['id'] ?>"><?= stripcslashes($value[$i]['value']) ?></div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
            } ?>

            <?php
            break;
        case 'span':
            if (($val = @unserialize($value)) !== false) {
                ?>
                <span class="multilang <?= $langs[0] ?>" <?= $additionalAttributes ?> ><?= $val[$langs[0]] ?></span>
                <?php
                for ($l = 1; $l < count($langs); $l++) {
                    if (isset($val[$langs[$l]])) {
                        ?>
                        <span
                            class="multilang <?= $langs[$l] ?>" <?= $additionalAttributes ?> ><?= $val[$langs[$l]] ?></span>
                        <?php
                    }
                }
            } else {
                ?>
                <span class="multilang <?= $langs[0] ?>" <?= $additionalAttributes ?> ><?= $value ?></span>
                <?php
            }
            break;
    }
}

function languagesCount($active)
{
    $CI = &get_instance();
    return $CI->model_languages->languagesCount($active);
}

function getTranslate($itemId, $itemName, $languageCode = false, $type = 'articles'){
    $model = getModel('languages');
    $translate = $model->getTranslate($itemId,$itemName,$languageCode,$type);
    if(isset($translate)) return $translate;

    return false;
}

function getTranslateValue($itemId, $itemName, $languageCode = false, $type = 'articles'){
    $translate = getTranslate($itemId,$itemName,$languageCode,$type);
    if(isset($translate['value'])) return $translate['value'];

    return false;
}

function addOrEditTranslate($itemId, $itemName, $languageCode, $type, $value, $new, $returnTranslate = true){
    $result = getTranslate($itemId, $itemName, $languageCode, $type);
    $CI = &get_instance();
    $dbins = array(
        'item_id'   => $itemId,
        'item_name'   => $itemName,
        'language_code' => $languageCode,
        'type'  => $type,
        'value' => $value,
        'new'   => $new
    );
    if(!$result)
        $result = $CI->db->insert('translations', $dbins);
    else {
        $result = $CI->db->where('id',$result['id'])->limit(1)->update('translations', $dbins);
    }

    if($result && $returnTranslate){
        $result = getTranslate($itemId, $itemName, $languageCode, $type);
    }

    return $result;
}

function getTranslateValueById($id){
    $model = getModel('languages');
    $tramslate = $model->getTranslateById($id);
    if(isset($tramslate['value'])) return $tramslate['value'];

    return false;
}

function setTrnslatesItemIds($oldId, $newId, $type = 'articles'){
    $CI = &get_instance();
    $CI->db->where('item_id', $oldId);
    $CI->db->where('type', $type);
    $CI->db->where('new', 1);
    $CI->db->update('translations', array('item_id' => $newId, 'new' => 0));
}

function getTranslateIdFromShortcode($value){
    if(isTranslateTableValue($value)) {
        $start = mb_strpos($value, '[');
        if ($start !== false) {
            $end = mb_strpos($value, ']');
            if ($end !== false) {
                $res = mb_substr($value, $start, ($end - $start), 'UTF-8');
                $res = str_replace('[**', '', $res);
                $tArr = explode(':', $res);
                if (isset($tArr[0]) && isset($tArr[1])) {
                    $translateId = $tArr[1];
                    return getTranslateValueById($translateId);
                }
            }
        }
    }
    return $value;
}

function isTranslateTableValue($value){
    if(mb_strpos($value,'[**translate:', null, 'UTF-8') !== false)
        return true;

    return false;
}