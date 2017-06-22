<?php
header("Content-type: text/html; charset=utf-8;");
require('../../ppf/fun.php');
require('../../ppf/pdo_mysql.php');
require('../../ppf/taglib.php');

if (!session_id()) session_start();  
chkLoginNoJump("uid"); 

$tpl=isset($_POST['tpl'])?$_POST['tpl']:"";
if(empty($tpl)){echo "error:1";exit;}
$pd=new pdo_mysql();
switch($tpl){
	case 'taglib':
	    $taglib=new TAGLIB();
		$tagArr=array('globalTag'=>$taglib->globalTag,'cateTag'=>$taglib->cateTag,'artTag'=>$taglib->artTag,'loopTag'=>$taglib->loopTag,'dataTag'=>$taglib->dataTag,'otherTag'=>$taglib->otherTag);
		echo json_encode($tagArr);
	    break;
}
?>