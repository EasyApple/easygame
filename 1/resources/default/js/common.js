// JavaScript Document
var _comm = {};
_comm.addToFavorite = function(url,title){
	if (document.all) 
	{ 
		window.external.addFavorite(url,title);
	} 
	else if (window.sidebar) 
	{ 
		window.sidebar.addPanel(title, url,""); 
	}
};
_comm.copyToClipBoard = function(){
	var copyText=location.href;
	if (window.clipboardData){window.clipboardData.setData("Text", copyText);}else{var flashcopier = 'flashcopier';if(!document.getElementById(flashcopier)) {var divholder = document.createElement('div');divholder.id = flashcopier;document.body.appendChild(divholder);}}
    alert('复制成功，请粘贴到你的QQ/MSN上推荐给你的好友！');
};
_comm.htmlsave = function(a){
	var html=location.href;
	//alert('http://www.le234.com/url.php');
	window.open('http://my.le234.com/url.php?a='+html+'?s&b='+encodeURI(a), '_blank', '');
	//window.location.href='http://my.le234.com/url.php?a='+html+'?s&b='+a;
};
//弹出全屏
_comm.quanping = function(strurl){
	//var strurl = window.location.href;
	//strurl = strurl.replace(".html","-screen.html")
	var str = "left=0,screenX=0,top=0,screenY=0,fullscreen=3,titlebar=0,scrollbar=0,location=0";//fullscreen=yes只对IE有效！ 
	if (window.screen) {
		var ah = screen.availHeight - 30;
		var aw = screen.availWidth - 10;
		str += ",height=" + ah;
		str += ",innerHeight=" + ah;
		str += ",width=" + aw;
		str += ",innerWidth=" + aw;
	} else {
		str += ",resizable"; // 对于不支持screen属性的浏览器，可以手工进行最大化。 manually
	}
	return window.open(strurl, name, str);
};
_comm.timeshow = function(name,time){
	setTimeout(name,time);
};
_comm.cookie={
	'get':function(n){
		var j,v='',k;
		var t=document.cookie.split('; ');
		for(var i=0;i<t.length;i++){
			k=t[i].indexOf('=');
			j=t[i];
			if(k>-1){
				j=t[i].substring(0,k);
				v=t[i].substring(k+1);
			}
			if(j==n){
				return v;
			}
		}
		return'';
	},
	'set':function(n,v,t){
		if(!t){
			t=86400;
		}
		var s=n+'='+v;
		if(t>0){
			s+='; expires='+(new Date(new Date().getTime()+t*1000).toGMTString())+'';
		}
		s=s+'; path=/; domain=.'+this.sd();
		document.cookie=s;
	},
	'sd':function(){
		var d=document.domain.split('.');
		if(d.length==1){
			return d[0];
		}
		if(d.length==2){
			return d[0]+'.'+d[1];
		}
		if(d.length>2){
			return d[d.length-2]+'.'+d[d.length-1];
		}
	}
};
_comm.addGamecookie = function(v){
	var _co = _comm.cookie.get('le234Lisya');
	if(_co.indexOf(location.href)<0){_comm.cookie.set('le234Lisya',_co+v);}
	_comm.updategamepost();
};
_comm.delAllGame = function(){
	_comm.cookie.set('le234Lisya','');
	document.getElementById('mygameids').innerHTML='';
};
_comm.readGame = function(){
	var str='';
	//_comm.delAllGame();
	b = _comm.cookie.get('le234Lisya');
	//b = unescape(b);
	if(b.length>0){
		c = b.split('||');
		for(i=0;i<c.length-1;i++){
			//_comm.delAllGame()
			d = c[i].split('|');
			str += "<a href='"+d[1]+"' target='_blank'>"+d[0]+"</a> ";
		}
	}
	if(str!=''){ str += "<a href='###' onclick='_comm.delAllGame()' class='clear'>清空</a>"; }
	return str;
};
_comm.writeGame = function(){
	if(typeof(__title) != "undefined"){
		value = location.href;
		_comm.addGamecookie(__title+'|'+value+'||');
		_comm.readGame();
	}
};
//判断评论输入框
_comm.submitpingpost=function(){
	gid = __id;
	gnicheng = document.getElementById('gnicheng').value();
	gcontent = document.getElementById("gcontent").value();
	
	if(gid==''){
		alert('参数错误');
		return false;
	}
	//if(gnicheng=='您的呢称'){
	//	gnicheng = '匿名';
	//}
	if(Trim(gcontent)=='' && Trim(gcontent).length<2){
		alert('请输入内容,内容不能少于2个汉字.')
		return false;	
	}
	
	//$.post('http://my.le234.com/?m=ping&jsoncallback=?',{"gid":qid,"gcontent":gcontent,"gnicheng":gnicheng},function(msg){
	//	if(msg==1){ alert('评论已经提交,审核后才能显示,谢谢你的评论.') }else{alert('提交失败')}
	//});
	//return false;
};
//更新游戏
_comm.updategamepost=function(){
	document.write('<script src="http://my.le234.com/?m=gupdate&gameid='+__id+'&jsoncallback=?"></script>');
};
//更新专题
_comm.updatezhuantipost=function(pin){
	if(pin){document.write('<script src="http://my.le234.com/?m=gupdate&zhuantiid='+pin+'&jsoncallback=?"></script>');}
};
_comm.submitsearchpost=function(){
	k = document.getElementById("k").value();
	if(k==''){alert('请输入搜索关键词');return false;}
};
_comm.writeGame();
//_comm.delAllGame('');