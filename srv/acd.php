<?php
/* cms文章栏目相关处理
 * 
 */
class ACD{
	//private $pd;//数据库连接
	private $acoInfo;//栏目信息关联数组
	private $tplInfo;//模板信息关联数组
	public $w;//站点、专题
	
	function __construct($w){
		//$this->pd=$pd;
		$this->w=$w;
		$this->getAcoTpl();
	}
	
	//获取栏目的全部信息(旧,已废弃)
    public function getAco($cid){
    	$stmt=$this->pd->prepare("select * from `main_art_category` order by pid asc,odx asc where id=?");
		if($stmt->execute(array(intval($cid)))){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}
		return false; 
    }
	
	//获取信息
	public function getAcoTpl(){
		if(!isset($pd))$pd=new pdo_mysql;
		$wh=" where A.topic_id=0 ";
		if($this->w!='')$wh=" where B.dname='{$this->w}' ";
		$res=$pd->query("select A.*,B.dname from `main_art_category` A left join `topic` B on A.topic_id=B.id {$wh} order by A.pid asc,A.odx asc")->fetchAll(PDO::FETCH_ASSOC);
		//p("select A.*,B.dname from `main_art_category` A left join `topic` B on A.topic_id=B.id {$wh} order by A.pid asc,A.odx asc");exit;
		$r=array();
		foreach($res as $k=>$v){
            $r[$v['id']]=$v;      			
		}
		$this->acoInfo=$r;
		
	    if(!$this->tplInfo){
			$res2=$pd->query("select id,filename,fileext,type from `template`")->fetchAll(PDO::FETCH_ASSOC);
			$r2=array();
			foreach($res2 as $k=>$v){
				$r2["type_{$v['type']}"][$v['id']]=$v;   //type=1为首页与栏目页，type=2为内容页   			
			}
			$this->tplInfo=$r2;
		}
	}
	
	//根据$aid,$cid判断加载的模板
	public function checkTpl($aid,$cid){
		$file=array();
		if($cid){
			$file['name']='';
			$file['ext']='';
			$cinfo=$this->getInfoByCid($cid);
			if(!$aid){
				//加载栏目页模板
				if(isset($this->tplInfo['type_1'])){
					$tpl_c=$this->tplInfo['type_1'];
						if(isset($tpl_c[$cinfo['tcid']])){
							$file['name']=$tpl_c[$cinfo['tcid']]['filename'];
							$file['ext']=$tpl_c[$cinfo['tcid']]['fileext'];
						}
					
				}
			}else{
				//加载内容页模板
				if(isset($this->tplInfo['type_2'])){
					$tpl_a=$this->tplInfo['type_2'];
					if(isset($tpl_a[$cinfo['taid']])){
						$file['name']=$tpl_a[$cinfo['taid']]['filename'];
						$file['ext']=$tpl_a[$cinfo['taid']]['fileext'];
					}
				}
			}
            $file['type']=$cinfo['type'];
			$file['out_url']=$cinfo['out_url'];
		}		
		return $file;
	}
	
