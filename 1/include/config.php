<?php

/* 
	@Main系统配置文件
*/

/* 报错级别 */
error_reporting(7);
/* 这里修改成你网站名称和网址 */
define ('MainWEBtitle', '快乐小游戏');
define ('MainWEBurl', 'www.le234.com');
/* @ Main系统安全码 */
define ('MainKEY', '830W413Nf4u891Dfffx4raqduf');
/* @ Main公共函数路径设置 */
define ('MainINC', ereg_replace("[/\\]{1,}", '/', dirname(__FILE__) ) );
/* @ Main站点根目录下默认路径 */
define ('MainROOT', dirname(MainINC));
/* @ 站点根目录 */
define ('SITEROOT_Main', dirname(dirname(MainROOT)));
/* @ Main站点根目录资源包 */
define ('MainRESOURCES', MainROOT.'/resources');
/* @ Main站点根目录接口定义 */
define ('MainAPI', MainROOT.'/api');
/* @ Main数据目录 */
define ('MainDATA', MainROOT.'/data');
/* @ Main默认模板配置 */
define ('MainDEFAULTTEMPLETS', 'default');
/* @ Main模板URL */
define('MainTPL', str_replace(MainROOT.'/','',MainRESOURCES).'/'.MainDEFAULTTEMPLETS.'/templets');
define('MainS', str_replace(MainROOT.'/','/',MainRESOURCES).'/'.MainDEFAULTTEMPLETS);

require_once MainINC."/Utility.class.php";
require_once MainAPI."/base.php";

?>