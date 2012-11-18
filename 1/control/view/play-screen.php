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
		$this->load('game');
	}
	
	function onls(){
		#游戏详情
		$gameid = Utility::getgpc('gameid');
		$gameshow = $this->api->game->gameshow($gameid);
		$gameshow = $this->api->game->showurl($gameshow);
		$gameshow = $gameshow[0];
		$this->view->assign('gameshow',$gameshow);
		$this->view->display('play-screen');
	}

}



?>