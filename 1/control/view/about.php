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
		$about = array('about'=>'关于我们','contact'=>'联系本站','declare'=>'版权声明','flash'=>'FLASH游戏发布','duty'=>'使用协议');
		$d = Utility::getgpc('d');
		$this->view->assign('d',$d);
		$this->view->assign('about',$about[$d]);
		$this->view->display('about');
	}

}



?>