<?php
//读取XML文件
// by MoreWindows( http://blog.csdn.net/MoreWindows )
if (!session_id()) session_start();#初始化session
$filename = "./counter.xml";
$article_array = array();
$allpv=0;
$alluv=0;
$todaypv=0;
$todayuv=0;
$todaydate="";
$tutime="";
$time=date("Y-m-d");
$dom = new DOMDocument('1.0', 'UTF-8');
$dom->load($filename);
$counts = $dom -> getElementsByTagName("count");
$ip=getip();
$sessionData=session::get($ip);
$tdsession=$ip.$time;
foreach ($counts as $count) {
	$allpv = $count->getElementsByTagName("allpv")->item(0)->nodeValue;
	$alluv = $count->getElementsByTagName("alluv")->item(0)->nodeValue;
	$todaypv = $count->getElementsByTagName("todaypv")->item(0)->nodeValue;
	$todayuv = $count->getElementsByTagName("todayuv")->item(0)->nodeValue;
	$todaydate = $count->getElementsByTagName("todaydate")->item(0)->nodeValue;
	$alluv++;
	if($todaydate==$time){
		$todayuv++;
		if($tdsession!=""&&$tdsession!=$sessionData){
			$allpv++;
			$todaypv++;
			$count->getElementsByTagName("allpv")->item(0)->nodeValue=$allpv;
			$count->getElementsByTagName("todaypv")->item(0)->nodeValue=$todaypv;
		}
		$count->getElementsByTagName("todayuv")->item(0)->nodeValue=$todayuv;
	}else{
		$count->getElementsByTagName("todaypv")->item(0)->nodeValue=1;
		$count->getElementsByTagName("todayuv")->item(0)->nodeValue=1;
		$count->getElementsByTagName("todaydate")->item(0)->nodeValue=$time;
	}
	session::set($ip, $tdsession, 86400);
	$count->getElementsByTagName("alluv")->item(0)->nodeValue=$alluv;
}
//对文件做修改后，一定要记得重新sava一下，才能修改掉原文件
$dom -> save('./counter.xml');

?>