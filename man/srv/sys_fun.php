<?php
header("Content-type: text/html; charset=utf-8;");
require('../../ppf/fun.php');
require('../../ppf/pdo_mysql.php');

if (!session_id()) session_start();  
chkLoginNoJump("uid"); 

$tpl=isset($_POST['tpl'])?$_POST['tpl']:"";
if(empty($tpl)){echo "error:1";exit;}
$pd=new pdo_mysql();
switch($tpl){
	#生成、修改配置信息
	case "gen":
		$res=$pd->query("select * from `sys_config` limit 1");
		if($r=$res->fetch(PDO::FETCH_ASSOC)){
			$p=file_get_contents('../../cfg/config.txt');
			foreach($r as $k=>$v){
				$p=str_replace('{'.$k.'}',$v,$p);
			}
			//p($p);
			file_put_contents('../../cfg/config.inc',$p); 	
            unset($p);
			echo "ok";exit;
		}
		echo "error:2";
		break;
	#删除静态文件
	case "s_del":
		loopDel('../../'.S_ROOT_PATH);//此处注意文档相对位置
		echo "ok";exit;
		break;
	#清除缓存
	case "c_del":
		loopDel('../../'.CACHE_ROOT_PATH);//此处注意文档相对位置
		echo "ok";exit;
		break;
	#备份数据库
	case "backup_db":
		$dbback_path=empty(DBBACK_ROOT_PATH)?'../../dbback':'../../'.DBBACK_ROOT_PATH;
		$type=isset($_POST['type'])?$_POST['type']:'1';
		$tname=isset($_POST['tname'])?$_POST['tname']:array();
		$dbback_name=isset($_POST['dbback_name'])?$_POST['dbback_name']:'';
		$dbback_name=empty($dbback_name)?'db_'.date('YmdHis',time()):htmlspecialchars($dbback_name,ENT_QUOTES);	    
		$dbback_name.='.sql';
		initDir($dbback_path);//初始化备份目录
		if(!checkFileName($dbback_name,$dbback_path)){
			echo "error:2";exit;//文件名已存在
		}
		//echo 'ok';exit;
		$table_info='';
		if($type=='1'){
			$table_info=$pd->query('show tables')->fetchAll(PDO::FETCH_NUM);
		}
	    if($type=='2'||$type=='3'){
			$table_info=array();
			foreach($tname as $t){
				$table_info[][0]=$t;
			}
		}
		//p($table_info);exit;
		if($table_info){			
			$lock_sql="lock tables ";
			foreach($table_info as $key=>$val){
				$lock_sql.=" `{$val[0]}` read,";
			}
			$lock_sql=rtrim($lock_sql,',');
			$pd->query($lock_sql);//读锁	
			
			$table_sql="/*Date ".date('Y-m-d H:i:s',time())."*/\r\n";
			$table_sql.="set foreign_key_checks=0;\r\n";//取消外键约束
			foreach($table_info as $k=>$v){
				$table_sql.="\r\ndrop table if exists `{$v[0]}`;\r\n";
				$table_create=$pd->query("show create table `{$v[0]}`")->fetch(PDO::FETCH_NUM);
				if($table_create){
					$table_sql.=$table_create[1].";\r\n\r\n";//获取表结构
				}
				$table_sql.="lock tables `{$v[0]}` write;\r\n";//文件中加入写锁，防止运行时有其他记录插入
				$table_data=$pd->query("select * from `{$v[0]}`");			
				while($row=$table_data->fetch(PDO::FETCH_NUM)){
					$table_sql.="insert into `{$v[0]}` values(";
					for($i=0;$i<count($row);$i++){
						$table_sql.="'".$row[$i]."',";
					}
					$table_sql=rtrim($table_sql,',');
					$table_sql.=");\r\n";
				}
				$table_sql.="unlock tables;\r\n";//解除写锁
			}
            $pd->query("unlock tables");//解除读锁
			$fp = fopen($dbback_path.'/'.$dbback_name, "w");
			fwrite($fp,$table_sql);
			fclose($fp);
			echo "ok&{$dbback_name}";exit;
			//echo $table_sql;			
		}
	    break;
	#还原数据库
	case "recover_db":
	    set_time_limit(0);
	    $dbback_path=empty(DBBACK_ROOT_PATH)?'../../dbback':'../../'.DBBACK_ROOT_PATH;
		$dbback_name=isset($_POST['dbback_name'])?$_POST['dbback_name']:'';
		if(empty($dbback_name)){
			echo "error:2";exit;//文件名为空,缺少必需参数
		}
		$file_path=rtrim($dbback_path,'/').'/'.$dbback_name;
		if(!file_exists($file_path)){
			echo "error:3";exit;//未找到该文件
		}
		$fp=fopen($file_path,"r");
		$lines='';
		while(!feof($fp)){
			$line=fgets($fp);
			//空行或--注释行跳过(暂不考虑头部的/*xxx*/)
			if(trim($line)==''||strstr($line,'--')){
				continue;
			}
			$lines.=$line;
			if(strstr($lines,';')){
                //恢复数据				
				if($pd->query($lines)===false){
					$pd->query("unlock tables");//恢复出错，解锁(备份时文件中创建表后已加入写锁)
					echo 'error:4';exit;//执行恢复语句时出错（可能原因：主键冲突、mysql设置max_allowed_packet太小的问题等）
				}
				$lines='';
			}
			continue;
		}
		fclose($fp);
        echo "ok";exit;		
	    break;
	#备份文件列表
	case "dbrecover_list":
	    $dbback_path=empty(DBBACK_ROOT_PATH)?'../../dbback':'../../'.DBBACK_ROOT_PATH;
		$files=loopFile($dbback_path,'sql');
        echo json_encode($files);exit;
	    break;
	#删除某个备份文件
	case "del_dbback":
	    $dbback_path=empty(DBBACK_ROOT_PATH)?'../../dbback':'../../'.DBBACK_ROOT_PATH;
		$dbback_name=isset($_POST['dbback_name'])?$_POST['dbback_name']:'';
		if(empty($dbback_name)){
			echo "error:2";exit;//文件名为空,缺少必需参数
		}
		$file_path=rtrim($dbback_path,'/').'/'.$dbback_name;
		if(!file_exists($file_path)){
			echo "error:3";exit;//未找到该文件
		}
		unlink($file_path);
		echo 'ok';exit;
	    break;
	#数据表优化
	case "optimize":
		$tname=isset($_POST['tname'])?$_POST['tname']:array();
		if(!$tname){
			echo "error:2";exit;//表名为空,缺少必需参数
		}
		foreach($tname as $t){
			//$pd->query("optimize table `{$t}`");//innodb需要在启动的时候指定--skip-new或者--safe-mode选项
			//此效果等同于optimize table，此处由于系统中的表都是innodb引擎，这样可以
			if($pd->query("alter table `{$t}` engine=innodb")===false){
				echo "error:3";exit;//优化过程中出错
			}
		}
		echo 'ok';exit;
	    break;
}
#遍历删除
function loopDel($dir){
	if(is_dir($dir)){
		if($handle=opendir($dir)){
			while(($file=readdir($handle))!==false){
				if($file!="." && $file!=".." && $file!="index.html"){
					if(is_dir($dir.'/'.$file)){
						loopDel($dir.'/'.$file);
					}else{
						unlink($dir.'/'.$file);
					}
				}
			}
			closedir($handle);
		}		
	}
}

