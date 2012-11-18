<?php
/*
	@ 前台模块：首页
	@ 日期：2010-12-12

*/

class control extends base {
	function __construct() {
		$this->control();
	}
	
	function control() {
		parent::__construct();
		//$this->load('game');
	}
	
	function onls(){
		$d = Utility::getgpc('d');
		$this->view->assign('d',$d);
		$this->view->display('about');
	}

}



?>