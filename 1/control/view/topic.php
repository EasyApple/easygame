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
		$topicpin = Utility::getgpc('topicpin');
		$p = Utility::getgpc('p');//分页参数
		$s = Utility::getgpc('s');//查找的状态
		$p = $p ? $p : 1;
		if($p>1){
			$titlename = "_第{$p}页";
			$this->view->assign('titlename',$titlename);
		}
		//每页显示条数
		$Tpage = 35;
		$Qpage = intval($Tpage*($p-1));
		
		//分页获取
		$rurl = $s ? array($s) : array();
		
		$topicpin = $topicpin ? $topicpin : 0;
		
		//获取专题详情
		$zhuanqushow = $this->api->game->zhuanqushow($topicpin);
		$zhuanqushow = $zhuanqushow[0];
		$this->view->assign('zhuanqushow',$zhuanqushow);
		
		//处理参数
		$where = $topicpin ? "and b.tag_id=$zhuanqushow[tag_id]" : '';
		
		$titletype = '';
		if($s=='f'){
			$order = "g_pingfen desc";
			$titletype = '最佳';
		}elseif($s=='n'){
			$order = "g_id desc";
			$titletype = '最新';
		}else{
			$order = "g_renqi desc";
		}
		
		$Listdata = $this->api->game->topiclist1($where,$order,$Qpage,$Tpage);
		
		$this->view->assign('titletype',$titletype);
		$this->view->assign('s',$s);
		
		//更多游戏
		$Listdata1 = $this->api->game->topiclist1($where,$order,0,600);
		$this->view->assign('Listdata1',$this->api->game->showurl($Listdata1));
		
		//获取分页总数
		$Zcount = $this->api->game->topiclist1count($where);
		$multi = is_array($Zcount) ? Utility::multi($Zcount[0]['C'],$Tpage,$p,$rurl) : '';
		$this->view->assign('multi',$multi);
		$this->view->assign('Listdata',$this->api->game->showurl($Listdata));
		
		$this->view->assign('gametype',$gametype);
		#专区按钮
		$zhuanqulist = $this->api->game->zhuanqulist(41);
		$this->view->assign('zhuanqulist',$zhuanqulist);
		#网友正在玩
		$newthisgame = $this->api->game->newgame("","g_uptime desc,g_id DESC",10);
		$this->view->assign('newthisgame',$this->api->game->showurl($newthisgame));
		
		$this->view->display('topic');
	}

}



?>