<?php
header("Content-type: text/html; charset=utf-8;");
if (!session_id()) session_start();#初始化session
require('./ppf/360_safe3.php');     
require('./ppf/fun.php'); 
require('./ppf/taglib.php'); 
require("./ppf/pdo_template_vis.php");
require("./ppf/browser.php");
require("./ppf/pdo_mysql.php");
require("./srv/acd.php");#获取栏目排序相关
require("./ppf/session.php");
#防止CC攻击处理
$timestampcc = time();
$cc_nowtime = $timestampcc;
if(isset($_SESSION['cc_lasttime'])){
	$cc_lasttime = $_SESSION['cc_lasttime'];
	$cc_times = $_SESSION['cc_times']+1;
	$_SESSION['cc_times'] = $cc_times;
}else{
	$cc_lasttime = $cc_nowtime;
	$cc_times = 1;
	$_SESSION['cc_times'] = $cc_times;
	$_SESSION['cc_lasttime'] = $cc_lasttime;
}  
if(($cc_nowtime-$cc_lasttime)<3){//3秒内刷新5次以上可能为cc攻击
	if($cc_times>=5){
		echo '刷新太快!';
		exit;
	}
}else{
	$cc_times = 0;
	$_SESSION['cc_lasttime'] = $cc_nowtime;
	$_SESSION['cc_times'] = $cc_times;
}
require("./ppf/counter.php");
#检测网站状态打开/关闭
if(WEB_STATE!='1'){
	die('<div style="color:grey;width:400px;height:300px;border:4px solid grey;margin:0 auto;text-align:center;"><h1 style="border-bottom:4px solid grey;">网站已关闭</h1><div>'.WEB_CLOSE_REASON.'</div></div>');
}


#检测传入模样
$w=isset($_GET["w"])?$_GET["w"]:"";
$qname=isset($_GET["t"])?$_GET["t"]:"";
$qname=($qname=='')?'index':$qname;
$qext='htm';
$cid=isset($_GET["c"])?$_GET["c"]:"";
$aid=isset($_GET["id"])?$_GET["id"]:"";
$p=isset($_GET["p"])?$_GET["p"]:"";
$keyword=isset($_GET["keyword"])?htmlspecialchars($_GET["keyword"],ENT_QUOTES):"";
#静态化处理
if(S_STATE=='1'){
	require("./srv/std.php");//引入静态化处理文件
	$std=new STD($w,$qname,$aid,$cid,$p,$keyword);
	//加载静态页面
	if($std->loadFile())exit;
}
//exit;
$acd=getCache('acd_'.$w);
if($acd=='-1'){
	$acd=new ACD($w);
	setCache('acd_'.$w,$acd);
}
//p($acd);
//exit;
$file=$acd->checkTpl($aid,$cid);
if($file){
	/*若在模板表中找到该模板文件名，则获取扩展名，否则按原传入值$qname加载模板，后缀.htm
	*此处即加载模板的两种情况：1.使用了cms链接标签如<%@url%><:@curl>；2.未使用链接标签，自定义链接如/?t=arts&cid=1
	*/
	$qext=($qname==$file['name'])?$file['ext']:'htm';
}

#模板
$w2=($w=='')?'':$w.'/';
$T=new pdo_template(rtrim(TEMPLATE_ROOT_PATH,'\/,\\').'/'.$w2.$qname.'.'.$qext);

//cms获取全局变量标签
$g_tag=getCache('g_tag');
if($g_tag=='-1'){
	$g_tag=array();
	$gtag=$T->db->query("select * from `global_tag`")->fetchAll(PDO::FETCH_ASSOC);
	foreach($gtag as $k=>$v){
		$g_tag[$v['type']][$v['code']]=$v;
	}
	setCache('g_tag',$g_tag);
}
//p($g_tag);exit;
//cms标签初始化
//p($_SERVER);exit;
$cms_tag_config=array(  
    'sys_tag'   =>array(#系统配置标签
		'web_name'     =>WEB_NAME,
		'web_url'      =>WEB_URL,
		'web_keyword'  =>WEB_KEYWORD,
		'web_des'      =>WEB_DES,
		'web_email'    =>WEB_EMAIL,
		'dir_root'     =>DIR_ROOT,
		'web_tel'      =>WEB_TEL,
		'web_icp'      =>WEB_ICP,
	),
	'page_info' =>array(#页面信息
	    'w'            =>$w,
		'cid'          =>$cid,
		'aid'          =>$aid,
		'qname'        =>$qname,
		'p'            =>$p,
		'@url'         =>$_SERVER['REQUEST_URI'],
		'keyword'      =>$keyword,
	),
	'acd'       =>$acd,
	'gtag'      =>$g_tag,
);
$T->cms_tag_init($cms_tag_config);


#释放资源
$T->clearNoN();
$T->clearNaN();
if(S_STATE=='1'){
	ob_start();
	$T->display();
	$ob_html=ob_get_contents();
	$fp=fopen($std->s_file_path,"w");
	fwrite($fp,$ob_html);
	fclose($fp);
}else{
	$T->display();
}
$T->close();	
unset($T);