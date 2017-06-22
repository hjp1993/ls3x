<?php 
header("Content-type: text/html; charset=utf-8;"); 
#2层列表显示
$t=$_GET["t"];
$f=$_GET["f"];
$pn=isset($_GET["pn"])?$_GET["pn"]:"";#列名
$pv=isset($_GET["pv"])?$_GET["pv"]:"";#列值
$sort=isset($_GET["sort"])?$_GET["sort"]:"id";
if(!isset($_GET["reload"])) #清空重载
  if(file_exists("./two/".$t.$f.$pn.$pv."_sort".$sort.".txt")){
     echo file_get_contents("./two/".$t.$f.$pn.$pv."_sort".$sort.".txt");
    exit;
  } 

include '../ppf/pdo_mysql.php'; 
$pd=new pdo_mysql();
if(empty($pn))
    $sql="select * from `".$t."` where pid=0 order by ".$sort." asc";
else
    $sql="select * from `".$t."` where pid=0 and ".$pn."='".$pv."' order by ".$sort." asc";
$rs=$pd->query($sql);
if($f=="txt"){
    $outs="";
    while($r=$rs->fetch(PDO::FETCH_ASSOC)){
       $outs.='<option  value="'.$r['id'].'">'.$r['name'].'</option>'; 
       if(empty($pn))
            $sql1="select * from `".$t."` where pid=".$r['id']." order by ".$sort." asc";
        else
            $sql1="select * from `".$t."` where pid=".$r['id']." and ".$pn."='".$pv."' order by ".$sort." asc";
        $rs1=$pd->query($sql1);
        while($r1=$rs1->fetch(PDO::FETCH_ASSOC))#第二级 	
            $outs.='<option  value="'.$r1['id'].'"> &nbsp;&nbsp; '.$r1['name'].'</option>';        		
    }
}
if($f=="group"){#optgroup分组显示
    $outs="";
    while($r=$rs->fetch(PDO::FETCH_ASSOC)){
       $outs.='<optgroup label="'.$r['name'].'"></optgroup>';  
       if(empty($pn))
            $sql1="select * from `".$t."` where pid=".$r['id']." order by ".$sort." asc";
        else
            $sql1="select * from `".$t."` where pid=".$r['id']." and `".$pn."`='".$pv."' order by ".$sort." asc";
        $rs1=$pd->query($sql1);
        while($r1=$rs1->fetch(PDO::FETCH_ASSOC))#第二级 	
            $outs.='<option value="'.$r1['id'].'"> &nbsp;&nbsp; '.$r1['name'].'</option>';        		
    }  
     unset($rs1);
}
if($f=="json"){
    $outs="[";$i=0;
    while($r=$rs->fetch(PDO::FETCH_ASSOC)){  
        if($i++>0)$outs.=",";
        $outs.='{"id":"'.$r['id'].'","name":"'.$r['name'].'","child":[';
        if(empty($pn))
            $sql1="select * from `".$t."` where pid=".$r['id']." order by ".$sort." asc";
        else
            $sql1="select * from `".$t."` where pid=".$r['id']." and ".$pn."='".$pv."' order by ".$sort." asc";
        $k=0;
        $rs1=$pd->query($sql1);        
        while($r1=$rs1->fetch(PDO::FETCH_ASSOC)){#第二级 	
            if($k++>0)$outs.=",";
            $outs.='{"id":"'.$r1['id'].'","name":"'.$r1['name'].'"}';  
        }
        $outs.="]}";
    }	
    $outs.="]";    
    unset($rs1);
}
file_put_contents("./two/".$t.$f.$pn.$pv."_sort".$sort.".txt",$outs); 
echo $outs; 
$pd->close();
unset($pd);
unset($rs);