<?php

function p($res){#打印结果
	echo "<pre>";
	print_r($res);
	echo "</pre>";	
}
function p2($res){#打印被编码的结果
	foreach($res as  $k=>$v){
		$res[$k]=base64_decode($v);
	}
	echo "<pre>";
	print_r($res);
	echo "</pre>";	
}
//判断字符串编码,需加@,不报错
function getcode($str){
	$s1 = @iconv('utf-8','gbk//ignore',$str);
	$s0 = @iconv('gbk','utf-8//ignore',$s1);
	if($s0 == $str){
		return true;#utf-8
	}else{
		return false;#gbk
	}
}
//返回utf8的字串
function get_utf8_str($str){
	$s1 = @iconv('utf-8','gbk//ignore',$str);
	$s0 = @iconv('gbk','utf-8//ignore',$s1);
	if($s0 == $str){
		return $str;#utf-8
	}else{
		return $s0;#gbk
	}
}
//中文截取字符串加省略号
function mb_get_str($start,$length,$str){
	$bm=getcode($str);
	if($bm){
		$bmi="utf-8";
		$len=mb_strlen($str,'utf8');
	}else{
		$bmi="gbk";
		$len=mb_strlen($str,'gbk');
	}
	if($length<$len){
		$str=mb_substr($str,$start,$length,$bmi)."...";
	}
	return $str;
}
//中文截取字符串2
function mb_get_str2($str,$start,$length,$postfix){
	$bm=getcode($str);
	if($bm){
		$bmi="utf-8";
		$len=mb_strlen($str,'utf8');
	}else{
		$bmi="gbk";
		$len=mb_strlen($str,'gbk');
	}
	if($length<$len&&$start<$len){
		$str=mb_substr($str,$start,$length,$bmi).$postfix;
	}
	return $str;
}
//获取无限级数组  $a数组中必须包含id,pid,name 3个字段
function get_tree_arr($a,$id){
	$tree = array();                                //每次都声明一个新数组用来放子元素  
    foreach($a as $v){  
        if($v['pid'] == $id){                      //匹配子记录  
            $v['children'] = get_tree_arr($a,$v['id']); //递归获取子记录  
            if($v['children'] == null){  
                unset($v['children']);             //如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）  
            }  
            $tree[] = $v;                           //将记录存入新数组  
        }  
    }  
    return $tree;                                  //返回新数组  
}
//获取无限极栏目html $tree为get_tree_arr方法所返回的tree数组
function get_tree_html($tree,$html="",$pre=""){
	foreach($tree as $k=>$tr){
		$html.="<option value='".$tr['id']."'>".$pre."|——".$tr['name'];
	    if(isset($tr['children'])){
	    	$pre.="&nbsp;&nbsp;&nbsp;&nbsp;";
	        $html=get_tree_html($tr['children'],$html,$pre);//注意：此处$html不是拼接
	        $pre=substr($pre,0,-24);
        }
		$html.="</option>";
	}
    return $html;
    
}

//检测字串,返回转义后的字串
function check_html($mixed){
	if(!is_array($mixed)){
		return htmlspecialchars($mixed,ENT_QUOTES);
	}else{
		foreach($mixed as $k=>$v){
			$mixed[$k]=htmlspecialchars($v,ENT_QUOTES);
		}
		return $mixed;
	}
}

//获取ip
function getIP()
{
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
}

function chkLogin($name='uid',$url='./?t=login'){
	if(!isset($_SESSION[$name])){
		header("location: ".$url."&url=".url_base64_encode($_SERVER["REQUEST_URI"]));	
		exit;
	}
}
function chkLoginNoJump($field="uid"){
	if(!isset($_SESSION[$field])){
		echo "未登录";exit;
	}
}
/*********************************************
字符串函数
**********************************************/
/**检测字符串开头相同*/
function startWith($a, $b) {
	return strpos($a, $b) == 0;
}
/**忽略大写*/
function startWithi($a, $b) {
	return stripos($a, $b) == 0;
}
/**检测字符串结尾相同 */
function endWith($a, $b) { 
	return ($pos = strpos($a, $b)) !== false && $pos == strlen($a) - strlen($b);
}
/**忽略大小写 */
function endWithi($a, $b) {
	return ($pos = stripos($a, $b)) !== false && $pos == strlen($a) - strlen($b);
}

