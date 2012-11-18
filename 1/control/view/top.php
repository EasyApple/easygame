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
		$typeid = Utility::getgpc('typeid');
		
		#获取分类信息
		if($typeid){
			$gametype = $this->api->game->gametype(1,$typeid);
			$gametype = $gametype[0];
		}else{
			$gametype['gt_id'] = 0;
			$gametype['gt_name'] = '综合类';
			$gametype['gt_name1'] = '综合';
		}
		$this->view->assign('gametype',$gametype);
		
		//分类游戏
		$where = $typeid ? "g_type=$typeid" : "";
		$gamelist = $this->api->game->newgame($where,"g_renqi desc,g_pingfen DESC",70);
		$gamelist = $this->api->game->showurl($gamelist);
		$this->view->assign('gamelist',$gamelist);
		
		#更多游戏
		$gamelist1 = $this->api->game->newgame($where,"g_pingfen DESC,g_id DESC",400);
		$gamelist1 = $this->api->game->showurl($gamelist1);
		$this->view->assign('gamelist1',$gamelist1);
		#专区按钮
		$zhuanqu = $this->api->game->zhuanqulist1($typeid,33);
		$this->view->assign('zhuanqu',$zhuanqu);
		
		$this->view->display('toplist');
	}

}



?>