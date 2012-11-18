<?php
/* 
	实用公共函数使用
	收集整理  2010.10.17 11:00 tangwei $
 */

class Utility{

	static function getip()
	{
		if(!empty($_SERVER["HTTP_CLIENT_IP"]))
		{
			$cip = $_SERVER["HTTP_CLIENT_IP"];
		}
		else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else if(!empty($_SERVER["REMOTE_ADDR"]))
		{
			$cip = $_SERVER["REMOTE_ADDR"];
		}
		else
		{
			$cip = '';
		}
		preg_match("/[\d\.]{7,15}/", $cip, $cips);
		$cip = isset($cips[0]) ? $cips[0] : 'unknown';
		unset($cips);
		return $cip;
	}
	
	/* 过滤接收值 */
	static function daddslashes($string, $force = 0, $strip = FALSE) {
	
		if(!MAGIC_QUOTES_GPC || $force) {
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = self::daddslashes($val, $force);
				}
			} else {
				$string = addslashes($strip ? stripslashes($string) : $string);
			}
			return $string;
		}
	}
	
	/* html转换\' */
	static function stripSlashes($string){
		return get_magic_quotes_gpc() ? stripslashes($string) : $string ;
	}

	// Returns true if $string is valid UTF-8 and false otherwise. 
	static function is_utf8($word) 
	{ 
		if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true) 
		{ 
			return true; 
		}else{
			return false; 
		} 
	} // function is_utf8 
	
	/* 
		@参数设置
		@$u >0适用于数组解码 
	*/
	static function getgpc($k, $t='R') {
		switch($t) {
			case 'P': $var = &$_POST; break;
			case 'G': $var = &$_GET; break;
			case 'C': $var = &$_COOKIE; break;
			case 'R': $var = &$_REQUEST; break;
		}
//		$var = self::daddslashes($var,1,TRUE);
		return isset($var[$k]) ? (is_array($var[$k]) ? $var[$k] : trim($var[$k])) : NULL;
	}
	
	/* @读取文件 */
	static function sReadFile($filename) {
		$content = '';
		if(function_exists('file_get_contents')) {
			@$content = file_get_contents($filename);
		} else {
			if(@$fp = fopen($filename, 'r')) {
				@$content = fread($fp, filesize($filename));
				@fclose($fp);
			}
		}
		return $content;
	}
	
	/* @写入文件 */
	static function sWriteFile($filename, $writetext, $openmod='w') {
		
		/* 验证文件夹,并建立 */
		self::createFolder(dirname($filename));
		
		if(@$fp = fopen($filename, $openmod)) {
			flock($fp, 2);
			fwrite($fp, $writetext);
			fclose($fp);
			return true;
		} else {
			exit('no write');
			return false;
		}
	}
	
	static function readHttphtml($url){
		//获取url内容
		@$content = file_get_contents($url);
		//if(!$content){
		//	$ch = curl_init() or die (curl_error());  //设置URL参数 
		//	curl_setopt($ch,CURLOPT_URL,$url);  //要求CURL返回数据  
		//	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  //执行请求
		//	$content = curl_exec($ch) or die (curl_error());  //取得返回的结果，并显示  
		//}
		return $content;
	}
	
	/* @递归创建文件夹 */
	static function createFolder($path)
	{
	   if (!file_exists($path))
	   {
			self::createFolder(dirname($path));
			mkdir($path, 0777);
	   }
	}
	
	/* @返回文件夹数量+1,返回新的路径 */
	static function createNumFolder($path){
		$count = is_dir($path) ? count(scandir($path))-1 : 1 ;
		return sprintf("%s/%s",$path,$count);
	}
	
	/* @追加文件内容 */
	static function insertFileContent($filename,$content,$model='\r\n'){
	}
	
	/* @提示后返回上一页 */
	static function tsgGo($bug){
		echo "<script>alert('{$bug}');history.go(-1);</script>";
		exit();
	}
	
	/* @提示后返回上一页 */
	static function tsgAlert($bug){
		echo "<script>alert('{$bug}');</script>";
		exit();
	}
	
	/* @直接跳转 */
	static function tsgHref($url){
		echo "<script>window.location.href='{$url}';</script>";
		exit();
	}
	
	/* @提示后跳转 */
	static function tsgGoHref($bug,$url){
		echo "<script>alert('{$bug}');window.location.href='{$url}';</script>";
		exit();
	}


	 /* 
	 	@设置cookie
	 */
	static function sSetCookie($key, $value, $life = 0) {
		/* 保存时间 */
		$life = $life ? $life : $baseXML->cookie;
		/* 保存数组 */
		$value = is_array($value) ? self::authCode(serialize($value),'ENCODE') : $value;
		setcookie($key, $value, $life?(time()+$life):0); 
	}
	
	/* 
	 	@字符串解密加密
		@加密使用方法：Utility::authCode($v,'ENCODE')
		@解密使用方法：Utility::authCode($v)
	 */
	static function inject_check($sql_str){       
		$e = eregi('DROP|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);
		if($e){
			return '';
		}else{
			return base64_encode($sql_str);
		}
	}
	 
	static function authCode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		
		$ckey_length = 4;	// 随机密钥长度 取值 0-32;
					// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
					// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
					// 当此值为 0 时，则不产生随机密钥
	
		$key = md5($key ? $key : MAILLISTKEY);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
	
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
	
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
	
		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
	
	function setcookie($key, $value, $life = 0, $httponly = false) {
		(!defined('UC_COOKIEPATH')) && define('UC_COOKIEPATH', '/');
		(!defined('UC_COOKIEDOMAIN')) && define('UC_COOKIEDOMAIN', '');

		if($value == '' || $life < 0) {
			$value = '';
			$life = -1;
		}
		
		$life = $life > 0 ? $this->time + $life : ($life < 0 ? $this->time - 31536000 : 0);
		$path = $httponly && PHP_VERSION < '5.2.0' ? UC_COOKIEPATH."; HttpOnly" : UC_COOKIEPATH;
		$secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
		if(PHP_VERSION < '5.2.0') {
			setcookie($key, $value, $life, $path, UC_COOKIEDOMAIN, $secure);
		} else {
			setcookie($key, $value, $life, $path, UC_COOKIEDOMAIN, $secure, $httponly);
		}
	}

	//分页
	//Tcount 总数
	//Tpage	 每页显示数量
	//p		 参数
	static function multi($Tcount, $Tpage, $p, $array, $top='./',$bottom='.html') {
		
		$mu = "";
		//总页数
		$z = ceil($Tcount / $Tpage);
		$l = 10;	//长度
		$v = $l/2;
		
		$diy = ($p>1 && $p<$z)?($p-1):0;
		$mu .= "<a href=\"".self::Lurl($diy, $array, $top, $bottom)."\" title=\"上一页\" class=\"pre\">上一页</a>\r\n";
		if($p>$v) $mu .= "<span>...</span>\r\n";
		
		//开始
		$ca = (($p - $v)<0) ? 0 : ($p - $v);
		//结束
		$cb = (($p + $v)>$z) ? $z : ($p + $v);
		
		if($cb-$ca<($l+1)){
			$x = ($l+1)-($cb-$ca);
			if($ca==0 && $cb<$z){
				if(($z-$cb)<$x){
					$cb = $cb + ($z-$cb);
				}else{
					$cb = $cb + $x;
				}
			}elseif($cb==$z && $ca>0){
				if(($ca-$x)<0){
					$ca = 0;
				}else{
					$ca = $ca - $x;
				}
			}
		}
		
		for($i=$ca;$i<$cb;$i++){
			$pi = ($p==($i+1))?"class=\"selected\"": "";
			$mu .= "<a href=\"".self::Lurl(($i+1), $array, $top, $bottom)."\" title=\"第".intval($i+1)."页\" {$pi}>".intval($i+1)."</a>\r\n";	
		}
		
		if(($p+$v)<$z) $mu .= "<span>...</span>\r\n";
		$end = ($p<$z)?$p+1:$z;
		$mu .= "<a href=\"".self::Lurl($end, $array, $top, $bottom)."\" title=\"下一页\" class=\"next\">下一页</a>";
		return $mu;
	}

	static function Lurl($p,$array,$top='./',$bottom='.html'){
		$p = ($p==0) ? 1 : $p;
		if($array){
			if($p && $p==1){
				return $top.implode('-',$array).$bottom;
			}else{
				return $top.implode('-',$array)."-".$p.$bottom;
			}
		}else{
			if($p==1){
				return "{$top}index{$bottom}";
			}else{
				return "{$top}p{$p}{$bottom}";
			}
		}
	}
	
}
?>