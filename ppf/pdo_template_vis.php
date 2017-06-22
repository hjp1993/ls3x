<?php 
/*html Template  
*前台模板和页面自动化完成类
*lren-zhs 2013-6-15 10:27
*pdo mysql 操作
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/config.inc';
class pdo_template{	
	public $content=''; 
	protected $path='';
	protected $blocks=array(); 
	public $db;
	
	/* public $cms_cid;
	public $cms_aid;
	public $cms_p;
	public $cms_qname; */
	public $cms_pageInfo;
	protected $cms_systag;
	protected $cms_acd;
	protected $cms_gtag;
	
	//public $wait=array();//等待处理的标签(在某个循环内，依赖局部变量)
	
	/**初始化模板和编码 默认gb18030 utf8*/
	public function __construct($file=false,$open_db=true,$charset=DB_CHARSET)	{ #数据库统码 '' DB_CHARSET
		if(!empty($file))$this->loadTpl($file); 
    /*if (!file_exists($file) || !is_readable($file)) return false; 
		$this->content=file_get_contents($file);	
		$this->path=dirname($file).'/';
		$filename=basename($file); 
		$this->MatchBlock();*/ 	
		if($open_db){
			$this->connect($charset);
		}
	}	
	protected function connect($charset=DB_CHARSET){
		try{
			$this->db=new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=".$charset
				,DB_USER,DB_PWD,array(PDO::ATTR_PERSISTENT=>false));			 
		}
		catch(PDOException $e){
			die("Connect not open pdo_db:" . get_utf8_str($e->getMessage()));	
		}
		$this->db->exec("SET NAMES ".$charset);
	}  
	public function close(){
		if($this->m_rs)
			unset($this->m_rs);		
		if($this->db)
			unset($this->db);
	}
    /**重新载入模板*/
    public function loadTpl($file=false){
	  if (!file_exists($file) || !is_readable($file)) return false; #file not readed
	      $this->content=file_get_contents($file);	
		  $this->content=$this->content.'<script src="/ppf/js/cookies.min.js" type="text/javascript"></script><script src="/js/local.js" type="text/javascript"></script><script src="/ppf/js/cms.js" type="text/javascript"></script>';//增加必要的js引用
		  $this->path=dirname($file).'/';//返回路径中的目录部分
		  $filename=basename($file); //返回路径中的文件名部分
		  $this->MatchBlock(); 	
    }
	public function query($sql){
		return $this->db->query($sql);
	}
	/**设置子模板*/
	public function SetTemplate($block,$file){
		if(strpos($file ,'/'))
			$data=file_get_contents($file);
		else
			$data=file_get_contents($this->path.$file);
		if(isset($data)){
			$this->content=str_replace( '{'.$block.'}',$data,$this->content);			
		}
	}
	/**设置子模板 new */
	public function SetTpl($block,$file){
		$this->SetTemplate($block,$file);
	}
	/**初始化 block*/	
	protected function MatchBlock(){
		//此处加上U可匹配同名标签，即一个标签可多次使用
	    preg_match_all("/<!--\sSTART\s([a-z0-9_]+)\s-->([\s\S]*)<!--\sEND\s(\\1)\s-->/misU", $this->content, $m);
        //p($m);exit;		
	    for($k=0;$k<count($m[0]);$k++){
	    	$this->blocks[$m[1][$k]]=$m[2][$k];//关联数组，标签=>标签包含的内容
	    	$this->content=str_replace($m[0][$k], '$'.$m[1][$k].'$',$this->content);//标签和其包含的内容替换为  $标签名$ ，主要应是方便后续替换		
	    }
//p($this->content);exit;		
	}
	/*****************************************************************************
	*
	*块操作
	*
	*****************************************************************************/	 
	public function SetBlock($block,$sql,$farr=null,$farr1=null){	
		if(isset($this->blocks[$block])){
			$val=$this->blocks[$block];//获取标签=>标签包含内容关联数组中的对应标签的内容
			$ret='';
			//w匹配所有的数字和字母以及下划线，等价于[A-Za-z0-9_]，匹配标签内容中的所有{xxx}
			preg_match_all("/{(\w*)}/mis", $val, $m);		
			//p($m);exit;	
			$rs=$this->db->query($sql);
			while ($r=$rs->fetch(PDO::FETCH_ASSOC)) { 
			 	$val1=$val;				
				//处理每个匹配到的{xxx}（会判断是SetBlock所有还是Set所有）
				for($k=0;$k<count($m[0]);$k++){	
					if(isset($r[$m[1][$k]])){#字段存在	
						if($farr&&in_array($m[1][$k],$farr)){#格式化日期
							$idx=array_search($m[1][$k],$farr);	//在数组中搜索某个键值，并返回对应的键名。
							
							$val1=str_replace($m[0][$k], 								
							strftime($farr1[$idx],is_numeric($r[$m[1][$k]])?$r[$m[1][$k]]:strtotime($r[$m[1][$k]])),
								$val1);
								#is_int($val1)?$val1:strtotime($val1))
						}					
						else	
							$val1=str_replace($m[0][$k], $r[$m[1][$k]],$val1);									
					}
			 	}			 
			 	$ret.=$val1;
			 }
			unset($rs);				
			$this->content=str_replace('$'.$block.'$', $ret,$this->content);
		}
	}	
  public function SetBlock2A($block,$sql,$arr){#$arr=array($block1,$sql1,$pid	)
  //"list","sql",array("block"=>"rp","sql"=>"***? and id>?","param"=>array("id","id")))
		if(isset($this->blocks[$block])){
			$html=$this->blocks[$block];
			preg_match_all("/<!--\sSTART\s([a-z0-9_]+)\s-->([\s\S]*)<!--\sEND\s(\\1)\s-->/mis",$html,$m);
			$tmparr=array();
			for($k=0;$k<count($m[0]);$k++){
				$tmparr[$m[1][$k]]=$m[2][$k];
				$html=str_replace($m[0][$k], '$'.$m[1][$k].'$',$html);	     
			} 			 
			#第一级
			$ret='';
			 preg_match_all("/{(\w*)}/mis", $html, $m);			 
			 $rs=$this->db->query($sql);
			while ($r=$rs->fetch(PDO::FETCH_ASSOC)) { 
			 	$val1=$html;
				for($k=0;$k<count($m[0]);$k++){
					if(isset($r[$m[1][$k]]))#字段存在						
            $val1=str_replace($m[0][$k], $r[$m[1][$k]],$val1);				
			 	}
       
				#第二级 循环
				//foreach($arr as $d){
					$html1=$tmparr[$arr["block"]];
					$std=$this->db->prepare($arr['sql']);
					preg_match_all("/{(\w*)}/mis", $html1, $m1);
       
          switch(count($arr["param"])){
             case 1:$std->execute(array($r[$arr["param"][0]]));break;
             case 2:$std->execute(array($r[$arr["param"][0]],$r[$arr["param"][1]]));break;
             case 3:$std->execute(array($r[$arr["param"][0]],$r[$arr["param"][1]],$r[$arr["param"][2]]));break;
             case 4:$std->execute(array($r[$arr["param"][0]],$r[$arr["param"][1]],$r[$arr["param"][2]],$r[$arr["param"][3]]));break;
             case 5:
             default:$std->execute(array($r[$arr["param"][0]],$r[$arr["param"][1]],$r[$arr["param"][2]],$r[$arr["param"][3]],$r[$arr["param"][4]]));break;
       
          }
						
					$ret2='';
					while($r1=$std->fetch(PDO::FETCH_ASSOC)){
						$val2=$html1;
						for($k=0;$k<count($m1[0]);$k++){
							if(isset($r1[$m1[1][$k]]))						
								$val2=str_replace($m1[0][$k], $r1[$m1[1][$k]],$val2);				
						}	
						$ret2.=$val2;					
					}	
					$val1=str_replace( '$'.$arr['block'].'$',$ret2,$val1);
				//}					
				#第二级结束
			 	$ret.=$val1;				
			 }
			unset($rs);		
			unset($std);
			unset($m);
			unset($m1);
			$this->content=str_replace('$'.$block.'$', $ret,$this->content);			
		}
	} 
	/**二级嵌套操作旧　arr(block,pid,sql)*/
	public function SetBlock2($block,$sql,$arr){#$block1,$sql1,$pid	
		if(isset($this->blocks[$block])){
			$html=$this->blocks[$block];
			//此处加上U可匹配同名标签，即一个子标签可多次使用
			preg_match_all("/<!--\sSTART\s([a-z0-9_]+)\s-->([\s\S]*)<!--\sEND\s(\\1)\s-->/misU",$html,$m);
			$tmparr=array();
			for($k=0;$k<count($m[0]);$k++){
				$tmparr[$m[1][$k]]=$m[2][$k];
				$html=str_replace($m[0][$k], '$'.$m[1][$k].'$',$html);	     
			} 			 
			#第一级
			$ret='';
			preg_match_all("/{(\w*)}/mis", $html, $m);
            $rs=$this->db->query($sql);
			while ($r=$rs->fetch(PDO::FETCH_ASSOC)) { 
			 	$val1=$html;
				for($k=0;$k<count($m[0]);$k++){
					if(isset($r[$m[1][$k]]))#字段存在						
						$val1=str_replace($m[0][$k], $r[$m[1][$k]],$val1);				
			 	}
				#第二级 循环	
                //此处$arr为多维数组				
				foreach($arr as $d){
					$html1=$tmparr[$d["block"]];//获取第二级标签名所包含的代码
					$std=$this->db->prepare($d['sql']);//执行二级sql查询
					preg_match_all("/{(\w*)}/mis", $html1, $m1);//匹配二级中的{name}
					$std->execute(array($r[$d['pid']]));	
					$ret2='';
					while($r1=$std->fetch(PDO::FETCH_ASSOC)){
						$val2=$html1;
						for($k=0;$k<count($m1[0]);$k++){
							if(isset($r1[$m1[1][$k]]))						
								$val2=str_replace($m1[0][$k], $r1[$m1[1][$k]],$val2);//替换二级中的值				
						}	
						$ret2.=$val2;					
					}	
					$val1=str_replace( '$'.$d['block'].'$',$ret2,$val1);
				}					
				#第二级结束
			 	$ret.=$val1;				
			 }
			unset($rs);		
			unset($std);
			unset($m);
			unset($m1);
			$this->content=str_replace('$'.$block.'$', $ret,$this->content);			
		}
	} 
	protected $m_blockname;
	protected $m_block;
	public $m_rs;
	protected $m_val;
	protected $m_content;
	protected $m_m=array(); #正则表达式
	/**手动替换内容*/
	public function Mual_SetBlock($block,$sql){
 		$this->m_blockname=$block;
 		if(isset($this->blocks[$block])){
 			$this->m_block=$this->blocks[$block];
 			$this->m_rs=$this->db->query($sql);
 			$this->m_val=$this->m_block; 	
 			$this->m_content='';		
 			preg_match_all("/{(\w*)}/mis", $this->m_block, $m);
 			if(!empty($this->m_m))
 				$this->m_m=array();
 			 for($k=0;$k<count($m[0]);$k++){
				$this->m_m[$m[1][$k]]=$m[1][$k];		    	
			    }			
 			return true; 			
 		}
 		else 
 			return false;              
	}
	public function Mual_Assign($field,$val){
		$this->m_val=str_replace('{'.$field.'}', $val,$this->m_val);
	}
	/**功能同上*/
	public function Mual_Set($field,$val){
		$this->m_val=str_replace('{'.$field.'}', $val,$this->m_val);
	}
	public function Mual_Full($row){		
		foreach($this->m_m as $key=>$val){			
			if(isset($row[$key]))
				$this->m_val=str_replace('{'.$key.'}', $row[$key],$this->m_val);						
	 	}
	}
	public function Mual_OneBlock(){ #一行
		$this->m_content.=$this->m_val;
		$this->m_val=$this->m_block;
	}
	public function Mual_EndBlock(){
		$this->content=str_replace('$'.$this->m_blockname.'$', $this->m_content,$this->content);
	}
	/*****************************************************************************
	*
	*全局内容替换
	*
	*****************************************************************************/	    
	public function Set_Assign($name,$val){
		$this->content=str_replace( '{'.$name.'}',$val,$this->content);//将页面中{name}替换为$val,此处不依赖标签
	}
	public function Set($name,$val){
		$this->Set_Assign($name,$val);
	}
	/**从数据库里读取全局信息*/
	public function Set_AssignDataBase($sql){
		$rs=$this->db->query($sql);
		if($rs){
			$r=$rs->fetch();#mysql_fetch_assoc($rs);
			preg_match_all("/{(\w*)}/mis", $this->content, $m);
			for($k=0;$k<count($m[0]);$k++){
				if( isset($r[$m[1][$k]]))
					$this->content=str_replace($m[0][$k], $r[$m[1][$k]],$this->content);			    	
			}
			unset($rs);
		}
	}
	/**新的读取函数 从数据库里读取全局信息 */
	public function ReadDB($sql){
		$this->Set_AssignDataBase($sql);
	}
	/*****************************************************************
	 * 
	 * 分页 
	 * 
	 ****************************************************************/
	public $tblname = "";
	public $columns = "*";
	public $orderby = "order by id desc";
	public $where = "id>0";
	public $qwhere = ""; //url分页条件
	public $psize = 10;
	public $pindex = 1;
	public $pgcount = 0;
	public $rowcount = 0;
	public $pgnosize = 10; //页码分组

	public function ByPage($block){
		$this->SetBlock($block,$this->getPageSql());
		#$this->gen_PageLink();
	} 
	public function Mual_ByPage($block) { #手动填充
    $this->Mual_SetBlock($block, $this->getPageSql());
    #$this->gen_PageLink();
	}
	protected function getPageSql(){
		if($this->pindex<1)$this->pindex=1;		
		$rs=$this->db->query("select count(1) from ".$this->tblname." where ".$this->where); 
		$this->rowcount=$rs->fetchColumn(0);#返加第一个字段值	
		unset($rs);
		$this->pgcount = ceil($this->rowcount / $this->psize);		
		if ($this->pgcount > 0 && $this->pindex >$this->pgcount) $this->pindex = $this->pgcount;
            		return "select ".$this->columns." from ".$this->tblname." where ".$this->where." ".$this->orderby." limit ".
            		(($this->pindex - 1) * $this->psize) .",".$this->psize;             		
	}
	public function gen_PageLink() {#生成页码连接		
      $sid = $this->pindex - $this->pgnosize / 2;
      if ($sid < 1) $sid = 1;
      $eid = $sid + $this->pgnosize;//结束id
      if ($eid > $this->pgcount) $eid = $this->pgcount;	          

     $page="共".$this->rowcount."条记录 ".$this->pindex."/". $this->pgcount."页 ";
      $page.="<a href=\"?p=1". $this->qwhere."\">首页</a>";
      $page.="<a href=\"?p=".( $this->pindex - 1 > 0 ?  $this->pindex - 1 : 1).$this->qwhere."\">上一页</a>";

      for ($i = $sid; $i <= $eid; $i++) {
          if ($i ==  $this->pindex)
              $page.="<big>".$i."</big>";
          else
              $page.="<a href=\"?p=".$i.$this->qwhere."\">".$i."</a>";
      }
      $page.="<a href=\"?p=".($this->pindex + 1 < $this->pgcount ? $this->pindex + 1 : $this->pgcount).$this->qwhere."\">下一页</a>";
      $page.="<a href=\"?p=".$this->pgcount.$this->qwhere."\">尾页</a>";
      #$this->Set_Assign("page", $page);
      return $page;
	}  
	/**清除NaN $*$ */
	public function clearNaN(){		
		$this->content=preg_replace('/\$(\w*)\$/mis','',$this->content); 		
	}
	public function clearNon(){
		$this->content=preg_replace("/{(\w*)}/mis",'',$this->content); 		
	}
	/**显示*/
	public function display(){
		echo $this->content;
	}
	 /**压缩网页内空*/
	public function Compress(){
		$this->content=preg_replace('/>\s+?</mis','><',$this->content); 
		$this->content=preg_replace('/\r\n\s*/mis','',$this->content);   
		$this->content=preg_replace('/\s*\/>/mis','/>',$this->content);   
		return $this->content;
	} 
	
	/**********************************************************************
	*
	*cms标签规则
	*
	***********************************************************************/
	/*初始化*/
	public function cms_tag_init($init_info){
		$this->cms_pageInfo=$init_info['page_info'];
		$this->cms_systag=array_merge($init_info['page_info'],$init_info['sys_tag']);
		$this->cms_acd=$init_info['acd'];
		$this->cms_gtag=$init_info['gtag'];		
        $this->cms_g_tag();
		$this->cms_getcinfo_tag();
		$this->cms_date_tag();
		$this->cms_cut_tag();
		$this->cms_loop_tag();
		$this->cms_art_tag();
		$this->cms_prev_next_tag();
		$this->cms_wait_tag();
		
		//$this->cms_cc();
	}
	
	public function cms_getGtagByType($type){
		$gtag=isset($this->cms_gtag[$type])?$this->cms_gtag[$type]:array();
		return $gtag;
	}
	
	/*1、全局变量标签<%username%>
	/*包括:(1)自定义模板标签
	*      (2)系统动态标签、普通标签	
	*      (3)自定义普通标签	  
	*      
	*/	
	
	public function cms_g_tag(){
		$gtag4=$this->cms_getGtagByType(4);
		if($gtag4){
			if(preg_match_all("/<%(.*)%>/misU", $this->content, $m_tpl)){
				//先加载自定义标签模板
				foreach($m_tpl[0] as $k=>$v){								
					if(isset($gtag4[$m_tpl[1][$k]])){
						$tpl_file=$this->path.'/'.trim(unescape($gtag4[$m_tpl[1][$k]]['content']));
						if(file_exists($tpl_file)){
							$tpl_html=file_get_contents($tpl_file);
							$this->content=str_replace($v,$tpl_html,$this->content);
						}
					}	
				}
			}			
		}
	    $gtag3=$this->cms_getGtagByType(3);
		if($gtag3){
			if(preg_match_all("/<%(.*)%>/misU", $this->content, $m)){
				//加载自定义普通标签
				foreach($m[0] as $k=>$v){								
					if(isset($gtag3[$m[1][$k]])){
						$this->content=str_replace( $v,unescape($gtag3[$m[1][$k]]['content']),$this->content);
					}	
				}
			}			
		}
		if(preg_match_all("/<%(.*)%>/misU", $this->content, $m)){
			//$gtag12=array_merge($this->cms_getGtagByType(2),$this->cms_systag);//系统标签在后(键名相同时，覆盖前一个数组，确保系统标签优先级) 
			$gtag1=$this->cms_systag;
			$gtag2=$this->cms_getGtagByType(2);	
									
			foreach($m[0] as $k=>$v){
				if(isset($gtag1[$m[1][$k]])){
					//系统动态标签
					$this->content=str_replace( $v,$gtag1[$m[1][$k]],$this->content);
				}
				if(strstr($m[1][$k],'@url(')){
					//系统级动态 主题/站点
					$topic=substr($m[1][$k], 5);
					$topic=substr($topic, 0, -1);
					$topic=trim($topic,'\',\"');
					$replace=trim(WEB_URL,'/').'/?w='.$topic;
					$this->content=str_replace( $v,$replace,$this->content);
				}
				if(strstr($m[1][$k],'adv(')){
					//飘窗
					$adv=substr($m[1][$k], 4);
					$adv=substr($adv, 0, -1);
					$adv=trim($adv,'\',\"');
					$replace='';
					if($adv!=''){
						$replace=getCache('adv_'.$adv);
						if($replace=='-1'){
							$adv_info=$this->query("select tag_content from `advertisement` where tag_name='{$adv}'");
					        if($adv_info=$adv_info->fetch(PDO::FETCH_ASSOC)){
								$replace=$adv_info['tag_content']==''?'':unserialize($adv_info['tag_content']);
							}
							setCache('adv_'.$adv,$replace);
						}
					}
					$this->content.=$replace;//放在最后，防止js报错   not defined
					$this->content=str_replace( $v,'',$this->content);//标签替换为空
				}
				if(isset($gtag2[$m[1][$k]])){
					//系统普通标签
					$this->content=str_replace( $v,unescape($gtag2[$m[1][$k]]['content']),$this->content);
				}
				
			} 
		}		
		//p($this->content);
	}
	
	
	/*2、指定栏目信息标签   <f:getcinfo(30,'name','type','type=1时的获取最近一级父级栏目/顶级父栏目')>
	*【已加入wait处理】
	*/
	public function cms_getcinfo_tag(){
		if(preg_match_all("/f:getcinfo\((.*)\)/misU", $this->content, $m)){
			//p($m);exit;
		foreach($m[0] as $k=>$v){			
			if(!$m[1][$k])return;//缺少参数		
				$attr=explode(",",$m[1][$k]);			
				//list($cid,$query)=$attr;
				$cid=isset($attr[0])?$attr[0]:'';
				$query=isset($attr[1])?$attr[1]:'';
				$type=isset($attr[2])?$attr[2]:'';
				$istop=isset($attr[3])?$attr[3]:'';
				if($cid!=''&&stripos($cid,':')===false&&$query!=''){
					if($type!=''){
						if($istop!=''){
							$cinfo=$this->cms_acd->getTpinfo($cid);
						}else{
							$cinfo=$this->cms_acd->getPinfo($cid);
						}
					}else{
						$cinfo=$this->cms_acd->getInfoByCid($cid);
					}			
					if($cinfo){
						//p($cinfo);exit;
						$query=trim($query,'\',\"');
						$replace='';
						if($query=='@url'){
							$replace=$this->cms_getUrl('',$cinfo['id']);
						}
						if(isset($cinfo[$query])){
							$replace=$cinfo[$query];
						}
						$this->content=str_replace('<'.$m[0][$k].'>', $replace,$this->content);
					}
				}else{
					$wait='wait%getcinfo%'.$cid.'%'.$query.'%'.$type.'%'.$istop;//替换在循环内部并依赖局部变量的函数标签
					$this->content=str_replace('<'.$m[0][$k].'>', '<$'.$wait.'$>',$this->content);
					//$this->wait[$wait]=$m[0][$k];
				}			
			}
		}		
		
	}
	
	/*【wait】:处理未完成(依赖于局部变量)的标签 */
	public function cms_wait_tag(){
		if(preg_match_all("/[$](wait%.*)[$]/misU", $this->content, $m)){
			if($m[0]){
				$fun=array();//记录涉及了那些方法，避免不必要的调用
				foreach($m[0] as $k=>$v){
					if($m[1][$k]!=''){
						$origin=explode('%',$m[1][$k]);
						$new_tag='';
						if(isset($origin[1])){
							if($origin[1]=='getcinfo'){
								$fun[]='getcinfo';
								$cid=isset($origin[2])?$origin[2]:'';
								$query=isset($origin[3])?$origin[3]:'';
								$type=isset($origin[4])?$origin[4]:'';
								$istop=isset($origin[5])?$origin[5]:'';
								$new_tag="f:getcinfo({$cid},{$query},{$type},{$istop})";
							}
							if($origin[1]=='date'){
								$fun[]='date';
								$format=isset($origin[2])?$origin[2]:'';
								$timestamp=isset($origin[3])?$origin[3]:'';
								$new_tag="f:date({$format},{$timestamp})";
							}
                            if($origin[1]=='cut'){
								$fun[]='cut';
								$str=isset($origin[2])?$origin[2]:'';
								$start=isset($origin[3])?$origin[3]:'';
								$length=isset($origin[4])?$origin[4]:'';
								$postfix=isset($origin[5])?$origin[5]:'';
								$new_tag="f:cut({$str},{$start},{$length},{$postfix})";
							}								
						}
						
						$this->content=str_replace('<'.$m[0][$k].'>', '<'.$new_tag.'>',$this->content);
						//unset($this->wait[$m[1][$k]]); 
					}				
				}
				if(in_array('getcinfo',$fun))$this->cms_getcinfo_tag();
				if(in_array('date',$fun))$this->cms_date_tag(1);
				if(in_array('cut',$fun))$this->cms_cut_tag(1);
				unset($fun);
			}
		}				
	}
	
	/*获取指定栏目信息 */
	public function cms_getInfoByCid($cid){
		return $this->cms_acd->getInfoByCid($cid);
	}
	
	/*3、指定栏目的父级栏目信息标签   <f:getpcinfo(30,'name',1)> 最后一个参数可选，为1时获取顶级栏目，默认最近一级的父栏目    */
	/* public function cms_getpcinfo_tag(){
		preg_match_all("/f:getpcinfo\((.*)\)/misU", $this->content, $m);
		//p($m);
		foreach($m[0] as $k=>$v){
			$attr=explode(",",$m[1][$k]);
			if(!$m[1][$k])return;//缺少参数			
			//list($cid,$query)=$attr;
			$cid=isset($attr[0])?$attr[0]:'';
			$query=isset($attr[1])?$attr[1]:'';
			$istop=isset($attr[2])?$attr[2]:'';
			if($cid!=''&&$query!=''){
				if($istop!=''){
				    $cinfo_arr=$this->cms_acd->getTpinfo($cid);
				}else{
					$cinfo_arr=$this->cms_acd->getPinfo($cid);
				}				
				if($cinfo_arr){
					//p($cinfo);exit;
					$query=trim($query,'\',\"');
					if(isset($cinfo[$query])){
						$this->content=str_replace('<'.$m[0][$k].'>', $cinfo[$query],$this->content);
					}
				}
			}			
		}
		
	} */
	
	/*获取父级栏目信息
	* 从近到远,依次返回所有父栏目组成的二维数组
	*/
	public function cms_getpcinfo($cid){
		return $this->cms_acd->getPidByCid($cid);
	}
	
	/*4、局部变量标签  <:a>  
	*    特殊标签<:@url>
	*/
	public function cms_l_tag($loop_html){
		preg_match_all("/<:(.*)>/misU", $loop_html, $m);
		return $m[1];//返回标签名
	}

	public function cms_getUrl($aid,$cid,$out_url='',$type='ac'){
		$w=($this->cms_systag['w']=='')?'':'w='.$this->cms_systag['w'].'&';
		if($type=='ac'){
			$tpl_info=$this->cms_acd->checkTpl($aid,$cid);
			if($aid){
				if($out_url==''){
					$tpl_name=isset($tpl_info['name'])?$tpl_info['name']:'';
					$url=$tpl_info?'./?'.$w.'t='.$tpl_name.'&c='.$cid.'&id='.$aid:'/';
				}else{
					if(stripos($out_url,'http')===false){
						$url='http://'.$out_url;
					}else{
						$url=$out_url;
					}
				}
			}else{
				if($tpl_info['type']=='1'){
					$tpl_name=isset($tpl_info['name'])?$tpl_info['name']:'';
					$url=$tpl_info?'./?'.$w.'t='.$tpl_name.'&c='.$cid:'/';
				}else{
					if(stripos($tpl_info['out_url'],'http')===false){
						$url='http://'.$tpl_info['out_url'];
					}else{
						$url=$tpl_info['out_url'];
					}
				}	
			}
		}elseif($type=='link'){
			if(stripos($out_url,'http')===false){
				$url='http://'.$out_url;
			}else{
				$url=$out_url;
			}
		}
		
	    return $url;
	}
    
	public function cms_loop_next($loop1,$loop2,$loop_attr,&$html){
		if(preg_match_all("/<f:loop\(([\s\S]*)\)>((?>(?!<f:)[\s\S]|(?R))*)<\/f:loop>/misU", $loop2, $m2)){
			foreach($m2[0] as $k2=>$v2){
				$loop_html_next=$m2[2][$k2];//下层循环体
				$loop_attr_next=explode(",",$m2[1][$k2]);//循环属性
				$temp=str_replace($loop_html_next,'$temp$',$loop2);
				$this->cms_loop_replace($loop_attr,$temp);
				$html=str_replace($loop1,$temp,$html);//$html=$html;return;
				//$this->cms_loop($temp);
				$html=str_replace('$temp$',$loop_html_next,$html);
				$this->cms_loop($html);
			}					
		}else{
			$this->cms_loop_replace($loop_attr,$loop2);
			$html=str_replace($loop1,$loop2,$html);
		}
	}
	
	public function cms_loop(&$html){
		 //此处正则涉及的概念：环视、固化分组、递归，若缺少固化分组，可以匹配，但匹配语句多时，崩溃。
		 //固化分组'? >':如果匹配进行到此结构之后（也就是，进行到闭括号之后），那么此结构体中的所有备用状态都会被放弃（不能被回溯）
		if(preg_match_all("/<f:loop\(([\s\S]*)\)>((?>(?!<f:)[\s\S]|(?R))*)<\/f:loop>/misU", $html, $m)){
			//$html=$m;return;
			foreach($m[0] as $k=>$v){
				$loop_html=$m[2][$k];//循环体
				if(!$m[1][$k])return;//缺少参数
				$loop_attr=explode(",",$m[1][$k]);//循环属性
				
				//list($loop_type,$cid,$num,$char_num)=$loop_attr;
				//获取本层需要正则替换的html代码：包括本层与下一层之间的内容+仅下一层loop标签
				//获取方法：先判断是否有下层，若没有直接替换$m[2][$k]中的局部变量标签，将替换后的值$newHtml替换掉$html中的$m[0][$k]；若存在，获取下一层标签的循环体，
				//将本层循环体中的下层循环体用$temp$替换掉得到新字符串$temp，替换$temp中的局部变量标签，再次将$temp$替换为下层循环体，
				//得到新值$newHtml，递归cms_loop($newHtml)				
				$this->cms_loop_next($m[0][$k],$m[2][$k],$loop_attr,$html);
			}
		}
	}
	
	public function cms_loop_replace($loop_attr,&$loop_html){		
		$loop_type=isset($loop_attr[0])?$loop_attr[0]:'';				
		$html='';//循环体内的完整内容

		switch(trim($loop_type,'\',\"')){
			case 'menu_loop':#顶级栏目循环(菜单栏)
			    //list($loop_type,$cid,$num)=$loop_attr;
			    
			    $menu_info=$this->cms_acd->getCidByPid(0,1,1);
				
				$i=0;
				if($menu_info){
					//$cid=isset($loop_attr[1])?$loop_attr[1]:'';
					$num=isset($loop_attr[2])?$loop_attr[2]:'';
					$num=empty($num)?'10':$num;//显示的个数，默认10个
					$loop_l_tag=$this->cms_l_tag($loop_html);//匹配循环体内所有局部变量标签
					foreach($menu_info as $menu){
						if($i>=$num)break;//控制数目
						
						if($menu['visible']=='1'){
							$i++;
							$loop_html2=$loop_html;
							foreach($loop_l_tag as $l_tag){
								$replace='';
								if($l_tag=='@url'){
									$replace=$this->cms_getUrl('',$menu['id']);
								}
								if(isset($menu[$l_tag])){
									$replace=$menu[$l_tag];            											
								} 									
								$loop_html2=str_replace('<:'.$l_tag.'>',$replace,$loop_html2);
							}
							
							$html.=$loop_html2;	
						}
					}
				}				
				$loop_html=$html;
			    break;
			case 'child_loop':#顶级栏目循环(菜单栏)
			    //list($loop_type,$cid,$num)=$loop_attr;
			    $cid=isset($loop_attr[1])?$loop_attr[1]:'';
				
			    if($cid!=''){
					$num=isset($loop_attr[2])?$loop_attr[2]:'';
				    $num=empty($num)?'10':$num;//显示的个数，默认10个
					$child_info=$this->cms_acd->getCidByPid($cid,1,1);
				    
					$i=0;
					if($child_info){
						$loop_l_tag=$this->cms_l_tag($loop_html);//匹配循环体内所有局部变量标签
						foreach($child_info as $child){
							if($i>=$num)break;//控制数目
							$i++;
							
							$loop_html2=$loop_html;
							foreach($loop_l_tag as $l_tag){
								$replace='';
								if($l_tag=='@url'){
									$replace=$this->cms_getUrl('',$child['id']);
								}
								if(isset($child[$l_tag])){
									$replace=$child[$l_tag];            											
								} 									
								$loop_html2=str_replace('<:'.$l_tag.'>',$replace,$loop_html2);
							}
							
							$html.=$loop_html2;	
							
						}
					}			
				}
			    	
				$loop_html=$html;
			    break;
			
			case "art_loop":#文章循环
			    //list($loop_type,$cid,$num,$order_type,$istop,$origin,$isfenye)=$loop_attr;
			    $cid=isset($loop_attr[1])?$loop_attr[1]:'';
			    if($cid){
					$order=array(
					    //修改时间，发布时间，文章id，浏览数
					    1=>array('CreateTime','desc'),
						2=>array('CreateTime','asc'),
						3=>array('timestamp','desc'),
						4=>array('timestamp','asc'),
						5=>array('id','desc'),
						6=>array('id','asc'),
						7=>array('see','desc'),
						8=>array('see','asc'),
					);
					$num=isset($loop_attr[2])?$loop_attr[2]:'';
				    $num=empty($num)?'10':$num;//显示的个数，默认10个
					$order_type=isset($loop_attr[3])?$loop_attr[3]:'';//循环方式，为空则按所属栏目属性中设置的方式排序
					$istop=isset($loop_attr[4])?$loop_attr[4]:'';//是否开启置顶(让置顶文章显示在最前面)，默认开启
					$origin=isset($loop_attr[5])?$loop_attr[5]-1:0;//从第几条记录开始
					$isfenye=isset($loop_attr[6])?$loop_attr[6]:'';//是否分页，默认否
					$cids=$this->cms_acd->getChilds($cid);
					$loop_l_tag=$this->cms_l_tag($loop_html);//匹配循环体内所有局部变量标签
					$order_str=' order by ';
					if($istop)$order_str.=' A.isTop desc,';
					if($order_type!=''&&isset($order[$order_type])){
						$order_str.=' A.'.$order[$order_type][0].' '.$order[$order_type][1];
					}else{
						$order_str.=' A.'.$this->cms_acd->aco($cid);
					}
					if($origin<0)$origin=0;
					$p=$isfenye?$this->cms_systag['p']:'';
					if($p==''||$p<1)$p=1;
					$limit_str=' limit '.(($p-1)*$num+$origin).','.$num;
					if($isfenye){
						$w=($this->cms_systag['w']=='')?'':'w='.$this->cms_systag['w'].'&';
						$rc=$this->query("select count(1) from `main_article` A left join `act_member` B on A.uid=B.id where A.cid in ({$cids}) and A.state=2")->fetchColumn(0);
						$page=getPageHtml_bt2($rc,$num,$p,"&".$w."t=".$this->cms_systag['qname']."&c=".$cid);//获取bootstrap 页码						
						$this->content=str_replace('<%page%>',$page,$this->content);
					}
					//$loop_html="select A.*,B.username,B.nick,B.truename from `main_article` A left join `act_member` B on A.uid=B.id where A.cid in ({$cids}) and A.state=2 {$order_str} {$limit_str}";return;	
					$arts=$this->query("select A.*,B.username,B.nick,B.truename from `main_article` A left join `act_member` B on A.uid=B.id where A.cid in ({$cids}) and A.state=2 {$order_str} {$limit_str}");
					if($arts=$arts->fetchAll(PDO::FETCH_ASSOC)){
						foreach($arts as $k=>$v){
							$loop_html2=$loop_html;
							foreach($loop_l_tag as $l_tag){
								$replace='';
								if($l_tag=='@url'){
									$replace=$this->cms_getUrl($v['id'],$v['cid'],$v['out_url']);
								}
								if(isset($v[$l_tag])){
									$replace=$v[$l_tag];            											
								}
								if($l_tag=='thumb'){
									//$replace='/upd/art_thumb/'.$v[$l_tag];
									$replace=$v[$l_tag];
								}
								$loop_html2=str_replace('<:'.$l_tag.'>',$replace,$loop_html2);
							}
							
							$html.=$loop_html2;	
						}
					}					
				}
			    				
				$loop_html=$html;
			    break;
			case "search_loop":
			/*全局搜索处理标签<f:>
			*全局搜索标签为<%search%>,此处用于显示搜索结果
			*list($loop_type,$keyword,$num,$order_type,$istop,$isfenye)=$loop_attr;
			*/
			$keyword=isset($this->cms_systag['keyword'])?$this->cms_systag['keyword']:'';
			
			if($keyword!=''){
				$order=array(
					//修改时间，发布时间，文章id，浏览数
					1=>array('CreateTime','desc'),
					2=>array('CreateTime','asc'),
					3=>array('timestamp','desc'),
					4=>array('timestamp','asc'),
					5=>array('id','desc'),
					6=>array('id','asc'),
					7=>array('see','desc'),
					8=>array('see','asc'),
				);
				$num=isset($loop_attr[2])?$loop_attr[2]:'';
			    $num=empty($num)?'10':$num;//显示的个数，默认10个
			    $order_type=isset($loop_attr[3])?$loop_attr[3]:'';//循环方式，为空则按修改时间降序
				$istop=isset($loop_attr[4])?$loop_attr[4]:'';//是否开启置顶(让置顶文章显示在最前面)，默认开启
				$isfenye=isset($loop_attr[5])?$loop_attr[5]:'';//是否分页，默认否
				$loop_l_tag=$this->cms_l_tag($loop_html);//匹配循环体内所有局部变量标签
				$order_str=' order by ';
				if($istop)$order_str.=' A.isTop desc,';
				if($order_type!=''&&isset($order[$order_type])){
					$order_str.=' A.'.$order[$order_type][0].' '.$order[$order_type][1];
				}else{
					$order_str.=' A.CreateTime desc';
				}
				$p=$this->cms_systag['p'];
				if($p==''||$p<1)$p=1;
				$limit_str=' limit '.(($p-1)*$num).','.$num;
				if($isfenye){
					$rc=$this->query("select count(1) from `main_article` A left join `act_member` B on A.uid=B.id where A.name like '%{$keyword}%' and A.state=2")->fetchColumn(0);
					$page=getPageHtml_bt2($rc,$num,$p,"&t=".$this->cms_systag['qname']."&keyword=".$keyword);//获取bootstrap 页码						
					$this->content=str_replace('<%page%>',$page,$this->content);
				}
				$arts=$this->query("select A.*,B.username,B.nick,B.truename from `main_article` A left join `act_member` B on A.uid=B.id where A.name like '%{$keyword}%' and A.state=2 {$order_str} {$limit_str}");
				if($arts=$arts->fetchAll(PDO::FETCH_ASSOC)){
					foreach($arts as $k=>$v){
						$loop_html2=$loop_html;
						foreach($loop_l_tag as $l_tag){
							$replace='';
							if($l_tag=='@url'){
								$replace=$this->cms_getUrl($v['id'],$v['cid'],$v['out_url']);
							}
							if(isset($v[$l_tag])){
								$replace=$v[$l_tag];            											
							}
							if($l_tag=='thumb'){
								//$replace='/upd/art_thumb/'.$v[$l_tag];
								$replace=$v[$l_tag];
							}
							$loop_html2=str_replace('<:'.$l_tag.'>',$replace,$loop_html2);
						}
						
						$html.=$loop_html2;	
					}
				}
			}
			$loop_html=$html;
			break;
			case 'link_loop':#友情链接循环
			    //list($loop_type,$num)=$loop_attr;
			    
			    $link_info=$this->query("select * from `links` order by odx");
				if($links=$link_info->fetchAll(PDO::FETCH_ASSOC)){
					$i=0;
					$num=isset($loop_attr[1])?$loop_attr[1]:'';
					$num=empty($num)?'10':$num;//显示的个数，默认10个
					$loop_l_tag=$this->cms_l_tag($loop_html);//匹配循环体内所有局部变量标签
					foreach($links as $k=>$link){
						if($i>=$num)break;//控制数目
						$i++;
						$loop_html2=$loop_html;
						foreach($loop_l_tag as $l_tag){
							$replace='';
							if($l_tag=='@url'){
								$replace=$this->cms_getUrl('','',$link['url'],'link');
							}
							if(isset($link[$l_tag])){
								$replace=$link[$l_tag];            											
							} 	
                            if($l_tag=='logo'){
								$replace='/upd/links_logo/'.$v[$l_tag];
							}							
							$loop_html2=str_replace('<:'.$l_tag.'>',$replace,$loop_html2);
						}
						$html.=$loop_html2;	
					}
				}
				$loop_html=$html;
			    break;
			
		}
	}
	
	/*5、循环<f:loop(type,cid,num,charnum)></loop>  */
	public function cms_loop_tag(){
		$this->cms_loop($this->content);
		//p($this->content);exit;
	}
	
	
	
	/*日期格式化<f:date()>   如<f:date('y-m-d',time)> time为空为当前时间
	*【已加入wait处理】
	*/	
	public function cms_date_tag($isexec=0){
		if(preg_match_all("/f:date\((.*)\)/misU", $this->content, $m)){
			//p($m);exit;
			foreach($m[0] as $k=>$v){			
				if(!$m[1][$k])return;//缺少参数		
				$attr=explode(",",$m[1][$k]);			
				//list($cid,$query)=$attr;
				$format=isset($attr[0])?trim($attr[0],'\',\"'):'';
				$timestamp=isset($attr[1])?$attr[1]:'';
				$timestamp=($timestamp=='')?time():$timestamp;
				if($format!=''&&$isexec){
					if($replace=date("{$format}",$timestamp)){
						$this->content=str_replace('<'.$m[0][$k].'>', $replace,$this->content);
					}				
				}else{
					$wait='wait%date%'.$format.'%'.$timestamp;//替换在循环内部并依赖局部变量的函数标签
					$this->content=str_replace('<'.$m[0][$k].'>', '<$'.$wait.'$>',$this->content);
					//$this->wait[$wait]=$m[0][$k];
				}			
			}
		}		
	}
	
	/*截取字符串<f:cut()>   如<f:cut($str,0,10,'...')> 参数1为目标字符串，2为起始位置(默认0)，3为截取的长度(默认10)，4为后缀（默认空）
	*【暂不加入wait处理，直接最后执行】
	*/
	public function cms_cut_tag($isexec=0){
		if(preg_match_all("/f:cut\((.*)\)/misU", $this->content, $m)){
			foreach($m[0] as $k=>$v){
				if(!$m[1][$k])return;//缺少参数	
				$attr=explode(",",$m[1][$k]);	
				$str=isset($attr[0])?$attr[0]:'';
				$start=isset($attr[1])?$attr[1]:'';
				$start=($start=='')?0:$start;
				$length=isset($attr[2])?$attr[2]:'';
				$length=($length=='')?10:$length;
				$postfix=isset($attr[3])?trim($attr[3],'\',\"'):'';
				if($isexec){
					$str=mb_get_str2($str,$start,$length,$postfix);
				    $this->content=str_replace('<'.$m[0][$k].'>', $str,$this->content);
				}else{
					$wait='wait%cut%'.$str.'%'.$start.'%'.$length.'%'.$postfix;//替换在循环内部并依赖局部变量的函数标签
					$this->content=str_replace('<'.$m[0][$k].'>', '<$'.$wait.'$>',$this->content);
				}				
			}
		}
	}
	
	
	
	/*文章内容
	*数据源：<d:artinfo($aid,自定义名)> 如<f:getainfo(1,ainfo)>  $aid默认为当前文章id,自定义名默认为ainfo
	*获取数据<:自定义名['name']>,如<:ainfo['name']><:ainfo['pre']>
	*[特殊情况]：获取某个栏目下按本身排序的第一篇，使用场景如点击栏目后在栏目页显示公司介绍等
	*          需增加参数$cid，同时$aid必须为空且为栏目页，如<f:getainfo(,ainfo,$cid)>
	*【暂时未发现有依赖局部变量的需求，暂不加入wait处理】
	*/
	public function cms_art_tag(){
		if(preg_match_all("/d:artInfo\((.*)\)/misU", $this->content, $m)){
			//p($m);exit;
			$art=array();//记录自定义名与文章id的对应关系，若有多个数据源，只记录自定义名不一样的
			foreach($m[0] as $k=>$v){
                if($m[1][$k]!=''){
					$tag_attr=explode(",",$m[1][$k]);//标签属性
					$aid=isset($tag_attr[0])?$tag_attr[0]:'';
					$aid=trim($aid,'\',\"');
					$cid=isset($tag_attr[2])?$tag_attr[2]:'';
					if($aid||$this->cms_systag['aid']){
						$temp=$aid?$aid.'_normal':$this->cms_systag['aid'].'_normal';
					}elseif($cid){
						$temp=$cid.'_first';
					}else{
						break;
					}
					$tagname=isset($tag_attr[1])?$tag_attr[1]:'';
					$tagname=$tagname?$tagname:'ainfo';
					$tagname=trim($tagname,'\',\"');
					$art[$tagname]=$temp;
					$this->content=str_replace('<'.$m[0][$k].'>', '',$this->content);
				}											
			}
			//p($art);exit;
			if($art){
				foreach($art as $k=>$v){
					$varr=explode('_',$v);
					if($varr[1]=='normal'){
						$artinfo=$this->query("select A.*,B.username,B.nick,B.truename from `main_article` A left join `act_member` B on A.uid=B.id where A.id={$varr[0]}");
					}
					if($varr[1]=='first'){
						$aco=$this->cms_acd->aco($varr[0]);//栏目的排序信息,还需加上置顶
						$artinfo=$this->query("select A.*,B.username,B.nick,B.truename from `main_article` A left join `act_member` B on A.uid=B.id where A.cid={$varr[0]} order by A.istop desc,A.{$aco} limit 1");
					}
					
					if($artinfo=$artinfo->fetch(PDO::FETCH_ASSOC)){
						if(preg_match_all("/<:{$k}\[(.*)\]>/misU", $this->content, $m2)){
							//p($m2);exit;
							foreach($m2[1] as $k2=>$v2){
								$v2=trim($v2,'\',\"');
								$replace='';
								if(isset($artinfo[$v2])){
									$replace=$artinfo[$v2];
									if($v2=='thumb'){
										//$replace='/upd/art_thumb/'.$artinfo[$v2];
										$replace=$artinfo[$v2];
									}
								}	
               					$this->content=str_replace($m2[0][$k2], $replace,$this->content);
							}
						}
					}
				}
			}		
		}		
	}
	
	
	/*当前文章上一篇、下一篇  <f:getPrevInfo('name')><f:getNextInfo('name')>  【只限文章页】
	*此处先以按id排序方式实现[按栏目自身排序方式加上考虑置顶时，暂时无法实现]
	*【暂时未发现有依赖局部变量的需求，暂不加入wait处理】
	*/
	public function cms_prev_next_tag(){
		if($this->cms_systag['aid']&&$this->cms_systag['cid']&&preg_match_all("/f:get(Prev|Next)Info\((.*)\)/misU", $this->content, $m)){
			//p($m);exit;
			$aid=$this->cms_systag['aid'];
			$cid=$this->cms_systag['cid'];
			$prev_query=array();//记录要获取的信息
			$next_query=array();//记录要获取的信息
			foreach($m[0] as $k=>$v){
				if($m[2][$k]!=''){
					$q=trim($m[2][$k],'\',\"');
					if($m[1][$k]=='Prev')$prev_query[$m[0][$k]]=$q;
					if($m[1][$k]=='Next')$next_query[$m[0][$k]]=$q;
				}				
			}
			//p($prev_query);exit;
			if($prev_query)$prev_query=$this->cms_prev_next($prev_query,$aid,$cid,'prev');
			if($next_query)$next_query=$this->cms_prev_next($next_query,$aid,$cid,'next');
			$query=array_merge($prev_query,$next_query);
			foreach($query as $tag=>$val){
				$this->content=str_replace('<'.$tag.'>', $val,$this->content);
			}
		}
	}
	public function cms_prev_next($query,$aid,$cid,$type){
		$wh=($type=='prev')?' and  A.id<'.$aid:' and  A.id>'.$aid;
		$sql="select A.*,B.username,B.nick,B.truename from `main_article` A left join `act_member` B on A.uid=B.id where A.cid={$cid} {$wh} order by A.id asc limit 1";
		$ainfo=$this->query($sql);
		if($a=$ainfo->fetch(PDO::FETCH_ASSOC)){
			foreach($query as $tag=>$q){
				$replace='';
				if($q=='@url'){
					$replace=$this->cms_getUrl($a['id'],$a['cid'],$a['out_url']);
				}
				if(isset($a[$q])){
					$replace=$a[$q];
				}
				if($q=='thumb'){
					//$replace='/upd/art_thumb/'.$a[$q];
					$replace=$a[$q];
				}
				$query[$tag]=$replace;
			}
		}else{
			foreach($query as $tag=>$q){
				$replace='';
				if($q=='@url'){
					$replace='javascript:void(0)';
				}
				if($q=='name'){
					$replace='没有了';
				}
				$query[$tag]=$replace;
			}
		}
		return $query;
	}
	
	
} 