function url_base64_encode($string) {
 $data = base64_encode($string);
 return str_replace(array('+','/','='),array('-','_',''),$data);
}
function url_base64_decode($string) {
   $data = str_replace(array('-','_'),array('+','/'),$string);
   $mod4 = strlen($data) % 4;
   if ($mod4) {
       $data .= substr('====', $mod4);
   }
   return base64_decode($data);
}
 /**压缩网页内空*/
function compressHtml($str) { 
	return preg_replace(array('/>\s+?</mis','/\r\n\s*/mis','/\s*\/>/mis'),
		array('><','','/>'),
		$str);   
}
#压缩html  
function compress_html($string) {  
	$string = str_replace(array("\r\n", "\n","\t"), '', $string);  
	$pattern = array ("/> *([^ ]*) *</", //去掉注释标记  
	"/[\s]+/",  //多个空格
	"/<!--[\\w\\W\r\\n]*?-->/",  //回车换行
	"/\" >/", //标签结束有空格
	"/  \"/",  //引号前有空格
	"'/\*[^*]*\*/'" //
	);  
	$replace = array(">\\1<"," ", "", "\">"," \"",  "");  
	return preg_replace($pattern, $replace, $string);  
} 

/*********************************************
cache 缓存
**********************************************/
function cache_get($dir){	 
    $fname=md5( $_SERVER['PHP_SELF'].$_SERVER["QUERY_STRING"]);
    if(file_exists($dir.$fname)){
        if((time()-filemtime($dir.$fname))<CACHE_TIME){#在显示时间内
            echo file_get_contents($dir.$fname);
            exit;
        }
    }	
}

function cache_set($dir,$html){  
    $fname=md5($_SERVER['PHP_SELF'].$_SERVER["QUERY_STRING"]);	
    file_put_contents($dir.$fname,$html);			
}

/*********************************************
分页函数
**********************************************/ 
function getPageHtml($rcount,$psize,$cur,$param){
     $pgcount = ceil($rcount / $psize);
     $sid = $cur - 5; #分组大小  10条 / 2 
      if ($sid < 1) $sid = 1;
      $eid = $sid + 5;//结束id
      if ($eid > $pgcount) $eid = $pgcount;	          

       $page="共".$rcount."条记录 ".$cur."/". $pgcount."页 ";
        $page.="<a href=\"?p=1". $param."\">首页</a>";
        $page.="<a href=\"?p=".( $cur - 1 > 0 ?  $cur - 1 : 1).$param."\">上一页</a>";

        for ($i = $sid; $i <= $eid; $i++) {
            if ($i ==  $cur)
                $page.="<big>".$i."</big>";
            else
                $page.="<a href=\"?p=".$i.$param."\">".$i."</a>";
        }
        $page.="<a href=\"?p=".($cur + 1 < $pgcount ? $cur + 1 : $pgcount).$param."\">下一页</a>";
        $page.="<a href=\"?p=".$pgcount.$param."\">尾页</a>";
        return $page;
}
/**获取bootstrap 页码*/
function getPageHtml_bt($rcount,$psize,$cur,$param){
     $pgcount = ceil($rcount / $psize);
     $sid = $cur - 5; #分组大小  10条 / 2 
      if ($sid < 1) $sid = 1;
      $eid = $sid + 5;//结束id
      if ($eid > $pgcount) $eid = $pgcount;
        $page="<li><a>".$rcount."条</a><a>页:".$cur."/". $pgcount."</a></li>";
        $page.="<li><a href=\"?p=1". $param."\">|&laquo;</a></li>";
        $page.="<li><a href=\"?p=".( $cur - 1 > 0 ?  $cur - 1 : 1).$param."\">&laquo;</a></li>";

        for ($i = $sid; $i <= $eid; $i++) {
            if ($i ==  $cur)
                $page.="<li><a>".$i."</a></li>";
            else
                $page.="<li><a href=\"?p=".$i.$param."\">".$i."</a></li>";
        }
        $page.="<li><a href=\"?p=".($cur + 1 < $pgcount ? $cur + 1 : $pgcount).$param."\">&raquo;</a></li>";
        $page.="<li><a href=\"?p=".$pgcount.$param."\">&raquo;|</a></li>";
        return $page;       
}
/**获取bootstrap 页码 【改2】*/
function getPageHtml_bt2($rcount,$psize,$cur,$param){
     $pgcount = ceil($rcount / $psize);
     $sid = $cur - 5; #分组大小  10条 / 2 
      if ($sid < 1) $sid = 1;
      $eid = $sid + 5;//结束id
      if ($eid > $pgcount) $eid = $pgcount;
        $page="<span>".$rcount."条</span><span>页:".$cur."/". $pgcount."</span>";
        $page.="<a href=\"./?p=1". $param."\">|&laquo;</a>";
        $page.="<a href=\"./?p=".( $cur - 1 > 0 ?  $cur - 1 : 1).$param."\">&laquo;</a>";

        for ($i = $sid; $i <= $eid; $i++) {
            if ($i ==  $cur)
                $page.="<span style='cursor:pointer'>".$i."</span>";
            else
                $page.="<a href=\"./?p=".$i.$param."\">".$i."</a>";
        }
        $page.="<a href=\"./?p=".($cur + 1 < $pgcount ? $cur + 1 : $pgcount).$param."\">&raquo;</a>";
        $page.="<a href=\"./?p=".$pgcount.$param."\">&raquo;|</a>";
		return $page;       
}

