<?php 
header("Content-type: text/html; charset=utf-8;"); 
#针对单条数据的缓存中心 id
$t=$_GET["t"];
$v=$_GET["v"]; #id值
$col=isset($_GET["col"])?$_GET["col"]:"name";#字段名
if(!isset($_GET["reload"])) #清空重载
if(file_exists("./id/".$t.$v.$col.".txt")){
  echo file_get_contents("./id/".$t.$v.$col.".txt");
  exit;
}

include '../ppf/pdo_mysql.php'; 
$pd=new pdo_mysql(); 
$outs=$pd->query("select `".$col."` from `".$t."` where id='".$v."'")->fetchColumn(0);
file_put_contents("./id/".$t.$v.$col.".txt",$outs); 
echo $outs; 
$pd->close();
unset($pd);