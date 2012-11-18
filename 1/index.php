<?php
/*
	@全局控制器
	@日期：2010-12-08
	@合作qq: 119906938

*/
require(dirname(__FILE__) . "/include/config.php");
/* 控制参数 */
$c = Utility::getgpc('c');
$m = Utility::getgpc('m');
$a = Utility::getgpc('a');

$c = empty($c) ? 'view' : $c;
$m = empty($m) ? 'index' : $m;
$a = empty($a) ? 'ls' : $a;

if (!in_array($c, array('view', 'manage'))) {
	$c = 'view';
}

/* 控制器核心 */
include MainROOT."/control/$c/$m.php";

$control = new control();
$method = 'on'.$a;
if(method_exists($control, $method) && $a{0} != '_') {
	$control->$method();
} elseif(method_exists($control, '_call')) {
	$control->_call('on'.$a, '');
} else {
	exit('Action not found!');
}

?>