#检查和设置备份目录
function initDir($path){
	if(!is_dir($path)){
		 mkdir($path,0777,true);
	 }
}
#检查备份文件名是否已存在
function checkFileName($filename,$dir){
	if(is_dir($dir)){
		if($handle=opendir($dir)){
			while(($file=readdir($handle))!==false){
				if($file!="." && $file!=".."){
					if(is_dir($dir.'/'.$file)){
						checkFileName($filename,$dir.'/'.$file);
					}else{
						if($filename==$file){
							return false;
						}
					}
				}
			}
			closedir($handle);
		}
    return true;		
	}
	return false;
}

#遍历查找目录下所有文件(支持多级目录,$file_extension表示查找的文件类型,默认查找所有)
function loopFile($dir,$file_extension=''){
	if(is_dir($dir)){
		static $arr=array();
		if($handle=opendir($dir)){
			while(($file=readdir($handle))!==false){
				if($file!="." && $file!=".."){
					if(is_dir($dir.'/'.$file)){
						loopFile($dir.'/'.$file,$file_extension);
					}elseif(!$file_extension){
						$arr[]=$file;
					}else{						
						$extension=pathinfo($file, PATHINFO_EXTENSION);//扩展名
						if($extension==$file_extension){
							$arr[]=$file;
						}						
					}
				}
			}
			closedir($handle);
		}
        return $arr;		
	}
}
?>