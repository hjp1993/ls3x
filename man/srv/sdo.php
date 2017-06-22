<?php 
/*set do
*/
header("Content-type: text/html; charset=utf-8;"); 
require '../../ppf/fun.php';
require '../../ppf/pdo_mysql.php';
date_default_timezone_set('PRC');

if (!session_id()) session_start();  
chkLoginNoJump("uid"); 
$uid=$_SESSION['uid'];

$pd=new pdo_mysql();
switch($_POST["tpl"]){
 case "chkreg":
    $u=$_POST["u"];
    /*$t=$_POST["t"];
    $m=$_POST["m"];
    $e=$_POST["e"];*/ 
    /*$rs=$pd->prepare("select count(1) from act_member where username=?");  
	$rs->execute(array($u));*/
	$rs=$pd->query("select count(1) from act_member where username='".$u."'");
	
    if($rs->fetchColumn(0))
      echo "1";
    else  
      echo "0";     
    break;    
  case "set_tpl":		 
		$pd->exec("update `main` set tpl='". $_POST['data']."' where id=1");	
    echo "ok";
		break;        
 case "aud_active": #
    $pd->exec("update activity set state=2,status=1 where id=".$_POST["id"]);
    echo "ok";  
    break;  
 case "del_sch_depart": #
    $pd->exec("delete from `sch_department` where id='".$_POST["id"]."'");
      echo "ok";  
    break;  
 /* case "del_topic": #
      $pd->exec("delete from `sch_topic` where id='".$_POST["id"]."'");
      echo "ok";  
    break;  */
  case "del_admin": #
      $pd->exec("delete from `main_member` where id='".$_POST["id"]."'");
      echo "ok";  
    break; 
	    case "audit_advers": 
      $pd->exec("update `main_topic` set state=2  where id=".$_POST["id"]);
        echo "ok";  
    break;
  case "ad_man":#添加管理员
    $u=$_POST["u"];
    $txt=$_POST["txt"];     
    $s=$_POST["s"];
    $nid=$pd->genid("sch_admin");
    $pd->exec("insert into sch_admin(id,sid,uid,intro,timestamp) values(".$nid.",".$s.",'".$u."','".$txt."',UNIX_TIMESTAMP())");
    echo "ok";   
    break;
  case "del_clsman": #
      $pd->exec("delete from `cls_member` where id='".$_POST["id"]."' and isman=2");
      echo "ok";  
    break;
  case "ad_clsman":#添加班级管理员
    $u=$_POST["u"];
    $txt=$_POST["txt"];     
    $c=$_POST["c"];
    $rs=$pd->query("select count(1) from cls_member where isman=2 and cid=".$c." and uid='".$u."'")->fetchColumn(0);
		if($rs==0){
      $nid=$pd->genid("cls_member");
      $pd->exec("insert into cls_member(id,uid,cid,idtype,intro,isman,timestamp,lastdo) values(".$nid.",'".$u."',".$c.",2,'".$txt."',2,UNIX_TIMESTAMP(),UNIX_TIMESTAMP())");
    }else{
      $pd->exec("update `cls_member` set isman=2  where cid=".$c." and uid='".$u."'");
    }
    echo "ok";   
    break; 
  case "m_clsman":#修改班级管理员
    $id=$_POST["id"];
    $txt=$_POST["txt"];
    $pd->exec("update `cls_member` set intro='".$txt."'  where id=".$id." ");
    echo "ok";   
    break;
  case "del_grpman": #
      $pd->exec("delete from `grp_member` where id='".$_POST["id"]."' and isman=2");
      echo "ok";  
    break;
  case "ad_grpman":#添加群组管理员
    $u=$_POST["u"];
    $txt=$_POST["txt"];     
    $g=$_POST["g"];
    $rs=$pd->query("select count(1) from grp_member where isman=2 and gid=".$g." and uid='".$u."'")->fetchColumn(0);
		if($rs==0){
      $nid=$pd->genid("grp_member");
      $pd->exec("insert into grp_member(id,uid,gid,intro,isman,timestamp,lastsay) values(".$nid.",'".$u."',".$g.",'".$txt."',2,UNIX_TIMESTAMP(),UNIX_TIMESTAMP())");
    }else{
      $pd->exec("update `grp_member` set isman=2  where gid=".$g." and uid='".$u."'");
    }
    echo "ok";   
    break; 
  case "m_grpman":#修改群组管理员
    $id=$_POST["id"];
    $txt=$_POST["txt"];
    $pd->exec("update `grp_member` set intro='".$txt."'  where id=".$id." ");
    echo "ok";   
    break;
  case "del_famman": #删除名师管理员
      $pd->exec("delete from `famous_member` where id='".$_POST["id"]."' and isman=2");
      echo "ok";  
    break;
  case "ad_famman":#添加名师管理员
    $u=$_POST["u"];
    $txt=$_POST["txt"];     
    $f=$_POST["f"];
    $rs=$pd->query("select count(1) from famous_member where isman=2 and fid=".$f." and uid='".$u."'")->fetchColumn(0);
		if($rs==0){
      $nid=$pd->genid("famous_member");
      $pd->exec("insert into famous_member(id,uid,fid,intro,isman,timestamp) values(".$nid.",'".$u."',".$f.",'".$txt."',2,UNIX_TIMESTAMP())");
    }else{
      $pd->exec("update `famous_member` set isman=2  where fid=".$f." and uid='".$u."'");
    }
    echo "ok";   
    break; 
  case "m_famman":#修改群组管理员
    $id=$_POST["id"];
    $txt=$_POST["txt"];
    $pd->exec("update `famous_member` set intro='".$txt."'  where id=".$id." ");
    echo "ok";   
    break;
   
  
    case "del_art": #
      $pd->exec("delete from `sch_art` where id=".$_POST["id"]);
      echo "ok";  
    break; 
  case "aud_fam": 
      $pd->exec("update `famous` set state=2  where id=".$_POST["id"]);
        echo "ok";  
    break;
    case "del_fam": #
      $pd->exec("update `famous` set state=4  where id=".$_POST["id"]);
      echo "ok";  
    break; 
  case "aud_sub": 
      $pd->exec("update `subject` set state=2  where id=".$_POST["id"]);
        echo "ok";  
    break;
    case "del_sub": #
      $pd->exec("update `subject` set state=4  where id=".$_POST["id"]);
      echo "ok";  
    break; 
  case "aud_grp": 
      $pd->exec("update `group` set state=2  where id=".$_POST["id"]);
        echo "ok";  
    break;
    case "del_grp": #
      $pd->exec("update `group` set state=4  where id=".$_POST["id"]);
      echo "ok";  
    break;           
  case "aud_cls": #
      $pd->exec("update `class` set state=2  where id=".$_POST["id"]);
        echo "ok";  
    break;
    
  case "aud_art": 
      $pd->exec("update `main_article` set state=2  where id=".$_POST["id"]);
        echo "ok";  
    break;  

   case "del_act": 
      $pd->exec("delete from `act_member` where id='".$_POST["id"]."'");
      $pd->exec("delete from `cls_member` where uid='".$_POST["id"]."'");
      $pd->exec("delete from `grp_member` where uid='".$_POST["id"]."'");
      $pd->exec("delete from `act_school` where uid='".$_POST["id"]."'");
      $pd->exec("delete from `sch_admin` where uid='".$_POST["id"]."'");
      echo "ok";  
    break;  
  case "admin_user": 
      if($pd->query("select count(1) from main_member where uid='".$_POST["id"]."'")->fetchColumn(0))
        echo "err用户已经是管理员";
      else{
        $nid=$pd->genid("main_member");
        $pd->exec("insert into main_member(id,uid,timestamp) values(".$nid.",'".$_POST["id"]."',UNIX_TIMESTAMP())");
        echo "ok";  
      }
    break;
	case "aud_push_list": 
		$pd->exec("update `push_list` set state=2  where id=".$_POST["id"]);
        echo "ok";  
		break;
	case "set_consult_art_comment":
		$time=time();
		if($pd->query("select count(1) from consult_art_comment where aid=".$_POST["aid"])->fetchColumn(0)){
			$pd->exec("update `consult_art_comment` set `des`='{$_POST["content"]}' where aid=".$_POST["aid"]);
		}else{
			$pd->exec("insert into consult_art_comment (`id`,`aid`,`des`,`timestamp`) values ('{$time}','{$_POST["aid"]}','{$_POST["content"]}','{$time}')");
		}
		$pd->exec("update `consult_art` set `show`=2,`endtime`='{$time}' where id=".$_POST["aid"]);
		echo "ok"; 
		break;
    case "del_consult_art":
		$pd->exec("delete from `consult_art` where id in ({$_POST["id"]})");
		echo "ok";
		break;
	case "del_menu_url":#删除单独后台功能列表
		$pd->exec("delete from `osa_menu_url` where menu_id=".$_POST["menu_id"]." or father_menu=".$_POST["menu_id"]);
		echo "ok";
		break;
	case "del_menu_url_all":#批量删除
		$menu_ids=implode(",", $_POST["menu_id"]);
		$pd->exec("delete from `osa_menu_url` where menu_id in(".$menu_ids.") or father_menu in(".$menu_ids.")");
		echo "ok";
		break;
	case "user_batch_deal":#用户处理【单个/批量】
		$ids=implode(",", $_POST["ids"]);
		$ts=isset($_POST["ts"])?$_POST["ts"]:'';
		
		if($_POST["bd"]=='del'){#删除
			$sql="delete from `act_member` where id in(".$ids.")";
		}elseif($_POST["bd"]=='ag'){#添加到用户组
			$sql="update `act_member` set user_group=".$ts." where id in(".$ids.")";
		}else{#其他
			$sql="update `act_member` set state=".$ts." where id in(".$ids.")";
		}
		$pd->exec($sql);
		echo "ok";
		break;
	case "del_user_group":#删除用户组
		$pd->exec("delete from `osa_user_group` where group_id=".$_POST["group_id"]);
		echo "ok";
		break;
	case "art_handle":
		$id=isset($_POST["id"])?$_POST["id"]:'';
		//$cid=isset($_POST["cid"])?$_POST["cid"]:'';
		$flag=isset($_POST["flag"])?$_POST["flag"]:'';
		/* if($flag=='2'||$flag=='3'){#控制审核权限
			$user_group=$_SESSION['user_group'];
			$cate_audit_auth=$pd->query("select cate_audit_auth from `osa_user_group` where group_id='{$user_group}'")->fetchColumn(0);
		    if($cate_audit_auth==''){echo 'error2';exit;}
			$cate_audit_auth=explode(",",$cate_audit_auth);
			$cid=explode(",",$cid);
			$result=array_intersect($cid,$cate_audit_auth);
			if(!$result){echo 'error2';exit;}
			$result=implode(",",$result);
		} */
		
		switch($flag){
			case "1":#回收站
				$sql="update `main_article` set state='4' where id in(".$id.")";
				break;
			/* case "2":#审核通过
				$sql="update `main_article` set state='2' where id in(".$id.") and cid in(".$result.")";
				break;
			case "3":#审核不通过
				$sql="update `main_article` set state='0' where id in(".$id.") and cid in(".$result.")";
				break; */
			case "2":#审核通过
				$sql="update `main_article` set state='2' where id in(".$id.")";
				break;
			case "3":#审核不通过
				$sql="update `main_article` set state='0' where id in(".$id.")";
				break;
			case "4":#彻底删除
				$sql="delete from `main_article` where id in(".$id.")";
				break;
			case "pop":#移动到其他栏目
			    $cid=isset($_POST["cid"])?$_POST["cid"]:'';
				if(!$cid){echo 'error';exit;}
				$sql="update `main_article` set cid='{$cid}' where id in(".$id.")";
				break;
		}
		$pd->exec($sql);
		echo "ok";
	break;
	case "dealNode":#处理栏目操作
	    $add=isset($_POST['add'])?$_POST['add']:"";
	    $drop=isset($_POST['drop'])?$_POST['drop']:"";
	    $rename=isset($_POST['rename'])?$_POST['rename']:"";
		$remove=isset($_POST['remove'])?$_POST['remove']:"";
        //p($rename);
		$sql="";
		//多级添加时，由于父级id临时采用的时间戳，而栏目表是自增的id，子节点的pid字段的值其实是不存在的。处理方法：新增临时字段tmp_id，tmp_pid
		if(!empty($add)){
			$tmp=array();
			$istmp=false;
			$sql.="insert into `main_art_category`(name,alias,pid,visible,odx,timestamp,childnums,nums,lastid,odb,scend,isatc,type,istc,tcid,ista,taid,out_url,intro,topic_id,tmp_id,tmp_pid) values ";
			foreach($add as $a){
				$a=json_decode($a);
				$childnums=isset($a->children)?count($a->children):0;
				$tmp[]="'".$a->id."'";
				if(strlen($a->pid)>10){
					$istmp=true;
					$sql.="('".$a->name."','".$a->alias."','0',".$a->visible.",".$a->odx.",unix_timestamp(),".$childnums.",0,'','".$a->odb."','".$a->scend."','".$a->isatc."','".$a->type."','".$a->istc."','".$a->tcid."','".$a->ista."','".$a->taid."','".$a->out_url."','".$a->intro."','".$a->topic_id."','".$a->id."','".$a->pid."'),";
				}else{
					$sql.="('".$a->name."','".$a->alias."','".$a->pid."',".$a->visible.",".$a->odx.",unix_timestamp(),".$childnums.",0,'','".$a->odb."','".$a->scend."','".$a->isatc."','".$a->type."','".$a->istc."','".$a->tcid."','".$a->ista."','".$a->taid."','".$a->out_url."','".$a->intro."','".$a->topic_id."','".$a->id."','-1'),";
				}
				
			}
			$sql=rtrim($sql,",");$sql.=";";
			if($istmp){
				$tmp=implode(",",$tmp);
				$sql.="update `main_art_category` A left join `main_art_category` B on A.tmp_pid=B.tmp_id set A.pid=B.id where A.tmp_id in ({$tmp}) and A.tmp_pid!='-1';";
			}
		}
		if(!empty($drop)){
			foreach($drop as $d){
				$d=json_decode($d);
				$sql.="update `main_art_category` set odx=".$d->odx.",pid='".$d->pid."' where id='".$d->id."';";
			}
		}
		
		if(!empty($rename)){
			foreach($rename as $ren){
				//p($ren);
				$ren=json_decode($ren);
				$sql.="update `main_art_category` set name='".$ren->name."',alias='".$ren->alias."',visible=".$ren->visible.",odb='".$ren->odb."',scend='".$ren->scend."',isatc='".$ren->isatc."',type='".$ren->type."',istc='".$ren->istc."',tcid='".$ren->tcid."',ista='".$ren->ista."',taid='".$ren->taid."',out_url='".$ren->out_url."',intro='".$ren->intro."',topic_id='".$ren->topic_id."' where id='".$ren->id."';";
			}
		}
		
		if(!empty($remove)){
			foreach($remove as $rem){
				$rem=json_decode($rem);
				$sql.="delete from `main_art_category` where id='".$rem->id."';";
				$sql.="update `main_article` set state=4 where cid='".$rem->id."';";//已删除栏目下文章进回收站
			}
		}
		//echo $sql;
		//exit;
		if($pd->exec($sql)!==false){
			echo '1';
		}else{
			echo '-1';
		}
		
		break;	
	case "deal_art_auth":#处理文章栏目权限
	    $change1=isset($_POST['change1'])?$_POST['change1']:"";
		$change2=isset($_POST['change2'])?$_POST['change2']:"";
		$type=isset($_POST['type'])?$_POST['type']:"";
		//p($change1);p($change2);exit;
		if(count($change1)>1){
			$arr=array();
			foreach($change1 as $k=>$v){
				if($k>0){
					if(count($v)>0){
						$cids=array();
						foreach($v as $v2){
							if(count($v2)>0){
								foreach($v2 as $v3){
									if($v3)array_push($cids,$v3);//去除0
								}
							}
							
							
						}
						sort($cids);
						$cids=implode(",",array_unique($cids));
					}else{
						$cids='';
					}
					$arr[$k]=$cids;
				}
			}
			$sql="";
			//p($arr);p($change2);exit;
			if($type=='fw'){
				foreach($arr as $k=>$a){
					$sql.="update `osa_user_group` set art_publish_auth='".$a."',art_audit_auth='".$change2[$k]."' where group_id=".$k.";";
				}
			}
			if($type=='sh'){
				foreach($arr as $k=>$a){
					$sql.="update `osa_user_group` set cate_audit_auth='".$a."' where group_id=".$k.";";
				}
			}
			//p($sql);exit;
		}
		if($pd->exec($sql)!==false){
			echo '1';
		}else{
			echo '-1';
		}
		break;
	case "del_links":#删除单个友情链接
		if($pd->exec("delete from `links` where id=".$_POST["id"])){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;
	case "del_links_all":#批量删除友情链接
		$ids=implode(",", $_POST["id"]);
		if($pd->exec("delete from `links` where id in(".$ids.")")){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;
    case "push_other_cate":#推送到其他栏目
	    $cur_id=$_POST["cur_id"];
		$cids=$_POST["push_cate"];
		//echo json_encode($_POST["push_cate"]);exit;
		$sql="";
		foreach($cids as $cid){
			$sql.="insert into `main_article` (id,cid,uid,`name`,pre,des,thumb,see,up,report,`share`,comments,`timestamp`,froms,fromid,state,CreateTime,isTop,push_cate) select (select max(id)+1 from main_article),".$cid.",uid,`name`,pre,des,thumb,see,up,report,`share`,comments,`timestamp`,froms,fromid,state,CreateTime,isTop,'' from `main_article` where id=".$cur_id.";";
		}
		//echo $sql;exit;
		if($pd->exec($sql)){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;	
    case "del_template":#删除单个模板
	    $type=isset($_POST["type"])?$_POST["type"]:"";
		$id=isset($_POST["id"])?$_POST["id"]:"";
		if($type==''||$id===''){
			echo 'error';exit;
		}
		if($pd->exec("delete from `template` where type='{$type}' and id={$id}")){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;
	case "del_template_all":#批量删除模板
	    $type=isset($_POST["type"])?$_POST["type"]:"";
		$ids=isset($_POST["id"])?implode(",", $_POST["id"]):"";
		if($type==''||$ids===''){
			echo 'error';exit;
		}
		if($pd->exec("delete from `template` where type='{$type}' and id in({$ids})")){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;
	case "check_global_tag":#检查标签代码是否已存在
	    $id=isset($_POST["id"])?$_POST["id"]:"";
		$code=isset($_POST["code"])?$_POST["code"]:"";
		$do=isset($_POST["do"])?$_POST["do"]:"";
		if($code==''||$do==''){
			echo 'error';exit;
		}
		$wh=($do=='m')?" and id <>{$id}":"";
		$res=$pd->query("select count(1) from `global_tag` where code='{$code}' {$wh}")->fetchColumn(0);
		if(!$res){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;
    case "del_global_tag":#删除单个全局标签
		$id=isset($_POST["id"])?$_POST["id"]:"";
		if($id==''){
			echo 'error';exit;
		}
		if($pd->exec("delete from `global_tag` where id={$id}")){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;
	case "del_global_tag_all":#批量删除全局标签
		$ids=isset($_POST["id"])?implode(",", $_POST["id"]):"";
		if($ids==''){
			echo 'error';exit;
		}
		if($pd->exec("delete from `global_tag` where id in({$ids})")){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;		
    case "del_topic":#删除单个专题
	    $id=isset($_POST["id"])?$_POST["id"]:"";
		if($id==''){
			echo 'error';exit;
		}
		if($pd->exec("delete from `topic` where id=".$id)){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;
	case "del_topic_all":#批量删除专题
		$ids=isset($_POST["id"])?implode(",", $_POST["id"]):"";
		if($ids==''){
			echo 'error';exit;
		}
		if($pd->exec("delete from `topic` where id in(".$ids.")")){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;		
	case "check_topic_dname":#检查专题目录是否已存在
	    $id=isset($_POST["id"])?$_POST["id"]:"";
		$dname=isset($_POST["dname"])?$_POST["dname"]:"";
		$do=isset($_POST["do"])?$_POST["do"]:"";
		if($dname==''||$do==''){
			echo 'error';exit;
		}
		$wh=($do=='m')?" and id <>{$id}":"";
		$res=$pd->query("select count(1) from `topic` where dname='{$dname}' {$wh}")->fetchColumn(0);
		if(!$res){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;
	case "del_adv_all":#批量删除专题
		$ids=isset($_POST["id"])?implode(",", $_POST["id"]):"";
		if($ids==''){
			echo 'error';exit;
		}
		if($pd->exec("delete from `advertisement` where id in(".$ids.")")){
			echo 'ok';
		}else{
			echo 'error';
		}
		break;	
	case "check_adv_tag_name":#检查飘窗英文名是否已经存在
	    $id=isset($_POST["id"])?$_POST["id"]:"";
		$tag_name=isset($_POST["tag_name"])?$_POST["tag_name"]:"";
		$do=isset($_POST["do"])?$_POST["do"]:"";
		if($tag_name==''||$do==''){
			echo 'error';exit;
		}
		$wh=($do=='m')?" and id <>{$id}":"";
		$res=$pd->query("select count(1) from `advertisement` where tag_name='{$tag_name}' {$wh}")->fetchColumn(0);
		if(!$res){
			echo 'ok';
		}else{
			echo 'error';
		}
	    break;
	case "deal_adv":#处理飘窗
	    $_POST=check_html($_POST);
	    $id=isset($_POST["id"])?$_POST["id"]:"";
		//$target=isset($_POST["target"])?$_POST["target"]:"1";
		//p($_POST);exit;
		$do=isset($_POST["do"])?$_POST["do"]:"";
		if($do==''){
			echo 'error';exit;
		}
		$href=$_POST['url'];
		if($_POST['url']==''){
			$href="javascript:void(0)";
		}elseif(strpos($_POST['url'], "http") === false){
			$href='http://'.$_POST['url'];
		}
		$target=$_POST['target']=='1'?'_blank':'';
		$tag_content=<<<eof
		<script>
			var cms_{$_POST['tag_name']} = new FloatWindow(); 
			var cms_option_{$_POST['tag_name']} = {  
			  posLeft: '{$_POST['left']}px',  
			  posTop: '{$_POST['top']}px',  
			  width: '{$_POST['width']}px',  
			  height: '{$_POST['height']}px',  
			  href: '{$href}',  
			  target: '{$target}',  
			  url: '/upd/adv_pic/{$_POST['pic']}',  
			  text: '{$_POST['content']}',
			  speed: '{$_POST['speed']}'		  
		 };  
		 cms_{$_POST['tag_name']}.init(cms_option_{$_POST['tag_name']});  
		 cms_{$_POST['tag_name']}.work();
		</script>;
eof;
		//p($tag_content);exit;
		$tag_content=serialize($tag_content);
		if($do=='a'){
			$stmt=$pd->prepare("insert into `advertisement`(`name`,`tag_name`,`intro`,`pic`,`content`,`url`,`target`,`left`,`top`,`width`,`height`,`speed`,`tag_content`,`timestamp`) values(:name,:tag_name,:intro,:pic,:content,:url,:target,:left,:top,:width,:height,:speed,:tag_content,".time().")");
			$add=array(
			    ':name'=>$_POST['name'],
				':tag_name'=>$_POST['tag_name'],
				':intro'=>$_POST['intro'],
				':pic'=>$_POST['pic'],
				':content'=>$_POST['content'],
				':url'=>$_POST['url'],
				':target'=>$_POST['target'],
				':left'=>$_POST['left'],
				':top'=>$_POST['top'],
				':width'=>$_POST['width'],
				':height'=>$_POST['height'],
				':speed'=>$_POST['speed'],
				':tag_content'=>$tag_content
			);
			//p($add);exit;
			if($stmt->execute($add)){
				echo "ok";
			}else{
				echo "error";
			}
		}
		if($do=='m'&&$id){
			$stmt=$pd->prepare("update `advertisement` set `name`=:name,`tag_name`=:tag_name,`intro`=:intro,`pic`=:pic,`content`=:content,`url`=:url,`target`=:target,`left`=:left,`top`=:top,`width`=:width,`height`=:height,`speed`=:speed,`tag_content`=:tag_content where id={$id}");
			$add=array(
			    ':name'=>$_POST['name'],
				':tag_name'=>$_POST['tag_name'],
				':intro'=>$_POST['intro'],
				':pic'=>$_POST['pic'],
				':content'=>$_POST['content'],
				':url'=>$_POST['url'],
				':target'=>$_POST['target'],
				':left'=>$_POST['left'],
				':top'=>$_POST['top'],
				':width'=>$_POST['width'],
				':height'=>$_POST['height'],
				':speed'=>$_POST['speed'],
				':tag_content'=>$tag_content
			);
			//p($add);exit;
			if($stmt->execute($add)){
				echo "ok";
			}else{
				echo "error";
			}
		}
	    break;
}		
$pd->close();
unset($pd);
unset($rs);