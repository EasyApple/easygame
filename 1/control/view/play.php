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
		$this->load('ping');
	}
	
	function onls(){
		#游戏详情
		$gameid = Utility::getgpc('gameid');
		$gameshow = $this->api->game->gameshow($gameid);
		$gameshow = $this->api->game->showurl($gameshow);
		$gameshow = $gameshow[0];
		$gameshow['gc_size'] = round($gameshow['gc_size'] / 1024 / 1024,2);
		$this->view->assign('gameshow',$gameshow);
		#相关游戏
		$moregame = $this->api->game->newgame("g_type={$gameshow[g_type]}","g_renqi desc,g_id desc",22);
		$this->view->assign('moregame',$this->api->game->showurl($moregame));
		#更多游戏
		$allmoregame = $this->api->game->newgame("g_type={$gameshow[g_type]}","g_pingfen desc,g_id desc",60);
		$this->view->assign('allmoregame',$this->api->game->showurl($allmoregame));
		#评论列表
		$pinglist = $this->api->ping->readping($gameid);
		$this->view->assign('pinglist',$pinglist);
		#下一个游戏
		$nextgame = $this->api->game->newgame("g_type={$gameshow[g_type]} and g_id>{$gameshow[g_id]}","g_id desc",1);
		if($nextgame){
			$nextgame = $this->api->game->showurl($nextgame);
			$nextgame = $nextgame[0];
			$this->view->assign('nextgame',$nextgame);
		}
		$this->view->display('play');
	}

}



?>