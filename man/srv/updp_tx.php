<?php
//加密方式：php源码混淆类加密。免费版地址:http://www.zhaoyuanma.com/phpjm.html 免费版不能解密,可以使用VIP版本。
//此程序由【找源码】http://Www.ZhaoYuanMa.Com (免费版）在线逆向还原，QQ：7530782 
?>
<?php
#header("Content-type: text/html; charset=gbk;");
require '../../cfg/config.inc';
foreach($_FILES as $f) 
{
if ($f["error"] >0){
echo '{"ret":"err","code":"01","des":"上传文件出错"}';
exit();
}
$fsize=$f["size"];#($f["size"] / 1024) .kb;
$ftmp_name=$f["tmp_name"];
$ftype=$f["type"];
$fname=$f["name"];
$fext=".".strtolower(pathinfo($fname,PATHINFO_EXTENSION));
if(!strpos(" .jpg.gif.png",$fext)){
echo '{"ret":"err","code":"03","des":"禁止上传的文件类型"}';
exit();
}
#$dir=DIR_ROOT.'/upd/face/'.$_POST["id"].".jpg";
#$y=date("Y");#/m/d
#$d=date("z");
#$w=ceil($d/7);
#$fd=$dir.$y."/".$w."/";#以每周为单位
if(!is_dir(DIR_ROOT.'/upd/face/')){
$re=mkdir(DIR_ROOT.'/upd/face/',0777,true);#第3个参数为创建多级目录
if(!$re){
echo '{"ret":"err","code":"05","des":"没有权限创建目录"}';exit;
exit();
}
}
if (move_uploaded_file($ftmp_name,DIR_ROOT.'/upd/face/'.$_POST["id"].".jpg")){
echo '{"ret":"ok","code":"10","fname":"'.$_POST["id"].'.jpg"}';
if (!session_id()) session_start();
$_SESSION['face']='/upd/face/'.$_POST["id"].'.jpg';
}
}
?>