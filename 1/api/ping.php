<?php
/*
    @游戏model
*/

class pingmodel {
    var $base;
    
    function __construct(&$base) {
        $this->pingmodel($base);
    }
    
    function pingmodel(&$base) {
        $this->base = $base;
    }
	//写入评论
	function writeping($gid,$gnicheng,$gcontent){
		$code = Utility::inject_check("ping|writeping||{$gid}|{$gnicheng}|{$gcontent}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	//读出评论
	function readping($gid,$int=20){
		$code = Utility::inject_check("ping|readping||{$gid}|{$int}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
}