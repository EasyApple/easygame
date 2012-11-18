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
		#随机时间
		$gametime = time()-rand(100000,2000000);
		$gametime = date("Y-m-d",$gametime);
		$this->view->assign('gametime',$gametime);
		#游戏标签
		$gametaglist = $this->api->game->gametaglist($gameid);
		$this->view->assign('gametaglist',$gametaglist);
		#专区按钮
		$zhuanqu = $this->api->game->zhuanqulist1(0,22);
		$this->view->assign('zhuanqu',$zhuanqu);
		#相关游戏
		$moregame = $this->api->game->newgame("g_type={$gameshow[g_type]}","g_renqi desc,g_id desc",40);
		$this->view->assign('moregame',$this->api->game->showurl($moregame));
		#更多游戏
		$allmoregame = $this->api->game->newgame("","g_renqi desc,g_id desc",120);
		$this->view->assign('allmoregame',$this->api->game->showurl($allmoregame));
		#网友正在玩
		$newthisgame = $this->api->game->newgame("","g_uptime desc,g_id DESC",20);
		$this->view->assign('newthisgame',$this->api->game->showurl($newthisgame));
		$this->view->display('show');
	}

}



?>