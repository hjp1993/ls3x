<?php 
header("Content-type: text/html; charset=utf-8;"); 
#subject cache

$t="sys_subject";
$s=$_GET["s"]; #school id
if(empty($s))$s="0";
$f=$_GET["f"];
$pn=isset($_GET["pn"])?$_GET["pn"]:"";#列名
$pv=isset($_GET["pv"])?$_GET["pv"]:"";#列值
$sort=isset($_GET["sort"])?$_GET["sort"]:"id";
if(!isset($_GET["reload"])) #清空重载
if(file_exists("./subject/".$t.$s.$f.$pn.$pv."_sort".$sort.".txt")){
   echo file_get_contents("./subject/".$t.$s.$f.$pn.$pv."_sort".$sort.".txt");
  exit;
}

include '../ppf/pdo_mysql.php'; 
$pd=new pdo_mysql();
if(empty($s)){#无school 0
  if(empty($pn))
      $sql="select * from ".$t." where school=0 order by ".$sort." asc";
  else
      $sql="select * from ".$t." where school=0 and ".$pn."='".$pv."'  order by ".$sort." asc";
}else{
  if(empty($pn))
      $sql="select * from ".$t." where school=0 or school=".$s." order by ".$sort." asc";
  else
      $sql="select * from ".$t." where school=".$s." or (school=0 and ".$pn."='".$pv."' )  order by ".$sort." asc";

}

$rs=$pd->query($sql);
if($f=="txt"){
    $outs="";
    while($r=$rs->fetch(PDO::FETCH_ASSOC)){
        $outs.='<option value="'.$r['id'].'">'.$r['name'].'</option>';	       		
    }	
}
if($f=="json"){
    $outs="[";
    while($r=$rs->fetch(PDO::FETCH_ASSOC)){        
        $outs.='{"id":"'.$r['id'].'","name":"'.$r['name'].'"},';		
    }	
    if(strlen($outs)>1)
        $outs=substr($outs,0,strlen($outs)-1).']';
    else 
        $outs.="]";
}
if($f=="obj"){
    $outs="{";
    while($r=$rs->fetch(PDO::FETCH_ASSOC)){        
        $outs.='"'.$r['id'].'":"'.$r['name'].'",';		
    }	
    if(strlen($outs)>1)
        $outs=substr($outs,0,strlen($outs)-1).'}';
    else 
        $outs.="}";
}
file_put_contents("./subject/".$t.$s.$f.$pn.$pv."_sort".$sort.".txt",$outs); 
echo $outs; 
$pd->close();
unset($pd);
unset($rs);