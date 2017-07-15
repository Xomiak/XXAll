<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//=====================================================
// ULogin session CodeIgniter
//-----------------------------------------------------
// Модуль поддержки сессий для uLogin
//-----------------------------------------------------
// http://ulogin.ru/
// team@ulogin.ru
// License GPL3
//-----------------------------------------------------
// Copyright (c) 2011-2012 uLogin
//=====================================================

require_once X_PATH."/application/libraries/Ulogin.php";
//vdd(X_PATH."/application/libraries/Ulogin.php");

//! Библиотека Uauth для фреймворка CodeIgniter
/** Организует авторизацию пользователей и работу в сессии посредством библиотеки ULogin
* http://ulogin.ru/
*/

class Uauth extends Ulogin {
	const session_key='ulogin_data';

	function __construct($params=array()) {
		parent::__construct($params);
		if(session_id()=='') {
			session_name('ul1');
			session_start();
		}
		$session_key = userdata(self::session_key);
		if($session_key == NULL)    $session_key = false;
		$this->userdata = $session_key;
	}

/** Возвращает ассоциативный массив с данными о пользователе. Поля массива описаны в методе set_fields
* \result данные о пользователе от провайдера авторизации
*
* Пример: $userdata=$this->uauth->userdata();
*
* $userdata содержит данные, предоставленные провайдером авторизации.
*/
	public function userdata() {
		if($this->userdata===false) {
			parent::userdata();
			set_userdata(self::session_key, $this->userdata);
			$_SESSION[self::session_key]=$this->userdata;
		}
		return $this->userdata;
	}

/** Завершает сессию и очищает сохраненные переменные
*/
	public function logout() {
		parent::logout();
		unset_userdata(self::session_key);
	}
}

/* End of file Uauth.php */