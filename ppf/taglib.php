<?php
/* cms系统标签库
 * 
 */
class TAGLIB{
    public $globalTag=array(
	    /*系统级全局变量【系统动态设置】*/
	    'web_name'     =>array('网站名',''),
	    'web_url'      =>array('网站地址',''),
		'web_keyword'  =>array('网站关键字',''),
		'web_des'      =>array('网站描述',''),
		'web_email'    =>array('网站邮箱',''),
		'web_tel'      =>array('网站联系电话',''),
		'web_icp'      =>array('网站备案信息',''),
		'dir_root'     =>array('网站文档根目录',''),
		'cid'          =>array('当前栏目id',''),
		'aid'          =>array('当前文章id',''),
		'qname'        =>array('当前页面模板名',''),
		'@url'         =>array('当前请求地址',''),
		'@url(xx)'     =>array('专题/站点地址','，xx为专题/站点目录名(专题管理中设置)'),
		'p'            =>array('当前分页页码',''),
		'page'         =>array('分页标签',''),
		'keyword'      =>array('当前搜索的关键字',''),
		'search'       =>array('全局搜索模板','，可在全局标签管理中查看，页面上可直接写该标签，或者复制模板代码粘贴到页面，具体样式用户自定义'),
	    'counter'      =>array('网站访问计数器','可在全局标签管理中查看，页面上可直接写该标签，或者复制模板代码粘贴到页面，样式可修改css'),
		'adv(xx)'      =>array('飘窗','xx为飘窗英文名，飘窗管理中可增加、修改飘窗，支持固定位置，支持各项参数设置，样式可修改css'),
	);
	public $cateTag=array(
	    /*栏目信息中可用的局部变量*/
		'@url'         =>array('特殊标签，链接','，栏目完整链接，支持跳转链接的判断，无需再拼接地址'),
		'id'           =>array('栏目id',''),
		'name'         =>array('栏目名',''),
		'alias'        =>array('栏目别名',''),
		'pid'          =>array('父栏目id',''),
		'visible'      =>array('是否可见','，一级栏目有效'),
		'timestamp'    =>array('栏目创建时间戳',''),
		'odb'          =>array('栏目下文章排序字段','，创建时间、修改时间、id号、阅读数'),
		'scend'        =>array('栏目下文章排序方式','，升序、降序，配合odb使用'),
		'type'         =>array('栏目类型','，内部栏目、外部栏目'),
		'out_url'      =>array('外部栏目跳转链接',''),
		'intro'        =>array('栏目简介',''),
	);
	public $artTag=array(
	    /*文章信息中可用的局部变量*/
		'@url'         =>array('特殊标签，链接','，文章完整链接，支持跳转链接的判断，无需再拼接地址'),
	    'id'           =>array('文章id号',''),
		'cid'          =>array('所属栏目id号',''),
		'uid'          =>array('发表文章的用户id',''),
		'name'         =>array('标题',''),
		'pre'          =>array('文章简介、描述',''),
		'des'          =>array('文章内容',''),
		'thumb'        =>array('缩略图名称','，完整的地址，无需再拼接地址'),
		'see'          =>array('阅读数',''),
		'timestamp'    =>array('创建时间',''),
	    'froms'        =>array('来源',''),
		'CreateTime'   =>array('修改时间',''),
		'isTop'        =>array('是否置顶',''),
		'out_url'      =>array('文章跳转链接','，不为空时，点击标题会跳转到指定连接'),
	);
	public $loopTag=array(
	    /*循环标签 f:loop() */
		'menu_loop'         =>array(
		    '菜单循环',
			'一级栏目循环，设置为不可见的一级栏目不会显示；支持内部多级多种类型的循环、各种标签的混用；最好控制在3层循环内，否则影响页面打开速度',
			'<f:loop(menu_loop,空,显示数目)>循环的内容</loop>
若显示数目不设置，可直接写为<f:loop(menu_loop)>循环的内容</loop>',
			'支持多级循环：
			<f:loop(menu_loop)>
				<li>
					<a href="<:@url>" target="" class="menua"><:name></a>
					<dl class="menu_second">
						<f:loop(child_loop,<:id>,,)>
						<dd><a href="<:@url>" target=""><:name></a></dd>
						</f:loop>
					</dl>
				</li>
			</f:loop>',
		),
	    'child_loop'       =>array(
		    '指定栏目的子栏目循环',
			'获取指定栏目的第一级子栏目，若指定栏目id为0，则与菜单循环相似，区别是不区分是否可见；支持内部多级多种类型的循环、各种标签的混用；最好控制在3层循环内，否则影响页面打开速度',
			'<f:loop(child_loop,栏目id,显示数目)>循环的内容</loop>',
			'支持多级循环：
			<f:loop(child_loop,<f:getcinfo(<%cid%>,id,1)>,,)>
			    <li><a href="<:@url>" target=""><:name></a></li>
			</f:loop>',
		),
		'art_loop'          =>array(
		    '指定栏目下的文章循环',
			'包含其子栏目下的文章；支持分页、指定从第几条记录开始、置顶、自定义排序方式(默认按该栏目设定的的文章排序方式)；内部支持除循环标签外其他标签',
			'<f:loop(art_loop,栏目id,(每页)显示数目,循环方式,是否置顶,起始位置,是否分页)>循环的内容</loop>',
			'不支持多级循环：
			<f:loop(art_loop,<%cid%>,2,,,,1)>
				<li>
					<i><img src="/html/images/nts_icon.jpg" /></i>
					<a href="<:@url>" target=""><:name></a>
					<span><f:date(Y-m-d,<:timestamp>)></span>
				</li>
			</f:loop>
			<%page%>',
		),
		'search_loop'       =>array(
		    '搜索结果循环',
			'与文章循环相似，支持分页、置顶、自定义排序方式(默认按该栏目设定的的文章排序方式)；内部支持除循环标签外其他标签',
			'<f:loop(search_loop,搜索的内容,(每页)显示数目,循环方式,是否置顶,是否分页)>循环的内容</loop>',
			'不支持多级循环：
			 <ul class="newsn_list">
				<f:loop(search_loop,<%keyword%>,2,,1,1)>
				<li>
					<a href="<:@url>" target=""><:name></a>
					<span><f:date(Y-m-d,<:timestamp>)></span>
				</li>
				</f:loop>
		     </ul>
			 <%page%>',
		),	
        'link_loop'         =>array(
		    '友情链接循环',
			'只有友情链接管理中有添加友情链接才能使用，按管理中设置的顺序排序；内部支持除循环标签外其他标签；此功能也可用栏目实现：新增友情链接栏目设置为不可见，添加链接即添加文章，链接地址填在文章的跳转地址上即可',
			'<f:loop(link_loop,显示数目)>循环的内容</loop>',
			'不支持多级循环：
		  1. <f:loop(link_loop,8)>
			     <a href="<:@url>"><:name></a>
			 </f:loop>
		  2. 如下select中value值设为链接地址可实现点击下拉列表后跳转
		     <select>
		     <f:loop(link_loop,8)>
			     <option value="<:@url>"><:name></option>
			 </f:loop>
			 </select>',
		),		
	);
	public $dataTag=array(
	    /*数据源标签 d: */
		'artinfo'      =>array(
		    '文章数据源',
			"某个文章的所有信息，在文章页任意处添加次标签即可，特殊情况：获取某个栏目下按本身排序的第一篇，使用场景如点击栏目后在栏目页显示公司介绍等，此时要求<span style='color:red'>文章id为空，栏目id不为空</span>",
			"<d:artinfo(文章id,自定义数据源名,栏目id(特殊情况下使用))>
数据源名用于调用该文章属性，默认名ainfo，如<:ainfo[des]>(或<:ainfo['des']>，推荐不加引号)；",
			'<d:artinfo(13)>，文章信息调用方式为<:ainfo[des]>
<d:artinfo(13,abc)>，文章信息调用方式为<:abc[des]>
特殊情况，栏目id为30下的第一篇文章(按该栏目的排序方式)<d:artinfo(,abc,30)>，文章信息调用方式为<:abc[des]>',
		),	
	);
	public $otherTag=array(
	    /*其他函数标签 f: */
		'date'         =>array(
		    '日期格式化',
			'适用于格式化时间戳',
			'<f:date(格式,时间戳)>，时间格式如y-m-d H:i:s,y/m/d等自定义',
			"格式化时间戳1490067073：<f:date(y-m-d,1490067073)>",
		),	
		'cut'          =>array(
		    '截取字符串',
			'支持中文截取、添加后缀、自定义起始位置',
			'<f:cut(目标字串,起始位置,长度,后缀)>',
			"截取字符串'abcd'前3位字符，并加上后缀...，结果如abc...：
    <f:cut(abcd,0,3,...)>",
		),
		'getcinfo'     =>array(
		    '获取指定栏目信息',
			'可获取最近的父级栏目和顶级栏目',
			'<f:getcinfo(栏目id,要查询的信息,是否查询父级栏目,是否查询顶级父栏目(要求type为1))>',
			"获取栏目id为30时的栏目名称：<f:getcinfo(30,name)>；
获取栏目id为30时的上一级栏目的名称：<f:getcinfo(30,name,1)>；
获取栏目id为30时的顶级父栏目的名称：<f:getcinfo(30,name,1,1)>",
		),
		'getPrevInfo'  =>array(
		    '当前文章上一篇',
			"仅当前文章，不支持指定文章；文章的属性都可使用；上一篇不存在时，文章属性的name值为'没有了',链接@url为空",
			'<f:getPrevInfo(要查询的上一篇文章的信息)>',
			"<f:getPrevInfo(name)>,
<f:getPrevInfo(@url)>,
<f:getPrevInfo(id)>",
		),
		'getNextInfo'  =>array(
		    '当前文章下一篇',
			"仅当前文章，不支持指定文章；文章的属性都可使用；上一篇不存在时，文章属性的name值为'没有了',链接@url为空",
			'<f:getNextInfo(要查询的下一篇文章的信息)>',
			"<f:getNextInfo(name)>,
<f:getNextInfo(@url)>,
<f:getNextInfo(id)>",
		),		
	);
}

?>