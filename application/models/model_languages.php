<?php
/**
 * Created by PhpStorm.
 * User: XomiaK
 * Date: 08.07.2016
 * Time: 15:53
 */

class Model_languages extends CI_Model {

    function getNewNum()
    {
        $num = $this->db->select_max('num')->get("languages")->result_array();
        if ($num[0]['num'] === NULL)
            return 0;
        else return ($num[0]['num'] + 1);
    }

    function getLanguages($active = -1, $noCurrent = false)
    {
        if($noCurrent) $this->db->where('code <>',getCurrentLanguageCode());
        if($active != -1) $this->db->where('active', $active);
        $this->db->order_by('num', 'ASK');
        return $this->db->get('languages')->result_array();
    }

    function getDefaultLanguage()
    {
        $this->db->where('default', 1);
        $ret = $this->db->get('languages')->result_array();
        if($ret) return $ret[0];
        return false;
    }

    function getDefaultLanguageCode()
    {
        $this->db->where('default', 1);
        $ret = $this->db->get('languages')->result_array();
        if($ret) return $ret[0]['code'];
        return false;
    }

    function getByCode($code, $active = -1)
    {
        if($active != -1) $this->db->where('active', $active);
        $this->db->where('code', $code);
        $ret = $this->db->get('languages')->result_array();
        if($ret) return $ret[0];
        return false;
    }

    function getById($id)
    {
        $this->db->where('id', $id);
        $ret = $this->db->get('languages')->result_array();
        if($ret) return $ret[0];
        return false;
    }

    function languagesCount($active = -1){
        if($active != -1) $this->db->where('active', $active);
        $this->db->from('languages');
        return $this->db->count_all_results();
    }

    function getTranslate($itemId, $itemName, $languageCode = false, $type = 'articles'){
        if(!$languageCode)
            $languageCode = getCurrentLanguageCode();
        $this->db->where('type', $type);
        $this->db->where('item_id', $itemId);
        $this->db->where('item_name', $itemName);
        $this->db->where('language_code', $languageCode);

        $this->db->limit(1);
        $result = $this->db->get('translations')->result_array();
        if(isset($result[0])) return $result[0];

        return false;
    }

    function getTranslateById($id){
        $this->db->where('id', $id);
        $this->db->limit(1);
        $result = $this->db->get('translations')->result_array();
        if(isset($result[0])) return $result[0];

        return false;
    }
}