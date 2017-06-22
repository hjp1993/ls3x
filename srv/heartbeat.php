<?php 
#心跳处理
header("Content-type: text/html; charset=utf-8;"); 
require '../ppf/fun.php';
require '../ppf/pdo_mysql.php';     
#检测登录
if (!session_id()) session_start();
if(isset($_SESSION["uid"])){
  $pd=new pdo_mysql();
  $pd->exec("update act_member set heart=UNIX_TIMESTAMP(),msg=ifnull(msg,0),notice=ifnull(notice,0) where id='".$_SESSION["uid"]."'");
  $num=$pd->query("select msg+notice from act_member where id='".$_SESSION["uid"]."'")->fetchColumn(0);  
  $pd->close();
  unset($pd);
  if(empty($num))
    echo '{"ret":"ok"}';
  else
    echo '{"ret":"new","num":"'.$num.'"}';  
}
else
  echo '{"ret":"no"}'; 