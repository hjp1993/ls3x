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
	case "savefile":
		$myfile = fopen($_POST["dir"], "w") or die("Unable to open file!");
		$txt = $_POST["file"];
		fwrite($myfile, $txt);
		fclose($myfile);
		echo "ok";
		break;
}		
$pd->close();
unset($pd);
unset($rs);