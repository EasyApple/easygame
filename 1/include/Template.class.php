<?php

/*
	This is NOT a freeware, use is subject to license terms
	$Id: template.class.php 845 2010-10-16 05:36:51Z tangwei $
*/

class template {

	var $tpldir;
	var $objdir;

	var $tplfile;
	var $objfile;
	var $langfile;

	var $vars;
	var $force = 1;

	var $var_regexp = "\@?\\\$[a-zA-Z_]\w*(?:\[[\w\.\"\'\[\]\$]+\])*";
	var $vtag_regexp = "\<\?=(\@?\\\$[a-zA-Z_]\w*(?:\[[\w\.\"\'\[\]\$]+\])*)\?\>";
	var $const_regexp = "\{([\w]+)\}";

	var $languages = array();
	var $sid;

	function __construct() {
		$this->template();
	}

	function template() {
		ob_start();
		$this->defaulttpldir = MainRESOURCES."/".MainDEFAULTTEMPLETS.'/templets';
		$this->tpldir = MainRESOURCES."/".MainDEFAULTTEMPLETS.'/templets';
		$this->objdir = MainDATA.'/view';
		$this->langfile = MainDATA.'/lang/cn.inc';
		if (version_compare(PHP_VERSION, '5') == -1) {
			register_shutdown_function(array(&$this, '__destruct'));
		}
	}

	function assign($k, $v) {
		$this->vars[$k] = $v;
	}

	function display($file) {
		if($this->vars){extract($this->vars, EXTR_SKIP);}
		include $this->gettpl($file);
	}

	function gettpl($file) {
		$this->tplfile = $this->tpldir.'/'.$file.'.htm';
		$this->objfile = $this->objdir.'/'.$file.'.php';
		$tplfilemtime = @filemtime($this->tplfile);
		if($tplfilemtime === FALSE) {
			$this->tplfile = $this->defaulttpldir.'/'.$file.'.htm';
		}
		
		if($this->force || !file_exists($this->objfile) || @filemtime($this->objfile) < filemtime($this->tplfile)) {
		
			if(empty($this->language)) {
				@include $this->langfile;
				if(is_array($languages)) {
					$this->languages += $languages;
				}
			}
			#有缓存
			$this->complie();
		}
		#无缓存
		//$this->complie();
		return $this->objfile;
	}

	function complie() {
		$template = file_get_contents($this->tplfile);
		$template = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);
		$template = preg_replace("/\{lang\s+(\w+?)\}/ise", "\$this->lang('\\1')", $template);

		$template = preg_replace("/\{($this->var_regexp)\}/", "<?=\\1?>", $template);
		$template = preg_replace("/\{($this->const_regexp)\}/", "<?=\\1?>", $template);
		$template = preg_replace("/(?<!\<\?\=|\\\\)$this->var_regexp/", "<?=\\0?>", $template);

		$template = preg_replace("/\<\?=(\@?\\\$[a-zA-Z_]\w*)((\[[\\$\[\]\w]+\])+)\?\>/ies", "\$this->arrayindex('\\1', '\\2')", $template);

		$template = preg_replace("/\{\{eval (.*?)\}\}/ies", "\$this->stripvtag('<? \\1?>')", $template);
		$template = preg_replace("/\{eval (.*?)\}/ies", "\$this->stripvtag('<? \\1?>')", $template);
		$template = preg_replace("/\{for (.*?)\}/ies", "\$this->stripvtag('<? for(\\1) {?>')", $template);

		$template = preg_replace("/\{elseif\s+(.+?)\}/ies", "\$this->stripvtag('<? } elseif(\\1) { ?>')", $template);

		for($i=0; $i<2; $i++) {
			$template = preg_replace("/\{loop\s+$this->vtag_regexp\s+$this->vtag_regexp\s+$this->vtag_regexp\}(.+?)\{\/loop\}/ies", "\$this->loopsection('\\1', '\\2', '\\3', '\\4')", $template);
			$template = preg_replace("/\{loop\s+$this->vtag_regexp\s+$this->vtag_regexp\}(.+?)\{\/loop\}/ies", "\$this->loopsection('\\1', '', '\\2', '\\3')", $template);
		}
		$template = preg_replace("/\{if\s+(.+?)\}/ies", "\$this->stripvtag('<? if(\\1) { ?>')", $template);

		$template = preg_replace("/\{template\s+(\w+?)\}/is", "<? include \$this->gettpl('\\1');?>", $template);
		$template = preg_replace("/\{template\s+(.+?)\}/ise", "\$this->stripvtag('<? include \$this->gettpl(\\1); ?>')", $template);


		$template = preg_replace("/\{else\}/is", "<? } else { ?>", $template);
		$template = preg_replace("/\{\/if\}/is", "<? } ?>", $template);
		$template = preg_replace("/\{\/for\}/is", "<? } ?>", $template);

		$template = preg_replace("/$this->const_regexp/", "<?=\\1?>", $template);
		$template = preg_replace("/(\\\$[a-zA-Z_]\w+\[)([a-zA-Z_]\w+)\]/i", "\\1'\\2']", $template);

		$fp = fopen($this->objfile, 'w');
		#替换图片,JS,CSS路径
		//echo MainS;
		//exit();
		//$template = preg_replace("/([(\"\/)|(\')|(\=)|(\()])(images)/i", str_replace('//','/',"\\1".MainS. "/\\2")  , $template );
		fwrite($fp, $template);
		fclose($fp);
	}

	function arrayindex($name, $items) {
		$items = preg_replace("/\[([a-zA-Z_]\w*)\]/is", "['\\1']", $items);
		return "<?=$name$items?>";
	}

	function stripvtag($s) {
		return preg_replace("/$this->vtag_regexp/is", "\\1", str_replace("\\\"", '"', $s));
	}

	function loopsection($arr, $k, $v, $statement) {
		$arr = $this->stripvtag($arr);
		$k = $this->stripvtag($k);
		$v = $this->stripvtag($v);
		$statement = str_replace("\\\"", '"', $statement);
		return $k ? "<? foreach((array)$arr as $k => $v) {?>$statement<?}?>" : "<? foreach((array)$arr as $v) {?>$statement<? } ?>";
	}

	function lang($k) {
		return !empty($this->languages[$k]) ? $this->languages[$k] : "{ $k }";
	}

	function __destruct() {

	}

}


?>