	//根据指定栏目id获取该栏目信息
	public function getInfoByCid($id){
		if(isset($this->acoInfo[$id])){
			return $this->acoInfo[$id];//当前栏目信息
		}
	}
	
	
	/*获取指定栏目的排序信息，返回字串
	 * cid为栏目id
	 * type不指定或为空时，返回形式如'timestamp desc'
	 * type=1时，返回形式如'timestamp'，即排序字段
	 * type=2时，返回形式如'desc'，即降序升序
	 * */
	public function aco($cid,$type=''){
		$cinfo=$this->acoInfo[$cid];
		if($type=='')return $cinfo['odb']." ".$cinfo['scend'];
	    if($type==1)return $cinfo['odb'];
		if($type==2)return $cinfo['scend'];
	}
	//获取特定栏目类型的id
	public function getCidByCtype($cate_type){
		//只返回第一个匹配到的栏目，关联数组形式
		foreach($this->acoInfo as $k=>$v){
            if($v['type']==$cate_type){
            	return $v;
            }      			
		}
	}
	//获取特定栏目类型下的所有id，返回id，name组成的二维数组
	public function getCidByCtype2($cate_type){
		$arr=array();
		foreach($this->acoInfo as $k=>$v){
            if($v['type']==$cate_type){
            	$arr[]=$v;
            }      			
		}
		return $arr;
	}
	/*获取指定栏目id下子栏目（默认所有级）信息,返回其组成的数组,可指定返回前xx级的子栏目
	 * id必须，type和flag可选，level固定为0，无需指定
	 * type不指定或为空时，仅仅返回由子栏目id组成的数组
	 * type=1时，返回子栏目相关信息的二维数组，并新增层级属性level
	 * flag表示返回前xx级的所有子栏目，默认-1，返回所有级,flag=1时表示返回第一级子栏目
	 */
	public function getCidByPid($id,$type='',$flag='-1',$level=0){
		static $arr = array(); //使用static
		if($level==0)$arr=array();//第一次调用此函数时，先重置静态变量$arr,否则会有累加效果
		if($level==$flag)return $arr;
	    $level++;
	    foreach($this->acoInfo as $key => $value)
	    {
	        if($value['pid' ] == $id)
	        {
	            $value[ 'level'] = $level;
				if($type==''){
					$arr[] = $value['id'];
				}elseif($type=='1'){
					$arr[] = $value;
				}else{
					return false;
				}
	            $this->getCidByPid($value['id'],$type,$flag,$level);
	        }
	    }
	    return $arr;
	}
	
	/*根据指定栏目id获取其父栏目id信息,从近到远,依次返回所有父栏目组成的二维数组
	 * level用于记录次数，无需指定
	 * */
	public function getPidByCid($id,$level=0){
		static $arr = array(); //使用static
		if($level==0)$arr=array();//第一次调用此函数时，先重置静态变量$arr,否则会有累加效果
		if(isset($this->acoInfo[$id])){
			$id_info= $this->acoInfo[$id];//当前栏目信息
	        if(isset($this->acoInfo[$id_info['pid']]))
	        {
	        	$pid_info=$this->acoInfo[$id_info['pid']];//上一级父栏目
	            $arr[]=$pid_info;
				$level++;
	            $this->getPidByCid($pid_info['id'],$level);
	        }		  
			if(count($arr)==0){$arr[]=$id_info;}  //返回本身	 	    			    
		}
	    return $arr;
	}
	/*************************以下为简化index.php页面代码方法***************************/
	/*
	*根据指定栏目id获取子栏目id（包含自身），返回数组或字串
	*type不指定或为空时，返回字串形式
	*type=1时返回数组形式
	*/
	public function getChilds($id,$type=''){
		$childs=$this->getCidByPid($id);
		array_push($childs,$id);
		if($type=='')return implode(",", $childs);
		if($type=='1')return $childs;
        return false;		
	}
	/*返回指定栏目顶级父栏目信息*/
	public function getTpinfo($id){
		//获取所有级pid
		$pids_arr=$this->getPidByCid($id);
		//顶级pid
		if(count($pids_arr)>0){
			$tpid=$pids_arr[count($pids_arr)-1];
		    return $tpid;
		}
		return false;		
	}
	/*返回指定栏目最近一级父栏目信息*/
	public function getPinfo($id){
		//获取所有级pid
		$pids_arr=$this->getPidByCid($id);
		//顶级pid
		if(count($pids_arr)>0){
			$pid=$pids_arr[0];
		    return $pid;
		}
		return false;		
	}
	/*用于打开页面时直接显示第一个栏目下的文章，返回第一个栏目id()，只对当前栏目是顶级栏目时有效
	 *参数cid为当前栏目，tpid为当前栏目的顶级父栏目
	*/
	public function getShowId($cid,$tpid){
		$childs_arr_one=$this->getCidByPid($tpid,'',1);
		$show_cid=($cid==$tpid&&count($childs_arr_one)!=0)?$childs_arr_one[0]:$cid;
		return $show_cid;
	}
}
	
	
	
	


?>