<?php 
header("Content-type: text/html; charset=utf-8"); 
#require('../ppf/360_safe3.php');
require('../comm/guser.php');
#获取登录信息
if (!session_id())session_start(); 
if(isset($_SESSION["uid"])){#已登录	#gbk-utf8
	echo '{"ret":"ok","uid":"'.$_SESSION["uid"].'","face":"'.$_SESSION["face"].'","idtype":"'.$_SESSION["idtype"].'","nick":"'.$_SESSION["nick"].'","msg":"'.$_SESSION["msg"].'"}'; 
      #mb_convert_encoding($_SESSION["nick"],"UTF-8", "GBK")
}
else{#检测cookie   
	if(isset($_COOKIE["cu"])){
		$cu=$_COOKIE["cu"];
		$ck=$_COOKIE["ck"];
    $GU=new GUser();
    $u=$GU->loginCook($cu,$ck);      
    if($u){
       echo '{"ret":"ok","uid":"'.$_SESSION["uid"].'","face":"'.$_SESSION["face"].'","idtype":"'.$_SESSION["idtype"].'","nick":"'.$_SESSION["nick"] .'","msg":"'.$_SESSION["msg"].'"}'; 
    }
    else  
      echo  '{"ret":"no","info":""}';
      
    $GU->close();
    unset($GU);
		
	}
	else
		echo  '{"ret":"no","info":""}';
}