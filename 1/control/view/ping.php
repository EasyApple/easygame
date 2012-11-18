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
		$this->load('ping');
	}
	
	function onls(){
		$gid = Utility::getgpc('gid','P');
		$gnicheng = Utility::getgpc('gnicheng','P');
		$gcontent = Utility::getgpc('gcontent','P');
		if($gnicheng=='您的呢称'){ $gnicheng='匿名'; }
		if($gid && $gcontent){
			$this->api->ping->writeping($gid,$gnicheng,$gcontent);
			$pinglun = iconv('UTF-8','gb2312','评论已经提交,谢谢你的评论.');
			Utility::tsgAlert($pinglun);
		}else{
			$pinglun = iconv('UTF-8','gb2312','提交失败');
			Utility::tsgAlert($pinglun);
		}
	}

}



?>