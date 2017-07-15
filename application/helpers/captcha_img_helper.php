<?php  if (!defined('BASEPATH'))
	exit('No direct script access allowed');

function createCaptcha() {
	$CI = & get_instance();
	$CI->load->helper('captcha');
	$vals = array(
		'img_path' => './captcha/',
		'font_path' => './system/fonts/texb.ttf',
		'img_url' => 'http://' . $_SERVER['SERVER_NAME'] . '/captcha/'
	);
	$cap = create_captcha($vals);
	$data = array(
		'captcha_time' => $cap['time'],
		'ip_address' => $CI->input->ip_address(),
		'word' => $cap['word']
	);
	$query = $CI->db->insert_string('captcha', $data);
	$CI->db->query($query);
	return $cap;
}

function checkCaptcha($captcha) {
	$CI = & get_instance();
	$expiration = time() - 7200; // Two hour limit
	$CI->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);
	// Then see if a captcha exists:
	$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
	$binds = array($captcha, $CI->input->ip_address(), $expiration);
	$query = $CI->db->query($sql, $binds);
	$row = $query->row();
	///////////
	//var_dump($row->count);
	if ($row->count == 0) {
		$err['captcha'] = $CI->lang->line('category_capcha_err');
	}
	return (isset($err)) ? $err : true;
}