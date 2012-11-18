<?php
$a=$_REQUEST['a'];
$b=$_REQUEST['b'];
$b = iconv("utf-8","gb2312",$b);
$Shortcut = "[InternetShortcut]
URL=$a
IDList=
IconFile=http://s.le234.com/ico/ico48.ico
IconIndex=1
[{000214A0-0000-0000-C000-000000000046}]
Prop3=19,2";
header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=$b.url;");
header("Content-Disposition: attachment; filename=".$b.".url;");
echo $Shortcut;
?>
