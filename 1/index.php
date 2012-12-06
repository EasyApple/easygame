<?
// PHPMINE v1.0
//来源http://www.phpvault.com
//是根据microsoft的挖地雷游戏编写
print "<html>";
print "<head>";
print "<title>PHP挖地雷</title>";
print "</head>";
print "<body bgcolor=#3F1FF1><center>";//更改颜色
print "<font size=3 face=Verdana><b>PHP挖地雷</b>";
if ($submit=="")//默认设置
{
   $NumMine=1; //地雷数
   $RowSize=2;
   $ColSize=2;
   $generer=1;
}
if($generer==1)//还没生成地图 ，else 到line 56
{
   //srand((double)microtime()*100000000); //生成随机数种子
   srand(time());//我写成这样
   $time_start=time();
   //判断输入的数值是否正确
   if(($RowSize<=1) || ($ColSize<=1) || ($NumMine==0))
   {
    print "<p><br><font size=-1 color=red>行数，列数或地雷数输入错误!!</font>";
    exit;
   }
   if($NumMine > $RowSize*$ColSize)
   {
    print "<p><br><font size=-1 color=red>地雷数太多!</font>";
    exit;
   }
   //初始化
   for($Row=1;$Row<=$RowSize;$Row++)
   {
    for($Col=1;$Col<=$ColSize;$Col++)
    {
     $Mine[$Row][$Col]="0";
     $Decouv[$Row][$Col]="0";
    }
   }//二维数组存地图，表示有没有地雷！
   $index=0;
   while($index<$NumMine)//随机产生地雷，注意有个数限制
   {
   //int rand ( [int $min, int $max] ) 从一个区间产生随机数
    $Row=rand(1,$RowSize);
    $Col=rand(1,$ColSize);
    if($Mine[$Row][$Col]=="0")
    {
     $Mine[$Row][$Col]="1";//0 无雷
     $index++;              //1 有雷
    }
   }
}
else
{
   $perdu=0;//
   $reste=$RowSize*$ColSize;
   for($Row=1;$Row<=$RowSize;$Row++)
   {
    for($Col=1;$Col<=$ColSize;$Col++)
    {
     $temp="Mine".($Row*($ColSize+1)+$Col);
     //echo $temp;
     $Mine[$Row][$Col]=$$temp;//变量传递，（可变变量）
     $temp="Decouv".($Row*($ColSize+1)+$Col);//每次点一个按钮就把值回传数组
               //int a[3][2];
               //a[1][1]=a+1*(2+1)+1
     $Decouv[$Row][$Col]=$$temp;
     if($Decouv[$Row][$Col]=="1") {$reste=$reste-1;}//reste 表示还剩多少个格子没动过
     $temp="submit".($Row*($ColSize+1)+$Col);
     if($$temp=="ok")
     {
      $reste=$reste-1;
      if($Mine[$Row][$Col]=="0")//有幸没有踩中地雷
      {
       $Decouv[$Row][$Col]="1";//已经探测过了，标记一下
      }
      else
      {
       $perdu=1;
      }
     }
    }
   }
   if($perdu==1)//中奖了，踩住地雷了
   {
    if ($myname=='leeinn') {
     print "<h2><font color=red> 不要灰心呀！</f></h2>" ;
    }
    else{
     print "<h2><font color=red> 您输啦!</f></h2>";
        }
    for($i=1;$i<=$RowSize;$i++)
    {
     for($j=1;$j<=$ColSize;$j++)
     {
      $Decouv[$i][$j]="1";
     }
    }
   }
   if(($reste==$NumMine)&&($perdu!=1))
   {
    print "<h2>你赢啦!</h2>";
    $time_stop=time();
    $time=$time_stop-$time_start;
    if ($myname=='leeinn') {
     $time=100;
    }
    print "<p><font size=-1><i>您的分数: $time</i></font>";//用时间计算分数
    for ($i=1;$i<=$RowSize;$i++)
    {
     for($j=1;$j<=$ColSize;$j++)
     {
      $Decouv[$i][$j]="1";
     }
    }
   }
}
print "<form method=get action='$PHP_SELF'>";//从网页得到数据，在按完“开始”的按钮后，接受来自自己的数据，
print "<input type=hidden name=time_start value=$time_start>";
print "<input type=hidden name=NumMine value=$NumMine>";
print "<input type=hidden name=RowSize value=$RowSize>";
print "<input type=hidden name=ColSize value=$ColSize>";
print "<input type=hidden name=generer value=0>";
print "<input type=hidden name=myname value=$myname>";//这里加一项
print "<p><table border=1 cellpadding=8>";//做表格
for($Row=1; $Row<=$RowSize; $Row++)
{
   print "<tr>";
   for($Col=1; $Col<=$ColSize; $Col++)
   {
    $nb=0;
    for($i=-1; $i<=1; $i++)
    {
     for($j=-1; $j<=1; $j++)
     {
      if($Mine[$Row+$i][$Col+$j] == "1")//上下左右，4个对角，如果有雷就让$nb++，
      {
       $nb++;
      }
     }
    }
    print "<td width=15 height=15 align=center valign=middle>";
    if($Decouv[$Row][$Col]=="1")
    {
     if($nb==0)//如果8个方向没有雷，就输出空格
     {
      print "&nbsp;";
     }
     else
     {
      if($Mine[$Row][$Col]=="1")
      {
       print "<font color=red>*</font>";//地雷就输出‘*’
      }
      else //自己不是雷，就输出周围的地雷数
      {
       print "$nb";
      }
     }
    }
    else
    {
     print "<input type=hidden name=submit value=ok>";
     print "<input type=submit name=submit".($Row*($ColSize+1)+$Col)." value=ok>";//在这里显示界面上的ok框
    }
    print "<input type=hidden name=Mine".($Row*($ColSize+1)+$Col)." value=".$Mine[$Row][$Col].">";
    print "<input type=hidden name=Decouv".($Row*($ColSize+1)+$Col)." value=".$Decouv[$Row][$Col].">";
    print "</td>";//见line:68
   }
   print "</tr>";
}
print "</table>";
print "</form>";
if ($myname=="leeinn") {
   print "I love you ,$myname";
}
else {
print "welcome to this game ,$myname" ;
}

?>
<hr>
<form method=post><!//向网页发送信息的方式>
行数 : &nbsp;<!//生成3 个输入框>
<input type=text name=RowSize value=2 size=2>
<br>
列数 : &nbsp;<!是个空格>
<input type=text name=ColSize value=2 size=2>
<br>
地雷数 : &nbsp;
<input type=text name=NumMine value=1 size=2>
<br>
姓名 : &nbsp;
<input type=text name=myname value="yjy" size=2>
<p>
<input type=submit name=submit value=开始>
<input type=hidden name=generer value=1> <! //判断是否生成地图 line :18   ,隐藏属性，不可见>
</form>
</body>
</html>