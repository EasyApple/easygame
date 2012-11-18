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
		$this->model = $this->load('game');
	}
	
	function onls(){
	
		$cacheindex = MainROOT.'/index.html';
		if(!file_exists($cacheindex) || time() - filemtime($cacheindex) > 86400 ){
			
			#总排行
			$zpaihang = $this->api->game->newgame("","g_renqi desc,g_id DESC",53);
			$this->view->assign('zpaihang',$this->api->game->showurl($zpaihang));
			#月排行
			$ypaihang = $this->api->game->ypaihang(53);
			$this->view->assign('ypaihang',$this->api->game->showurl($ypaihang));
			#最新评分排行
			$newpan = $this->api->game->newgame("","g_pingfen desc,g_id DESC",90);
			$this->view->assign('newpan',$this->api->game->showurl($newpan));
			#游戏分类
			$gamelist = $gamebottom = array();
			$gametype = $this->api->game->gametype(14);
			foreach($gametype as $k=>$v){
				$gamelist[$v['gt_id']] = $this->api->game->newgame("g_type=$v[gt_id]","g_renqi desc,g_pingfen DESC",30);
				$gamelist[$v['gt_id']] = $this->api->game->showurl($gamelist[$v['gt_id']]);
				#底部列表页面
				$gamebottom[$v['gt_id']] = $this->api->game->newgame("g_type=$v[gt_id]","g_id DESC",80);
				$gamebottom[$v['gt_id']] = $this->api->game->showurl($gamebottom[$v['gt_id']]);
			}
			$this->view->assign('gametype',$gametype);
			$this->view->assign('gamelist',$gamelist);
			$this->view->assign('gamebottom',$gamebottom);
			#网友正在玩
			$newthisgame = $this->api->game->newgame("","g_uptime desc,g_id DESC",20);
			$this->view->assign('newthisgame',$this->api->game->showurl($newthisgame));
			#专区
			$zhuanqu = $this->api->game->zhuanqulist(34);
			$this->view->assign('zhuanqu',$zhuanqu);
			ob_start();
			$this->view->display('index');
			$contents = ob_get_contents();
			ob_end_clean();
			$fp = fopen($cacheindex, 'w');
			fwrite($fp, $contents);
			fclose($fp);
			include "index.html";
		}else{
			include "index.html";
		}
	}
}



?>