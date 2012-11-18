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

		$typeid = $typeid ? $typeid : 0;
		
		//分页获取
		$rurl = $s ? array('list',"typeid={$typeid}","s={$s}") : array('list',"typeid={$typeid}");
		//处理参数
		$where = $typeid ? "and g_type=$typeid" : '';
		
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

		$Listdata = $this->api->game->gamelist1($where,$order,$Qpage,$Tpage);
		
		$this->view->assign('titletype',$titletype);
		$this->view->assign('s',$s);
		
		//更多游戏
		$Listdata1 = $this->api->game->gamelist1($where,$order,0,600);
		$this->view->assign('Listdata1',$this->api->game->showurl($Listdata1));
		
		//获取分页总数
		$Zcount = $this->api->game->gamelist1count($where);
		$multi = is_array($Zcount) ? Utility::multi($Zcount[0]['C'],$Tpage,$p,$rurl) : '';
		$this->view->assign('multi',$multi);
		$this->view->assign('Listdata',$this->api->game->showurl($Listdata));
		
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
		#专区按钮
		$zhuanqu = $this->api->game->zhuanqulist1($typeid,33);
		$this->view->assign('zhuanqu',$zhuanqu);
		#网友正在玩
		$newthisgame = $this->api->game->newgame("","g_uptime desc,g_id DESC",10);
		$this->view->assign('newthisgame',$this->api->game->showurl($newthisgame));
		#总排行
		$zpaihang = $this->api->game->newgame("","g_renqi desc,g_id DESC",37);
		$this->view->assign('zpaihang',$this->api->game->showurl($zpaihang));
		#月排行
		$ypaihang = $this->api->game->ypaihang(37);
		$this->view->assign('ypaihang',$this->api->game->showurl($ypaihang));
		
		$this->view->display('list');
	}

}



?>