/*新文件缓存【仅适用于通用数据的缓存，某个用户的相关数据请勿使用】
**缓存文件形如abc.txt；
**默认有效期为7天
*/
//设置缓存
function setCache($name,$mixVal){
	$cache_root_path=rtrim(CACHE_ROOT_PATH,'/');
	if(!is_dir($cache_root_path)) mkdir($cache_root_path,0777,true);
	$content=serialize($mixVal);
	file_put_contents($cache_root_path.'/'.$name.'.txt',$content);
}

//获取缓存
function getCache($name){
	$file=rtrim(CACHE_ROOT_PATH,'/').'/'.$name.'.txt';
	$content='-1';
	if(file_exists($file)){
		if((time()-filemtime($file))<3600*24*CACHE_EXPIR){
			$content=file_get_contents($file);
		    $content=unserialize($content);
		}		
	}
	return $content;
	//return '-1';
}

/** 
 * js escape php 实现 
 * @param $string           the sting want to be escaped 
 * @param $in_encoding       
 * @param $out_encoding      
 */ 
function escape($string, $in_encoding = 'UTF-8',$out_encoding = 'UCS-2') { 
    $return = ''; 
    if (function_exists('mb_get_info')) { 
        for($x = 0; $x < mb_strlen ( $string, $in_encoding ); $x ++) { 
            $str = mb_substr ( $string, $x, 1, $in_encoding ); 
            if (strlen ( $str ) > 1) { // 多字节字符 
                $return .= '%u' . strtoupper ( bin2hex ( mb_convert_encoding ( $str, $out_encoding, $in_encoding ) ) ); 
            } else { 
                $return .= '%' . strtoupper ( bin2hex ( $str ) ); 
            } 
        } 
    } 
    return $return; 
}

function unescape($str) 
{ 
    $ret = ''; 
    $len = strlen($str); 
    for ($i = 0; $i < $len; $i ++) 
    { 
        if ($str[$i] == '%' && $str[$i + 1] == 'u') 
        { 
            $val = hexdec(substr($str, $i + 2, 4)); 
            if ($val < 0x7f) 
                $ret .= chr($val); 
            else  
                if ($val < 0x800) 
                    $ret .= chr(0xc0 | ($val >> 6)) . 
                     chr(0x80 | ($val & 0x3f)); 
                else 
                    $ret .= chr(0xe0 | ($val >> 12)) . 
                     chr(0x80 | (($val >> 6) & 0x3f)) . 
                     chr(0x80 | ($val & 0x3f)); 
            $i += 5; 
        } else  
            if ($str[$i] == '%') 
            { 
                $ret .= urldecode(substr($str, $i, 3)); 
                $i += 2; 
            } else 
                $ret .= $str[$i]; 
    } 
    return $ret; 
}