<?php
/*
    @游戏model
*/

class gamemodel {
    var $db;
    var $base;
    
    function __construct(&$base) {
        $this->gamemodel($base);
    }
    
    function gamemodel(&$base) {
        $this->base = $base;
    }
	
	function newgame($where='',$order='',$int=10){
		$code = Utility::inject_check("game|newgame||{$where}|{$order}|{$int}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	#专题
	function zhuanqulist($int){
		$code = Utility::inject_check("game|zhuanqulist||{$int}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	function zhuanqulist1($type,$int){
		$code = Utility::inject_check("game|zhuanqulist1||{$type}|{$int}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	#单个专题详情
	function zhuanqushow($tag_pin){
		$code = Utility::inject_check("game|zhuanqushow||{$tag_pin}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	#按关键词查找专题
	function zhuanqukey($key){
		$code = Utility::inject_check("game|zhuanqukey||{$key}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	#模糊专题查找
	function zhuanqukeymo($key,$sort=0,$int=1){
		$code = Utility::inject_check("game|zhuanqukeymo||{$key}|{$sort}|{$int}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	#月排行
	function ypaihang($int){
		$code = Utility::inject_check("game|ypaihang||{$int}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	#游戏分类
	function gametype($int=10,$typeid=0){
		$code = Utility::inject_check("game|gametype||{$int}|{$typeid}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	
	//获取单个游戏信息
	function gameshow($gameid=0,$int=1){
		$code = Utility::inject_check("game|gameshow||{$gameid}|{$int}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	//游戏标签
	function gametaglist($gameid,$int=5){
		$code = Utility::inject_check("game|gametaglist||{$gameid}|{$int}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	//游戏搜索
	function gamekey($key,$where=''){
		$code = Utility::inject_check("game|gamekey||{$key}|{$where}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	function gamelist1($where='',$order='',$Qpage=0,$Tpage=0){
		$code = Utility::inject_check("game|gamelist1||{$where}|{$order}|{$Qpage}|{$Tpage}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	function gamelist1count($where=''){
		$code = Utility::inject_check("game|gamelist1count||{$where}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	function topiclist1($where='',$order='',$Qpage=0,$Tpage=0){
		$code = Utility::inject_check("game|topiclist1||{$where}|{$order}|{$Qpage}|{$Tpage}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	function topiclist1count($where=''){
		$code = Utility::inject_check("game|topiclist1count||{$where}");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	function gamerand(){
		$code = Utility::inject_check("game|gamerand||");
		return json_decode(Utility::readHttphtml($this->base->gameapi.$code),true);
	}
	/*
		$int = 1 列表页
		$int = 2 专题页
		$int = 3 详情页
		$int = 4 播放页
		
	*/
	function showurl($list){
		//exit();
		if(is_array($list)){
			foreach($list as $k=>$v){
				$return[$k] = (array)$v;
				$return[$k]['url'] = $this->showurlpage($v['g_type'],$v['g_id']);
				if($v['g_pingfen']){
					$return[$k]['ping'] = $this->spingfen($v['g_pingfen']);
				}
				$return[$k]['urlplay'] = $this->showurlpageplay($v['g_type'],$v['g_id']);
				$return[$k]['urlscreen'] = $this->showurlpagescreen($v['g_type'],$v['g_id']);
			}
		}
		return $return;
	}
	
	#评分
	function spingfen($int){
		if($int>=8){
			return 'x5';
		}elseif($int>=6){
			return 'x4';
		}
		elseif($int>=4){
			return 'x3';
		}elseif($int>=2){
			return 'x2';
		}else{
			return 'x1';
		}
	}
	
	function listurl($typeid){
		return "/{$typeid}/";
	}
	function topicurl($tagpin){
		return "/{$tagpin}/";
	}
	function showurlpage($tagpin,$id){
		return "/{$tagpin}/{$id}.html";
	}
	function showurlpageplay($tagpin,$id){
		return "/{$tagpin}/{$id}-play.html";
	}
	function showurlpagescreen($tagpin,$id){
		return "/{$tagpin}/{$id}-screen.html";
	}
	function palyurl($tagpin){
		return "/{$tagpin}/";
	}
	
}