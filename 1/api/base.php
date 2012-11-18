<?php

/* 
	base ,
	收集整理  2010.12.12 11:00 tangwei $
 */

class base {
	
	var $view;
	var $time;
	var $cache = array();
	var $app = array();
	var $api;
	var $db;
	var $gameapi = 'http://api.le234.com/?code=';

	function __construct() {
		$this->base();
	}
	
	function base(){
		$this->init_var();
		$this->init_template();
	}
	
	function init_user(){
		$obj[userid] = 1;
		$this->user = $obj;	
	}
	
	function init_template() {
		require_once MainINC.'/Template.class.php';
		$this->view = new template();
	}
	
	
	function init_var() {
		$this->time = time();
		define('FORMHASH', $this->formhash());
	}
	
	function formhash() {
		return substr(md5(substr($this->time, 0, -4).MainKEY), 16);
	}

	function submitcheck() {
		return Utility::getgpc('formhash', 'P') == FORMHASH ? true : false;
	}
	
	function load($model, $dir = '', $base = NULL) {
		$base = $base ? $base : $this;
		if($dir){
			if(!isset($this->api->$dir->$model)) {
				require_once MainAPI."/$dir/$model.php";
				eval('$this->api->$dir->$model = new '.$model.'$dir($base);');
			}
		}else{
			if(!isset($this->api->$model)) {
				require_once MainAPI."/$model.php";
				eval('$this->api->$model = new '.$model.'model($base);');
			}
		}
	}

}

?>