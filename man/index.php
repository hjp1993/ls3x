<?php

/*主站 管理中心 */
header("Content-type: text/html; charset=utf-8;");
date_default_timezone_set('PRC');
require('../ppf/360_safe3.php');  
require('../ppf/fun.php');
require('../ppf/pdo_mysql.php');
require("../ppf/pdo_template.php");
require("../ppf/browser.php");
require("./srv/RABC.class.php");
$qname=isset($_GET["t"])?$_GET["t"]:"index"; 
//p($_COOKIE);exit;
if (!session_id()) session_start(); 
//$pd=new pdo_mysql();
if($qname!="login"&&$qname!="error"&&$qname!="exit"&&$qname!="404"){
	chkLogin("uid","/man/?t=login");
	//检测用户是否有该页面的权限
	if(!RABC::checkUrl2("/man/?t=".$qname)){
		echo "<script language='javascript' type='text/javascript'>";
		echo "document.location='/man/?t=error'";
		echo "</script>";
	}
	$uid=$_SESSION['uid']; 
}
$T=new pdo_template('./html/'.$qname.'.htm');   
$T->SetTpl('css','css.inc');
$T->SetTpl('js','js.inc');
$T->SetTpl('ppf','ppf.inc');     
switch($qname){    
	case "login":#首页
	  if(isset($_SESSION['uid'])){
		header("Location:/man/");         
	  } 
	#检测浏览器版本针对IE
	$brow=getBrowser().getBrowserVer();
	if($brow=="ie5"||$brow=="ie6"||$brow=="ie7"||$brow=="ie8"||$brow=="ie9"){
		Header("Location: /?t=ie"); 
	}
	if(isset($_GET["url"]))
	    $T->Set("tourl",url_base64_decode($_GET["url"]));
	$request_uri_arr=explode("?",$_SERVER["REQUEST_URI"]);
	$request_uri=$request_uri_arr[1];
	$request_uri="/?".$request_uri;
    //$request_uri="/?".explode("?",$_SERVER["REQUEST_URI"])[1];//低版本报错，太长
    $tl_url=APP_LOGIN."/?t=login&url=".url_base64_encode($request_uri);
    $T->Set("tl_url",$tl_url);
	break;
  case "exit":#退出
	if(isset($_SESSION["uid"])){
		  unset($_SESSION["uid"]);
		  session_destroy();#session_unset(); 
	 }
	 
	break; 
 
  case "arts":
    $p=isset($_GET["p"])?$_GET["p"]:"1"; 
    $so=isset($_GET["so"])?$_GET["so"]:"";
    $cid=isset($_GET["c"])?$_GET["c"]:"";
	$state=isset($_GET["state"])?$_GET["state"]:"";
	$tid=isset($_GET["tid"])?$_GET["tid"]:"";
	$tid=($tid=='')?0:$tid;
    if($p<1)$p=1;
    $wh="";  
	$wh_s1="";
	$wh_s2="";
    if(!empty($cid))$wh=$wh." and (cid=".$cid." or pid=".$cid.") ";        
    if(!empty($so))$wh=$wh." and ma.name like '%".$so."%'";
	if($state!=""){
		$wh_s1=" and `state`='".$state."'";
		$wh_s2=" and ma.`state`='".$state."'";
	};
	$cate_audit_auth=$T->db->query("select oug.cate_audit_auth from act_member am LEFT JOIN osa_user_group oug on am.user_group=oug.group_id where am.id='".$uid."'")->fetchColumn(0);
	$rc=0;
	if($cate_audit_auth!=''){
		$rc= $T->db->query("select count(1) from `main_article` ma left join main_art_category mac on mac.id=ma.cid where ma.id>0 and mac.topic_id={$tid} and ma.cid in ({$cate_audit_auth}) ".$wh.$wh_s1)->fetchColumn(0);
        $T->SetBlock("list","select ma.*,M.truename,t.filename,mac.name as cname,mac.topic_id from `main_article` ma left join act_member M on M.id=ma.uid left join main_art_category mac on mac.id=ma.cid left join template t on mac.taid=t.id where ma.id>0 and mac.topic_id={$tid}  and ma.cid in ({$cate_audit_auth}) ".$wh.$wh_s2." order by ma.CreateTime desc limit ".(($p-1)*15).",15");
	}
    $page=getPageHtml_bt($rc,15,$p,"&t=arts&tid=".$tid."&c=".$cid."&so=".$so);
    $T->Set("page",$page);
    $T->Set("so",$so);
	$T->SetBlock("topic_list", "select * from `topic` order by odx asc");
	break;  
  case "myarts":
    $p=isset($_GET["p"])?$_GET["p"]:"1"; 
    $so=isset($_GET["so"])?$_GET["so"]:"";
    $cid=isset($_GET["c"])?$_GET["c"]:"";
	$state=isset($_GET["state"])?$_GET["state"]:"";
	$tid=isset($_GET["tid"])?$_GET["tid"]:"";
	$tid=($tid=='')?0:$tid;
    if($p<1)$p=1;
    $wh="";  
	$wh_s1="";
	$wh_s2="";
    if(!empty($cid))$wh=$wh." and (cid=".$cid." or pid=".$cid.") ";        
    if(!empty($so))$wh=$wh." and ma.name like '%".$so."%'";
	if($state!=""){
		$wh_s1=" and `state`='".$state."'";
		$wh_s2=" and ma.`state`='".$state."'";
	};
    $rc= $T->db->query("select count(1) from `main_article` ma left join main_art_category mac on mac.id=ma.cid where ma.id>0 and mac.topic_id={$tid} ".$wh.$wh_s1." and uid='".$uid."' ")->fetchColumn(0);
    $page=getPageHtml_bt($rc,15,$p,"&t=arts&tid=".$tid."&c=".$cid."&so=".$so);
    $T->Set("page",$page); 
    $T->SetBlock("list","select ma.*,M.truename,t.filename,mac.name as cname,mac.topic_id from `main_article` ma left join act_member M on M.id=ma.uid left join main_art_category mac on mac.id=ma.cid left join template t on mac.taid=t.id where ma.id>0 and mac.topic_id={$tid} ".$wh.$wh_s2." and uid='".$uid."' order by ma.CreateTime desc limit ".(($p-1)*15).",15");
    $T->Set("so",$so);
	$T->Set("uid",$uid);
	$T->SetBlock("topic_list", "select * from `topic` order by odx asc");
	break;  
  case "art_cate":
   /* $cate_info=$T->db->query("select id,pid,name from `main_art_category` where visible=1")->fetchAll(PDO::FETCH_ASSOC);
    $tree_arr=get_tree_arr($cate_info,0);
    
    $tree_html=get_tree_html($tree_arr);echo json_encode($cate_info);exit;
    $T->Set("tree_arr",json_encode($tree_arr));
    $T->Set("tree_html",$tree_html);
    $T->Set("tree_list",json_encode($cate_info));*/
    /*exit;
    $T->SetBlock2("category_tree_list", "select id,name from main_art_category where pid=0 order by id", array(array("block"=>"rp","pid"=>"id","sql"=>"select id,name from main_art_category where pid=?")));*/
    //type=1为首页与栏目页模板,2为内容页模板
    $T->SetBlock("tc_list", "select id,name,filename,fileext from `template` where type=1 order by id asc");
	$T->SetBlock("ta_list", "select id,name,filename,fileext from `template` where type=2 order by id asc");
	$T->SetBlock("topic_list", "select id,name from `topic` order by odx asc");
    
	break;
  case "art_auth":
    $type=isset($_GET["type"])?$_GET["type"]:"";
	if($type=='sh'){
		$T->Set("type",'sh');
		$T->Set("type_name",'审核');
	}else{
		$T->Set("type",'fw');
		$T->Set("type_name",'发文');
	}
	$T->SetBlock("group_list", "select group_id,group_name from `osa_user_group` order by group_id desc");
	//$T->SetBlock2("main_menu_list", "select menu_id,menu_name,father_menu from `osa_menu_url` where father_menu=0 order by odx", array(array("block"=>"include_menu_list","pid"=>"menu_id","sql"=>"select menu_id,menu_name,father_menu from `osa_menu_url` where father_menu=?"))); 
	$T->SetBlock("topic_list", "select id,name from `topic` order by odx asc");
	break;
  case "art_am":
     if(!empty($_GET["id"])){
       $thumb= $T->db->query("select thumb from `main_article` where id=".$_GET["id"])->fetchColumn(0);
       $T->Set("thumb",$thumb);
     }
	 $tid=isset($_GET["tid"])?$_GET["tid"]:"";
	 $tid=($tid=='')?0:$tid;
	 $T->Set("topic_id",$tid);
	 $T->SetBlock("topic_list", "select * from `topic` order by odx asc");
     break;
  case "art_myam":
     if(!empty($_GET["id"])){
       $thumb= $T->db->query("select thumb from `main_article` where id=".$_GET["id"])->fetchColumn(0);
       $T->Set("thumb",$thumb);
     }
	 $art_audit_auth=$T->db->query("select oug.art_audit_auth from `act_member` am left join osa_user_group oug on oug.group_id=am.user_group where am.id='".$uid."' ")->fetchColumn(0);
	 //判断是否有审核权限
	 if($art_audit_auth=="0"){
		$T->Set("state","2");
	 }else{
		$T->Set("state","0");
	 }
	 $T->Set("uid",$uid);
	 $tid=isset($_GET["tid"])?$_GET["tid"]:"";
	 $tid=($tid=='')?0:$tid;
	 $T->Set("topic_id",$tid);
	 $T->SetBlock("topic_list", "select * from `topic` order by odx asc");
     break;
  case "consult":
    $p=isset($_GET["p"])?$_GET["p"]:"1"; 
    $so=isset($_GET["so"])?$_GET["so"]:"";
    $cid=isset($_GET["c"])?$_GET["c"]:""; 
    if($p<1)$p=1;
    $wh="";                                           
    if(!empty($cid))$wh=" and cid=".$cid;        
    if(!empty($so))$wh=" and title like '%".$so."%'";
    $rc= $T->db->query("select count(1) from `consult_art` where id>0".$wh)->fetchColumn(0);
    $page=getPageHtml_bt($rc,15,$p,"&t=arts&c=".$cid."&so=".$so);
    $T->Set("page",$page); 
    $T->SetBlock("list","select T.*,M.truename from `consult_art` T left join act_member M on M.id=T.uid where T.id>0".$wh." order by T.id desc limit ".(($p-1)*15).",15",array("endtime"),array("%Y-%m-%d %H:%M"));
    $T->Set("so",$so);
	  break;
  case "consult_cate":
	 
     $T->SetBlock("list","select * from `consult_art_category` order by odx desc,id desc",array("endtime"),array("%Y-%m-%d"));
    
    break;
  case "consult_am":
	$id=isset($_GET["id"])?$_GET["id"]:""; 
	
	$des= $T->db->query("select des from `consult_art_comment` where aid={$id} order by id desc  limit 1")->fetchColumn(0);
	$T->Set("backdes",$des);
	break;
	
  case "index": #g首页          
    $T->ReadDB("SELECT am.id,oug.group_name,am.truename from act_member am left join osa_user_group oug on oug.group_id=am.user_group where am.id='".$uid."'");
    $rabc=new RABC($_SESSION['user_group'],$T->db);
    $menu_info=$rabc->getMenuInfo();
	$menu_str="";
	/*foreach($menu_info as $k=>$menu){
		if($menu['father_menu']=='0'&&$menu['is_show']=='1'){
		    $menu_str.='<li><a href="'.$menu['menu_url'].'" class="J_menuItem"><i class="fa fa-comment-o"></i><span class="nav-label">'.$menu['menu_name'].'</span><span class="fa arrow"></span></a></li>';
		}
	}*/
	foreach($rabc->getChildMenuInfo(0) as $k=>$menu){
		$menu_str.='<li><a href="'.$menu['menu_url'].'" ><i class="'.$menu['menu_icon'].'"></i><span class="nav-label">'.$menu['menu_name'].'</span><span class="fa arrow"></span></a>';
		$child_info=$rabc->getChildMenuInfo($menu['menu_id']);
		if($child_info){
			foreach($child_info as $kc=>$menuc){
				$menu_str.='<ul class="nav nav-second-level"><li><a class="J_menuItem" href="'.$menuc['menu_url'].'" data-index="0"><i class="'.$menuc['menu_icon'].'"></i>'.$menuc['menu_name'].'</a></li></ul>';
			}
		}
		$menu_str.='</li>';
	}
	$T->Set("menu_list", $menu_str);
    break; 
  case "menu_list":
	$T->SetBlock("main_menu", "select menu_id,menu_name from `osa_menu_url` where father_menu=0");
	$p=isset($_GET["p"])?$_GET["p"]:"1"; 
    $so=isset($_GET["so"])?$_GET["so"]:"";
    $mid=isset($_GET["mid"])?$_GET["mid"]:"";
    $ism=isset($_GET["ism"])?$_GET["ism"]:""; 
    if($p<1)$p=1;
    $wh="";                                           
    $wh.=(!empty($mid))?" and (m1.menu_id=".$mid." or m1.father_menu=".$mid.") ":"";
    if(!empty($ism)){
	    $wh.=(!empty($ism)&&$ism==1)?" and m1.is_show=1":" and m1.is_show=0";
    }   
    $wh.=(!empty($so))?" and m1.menu_name like '%".$so."%'":"";
    $rc= $T->db->query("select count(1) from `osa_menu_url` m1 where 1=1 ".$wh)->fetchColumn(0);
    $page=getPageHtml_bt($rc,15,$p,"&t=menu_list&mid=".$mid."&ism=".$ism."&so=".$so);
    $T->Set("page",$page);
    $T->SetBlock("menu_list","select m1.*,m2.menu_name as pmenu_name from `osa_menu_url` m1 left join `osa_menu_url` m2 on m1.father_menu=m2.menu_id where 1=1 ".$wh." order by m1.menu_id,m1.father_menu limit ".(($p-1)*15).",15");
    $T->Set("so",$so);  
    $T->Set("mid",$mid);
    $T->Set("ism",$ism);
	$href_state=url_base64_encode("/man/?p=".$p."&t=menu_list&mid=".$mid."&ism=".$ism."&so=".$so);//用于修改/新增后返回原来页面状态
	$T->Set("href_state", $href_state);
	break;
  case "menu_am":
    $href_state=isset($_GET['href_state'])?url_base64_decode($_GET['href_state']):"";
    $do=isset($_GET['do'])?$_GET['do']:"a";
    $id=isset($_GET['id'])?$_GET['id']:"";
	$T->SetBlock("main_menu", "select menu_id,menu_name from `osa_menu_url` where father_menu=0");
	$T->Set("do", $do);
	$T->Set("menu_id", $id);
	$T->Set("href_state", $href_state);
    break;
  case "user_list":
	$T->SetBlock("group_list", "select group_id,group_name from `osa_user_group` order by group_id");
	$p=isset($_GET["p"])?$_GET["p"]:"1"; 
    $so=isset($_GET["so"])?$_GET["so"]:"";
    $gid=isset($_GET["gid"])?$_GET["gid"]:"";
    $state=isset($_GET["state"])?$_GET["state"]:"";
	$stype=isset($_GET["stype"])?$_GET["stype"]:"1";
    if($p<1)$p=1;
    $wh="";                                           
    $wh.=(!empty($gid))?" and a.user_group=".$gid:"";
    $wh.=($state!='')?" and a.state=".$state:"";//p($wh);  
    if(!empty($so)){
	    $wh.=($stype=='1')?" and a.username like '%".$so."%'":" and a.id=".$so;
    }   
    $rc= $T->db->query("select count(1) from `act_member` a where 1=1 ".$wh)->fetchColumn(0);
    $page=getPageHtml_bt($rc,15,$p,"&t=user_list&gid=".$gid."&state=".$state."&stype=".$stype."&so=".$so);
    $T->Set("page",$page);
    $T->SetBlock("user_list","select a.id,a.username,a.email,FROM_UNIXTIME(a.timestamp,'%Y-%m-%d %H:%i:%S') as regtime,FROM_UNIXTIME(a.lasttime,'%Y-%m-%d %H:%i:%S') as lasttime,a.lastip,a.state,g.group_name from `act_member` a left join `osa_user_group` g on a.user_group=g.group_id where 1=1 ".$wh." order by a.id desc limit ".(($p-1)*15).",15");
    $T->Set("so",$so);  
    $T->Set("gid",$gid);
    $T->Set("state",$state);
	$T->Set("stype",$stype); 
	$href_state=url_base64_encode("/man/?p=".$p."&t=user_list&gid=".$gid."&state=".$state."&stype=".$stype."&so=".$so);//用于修改/新增后返回原来页面状态
	$T->Set("href_state",$href_state);  
	break;
  case "user_am":
	$href_state=isset($_GET['href_state'])?url_base64_decode($_GET['href_state']):"";
	$T->Set("href_state", $href_state);
	$T->SetBlock("group_list", "select group_id,group_name from `osa_user_group` order by group_id");  
	break;
  case "user_group":
	$p=isset($_GET["p"])?$_GET["p"]:"1"; 
    if($p<1)$p=1;
    $rc= $T->db->query("select count(1) from `osa_user_group`")->fetchColumn(0);
    $page=getPageHtml_bt($rc,15,$p,"&t=user_group");
    $T->Set("page",$page);
    $T->SetBlock("group_list","select * from `osa_user_group` limit ".(($p-1)*15).",15");
	$href_state=url_base64_encode("/man/?p=".$p."&t=user_group");//用于修改/新增后返回原来页面状态
	$T->Set("href_state", $href_state);    
	break;
  case "group_am":
	$do=isset($_GET['do'])?$_GET['do']:"";
	$id=isset($_GET['id'])?$_GET['id']:"";
	$href_state=isset($_GET['href_state'])?url_base64_decode($_GET['href_state']):"";
	$T->Set("href_state", $href_state);
	$T->Set("group_id", $id);
	$T->Set("do", $do);
	break;
  case "menu_auth":
	$T->SetBlock("group_list", "select group_id,group_name from `osa_user_group` order by group_id desc");
	$T->SetBlock2("main_menu_list", "select menu_id,menu_name,father_menu from `osa_menu_url` where father_menu=0 order by odx", array(array("block"=>"include_menu_list","pid"=>"menu_id","sql"=>"select menu_id,menu_name,father_menu from `osa_menu_url` where father_menu=?")));  
	break;
  case "profile":
    $T->ReadDB("SELECT * from act_member where id='".$uid."'");
    break; 
  case "main":
	$T->ReadDB("select (select count(*) from main_article where uid='".$uid."') as total,(select count(*) from main_article where state='0' and uid='".$uid."') as dsh,(select count(*) from main_article where state='2' and uid='".$uid."') as ysh,(select count(*) from main_article where state='4' and uid='".$uid."') as hsz");
	$T->SetBlock("kjcd_list", "select * from osa_menu_url where menu_url<>'' and shortcut_allowed=1  ORDER BY odx desc");
	$T->SetBlock("yqlj_list", "select * from `links` order by odx desc");
	break;
  case "links":
    $T->SetBlock("links_list", "select * from `links` order by odx asc");
    break;
  case "sys_config":
	$T->Set("DB_DATABASE",DB_DATABASE);
	$T->Set("DB_HOST",DB_HOST);
	$T->Set("DB_PORT",DB_PORT);
	$T->Set("DB_USER",DB_USER);
	$T->Set("DB_PWD",DB_PWD);
	$T->Set("DB_NAME",DB_NAME);
	$T->Set("DB_CHARSET",DB_CHARSET);
	break;
  case "database_tool":
    $tables=$T->db->query("show tables")->fetchAll(PDO::FETCH_NUM);
	foreach($tables as $k=>$v){
		$T->db->query("analyze table `{$v[0]}`")->fetchAll(PDO::FETCH_NUM);
	}
	$T->SetBlock("table_info","select (@rowNO := @rowNo+1) AS ROWNO,A.TABLE_NAME,A.TABLE_ROWS,round((A.DATA_LENGTH+A.INDEX_LENGTH)/1024, 3) as TABLE_LENGTH from information_schema.tables as A,(select @rowNo:=0) as B where A.table_schema='".DB_NAME."'");
    $dbback_down_path="/".ltrim(DBBACK_ROOT_PATH,"./,../");
	$dbback_down_path=rtrim($dbback_down_path,"/")."/";
	$T->Set("dbback_down_path",$dbback_down_path); 
	break;
  case "template_c":
    //type=1为首页与栏目页模板
    $T->SetBlock("tc_list", "select * from `template` where type=1 order by id asc");
    break;
  case "template_a":
    //type=2为内容页模板
    $T->SetBlock("ta_list", "select * from `template` where type=2 order by id asc");
    break;
  case "global_tag":
    require("../ppf/taglib.php");
    //type=1,2为系统级动态、普通标签，不可删除或修改;type=3,4为自定义普通、模板标签;标签名不可重复
	$s=isset($_GET['s'])?$_GET['s']:'';
	$wh='';
	if($s=='12')$wh=' where type=1 or type=2 ';
	if($s=='34')$wh=' where type=3 or type=4 ';
    $T->SetBlock("gtag_list", "select * from `global_tag` {$wh} order by type asc,id asc");
    break;
    case "statistics": 
	//用户统计
	//$T->SetBlock("custom_tj", "select am.id,am.username,am.truename,count(*) as count from act_member am LEFT JOIN main_article ma on ma.uid=am.id where ma.state=2  group by am.id ORDER BY count(*) desc");
	//栏目统计
	//$T->SetBlock("column_tj", "");
	//用户组统计
	//$T->SetBlock("group_tj", "select aug.group_name,count(*) as count from act_member am LEFT JOIN main_article ma on ma.uid=am.id LEFT JOIN osa_user_group aug on am.user_group=aug.group_id where ma.state=2 group by aug.group_name ORDER BY count(*) desc ");
	$tid=isset($_GET['tid'])?$_GET['tid']:'0';
	$cid=isset($_GET['c'])?$_GET['c']:'0';
	$gid=isset($_GET['gid'])?$_GET['gid']:'0';
	$uname=isset($_GET['uname'])?$_GET['uname']:'';
	$ft=isset($_GET['ft'])?$_GET['ft']:'';
	$et=isset($_GET['et'])?$_GET['et']:'';
	$T->SetBlock("topic_list", "select * from `topic` order by odx asc");
	$T->SetBlock("group_list", "select group_id,group_name from `osa_user_group` order by group_id");
	
	$wh="";$wh2="";
	$wh.=($cid=='0')?"":" and C.cid={$cid}";
	$wh.=($gid=='0')?"":" and A.user_group={$gid}";
	$wh2.=($gid=='0')?"":" and A.user_group={$gid}";
	$ft_s=strtotime($ft);
	$et_s=strtotime($et);
	if($ft_s==''&&$et_s==''){
		$wh.="";
	}elseif($ft_s!=''&&$et_s==''){
		$wh.=" and C.timestamp>=".(int)$ft_s;
	}elseif($ft_s==''&&$et_s!=''){
		$wh.=" and C.timestamp<=".((int)$et_s+3600*24);
	}elseif($ft_s!=''&&$et_s!=''){
		$wh.=" and C.timestamp between ".(int)$ft_s." and ".((int)$et_s+3600*24);
	}
	$wh.=($uname=='')?"":" and A.username like '%{$uname}%'";
	$wh2.=($uname=='')?"":" and A.username like '%{$uname}%'";
	//p($wh);
	$p=isset($_GET["p"])?$_GET["p"]:"1"; 
    if($p<1)$p=1;
    $rc= $T->db->query("select count(1) from `act_member` A where A.state=2 {$wh2}")->fetchColumn(0);
	
	$html='';
    $page=getPageHtml_bt($rc,15,$p,"&t=statistics&tid={$tid}&c={$cid}&gid={$gid}&uname={$uname}&ft={$ft}&et={$et}");
    $T->Set("page",$page);
	if($rc>0){
		//若直接用left join ，不满足条件的用户将不会列出来
		$total1= $T->db->query("select A.id,A.username,B.group_name from `act_member` A left join `osa_user_group` B on A.user_group=B.group_id where A.state=2 {$wh2} limit ".(($p-1)*15).",15")->fetchAll(PDO::FETCH_ASSOC);
	    $total2=$T->db->query("select A.id,count(*) as tnum,sum(C.see) as tsee from `act_member` A left join `osa_user_group` B on A.user_group=B.group_id left join `main_article` C on A.id=C.uid left join `main_art_category` D on C.cid=D.id where A.state=2 and C.state=2 and D.topic_id={$tid} {$wh} group by A.id")->fetchAll(PDO::FETCH_ASSOC);
	    $total2_new=array();
		if($total2){
			foreach($total2 as $k=>$v){
				$total2_new[$v['id']]=$v;
			}
		}
		foreach($total1 as $k=>$v){
			if(isset($total2_new[$v['id']])){
				$tnum=$total2_new[$v['id']]['tnum'];
				$tsee=$total2_new[$v['id']]['tsee'];
			}else{
				$tnum=0;
				$tsee=0;
			}
			
			$html.='<tr id="row'.$v['id'].'" class="tr_list"><td>'.$v['group_name'].'</td><td>'.$v['username'].'</td><td>'.$tnum.'</td><td>'.$tsee.'</td></tr>';
		}
		
	}
	$T->Set("html",$html);
	//p($total1);p($total2_new);exit;
	//p("select A.username,count(*) as tnum,sum(C.see) as tsee, B.group_name from `act_member` A left join `osa_user_group` B on A.user_group=B.group_id left join `main_article` C on A.id=C.uid left join `main_art_category` D on C.cid=D.id where A.state=2 and C.state=2 and D.topic_id={$tid} {$wh} group by A.id limit ".(($p-1)*15).",15");exit;
	//$T->SetBlock("total","select A.username,count(*) as tnum,sum(C.see) as tsee, B.group_name from `act_member` A left join `osa_user_group` B on A.user_group=B.group_id left join `main_article` C on A.id=C.uid left join `main_art_category` D on C.cid=D.id where A.state=2 and C.state=2 and D.topic_id={$tid} {$wh} group by A.id limit ".(($p-1)*15).",15");
	
	break;
  case "catalog":
	$dir = isset($_GET['dir'])?base64_decode($_GET['dir']):'./../html/';
	$fileArr = [];
	$nameArr = [];
	$typeArr = [];
	clearstatcache();
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
			array_push($nameArr,mb_convert_encoding($file, "UTF-8", "GBK"));
			array_push($typeArr,filetype($dir.$file));
			} closedir($dh);
		}
	}
	array_splice($nameArr,0,2);
	array_splice($typeArr,0,2);
	array_push($fileArr,$typeArr,$nameArr);
	$keyArr = array('type','name');
	$fileArr=array_combine($keyArr,$fileArr);
	$fileList=json_encode($fileArr);
	$T->Set("dir",base64_encode($dir));
	$T->Set("fileList",$fileList);
	break;
  case "topic":
    $T->SetBlock("topic_list", "select * from `topic` order by odx asc");
    break;
  case "adv":#广告、飘窗
    $T->SetBlock("adv_list", "select * from `advertisement`");
    break;
}  
$bid=isset($_SESSION['bid'])?$_SESSION['bid']:'';
$T->Set("bid",$bid);//用于判断是否已经统一登录
$T->Set("gtitle",WEB_NAME);
$T->Set("APP_STATE",APP_STATE);// 用于判断是否开启统一登录
$T->Set("APP_ID",APP_ID); 
$T->Set("APP_URL",APP_URL); 
$T->Set("APP_LOGIN",APP_LOGIN);
$T->Set("LR_NAME",LR_NAME); 
$T->clearNaN();
$T->clearNoN();     
$T->display();
$T->close();
//$pd->close();	
unset($T);
//unset($pd);