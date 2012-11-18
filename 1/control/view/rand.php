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
		$rand = $this->api->game->gamerand();
		$rand = $rand[0];
		Utility::tsgHref("/{$rand[g_type]}/{$rand[g_id]}.html");
	}

}



?>