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
		#专区按钮
		$zhuanqu = $this->api->game->zhuanqulist(200);
		$this->view->assign('zhuanqu',$zhuanqu);
		#网友正在玩
		$newthisgame = $this->api->game->newgame("","g_uptime desc,g_id DESC",10);
		$this->view->assign('newthisgame',$this->api->game->showurl($newthisgame));
		
		$this->view->display('zhuanti');
	}

}



?>