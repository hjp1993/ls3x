/*Date 2017-05-08 05:15:22*/
set foreign_key_checks=0;

drop table if exists `act_member`;
CREATE TABLE `act_member` (
  `id` varchar(18) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `cardno` varchar(18) DEFAULT NULL,
  `pmd5` varchar(32) DEFAULT NULL,
  `idtype` smallint(6) DEFAULT NULL,
  `nick` varchar(20) DEFAULT NULL,
  `face` tinyint(4) DEFAULT NULL,
  `truename` varchar(10) DEFAULT NULL,
  `ename` varchar(50) DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `lgnums` int(11) DEFAULT NULL,
  `lasttime` int(11) DEFAULT NULL,
  `lastip` varchar(15) DEFAULT NULL,
  `tmp` varchar(32) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `subject` smallint(6) DEFAULT NULL,
  `addr` int(11) DEFAULT NULL,
  `grade` smallint(6) DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `pre` varchar(150) DEFAULT NULL,
  `lvl` int(11) unsigned DEFAULT NULL,
  `credit` smallint(6) DEFAULT NULL,
  `integral` int(11) DEFAULT NULL,
  `gold` int(11) DEFAULT NULL,
  `cash` decimal(11,2) DEFAULT NULL,
  `period` tinyint(4) DEFAULT NULL,
  `school` int(11) DEFAULT NULL,
  `intoyear` smallint(6) DEFAULT NULL,
  `msg` smallint(6) DEFAULT NULL,
  `notice` smallint(6) DEFAULT NULL,
  `heart` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `hobbies` varchar(500) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `cli_token` varchar(32) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `recommend` int(11) DEFAULT '0',
  `user_group` int(11) DEFAULT '2',
  `template` varchar(32) DEFAULT 'default' COMMENT '主题模板',
  `shortcuts` text COMMENT '快捷菜单',
  `bid` int(11) DEFAULT NULL COMMENT '统一登录',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `act_member` write;
insert into `act_member` values('a1401330136','lren','cplus@lren.org','1234','12','37f0ba275f1b80fe10498031008ff7cf','2','良苏','1','张良人','','0','0000-00-00','33','1468396611','192.168.10.205','4aadb6d30f39dc4cba566f902242615a','0','101','108','11','0','','0','6','1','0','0.00','2','70','0','0','0','1468396646','1482926007','','2','a1401330136','2','0','1','default','','0');
insert into `act_member` values('a1401955133','test','6532890@qq.com','test1','1','098f6bcd4621d373cade4e832627b4f6','1','飞翔的企鹅','1','张一凡','liang ren','1','2014-12-11','768','1489020154','::1','52bf8b50c6b26f378e79de1c546ea4e5','0','101','9','11','0','我心安处是故乡。','0','57','209','0','0.00','2','2','0','0','0','1469969183','1481849472','','18','a08594ed7470dfb8e4d62b7cfd731dc5','2','0','2','default','','0');
insert into `act_member` values('a1411090712','tech','tech@123.com','130651','12345','d9f9133fb120cd6096870bc2b496805b','3','向日葵','1','张三丰','techer sa','1','2014-10-08','1343','1494210441','::1','15f80c00ea6056ac159b8213aaae681d','0','100','9','11','0','孩子是明天的未来','0','35','37','0','0.00','2','70','2015','0','0','1474327715','1482892374','游戏，唱歌, 玩游戏，看书，上网，交友，游泳，潜水','12','6ad243d5b4774e35e47f131463158f87','2','0','1','default','','4216');
insert into `act_member` values('a1489020206','ceshi','','','','e10adc3949ba59abbe56e057f20f883e','0','ceshi','0','ceshi','','1','0000-00-00','4','1490606158','::1','93b6045f93caeef758b74919d63cb53b','0','0','0','0','0','','0','0','0','0','0.00','0','0','0','0','0','0','1489020206','','0','','2','0','2','default','','0');
unlock tables;

drop table if exists `consult_art`;
CREATE TABLE `consult_art` (
  `id` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `sex` int(2) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `unit` varchar(100) DEFAULT NULL COMMENT '单位',
  `ip` varchar(50) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` text,
  `see` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `show` int(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `consult_art` write;
insert into `consult_art` values('1481680316','1477512752','','你好','0','13555234565','12312312','312312312','::1','12312','3123123','0','1481680316','1481683841','2');
unlock tables;

drop table if exists `consult_art_category`;
CREATE TABLE `consult_art_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `pid` int(11) DEFAULT '0' COMMENT '父id',
  `visible` tinyint(4) DEFAULT NULL,
  `odx` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `childnums` int(11) DEFAULT NULL,
  `nums` int(11) DEFAULT NULL,
  `lastid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `consult_art_category` write;
insert into `consult_art_category` values('1477502573','资格认证','0','0','0','1477502573','0','0','0');
insert into `consult_art_category` values('1477512752','校长信箱','0','0','1','1481858897','0','0','0');
unlock tables;

drop table if exists `consult_art_comment`;
CREATE TABLE `consult_art_comment` (
  `id` int(11) NOT NULL DEFAULT '0',
  `aid` int(11) DEFAULT NULL,
  `des` text,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `consult_art_comment` write;
insert into `consult_art_comment` values('1477499772','1477498333','啊实打实的','1477499772');
insert into `consult_art_comment` values('1477499930','1477498333','按时打算','1477499930');
insert into `consult_art_comment` values('1477499955','1477498333','撒大声地','1477499955');
insert into `consult_art_comment` values('1477499962','1477498333','反反复复','1477499962');
insert into `consult_art_comment` values('1477500122','1477492777','手上的当然','1477500122');
insert into `consult_art_comment` values('1477500148','1477498333','按时打算','1477500148');
insert into `consult_art_comment` values('1477500325','1477498333','按时打算','1477500325');
insert into `consult_art_comment` values('1477500418','1477492777','啊啊啊','1477500418');
insert into `consult_art_comment` values('1477500824','1477498333','阿萨德','1477500824');
insert into `consult_art_comment` values('1477500981','1477484988','啊实打实的','1477500981');
insert into `consult_art_comment` values('1477502972','1477502916','您好，请电话咨询85822152.','1477502972');
insert into `consult_art_comment` values('1477505174','1477505165','实打实大师','1477505174');
insert into `consult_art_comment` values('1477505178','1477505151','啊实打实大','1477505178');
insert into `consult_art_comment` values('1477505182','1477505140','公司的广东省分公司','1477505182');
insert into `consult_art_comment` values('1477509616','1477509603','啊实打实的
发发发
刚刚','1477509616');
insert into `consult_art_comment` values('1477512782','1477512773','asdasd ','1477512782');
insert into `consult_art_comment` values('1479046439','1479046342','什么跟什么啊','1479046439');
insert into `consult_art_comment` values('1481682642','1481680362','ds','1481682642');
insert into `consult_art_comment` values('1481683841','1481680316','aaaaaaaaa','1481683841');
unlock tables;

drop table if exists `global_tag`;
CREATE TABLE `global_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `content` longtext,
  `desc` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

lock tables `global_tag` write;
insert into `global_tag` values('1','网站名','web_name','系统动态设置','网站名','1','1491658006');
insert into `global_tag` values('2','网站地址','web_url','系统动态设置','网站地址','1','1491658008');
insert into `global_tag` values('3','网站关键字','web_keyword','系统动态设置','网站关键字','1','1491658009');
insert into `global_tag` values('4','网站描述','web_des','系统动态设置','网站描述','1','1491658010');
insert into `global_tag` values('5','网站邮箱','web_email','系统动态设置','网站邮箱','1','1491658011');
insert into `global_tag` values('6','文档根目录','dir_root','系统动态设置','文档根目录','1','1491658012');
insert into `global_tag` values('7','当前栏目id','cid','系统动态设置','当前栏目id','1','1491658013');
insert into `global_tag` values('8','当前文章id','aid','系统动态设置','当前文章id','1','1491658014');
insert into `global_tag` values('9','当前页面模板名','qname','系统动态设置','当前页面模板名','1','1491658015');
insert into `global_tag` values('10','当前分页页码','p','系统动态设置','当前分页页码','1','1491658016');
insert into `global_tag` values('11','当前请求地址','@url','系统动态设置','当前请求地址','1','1491658017');
insert into `global_tag` values('12','搜索关键字','keyword','系统动态设置','搜索关键字','1','1491658018');
insert into `global_tag` values('13','分页','page','系统动态设置','分页','1','1491658019');
insert into `global_tag` values('14','全局搜索','search','%3Cdiv%20id%3D%22cms_globalSearch%22%20class%3D%22%22%3E%0A%20%20%20%3Cinput%20id%3D%22cms_keyword%22%20type%3D%22text%22%20value%3D%22%u8BF7%u8F93%u5165%u5173%u952E%u5B57%22%20maxlength%3D%22100%22%20size%3D%2250%22/%3E%0A%20%20%20%3Cinput%20id%3D%22cms_submit%22%20type%3D%22button%22%20value%3D%22%u641C%u7D22%22/%3E%0A%3C/div%3E%0A%3Cscript%20language%3D%22javascript%22%20type%3D%22text/javascript%22%3E%0A%3C%21--%u786E%u8BA4%u5DF2%u5F15%u7528jquery%u6587%u4EF6--%3E%0A%24%28function%28%29%20%7B%0A%20%20%20%20var%20cms_keyword%20%3D%20%24%28%22%23cms_globalSearch%20%23cms_keyword%22%29%3B%0A%20%20%20%20var%20cms_submit%20%3D%20%24%28%22%23cms_globalSearch%20%23cms_submit%22%29%3B%0A%20%20%20%20cms_keyword.focus%28function%28%29%20%7B%0A%20%20%20%20%20%20%20%20if%20%28this.value%20%3D%3D%20%27%u8BF7%u8F93%u5165%u5173%u952E%u5B57%27%29this.value%20%3D%20%27%27%3B%0A%20%20%20%20%7D%29.blur%28function%28%29%20%7B%0A%20%20%20%20%20%20%20%20if%20%28this.value%20%3D%3D%20%27%27%29%20this.value%20%3D%20%27%u8BF7%u8F93%u5165%u5173%u952E%u5B57%27%3B%0A%20%20%20%20%7D%29.keypress%28function%20%28e%29%20%7B%0A%20%20%20%20%20%20%20%20if%20%28%28e.which%20%26%26%20e.which%20%3D%3D%2013%29%20%7C%7C%20%28e.keyCode%20%26%26%20e.keyCode%20%3D%3D%2013%29%29%7B%0A%20%20%20%20%20%20%20%20%20%20%20%20cms_submit.click%28%29%3B%0A%20%20%20%20%20%20%20%20%20%20%20%20return%20false%3B%0A%20%20%20%20%20%20%20%20%7D%0A%20%20%20%20%20%20%20%20return%20true%3B%0A%20%20%20%20%7D%29%0A%0A%20%20%20%20cms_submit.click%28function%28%29%20%7B%0A%20%20%20%20%20%20%20%20var%20value%20%3D%20cms_keyword.val%28%29%3B%20%20%20%20%20%20%20%0A%20%20%20%20%20%20%20%20if%20%28value%20%3D%3D%20%27%u8BF7%u8F93%u5165%u5173%u952E%u5B57%27%20%7C%7C%20value%20%3D%3D%20%27%27%29%20%7B%0A%20%20%20%20%20%20%20%20%20%20%20%20alert%28%27%u8BF7%u8F93%u5165%u5173%u952E%u5B57%u8FDB%u884C%u641C%u7D22%uFF01%27%29%3B%0A%20%20%20%20%20%20%20%20%20%20%20%20return%3B%0A%20%20%20%20%20%20%20%20%7D%0A%20%20%20%20%20%20%20%20location.href%20%3D%20%27/%3Ft%3Dresult%26keyword%3D%27+value%3B%20//%u53EF%u5C06result%u6362%u4E3A%u5176%u4ED6%u6A21%u677F%uFF0C%u53C2%u6570%u540Dkeyword%u4E0D%u53EF%u6362%0A%20%20%20%20%7D%29%0A%7D%29%0A%3C/script%3E%0A','全局搜索模板','2','1492685331');
insert into `global_tag` values('24','测试2','c22','ddd','测试2','3','1491818075');
insert into `global_tag` values('25','头部','head','head.htm','头部','4','1491732977');
insert into `global_tag` values('26','css和js','meta','cssjs.htm','css和js','4','1491818133');
insert into `global_tag` values('27','尾部','foot','foot.htm','尾部','4','1491818138');
insert into `global_tag` values('28','测试3','ceshi3','ceshi3','','3','1492574891');
insert into `global_tag` values('29','计数器','counter','%3Cscript%20type%3D%22text/javascript%22%20src%3D%22/js/counter.js%22%3E%3C/script%3E','计数器','2','1493885533');
unlock tables;

drop table if exists `links`;
CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `odx` smallint(6) DEFAULT '0',
  `timestamp` int(11) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL COMMENT '友情链接logo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

lock tables `links` write;
insert into `links` values('1','测试1','www.baidu.com','1','1493179789','');
insert into `links` values('2','ceshi','http://www.baidu.com','2','1493179814','');
unlock tables;

drop table if exists `main_art_category`;
CREATE TABLE `main_art_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `alias` varchar(100) DEFAULT NULL COMMENT '别名',
  `pid` int(11) DEFAULT '0' COMMENT '父id',
  `visible` tinyint(4) DEFAULT '1',
  `odx` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `childnums` int(11) DEFAULT NULL,
  `nums` int(11) DEFAULT NULL,
  `lastid` int(11) DEFAULT NULL,
  `odb` varchar(32) DEFAULT 'CreateTime',
  `scend` varchar(32) DEFAULT 'desc',
  `isatc` tinyint(4) DEFAULT '1' COMMENT '排序是否应用到子栏目',
  `type` tinyint(4) DEFAULT '1',
  `istc` tinyint(4) DEFAULT '1' COMMENT '栏目模板是否应用到子栏目',
  `tcid` int(11) DEFAULT '0' COMMENT '栏目页模板',
  `ista` tinyint(4) DEFAULT '1' COMMENT '内容模板是否应用到子栏目',
  `taid` int(11) DEFAULT '0' COMMENT '内容页模板',
  `out_url` varchar(255) DEFAULT NULL,
  `intro` text,
  `topic_id` smallint(6) DEFAULT '0',
  `tmp_id` varchar(20) DEFAULT NULL,
  `tmp_pid` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

lock tables `main_art_category` write;
insert into `main_art_category` values('72','网站首页','','0','1','0','1491443369','0','0','0','CreateTime','desc','1','1','1','0','1','0','','','0','','');
insert into `main_art_category` values('73','学校概况','','0','1','1','1491443369','0','0','0','CreateTime','desc','1','1','1','2','1','5','','','0','','');
insert into `main_art_category` values('74','新闻中心','ceshi','0','1','2','1491443369','0','0','0','CreateTime','asc','1','1','0','2','1','3','www.baidu.com','ceshiccc','0','','');
insert into `main_art_category` values('75','教育科研','','0','1','3','1491443369','0','0','0','CreateTime','desc','1','1','1','2','1','5','','测试','0','','');
insert into `main_art_category` values('76','教师频道','','0','1','4','1491443369','0','0','0','CreateTime','desc','1','1','1','2','1','3','','','0','','');
insert into `main_art_category` values('77','德育天地','','0','1','5','1491443369','0','0','0','CreateTime','desc','1','1','1','2','1','3','','nn','0','','');
insert into `main_art_category` values('78','校务公开','','0','1','6','1491443369','0','0','0','CreateTime','desc','1','1','1','2','1','3','','','0','','');
insert into `main_art_category` values('79','家校指导','','0','1','7','1491443369','0','0','0','CreateTime','desc','1','1','1','2','1','3','','','0','','');
insert into `main_art_category` values('80','课程建设','','0','1','8','1491443369','0','0','0','CreateTime','desc','1','1','1','2','1','3','','','0','','');
insert into `main_art_category` values('81','年级动态','','0','1','9','1491443369','0','0','0','CreateTime','desc','1','1','1','2','1','3','','','0','','');
insert into `main_art_category` values('82','学校简介','','73','1','0','1491443544','0','0','0','CreateTime','desc','1','1','1','2','1','5','','','0','','');
insert into `main_art_category` values('83','现任校领导','','73','1','1','1491443544','0','0','0','CreateTime','desc','1','1','1','2','1','5','www','','0','','');
insert into `main_art_category` values('84','历史沿革','','73','1','2','1491443544','0','0','0','CreateTime','desc','1','1','1','2','1','5','','ceshi ','0','','');
insert into `main_art_category` values('85','学校荣誉','','73','1','3','1491443544','0','0','0','CreateTime','desc','1','1','1','2','1','5','','','0','','');
insert into `main_art_category` values('86','校园风景','','73','1','4','1491443544','0','0','0','CreateTime','desc','1','1','1','2','1','5','','','0','','');
insert into `main_art_category` values('87','学校特色','','73','1','5','1491443544','0','0','0','CreateTime','desc','1','1','1','2','1','5','','','0','','');
insert into `main_art_category` values('88','校内新闻','','74','1','0','1491443544','0','0','0','CreateTime','asc','1','1','1','2','1','5','http://www.baidu.com/','ceshi','0','','');
insert into `main_art_category` values('89','校园公告','','74','1','1','1491443544','0','0','0','CreateTime','asc','1','1','1','2','1','5','','','0','','');
insert into `main_art_category` values('90','团队活动','','74','1','2','1491443544','0','0','0','CreateTime','asc','1','0','1','0','1','0','http://www.baidu.com','','0','','');
insert into `main_art_category` values('91','大事记','','74','1','3','1491443544','0','0','0','CreateTime','asc','1','0','1','0','1','0','www.baidu.com','','0','','');
insert into `main_art_category` values('92','测试1','','88','1','0','1492161563','0','0','0','CreateTime','asc','1','1','1','2','1','5','','','0','','');
insert into `main_art_category` values('93','测试2','','88','1','1','1492161563','0','0','0','CreateTime','asc','1','1','1','2','1','5','','','0','','');
insert into `main_art_category` values('94','首页幻灯片','','0','0','10','1492393073','0','0','0','CreateTime','desc','1','1','1','2','1','3','','','0','','');
insert into `main_art_category` values('95','t1','','0','1','0','1494210521','0','0','0','CreateTime','desc','1','1','1','0','1','0','','','1','1494210478557','-1');
insert into `main_art_category` values('96','t2','','0','1','1','1494210521','2','0','0','CreateTime','desc','1','1','1','0','1','0','','','1','1494210485787','-1');
insert into `main_art_category` values('97','t3','','0','1','2','1494210521','0','0','0','CreateTime','desc','1','1','1','0','1','0','','','1','1494210496611','-1');
insert into `main_art_category` values('98','123','','96','1','0','1494210521','0','0','0','CreateTime','desc','1','1','1','0','1','0','','','1','1494210505826','1494210485787');
insert into `main_art_category` values('99','456','','96','1','1','1494210521','0','0','0','CreateTime','desc','1','1','1','0','1','0','','','1','1494210505850','1494210485787');
insert into `main_art_category` values('100','new node','','0','1','0','1494210544','1','0','0','CreateTime','desc','1','1','1','0','1','0','','','2','1494210536876','-1');
insert into `main_art_category` values('101','new node','','100','1','0','1494210544','0','0','0','CreateTime','desc','1','1','1','0','1','0','','','2','1494210541714','1494210536876');
unlock tables;

drop table if exists `main_article`;
CREATE TABLE `main_article` (
  `id` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `pre` varchar(250) DEFAULT NULL,
  `des` text,
  `thumb` varchar(250) NOT NULL,
  `see` int(11) DEFAULT NULL,
  `up` int(11) DEFAULT NULL,
  `report` int(11) DEFAULT NULL,
  `share` int(11) DEFAULT NULL,
  `comments` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `froms` varchar(100) DEFAULT NULL,
  `fromid` int(11) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL,
  `CreateTime` int(11) DEFAULT NULL,
  `isTop` tinyint(4) DEFAULT '0',
  `push_cate` varchar(255) DEFAULT NULL,
  `out_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `main_article` write;
insert into `main_article` values('1','91','a1411090712','ceshi',' ceshi','<p>ceshi</p>','','0','0','0','0','0','1492236156','ceshi','','2','1491459533','0','','');
insert into `main_article` values('2','91','a1411090712','wew',' ewew','<p>ceshi&nbsp;</p>','','0','0','0','0','0','1492236136','','','2','1491528637','0','','');
insert into `main_article` values('3','94','a1411090712','幻灯片1',' ','<p>幻灯片1</p>','1492393128.jpg','0','0','0','0','0','1492393156','','','2','1492393156','0','','');
insert into `main_article` values('4','94','a1411090712','幻灯片2',' ','<p>幻灯片2</p>','1492393252.jpg','0','0','0','0','0','1492393261','','','2','1492393261','0','','');
insert into `main_article` values('5','94','a1411090712','幻灯片3',' ','<p>幻灯片3</p>','1492393282.jpg','0','0','0','0','0','1492393293','','','2','1492393293','0','','');
insert into `main_article` values('6','94','a1411090712','幻灯片4',' ','<p>幻灯片4</p>','1492393314.jpg','1','0','0','0','0','1492393330','','','2','1492393320','0','','');
insert into `main_article` values('7','91','a1411090712','sdsd',' ','<p style="line-height: 16px;"><img style="vertical-align: middle; margin-right: 2px;" src="http://localhost:8065/widget/ueditor/dialogs/attachment/fileTypeImages/icon_rar.gif"/><a style="font-size:12px; color:#0066cc;" href="/upd/file/20170420/1492669056634847.zip" title="Navicat Premium_11.2.7简体中文版.zip">Navicat Premium_11.2.7简体中文版.zip</a></p><p><br/></p>','','0','0','0','0','0','1493017209','','','2','1492669080','0','','www.baidu.com');
insert into `main_article` values('8','91','a1411090712','asdasd',' ','<p><img src="../../upds/img/2017/17/14932009425392.png" style=""/></p><p><img src="../../upds/img/2017/17/14932009423600.png" style=""/></p><p><img src="../../upds/img/2017/17/14932009425411.jpg" style=""/></p><p><img src="../../upds/img/2017/17/14932009421900.jpg" style=""/></p><p><img src="../../upds/img/2017/17/14932009426800.jpg" style=""/></p><p><img src="../../upds/img/2017/17/14932009423643.jpg" style=""/>asdas</p><p><br/></p>','../../upds/img/2017/17/14932009425411.jpg','0','0','0','0','0','1493200961','','','2','1493200950','0','','');
insert into `main_article` values('9','91','a1411090712','ceshishi',' ','<p><img src="../../upds/img/2017/17/14932025998304.jpg" style=""/></p><p><img src="../../upds/img/2017/17/14932025993696.jpg" style=""/></p><p><br/></p>','../../upds/img/2017/17/14932025998304.jpg','0','0','0','0','0','1493202625','张三丰','','2','1493202585','0','','');
unlock tables;

drop table if exists `osa_menu_url`;
CREATE TABLE `osa_menu_url` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_url` varchar(255) DEFAULT NULL,
  `is_show` tinyint(4) DEFAULT NULL COMMENT '是否在sidebar里出现',
  `online` int(11) DEFAULT '1' COMMENT '在线状态，还是下线状态，即可用，不可用。',
  `shortcut_allowed` int(10) unsigned DEFAULT '0' COMMENT '是否允许快捷访问',
  `menu_desc` varchar(255) DEFAULT NULL,
  `odx` int(11) DEFAULT '0',
  `father_menu` int(11) DEFAULT '0' COMMENT '上一级菜单',
  `menu_icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='功能链接（菜单链接）';

lock tables `osa_menu_url` write;
insert into `osa_menu_url` values('1','后台主界面','/man/?t=index','0','1','0','后台主界面','0','0','fa fa-sun-o');
insert into `osa_menu_url` values('2','主页','','1','1','0','主页','0','0','fa fa-home');
insert into `osa_menu_url` values('3','个人面板','/man/?t=main','1','1','0','个人面板','0','2','fa fa-map-pin');
insert into `osa_menu_url` values('4','首页','/man/?t=main','0','1','0','首页','0','1','');
insert into `osa_menu_url` values('5','文章管理','','1','1','0','文章管理','1','0','fa fa-book');
insert into `osa_menu_url` values('6','发文管理','/man/?t=arts','1','1','0','发文管理','0','5','fa fa-book');
insert into `osa_menu_url` values('7','发表/修改文章','/man/?t=art_am','0','1','0','发表/修改文章','0','5','');
insert into `osa_menu_url` values('8','文章类型','/man/?t=art_cate','0','1','0','文章类型','0','5','');
insert into `osa_menu_url` values('9','在线咨询','','1','1','0','在线咨询','4','0','fa fa-commenting');
insert into `osa_menu_url` values('10','资讯管理','/man/?t=consult','1','1','0','资讯管理','0','9','');
insert into `osa_menu_url` values('11','咨询栏目管理','/man/?t=consult_cate','0','1','0','咨询栏目管理','0','9','');
insert into `osa_menu_url` values('12','咨询办理','/man/?t=consult_am','0','1','0','咨询办理','0','9','');
insert into `osa_menu_url` values('22','用户列表','/man/?t=user_list','1','1','0','用户列表','0','49','fa fa-user');
insert into `osa_menu_url` values('23','添加/修改用户','/man/?t=user_am','0','1','0','添加/修改用户','0','49','');
insert into `osa_menu_url` values('27','用户组','/man/?t=user_group','1','1','0','用户组管理','0','49','fa fa-users');
insert into `osa_menu_url` values('30','权限管理','','1','1','0','用户权限依赖于账号组的权限','4','0','fa fa-key');
insert into `osa_menu_url` values('34','功能列表','/man/?t=menu_list','1','1','0','菜单功能及可访问的链接','0','50','');
insert into `osa_menu_url` values('35','增加/修改功能','/man/?t=menu_am','0','1','0','增加/修改功能','0','50','');
insert into `osa_menu_url` values('47','文章栏目权限','/man/?t=art_auth','1','1','0','文章栏目权限管理（增删改查）','0','30','');
insert into `osa_menu_url` values('48','后台功能权限','/man/?t=menu_auth','1','1','0','后台功能权限管理','0','30','');
insert into `osa_menu_url` values('49','用户管理','','1','1','0','用户管理','2','0','fa fa-user');
insert into `osa_menu_url` values('50','后台设置','','1','1','0','后台设置','5','0','fa fa-server');
insert into `osa_menu_url` values('51','添加/修改用户组','/man/?t=group_am','0','1','0','添加/修改用户组','0','49','');
insert into `osa_menu_url` values('52','栏目管理','/man/?t=art_cate','1','1','0','文章栏目管理','0','5','fa fa-bars');
insert into `osa_menu_url` values('53','字体图标','/man/?t=fontawesome','0','1','0','水水水水','0','50','fa fa-ban');
insert into `osa_menu_url` values('54','咨询栏目添加修改','/man/?t=consult_cate_am','0','1','0','','0','9','');
insert into `osa_menu_url` values('55','个人操作','','1','1','0','','1','0','fa fa-certificate');
insert into `osa_menu_url` values('56','我的发文','/man/?t=myarts','1','1','1','','0','55','');
insert into `osa_menu_url` values('57','系统功能设置','','1','1','0','','7','0','fa fa-gears');
insert into `osa_menu_url` values('58','核心全局参数设置','/man/?t=sys_config','1','1','0','','0','57','');
insert into `osa_menu_url` values('59','友情链接管理','/man/?t=links','1','1','0','','0','57','');
insert into `osa_menu_url` values('60','友情链接添加/修改','/man/?t=links_am','0','1','0','','0','57','');
insert into `osa_menu_url` values('61','我的发文添加/修改','/man/?t=art_myam','0','1','0','','0','55','');
insert into `osa_menu_url` values('62','个人资料','/man/?t=profile','1','1','1','','0','55','');
insert into `osa_menu_url` values('63','修改资料','/man/?t=profile_am','0','1','0','','0','55','');
insert into `osa_menu_url` values('64','数据库工具','/man/?t=database_tool','1','1','0','数据库备份、还原、优化','0','57','');
insert into `osa_menu_url` values('65','模板管理','','1','1','0','模板管理、自定义标签管理','8','0','fa fa-clone');
insert into `osa_menu_url` values('66','首页与栏目页模板','/man/?t=template_c','1','1','0','栏目页（包含首页）模板','0','65','');
insert into `osa_menu_url` values('67','内容页模板','/man/?t=template_a','1','1','0','内容页模板','0','65','');
insert into `osa_menu_url` values('68','首页与栏目页模板添加/修改','/man/?t=template_c_am','0','1','0','首页与栏目页模板添加/修改','0','65','');
insert into `osa_menu_url` values('69','内容页模板添加/修改','/man/?t=template_a_am','0','1','0','内容页模板添加/修改','0','65','');
insert into `osa_menu_url` values('70','标签管理','','1','1','0','标签管理','9','0','fa fa-anchor');
insert into `osa_menu_url` values('71','全局变量标签','/man/?t=global_tag','1','1','0','全局变量标签管理','0','70','');
insert into `osa_menu_url` values('72','全局变量标签添加/修改','/man/?t=global_tag_am','0','1','0','全局变量标签(自定义)添加/修改','0','70','');
insert into `osa_menu_url` values('73','标签自动生成器','/man/?t=label_generator','0','1','0','标签自动生成器','0','70','');
insert into `osa_menu_url` values('74','插件管理','','1','1','0','插件管理','10','0','fa fa-crop');
insert into `osa_menu_url` values('75','发文统计','/man/?t=statistics','1','1','0','','0','5','fa fa-bar-chart');
insert into `osa_menu_url` values('76','文件目录','/man/?t=catalog','1','1','0','','0','57','');
insert into `osa_menu_url` values('77','专题管理','/man/?t=topic','1','1','0','专题管理','0','5','fa fa-code-fork');
insert into `osa_menu_url` values('78','专题添加/修改','/man/?t=topic_am','0','1','0','专题添加/修改','0','5','');
unlock tables;

drop table if exists `osa_user_group`;
CREATE TABLE `osa_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) DEFAULT NULL,
  `group_role` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `owner_id` int(11) DEFAULT NULL COMMENT '创建人ID',
  `group_desc` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `art_publish_auth` text,
  `art_audit_auth` tinyint(4) DEFAULT '1' COMMENT '默认需要审核',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='账号组';

lock tables `osa_user_group` write;
insert into `osa_user_group` values('1','超级管理员组','1,4,2,3,5,6,7,8,52,75,77,78,55,56,61,62,63,49,22,23,27,51,9,10,11,12,54,30,47,48,50,34,35,53,57,58,59,60,64,76,65,66,67,68,69,70,71,72,73,74','1','超级管理员组','72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,96,98,99','0');
insert into `osa_user_group` values('2','默认账号组','1,4,2,3,15,55,56,61,62,63','1','默认账号组','73,74,82,83,84,85,86,87,88,89,90,91,92,93,97','1');
unlock tables;

drop table if exists `ppf_manager`;
CREATE TABLE `ppf_manager` (
  `id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `pmd5` varchar(32) DEFAULT NULL,
  `lgnums` int(11) DEFAULT NULL,
  `lastip` varchar(15) DEFAULT NULL,
  `lasttime` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

lock tables `ppf_manager` write;
insert into `ppf_manager` values('1','lren','管理员','8049c97086380932e96179fda9f7a7d8','131','::1','1491654366','1410234918');
insert into `ppf_manager` values('2','super','总管理员1','8049c97086380932e96179fda9f7a7d8','1','10.0.0.8','1397610618','1397293550');
unlock tables;

drop table if exists `ppf_module`;
CREATE TABLE `ppf_module` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `pidlist` varchar(100) DEFAULT NULL,
  `lvl` int(11) DEFAULT NULL,
  `childnums` int(11) DEFAULT NULL,
  `odx` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `hints` varchar(100) DEFAULT NULL,
  `tpl` varchar(60) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `ppf_module` write;
insert into `ppf_module` values('1','0','0,1,','1','2','0','档案管理','档案管理（审阅，评分）','dossier','1397294218');
insert into `ppf_module` values('2','1','0,1,2,','2','0','0','审阅','','state','1397294285');
insert into `ppf_module` values('3','1','0,1,3,','2','0','0','评分','','score','1397294297');
insert into `ppf_module` values('4','0','0,4,','1','2','0','教师成长考核','','assessment','1397364129');
insert into `ppf_module` values('5','4','0,4,5,','2','0','0','教师成长校（园）级考核','','assessment_sch','1397364158');
insert into `ppf_module` values('6','4','0,4,6,','2','0','0','教师成长区级考核','','assessment_reg','1397364193');
unlock tables;

drop table if exists `ppf_tpl`;
CREATE TABLE `ppf_tpl` (
  `id` int(11) NOT NULL,
  `php` varchar(60) DEFAULT NULL,
  `tpl` varchar(100) DEFAULT NULL,
  `ico` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `tips` varchar(150) DEFAULT NULL,
  `ishtm` tinyint(4) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `pidlist` varchar(100) DEFAULT NULL,
  `lvl` tinyint(4) DEFAULT NULL,
  `childnums` smallint(6) DEFAULT NULL,
  `odx` int(11) DEFAULT NULL,
  `hidden` tinyint(4) DEFAULT NULL,
  `tblname` varchar(100) DEFAULT NULL,
  `tblkey` varchar(50) DEFAULT NULL,
  `ctrlpass` varchar(60) DEFAULT NULL,
  `tblsha1` varchar(60) DEFAULT NULL,
  `tblmd5` varchar(60) DEFAULT NULL,
  `tblunique` int(11) DEFAULT NULL,
  `tbldefault` int(11) DEFAULT NULL,
  `tblseed` varchar(5) DEFAULT NULL,
  `tblorder` varchar(50) DEFAULT NULL,
  `tblorderby` varchar(50) DEFAULT NULL,
  `treeis` tinyint(4) DEFAULT NULL,
  `treepid` varchar(60) DEFAULT NULL,
  `treepidlist` varchar(60) DEFAULT NULL,
  `formatdates` varchar(100) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `usepre` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `ppf_tpl` write;
insert into `ppf_tpl` values('1','','no','0.gif','GII-System','系统管理','0','0','0,1,','1','3','0','0','','id','','','','0','0','','','','0','','','','1397210235','0');
insert into `ppf_tpl` values('2','','111',' ','后台管理中心','','0','0','0,2,','1','6','2','0','','','','','','0','0','','','','0','','','','1397634729','0');
insert into `ppf_tpl` values('3','','','3.gif','主站管理中心【顶级】','','0','0','0,3,','1','11','8','0','','','','','','0','0','','','','0','','','','1397210041','0');
insert into `ppf_tpl` values('4','','','4.gif','前端页面处理操作','','0','0','0,4,','1','12','5','0','','','','','','0','0','','','','0','','','','1397268185','0');
insert into `ppf_tpl` values('11','','ppf_tpl','','模板管理','模板管理','1','1','0,1,11,','2','0','0','0','ppf_tpl','id','','','','2','7','1','odx','desc','1','pid','pidlist','','1410396311','0');
insert into `ppf_tpl` values('111','','','','三级模板','','0','11','','2','0','111','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('112','','1','','隐藏的模板操作','','0','1','0,1,112,','1','5','0','1','1','id','','','','0','0','time','id','desc','0','pid','','','1448607867','0');
insert into `ppf_tpl` values('113','','ppf_tpl_unique','','模板唯一字段','唯一字段','0','112','0,1,112,113,','2','0','0','1','ppf_tpl_unique','id','','','','0','0','1','id','desc','0','pid','','','1446102649','0');
insert into `ppf_tpl` values('114','','ppf_tpl_default','','模板字段默认值','模板字段默认值','0','112','0,1,112,114,','2','0','114','1','ppf_tpl_default','id','','','','0','0','1','id','desc','0','pid','','','1397210272','0');
insert into `ppf_tpl` values('115','','ppf_tpl_query','','模板查询字段','','0','112','0,1,112,115,','2','0','115','1','ppf_tpl_query','id','','','','0','0','1','id','desc','0','','','','1397210274','0');
insert into `ppf_tpl` values('116','','ppf_tpl_display','','模板显示字段','','0','112','0,1,112,116,','2','0','116','1','ppf_tpl_display','id','','','','0','0','1','id','desc','0','','','','1397210276','0');
insert into `ppf_tpl` values('117','','ppf_tpl_edit','','模板增删改字段','','0','112','0,1,112,117,','2','0','117','1','ppf_tpl_edit','id','','','','0','1','1','id','desc','0','','','','1397210278','0');
insert into `ppf_tpl` values('118','','ppf_manager','','系统帐号管理','','0','1','0,1,118,','2','0','2','0','ppf_manager','id','password','','pmd5','1','3','time','id','desc','0','pid','',',lasttime,','1397210191','0');
insert into `ppf_tpl` values('168','t.php','','0.gif','用户中心','','0','4','0,4,168,','2','4','168','0','','id','','','','0','0','time','id','desc','0','pid','pidlist',',','1397268464','0');
insert into `ppf_tpl` values('169','t.php','','1.gif','个人空间','','0','4','0,4,169,','2','19','169','0','','id','','','','0','0','time','id','desc','0','pid','pidlist',',','1397268482','0');
insert into `ppf_tpl` values('170','t.php','','2.gif','教师空间','','0','4','0,4,170,','2','16','170','0','','id','','','','0','0','time','id','desc','0','pid','pidlist',',','1411872195','0');
insert into `ppf_tpl` values('171','t.php','tech','','教师空间信息','','1','170','0,4,170,171,','3','0','172','0','tech','id','','','','0','0','1','id','desc','0','pid','pidlist',',','1411872225','1');
insert into `ppf_tpl` values('172',' ','user_reg','','注册','','0','168','0,4,168,172,','3','0','179','0','act_member','id','pwd','','pmd5','3','5','time','id','desc','0',' ',' ',',','1401954383','1');
insert into `ppf_tpl` values('174','t.php','comm_subject','','公共学科管理','','1','169','0,4,169,174,','3','0','176','0','subject','id','','','','0','0','1','id','desc','0','pid','pidlist',',','1398742902','0');
insert into `ppf_tpl` values('175','t.php','blog','','博客','','1','169','0,4,169,175,','3','0','174','0','blog_list','id','','','','0','1','time','id','desc','0','pid','pidlist',',','1404207215','0');
insert into `ppf_tpl` values('176','t.php','comm_grade','','学段年级管理','','1','169','0,4,169,176,','3','0','177','0','grade','id','','','','0','0','1','odx','desc','1','pid','pidlist',',','1399536859','0');
insert into `ppf_tpl` values('177','t.php','comm_addr','','地址库管理','','1','169','0,4,169,177,','3','0','196','0','address','id','','','','0','0','1','odx','desc','1','pid','pidlist',',','1399536913','0');
insert into `ppf_tpl` values('180','t.php','faq_add','','FAQ添加','','1','170','0,4,170,180,','3','0','181','0','tech_faq','id','','','','0','0','time','id','desc','0','pid','pidlist',',','1412931223','0');
insert into `ppf_tpl` values('181','t.php','sys_info','','系统信息管理','','1','200','0,2,200,181,','3','0','0','0','sys_info','id','','','','0','0','1','id','desc','0','pid','pidlist',',','1401089580','0');
insert into `ppf_tpl` values('182','t.php','','5.gif','学生空间','','0','4','0,4,182,','2','5','182','0','','id','','','','0','0','time','id','desc','0','pid','pidlist',',','1414736470','0');
insert into `ppf_tpl` values('186','t.php','student','','学生空间表','','1','182','0,4,182,186,','3','0','186','0','student','id','','','','0','0','time','id','desc','0','pid','pidlist',',','1414736505','0');
insert into `ppf_tpl` values('189','t.php','ppf_module','','页面上权限模块','','1','1','0,1,189,','2','0','5','0','ppf_module','id','','','','1','0','1','odx','desc','1','pid','pidlist',',','1397294233','0');
insert into `ppf_tpl` values('196','t.php','zone','','空间设置','','1','169','0,4,169,196,','3','0','175','0','zone','id','','','','0','0','1','odx','desc','0','pid','pidlist',',','1404983549','0');
insert into `ppf_tpl` values('199','','','1.gif','业务管理','','0','2','0,2,199,','2','7','2','0','','','','','','0','0','','','','0','','','','1400745403','0');
insert into `ppf_tpl` values('200','','','2.gif','系统管理','','0','2','0,2,200,','2','4','0','0','','','','','','0','0','','','','0','','','','1400745409','0');
insert into `ppf_tpl` values('203','t.php','sys_org_type','','学校类型','','0','1363','0,2,1363,203,','3','0','0','0','sys_org_type','id','','','','0','0','1','odx','desc','0','pid','pidlist','','1448610665','0');
insert into `ppf_tpl` values('207','t.php','manager','','系统管理员','','0','200','0,2,200,207,','3','0','1','0','manager','id','pass','','pmd5','0','0','1','id','asc','0','','',',lasttime,','1401089847','0');
insert into `ppf_tpl` values('210','t.php','sys_server','','服务器管理','','0','200','0,2,200,210,','3','0','4','0','sys_server','id','','','','1','1','1','id','asc','0','','','','1401178009','0');
insert into `ppf_tpl` values('212','','','2.gif','基础数据管理','','0','2','0,2,212,','2','4','3','0','','','','','','0','0','','','','0','','','','1401850071','0');
insert into `ppf_tpl` values('213','t.php','sys_addr','','地址库管理','','1','1363','0,2,1363,213,','3','0','9','0','sys_addr','id','','','','0','0','1','odx','asc','1','pid','pidlist','','1448609174','0');
insert into `ppf_tpl` values('214','t.php','sys_period','','学段','','1','1363','0,2,1363,214,','3','0','3','0','sys_period','id','','','','0','0','1','odx','asc','0','pid','pidlist','','1448609196','0');
insert into `ppf_tpl` values('215','t.php','sys_subject','','学科','','1','1363','0,2,1363,215,','3','0','8','0','sys_subject','id','','','','0','0','100','odx','desc','0','','',' ','1448609210','0');
insert into `ppf_tpl` values('217','t.php','class','','班级管理','','1','199','0,2,199,217,','3','0','4','0','class','id','','','','0','0','time','id','desc','0','','',',timestamp,','1419306018','0');
insert into `ppf_tpl` values('218','t.php','group','','群组管理','','1','199','0,2,199,218,','3','0','6','0','group','id','','','','0','0','time','id','desc','0','','',',timestamp,','1419313687','0');
insert into `ppf_tpl` values('219','','home','','个人信息修改','','0','168','0,4,168,219,','3','0','219','0','act_member','id','','','','0','0','time','odx','desc','0','','','','1418958760','1');
insert into `ppf_tpl` values('224','','contact','','联系方式','','0','168','0,4,168,224,','3','0','224','0','act_contacts','id','','','','0','0','1','id','asc','0','','','timestamp','1407314303','0');
insert into `ppf_tpl` values('226','t.php','sys_app','','接入网站管理','','0','200','0,2,200,226,','3','0','4','0','sys_app','id','','','','0','1','1','id','asc','0','','','','1410505584','0');
insert into `ppf_tpl` values('227','','sys_grade','','年级','','1','1363','0,2,1363,227,','3','0','5','0','sys_grade','id','','','','0','0','1','id','asc','0','','','','1448609215','0');
insert into `ppf_tpl` values('228','','school','','学校管理新','','1','199','0,2,199,228,','3','0','1','0','school','id','','','','4','0','1','','','0','','','','1412735613','0');
insert into `ppf_tpl` values('230','','faq_info','','FAQ_回复','','1','170','0,4,170,230,','3','0','230','0','tech_faq_question','id','','','','0','0','time','','','0','','','','1412931268','0');
insert into `ppf_tpl` values('231','','tech_schedule','','日程','','0','170','0,4,170,231,','3','0','0','0','tech_schedule','id','','','','0','0','time','','','0','','','','1420784129','0');
insert into `ppf_tpl` values('233','','sys_textbook_volume','','上下册','','1','212','0,2,212,233,','3','0','233','0','sys_textbook_volume','id','','','','0','0','1','','','0','','','','1413270167','0');
insert into `ppf_tpl` values('234','','sys_textbook_chapter','','单元/章/节','','1','212','0,2,212,234,','3','0','234','0','sys_textbook_chapter','id','','','','0','0','1','','','0','','','','1413268628','0');
insert into `ppf_tpl` values('235','','sys_textbook','','课文库','','1','199','0,2,199,235,','3','0','8','0','sys_textbook','id','','','','0','0','1','id','asc','0','','','','1413268717','0');
insert into `ppf_tpl` values('236','','','','隐藏数据处理','','0','2','0,2,236,','2','1','20','1','','','','','','0','0','','','','0','','','','1413271683','0');
insert into `ppf_tpl` values('237','','act_member','','用户处理','','0','199','0,2,199,237,','3','0','0','0','act_member','id','pass','','pmd5','0','0','time','id','desc','0','','',',timestamp,','1446102766','1');
insert into `ppf_tpl` values('239','','tech_homework','','家庭作业','','1','170','0,4,170,239,','3','0','239','0','tech_homework','id','','','','0','0','1','id','desc','0','','','','1413341888','0');
insert into `ppf_tpl` values('240','','res_courseware','','课件管理','','0','170','0,4,170,240,','3','0','240','0','res_courseware','id','','','','0','0','1','','','0','','','','1413526226','0');
insert into `ppf_tpl` values('241','','res_type','','资源类型','','1','212','0,2,212,241,','3','0','241','0','res_type','id','','','','0','0','1','id','asc','0','','','','1413527676','0');
insert into `ppf_tpl` values('243','','beike','','备课','','0','170','0,4,170,243,','3','0','243','0','beike','id','','','','0','2','time','','','0','','','','1414397782','0');
insert into `ppf_tpl` values('245','','beike_list','','备课列表页','','0','170','0,4,170,245,','3','0','245','0','beike_list','id','','','','0','0','time','','','0','','','','1414463429','0');
insert into `ppf_tpl` values('246','','itembank','','题库','','0','170','0,4,170,246,','3','0','246','0','itembank','id','','','','0','0','1','','','0','','','','1414561012','0');
insert into `ppf_tpl` values('247','','stu_note','','笔记','','0','182','0,4,182,247,','3','0','247','0','stu_note','id','','','','0','0','time','','','0','','','','1415156655','0');
insert into `ppf_tpl` values('248','','','','独立模块','','0','4','0,4,248,','2','2','248','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('249','','faq','','FAQ','','0','248','0,4,248,249,','3','0','249','0','faq','id','','','','0','0','1','','','0','','','','1415092615','0');
insert into `ppf_tpl` values('250','','faq_answer','','FAQ_回复','','0','248','0,4,248,250,','3','0','250','0','faq_answer','id','','','','0','0','1','','','0','','','','1415151407','0');
insert into `ppf_tpl` values('251','','stu_datum','','学习资料','','0','182','0,4,182,251,','3','0','251','0','stu_datum','id','','','','0','0','time','','','0','','','','1415239133','0');
insert into `ppf_tpl` values('252','','tech_class_subject','','班级任课','','0','170','0,4,170,252,','3','0','252','0','tech_class_subject','id','','','','0','0','1','','','0','','','','1415265453','0');
insert into `ppf_tpl` values('253','','stu_homework','','家庭作业[学生]','','0','182','0,4,182,253,','3','0','253','0','stu_homework','id','','','','0','0','1','','','0','','','','1415604229','0');
insert into `ppf_tpl` values('254','','stu_schedule','','学生计划','','0','182','0,4,182,254,','3','0','254','0','stu_schedule','id','','','','0','0','1','','','0','','','','1415847842','0');
insert into `ppf_tpl` values('255','','','','家长空间','','0','4','0,4,255,','2','1','255','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('256','','guardian','','家长空间表','','0','255','0,4,255,256,','3','0','256','0','guardian','id','','','','0','0','1','','','0','','','','1415848595','0');
insert into `ppf_tpl` values('261','','','','班级空间','','0','4','0,4,261,','2','15','261','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('262','','cls_notice','','班级通知','','0','261','0,4,261,262,','3','0','262','0','cls_notice','id','','','','0','0','time','','','0','','','','1416988045','0');
insert into `ppf_tpl` values('263','','cls_activity','','班级活动','','0','261','0,4,261,263,','3','0','263','0','cls_activity','id','','','','0','0','time','','','0','','','','1416992425','0');
insert into `ppf_tpl` values('264','','cls_diary','','班级日记','','0','261','0,4,261,264,','3','0','264','0','cls_diary','id','','','','0','0','time','','','0','','','','1416993278','0');
insert into `ppf_tpl` values('265','','cls_honor','','班级荣誉','','0','261','0,4,261,265,','3','0','265','0','cls_honor','id','','','','0','0','time','','','0','','','','1417664813','0');
insert into `ppf_tpl` values('271','','cls_mien','','班级风采','','0','261','0,4,261,271,','3','0','271','0','cls_mien','id','','','','0','0','time','','','0','','','','1418713639','0');
insert into `ppf_tpl` values('273','','','','名师工作室','','0','4','0,4,273,','2','9','0','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('274','','famous','','名师工作室','','0','199','0,2,199,274,','3','0','3','0','famous','id','','','','0','0','time','','','0','','','','1439369786','0');
insert into `ppf_tpl` values('275','','blog_cate','','博客类别','','0','169','0,4,169,275,','3','0','0','0','blog_cate','id','','','','0','0','time','','','0','','','','1420429735','0');
insert into `ppf_tpl` values('278','','blog_comments','','博客回复','','0','169','0,4,169,278,','3','0','0','0','blog_comments','id','','','','0','0','time','','','0','','','','1420442361','0');
insert into `ppf_tpl` values('279','','weibo','','微博','','0','169','0,4,169,279,','3','0','0','0','weibo','id','','','','0','0','time','','','0','','','','1420445496','0');
insert into `ppf_tpl` values('280','','friend_group','','好友分组','','0','169','0,4,169,280,','3','0','0','0','act_friend_group','id','','','','0','0','time','','','0','','','','1420535004','0');
insert into `ppf_tpl` values('281','','zone_fav_type','','收藏类别','','0','169','0,4,169,281,','3','0','0','0','zone_fav_type','id','','','','0','0','time','','','0','','','','1443348784','0');
insert into `ppf_tpl` values('282','','zone_album','','相册','','0','169','0,4,169,282,','3','0','0','0','zone_album','id','','','','0','0','time','','','0','','','','1420614394','0');
insert into `ppf_tpl` values('283','','tech_def_property','','默认的属性','','0','170','0,4,170,283,','3','0','0','0','tech_def_property','id','','','','0','0','time','','','0','','','','1420774895','0');
insert into `ppf_tpl` values('284','','','','学校空间','','0','4','0,4,284,','2','7','0','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('285','','sch_art','','校园文章','','0','284','0,4,284,285,','3','0','0','0','sch_art','id','','','','0','0','time','','','0','','','','1421225349','0');
insert into `ppf_tpl` values('286','','sch_art_cate','','校园文章类别','','0','284','0,4,284,286,','3','0','0','0','sch_art_cate','id','','','','0','0','time','','','0','','','','1421225913','0');
insert into `ppf_tpl` values('1280','','famous_member','','空间成员','','0','273','0,4,273,1280,','3','0','0','0','famous_member','id','','','','0','0','1','','','0','','','','1420612391','0');
insert into `ppf_tpl` values('1281','','famous_news','','新闻动态','','0','273','0,4,273,1281,','3','0','0','0','famous_news','id','','','','0','0','1','','','0','','','','1420684484','0');
insert into `ppf_tpl` values('1282','','famous_plan','','工作室计划','','0','273','0,4,273,1282,','3','0','0','0','famous_plan','id','','','','0','0','1','','','0','','','','1421134911','0');
insert into `ppf_tpl` values('1283','','famous_course','','教学课程','','0','273','0,4,273,1283,','3','0','0','0','famous_course','id','','','','0','0','1','','','0','','','','1421203354','0');
insert into `ppf_tpl` values('1284','','famous_rearch','','课题研究','','0','273','0,4,273,1284,','3','0','0','0','famous_rearch','id','','','','0','0','1','','','0','','','','1421204593','0');
insert into `ppf_tpl` values('1285','','famous_article','','论文','','0','273','0,4,273,1285,','3','0','0','0','famous_article','id','','','','0','0','1','','','0','','','','1421206343','0');
insert into `ppf_tpl` values('1286','','famous_pic','','名师图片','','0','273','0,4,273,1286,','3','0','0','0','famous_pic','id','','','','0','0','1','','','0','','','','1421823022','0');
insert into `ppf_tpl` values('1287','','sch_topic','','学校专题','','0','284','0,4,284,1287,','3','0','0','0','sch_topic','id','','','','0','0','time','','','0','','','','1422338283','0');
insert into `ppf_tpl` values('1288','','famous_cate','','文章类别','','0','273','0,4,273,1288,','3','0','0','0','famous_cate','id','','','','0','0','1','','','0','','','','1445571412','0');
insert into `ppf_tpl` values('1290','','sch_depart','','学校部门','','0','284','0,4,284,1290,','3','0','0','0','sch_department','id','','','','0','0','1','','','0','','','','1438591131','0');
insert into `ppf_tpl` values('1291','','grp_member','','群组成员','','0','236','0,2,236,1291,','3','0','0','0','grp_member','id','','','','0','0','1','','','0','','','','1438670657','0');
insert into `ppf_tpl` values('1293','','weibo_comments','','微博回复','','0','169','0,4,169,1293,','3','0','0','0','weibo_comments','id','','','','0','0','1','','','0','','','','1439198313','0');
insert into `ppf_tpl` values('1297','','main_member','','管理员','','0','3','0,3,1297,','2','0','0','0','main_member','id','','','','0','0','1','','','0','','','','1439430623','0');
insert into `ppf_tpl` values('1298','','','','学科空间','','0','4','0,4,1298,','2','15','0','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('1299','','sub_resources','','资源发布','','0','1298','0,4,1298,1299,','3','0','0','0','sub_resources','id','','','','0','0','1','','','0','','','','1440040886','0');
insert into `ppf_tpl` values('1300','','sub_news','','学科新闻','','0','1298','0,4,1298,1300,','3','0','0','0','sub_news','id','','','','0','0','time','','','0','','','','1439514431','0');
insert into `ppf_tpl` values('1301','','sub_articles','','文章发布','','0','1298','0,4,1298,1301,','3','0','0','0','sub_articles','id','','','','0','0','1','','','0','','','','1439883282','0');
insert into `ppf_tpl` values('1302','','sub_slides','','首页幻灯片','','0','1298','0,4,1298,1302,','3','0','0','0','sub_slides','id','','','','0','0','1','','','0','','','','1441182872','0');
insert into `ppf_tpl` values('1303','','subject','','学科空间','','0','1298','0,4,1298,1303,','3','0','0','0','subject','id','','','','0','0','1','','','0','','','','1439431261','0');
insert into `ppf_tpl` values('1304','','main_art_cate','','文章类别','','0','3','0,3,1304,','2','0','0','0','main_art_category','id','','','','0','0','1','','','0','','','','1439458127','0');
insert into `ppf_tpl` values('1305','','famous_slide','','幻灯片','','0','273','0,4,273,1305,','3','0','0','0','famous_slide','id','','','','0','0','1','','','0','','','','1439458563','0');
insert into `ppf_tpl` values('1306','','main_article','','文章列表管理','','0','3','0,3,1306,','2','0','0','0','main_article','id','','','','0','0','1','','','0','','','','1439519249','0');
insert into `ppf_tpl` values('1307','','sub_def_labels','','资源默认标签组','','0','1298','0,4,1298,1307,','3','0','0','0','sub_def_labels','id','','','','0','0','1','','','0','','','','1440043132','0');
insert into `ppf_tpl` values('1308','','main_topic','','专题管理','','0','3','0,3,1308,','2','0','0','0','main_topic','id','','','','0','0','1','','','0','','','','1439523012','0');
insert into `ppf_tpl` values('1309','','sub_comments','','文章评论','','0','1298','0,4,1298,1309,','3','0','0','0','sub_comments','id','','','','0','0','1','','','0','','','','1440489360','0');
insert into `ppf_tpl` values('1310','','main_problem','','课题管理','','0','3','0,3,1310,','2','0','0','0','main_problem','id','','','','0','0','1','','','0','','','','1439540268','0');
insert into `ppf_tpl` values('1311','','sub_article_type','','文章分类','','0','1298','0,4,1298,1311,','3','0','0','0','sub_article_type','id','','','','0','0','1','','','0','','','','1439878709','0');
insert into `ppf_tpl` values('1312','','act_friend','','好友','','0','169','0,4,169,1312,','3','0','0','0','act_friend','id','','','','0','0','1','','','0','','','','1440053628','0');
insert into `ppf_tpl` values('1313','','act_friend_apply','','好友申请','','0','168','0,4,168,1313,','3','0','0','0','act_friend_apply','id','','','','0','0','1','','','0','','','','1440058088','0');
insert into `ppf_tpl` values('1314','','cls_cate','','类别管理','','0','261','0,4,261,1314,','3','0','0','0','class_category','id','','','','0','0','1','','','0','','','','1440493812','0');
insert into `ppf_tpl` values('1315','','cls_art','','文章管理','','0','261','0,4,261,1315,','3','0','0','0','class_article','id','','','','0','0','1','','','0','','','','1440495631','0');
insert into `ppf_tpl` values('1316','','cls_slide','','幻灯片管理','','0','261','0,4,261,1316,','3','0','0','0','cls_slide','id','','','','0','0','1','','','0','','','','1440571667','0');
insert into `ppf_tpl` values('1317','','','','活动','','0','4','0,4,1317,','2','8','0','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('1318','','activity','','活动列表','','0','1317','0,4,1317,1318,','3','0','0','0','activity','id','','','','0','0','time','','','0','','','','1440984749','0');
insert into `ppf_tpl` values('1319','','active_lvl','','活动级别','','0','1317','0,4,1317,1319,','3','0','0','0','active_level','id','','','','0','0','1','','','0','','','','1441078753','0');
insert into `ppf_tpl` values('1320','','active_cate','','活动类别','','0','1317','0,4,1317,1320,','3','0','0','0','active_category','id','','','','0','0','1','','','0','','','','1441078828','0');
insert into `ppf_tpl` values('1323','','active_thing','','活动心得','','0','1317','0,4,1317,1323,','3','0','0','0','active_thing','id','','','','0','0','1','','','0','','','','1441765996','0');
insert into `ppf_tpl` values('1324','','active_summary','','活动总结','','0','1317','0,4,1317,1324,','3','0','0','0','active_summary','id','','','','0','0','1','','','0','','','','1441766010','0');
insert into `ppf_tpl` values('1327','','subjecter','','主学科空间','','0','1298','0,4,1298,1327,','3','0','0','0','subjecter','id','','','','0','0','1','','','0','','','','1441768856','0');
insert into `ppf_tpl` values('1328','','subjecter_article_type','','主学科文章分类','','0','1298','0,4,1298,1328,','3','0','0','0','subjecter_article_type','id','','','','0','0','1','','','0','','','','1441788782','0');
insert into `ppf_tpl` values('1329','','subjecter_articles','','主学科文章','','0','1298','0,4,1298,1329,','3','0','0','0','subjecter_articles','id','','','','0','0','1','','','0','','','','1441789064','0');
insert into `ppf_tpl` values('1331','','subjecter_comments','','主学科文章评论','','0','1298','0,4,1298,1331,','3','0','0','0','subjecter_comments','id','','','','0','0','1','','','0','','','','1441964085','0');
insert into `ppf_tpl` values('1332','','sch_admin','','管理员','','0','284','0,4,284,1332,','3','0','0','0','sch_admin','id','','','','0','0','time','','','0','','','','1443173040','0');
insert into `ppf_tpl` values('1333','','photo','','照片','','0','169','0,4,169,1333,','3','0','0','0','zone_album_pic','id','','','','0','0','time','','','0','','','','1443258411','0');
insert into `ppf_tpl` values('1334','','blog_comment_comments','','博客回复的回复','','0','169','0,4,169,1334,','3','0','0','0','blog_comment_comments','id','','','','0','0','time','','','0','','','','1443322661','0');
insert into `ppf_tpl` values('1335','','zone_leave','','留言板','','0','169','0,4,169,1335,','3','0','0','0','zone_leave','id','','','','0','0','time','','','0','','','','1443342089','0');
insert into `ppf_tpl` values('1336','','zone_leave_comments','','留言板回复','','0','169','0,4,169,1336,','3','0','0','0','zone_leave_comments','id','','','','0','0','time','','','0','','','','1443347163','0');
insert into `ppf_tpl` values('1337','','teacher_news_type','','教师空间文章类别','','0','170','0,4,170,1337,','3','0','0','0','teacher_news_type','id','','','','0','0','time','','','0','','','','1444704675','0');
insert into `ppf_tpl` values('1338','','zone_fav','','收藏夹','','0','169','0,4,169,1338,','3','0','0','0','zone_fav','id','','','','0','0','time','','','0','','','','1443349275','0');
insert into `ppf_tpl` values('1339','','teacher_news','','教师空间文章','','0','170','0,4,170,1339,','3','0','0','0','teacher_news','id','','','','0','0','time','','','0','','','','1444704670','0');
insert into `ppf_tpl` values('1340','','sys_zone_template','','ZONE模板','','0','1364','0,2,1364,1340,','3','0','0','0','sys_zone_template','id','','','','0','0','1','','','0','','','','1448609130','0');
insert into `ppf_tpl` values('1341','','subjecter_books','','课本管理','','0','1298','0,4,1298,1341,','3','0','0','0','subjecter_books','id','','','','0','0','1','','','0','','','','1444376789','0');
insert into `ppf_tpl` values('1342','','cls_member','','班级成员管理','','0','261','0,4,261,1342,','3','0','0','0','cls_member','id','','','','0','0','time','','','0','','','','1444456312','0');
insert into `ppf_tpl` values('1343','','cls_saying','','教师语录','','0','261','0,4,261,1343,','3','0','0','0','cls_saying','id','','','','0','0','1','','','0','','','','1444616130','0');
insert into `ppf_tpl` values('1344','','cls_album','','班级相册','','0','261','0,4,261,1344,','3','0','0','0','cls_album','id','','','','0','0','1','','','0','','','','1444618878','0');
insert into `ppf_tpl` values('1345','','cls_photo','','相册照片','','0','261','0,4,261,1345,','3','0','0','0','cls_photo','id','','','','0','0','1','','','0','','','','1444619909','0');
insert into `ppf_tpl` values('1346','','sys_books_chapters','','章管理','','0','1298','0,4,1298,1346,','3','0','0','0','sys_books_chapters','id','','','','0','0','1','','','0','','','','1444699715','0');
insert into `ppf_tpl` values('1347','','tech_grow','','教师空间成长规划文章','','0','170','0,4,170,1347,','3','0','0','0','tech_grow','id','','','','0','0','time','','','0','','','','1445582012','0');
insert into `ppf_tpl` values('1348','','tech_grow_type','','教师空间成长规划文章类别','','0','170','0,4,170,1348,','3','0','0','0','tech_grow_type','id','','','','0','0','time','','','0','','','','1445582036','0');
insert into `ppf_tpl` values('1349','','tech_grow_myinfo','','教师空间成长规划基本情况','','0','170','0,4,170,1349,','3','0','0','0','tech_grow_myinfo','id','','','','0','0','time','','','0','','','','1445582041','0');
insert into `ppf_tpl` values('1350','','sys_textbook_edition','','教材版本','','0','212','0,2,212,1350,','3','0','0','0','sys_textbook_edition','id','','','','0','0','1','','','0','','','','1444889503','0');
insert into `ppf_tpl` values('1351','','act_school','','学校用户—关连表','','0','284','0,4,284,1351,','3','0','0','0','act_school','id','','','','0','0','1','','','0','','','','1444959461','0');
insert into `ppf_tpl` values('1354','','sch_slide','','幻灯片','','0','284','0,4,284,1354,','3','0','0','0','sch_slide','id','','','','0','0','1','','','0','','','','1445590135','0');
insert into `ppf_tpl` values('1355','','sys_tpl_class','','Class空间模板','','0','1364','0,2,1364,1355,','3','0','0','0','sys_tpl_class','id','','','','0','0','1','','','0','','','','1448611959','0');
insert into `ppf_tpl` values('1356','','cls_comments','','班级评论','','0','261','0,4,261,1356,','3','0','0','0','cls_comments','id','','','','0','0','time','','','0','','','','1445910553','0');
insert into `ppf_tpl` values('1357','','subjecter_resources','','资源管理','','0','1298','0,4,1298,1357,','3','0','0','0','subjecter_resources','id','','','','0','0','1','','','0','','','','1446099208','0');
insert into `ppf_tpl` values('1358','','cls_art_cate','','新文章分类','','0','261','0,4,261,1358,','3','0','0','0','cls_art_cate','id','','','','0','0','time','','','0','','','','1446110392','0');
insert into `ppf_tpl` values('1359','','cls_art_new','','新文章管理 ','','0','261','0,4,261,1359,','3','0','0','0','cls_art','id','','','','0','0','time','','','0','','','','1446189189','0');
insert into `ppf_tpl` values('1360','','active_status','','活动状态','','0','1317','0,4,1317,1360,','3','0','0','0','active_status','id','','','','0','0','1','','','0','','','','1446453653','0');
insert into `ppf_tpl` values('1361','','active_member','','活动成员','','0','1317','0,4,1317,1361,','3','0','0','0','active_member','id','','','','0','0','1','','','0','','','','1446689786','0');
insert into `ppf_tpl` values('1362','','sys_tpl_index','','Index模板管理','','0','1364','0,2,1364,1362,','3','0','0','0','sys_tpl_index','id','','','','0','0','1','','','0','','','','1448609136','0');
insert into `ppf_tpl` values('1363','','12','','数据字典','','0','2','0,2,1363,','2','5','5','0','','','','','','0','0','','','','0','','','','1448609738','0');
insert into `ppf_tpl` values('1364','','123','','模板管理','','0','2','0,2,1364,','2','6','6','0','','','','','','0','0','','','','0','','','','1448609725','0');
insert into `ppf_tpl` values('1365','','sys_tpl_group','','Group模板','','0','1364','0,2,1364,1365,','3','0','0','0','sys_tpl_group','id','','','','0','0','1','','','0','','','','1455762077','0');
insert into `ppf_tpl` values('1366','','','','群组空间','','0','4','0,4,1366,','2','3','0','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('1367','','grp_weibo','','群组微博','','0','1366','0,4,1366,1367,','3','0','0','0','grp_weibo','id','','','','0','0','time','','','0','','','','1455862634','0');
insert into `ppf_tpl` values('1368','','grp_weibo_comment','','群组微博回复','','0','1366','0,4,1366,1368,','3','0','0','0','grp_weibo_comment','id','','','','0','0','1','','','0','','','','1455862774','0');
insert into `ppf_tpl` values('1369','','grp_forum','','群组贴子','','0','1366','0,4,1366,1369,','3','0','0','0','grp_forum','id','','','','0','0','time','','','0','','','','1456131036','0');
insert into `ppf_tpl` values('1370','','main_video_cate','','视频类别','','0','3','0,3,1370,','2','0','0','0','main_video_category','id','','','','0','0','1','','','0','','','','1456557178','0');
insert into `ppf_tpl` values('1371','','main_video','','视频列表管理','','0','3','0,3,1371,','2','0','0','0','main_video','id','','','','0','0','1','','','0','','','','1456557249','0');
insert into `ppf_tpl` values('1372','','','','移动端','','0','0','0,1372,','1','1','0','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('1373','','','','首页新闻管理','','0','1372','0,1372,1373,','2','3','0','0','','','','','','0','0','1','','','0','','','','1463122718','0');
insert into `ppf_tpl` values('1374','','mo_category','','移动新闻类别','','0','1373','0,1372,1373,1374,','3','0','0','0','mo_category','id','','','','0','0','1','','','0','','','','1463121781','0');
insert into `ppf_tpl` values('1375','','mo_articles','','移动新闻管理','','0','1373','0,1372,1373,1375,','3','0','0','0','mo_articles','id','','','','0','0','1','','','0','','','','1463122893','0');
insert into `ppf_tpl` values('1376','','mo_advers','','移动首页广告','','0','1373','0,1372,1373,1376,','3','0','0','0','mo_advers','id','','','','0','0','1','','','0','','','','1463123330','0');
insert into `ppf_tpl` values('1377','','push','','博客推送','','0','169','0,4,169,1377,','3','0','5','0','push_list','id','','','','0','0','1','','','0','','','','1463642035','0');
insert into `ppf_tpl` values('1378','','push_cate','','推送类别','','0','1317','0,4,1317,1378,','3','0','5','0','push_category','id','','','','0','0','1','','','0','','','','1463726300','0');
insert into `ppf_tpl` values('1379','','sys_tpl_school','','School模板','','0','1364','0,2,1364,1379,','3','0','0','0','sys_tpl_school','id','','','','0','0','1','','','0','','','','1466761962','0');
insert into `ppf_tpl` values('1380','','sys_tpl_famous','','Famous模板','','0','1364','0,2,1364,1380,','3','0','0','0','sys_tpl_famous','id','','','','0','0','1','','','0','','','','1466761969','0');
insert into `ppf_tpl` values('1381','','recommend_reply','','图书推荐点评','','0','3','0,3,1381,','2','0','0','0','recommend_reply','id','','','','0','0','time','','','0','','','','1467258591','0');
insert into `ppf_tpl` values('1382','','art_cate_role','','文章权限管理','','0','199','0,2,199,1382,','3','0','0','0','main_art_category','id','','','','0','0','1','','','0','','','','1472464548','0');
insert into `ppf_tpl` values('1383','','','','连云教育','','0','0','0,1383,','1','1','0','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('1384','','','','在线咨询','','0','1383','0,1383,1384,','2','2','0','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('1385','','consult_art_category','','咨询栏目','','0','1384','0,1383,1384,1385,','3','0','0','0','consult_art_category','id','','','','0','0','time','','','0','','','','1477422451','0');
insert into `ppf_tpl` values('1386','','consult_art','','咨询页面','','0','1384','0,1383,1384,1386,','3','0','0','0','consult_art','id','','','','0','0','time','','','0','','','','1477422462','0');
insert into `ppf_tpl` values('1387','','osa_menu_url','','man功能菜单','','0','1389','0,1389,1387,','0','0','0','0','osa_menu_url','menu_id','','','','0','0','1','','','0','','','','0','0');
insert into `ppf_tpl` values('1388','','osa_user_group','','用户组','','0','1389','0,1389,1388,','0','0','0','0','osa_user_group','group_id','','','','0','0','1','','','0','','','','1482932253','1');
insert into `ppf_tpl` values('1389','','','','管理员后台','','0','0','0,1389,','1','4','0','0','','','','','','0','0','','','','0','','','','0','0');
insert into `ppf_tpl` values('1390','','sys_config','','系统配置','','0','1389','0,1389,1390,','2','0','0','0','sys_config','id','','','','0','0','1','','','0','','','','1482458518','0');
insert into `ppf_tpl` values('1391','','links','','友情链接','','0','1389','0,1389,1391,','2','0','0','0','links','id','','','','0','0','1','','','0','','','','1482604935','0');
insert into `ppf_tpl` values('1392','','template','','首页与栏目页模板管理','','0','3','0,3,1392,','2','0','0','0','template','id','','','','0','0','1','','','0','','','','1491549784','0');
insert into `ppf_tpl` values('1393','','global_tag','','全局标签','','0','3','0,3,1393,','2','0','0','0','global_tag','id','','','','0','0','1','','','0','','','','1491654407','0');
insert into `ppf_tpl` values('1394','','topic','','专题管理','','0','3','0,3,1394,','2','0','0','0','topic','id','','','','0','0','1','','','0','','','','1493263406','0');
unlock tables;

drop table if exists `ppf_tpl_default`;
CREATE TABLE `ppf_tpl_default` (
  `id` int(11) NOT NULL,
  `ptid` int(11) DEFAULT NULL,
  `col` varchar(50) DEFAULT NULL,
  `val` varchar(60) DEFAULT NULL,
  `odx` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `ppf_tpl_default` write;
insert into `ppf_tpl_default` values('1','11','tbldefault','0','0','1397095319');
insert into `ppf_tpl_default` values('2','11','tblunique','0','0','0');
insert into `ppf_tpl_default` values('3','11','ishtm','0','0','0');
insert into `ppf_tpl_default` values('4','118','lgnums','0','0','1397098037');
insert into `ppf_tpl_default` values('5','117','hidden','0','0','1397106530');
insert into `ppf_tpl_default` values('6','118','timestamp','0','0','1397106577');
insert into `ppf_tpl_default` values('8','11','treeis','0','0','1397107979');
insert into `ppf_tpl_default` values('9','11','hidden','0','0','1397119352');
insert into `ppf_tpl_default` values('10','11','childnums','0','0','1397119357');
insert into `ppf_tpl_default` values('11','11','odx','0','0','1397119361');
insert into `ppf_tpl_default` values('12','142','state','2','0','1397199374');
insert into `ppf_tpl_default` values('13','210','skey','md5(UNIX_TIMESTAMP())','0','1401265787');
insert into `ppf_tpl_default` values('14','209','unit','0','0','1401852771');
insert into `ppf_tpl_default` values('15','209','ispublic','0','0','1401852713');
insert into `ppf_tpl_default` values('16','209','isdefault','0','0','1401852722');
insert into `ppf_tpl_default` values('17','172','face','0','0','1407319386');
insert into `ppf_tpl_default` values('18','172','gold','0','0','1402994827');
insert into `ppf_tpl_default` values('19','172','credit','0','0','1402994832');
insert into `ppf_tpl_default` values('20','172','integral','0','0','1402994838');
insert into `ppf_tpl_default` values('21','175','tid','1','0','1404207233');
insert into `ppf_tpl_default` values('22','172','nick','UNIX_TIMESTAMP()','0','1407319592');
insert into `ppf_tpl_default` values('23','226','key','md5(now())','0','1410505998');
insert into `ppf_tpl_default` values('24','173','state','0','0','1412824337');
insert into `ppf_tpl_default` values('25','173','default','0','0','1412844642');
insert into `ppf_tpl_default` values('26','243','state','0','0','1414115060');
insert into `ppf_tpl_default` values('27','243','del','0','0','1414115079');
unlock tables;

drop table if exists `ppf_tpl_display`;
CREATE TABLE `ppf_tpl_display` (
  `id` int(11) NOT NULL,
  `ptid` int(11) DEFAULT NULL,
  `col` varchar(50) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `odx` int(11) DEFAULT NULL,
  `hidden` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `ppf_tpl_display` write;
insert into `ppf_tpl_display` values('1','118','id','编号','0','0');
insert into `ppf_tpl_display` values('2','118','username','用户名','0','0');
insert into `ppf_tpl_display` values('3','118','name','名称','0','0');
insert into `ppf_tpl_display` values('4','118','lasttime','最后登录','0','0');
insert into `ppf_tpl_display` values('5','118','lastip','最后ip','3','0');
insert into `ppf_tpl_display` values('6','119','id','id','0','0');
insert into `ppf_tpl_display` values('7','119','name','name','0','0');
insert into `ppf_tpl_display` values('8','119','timestamp','timestamp','0','0');
insert into `ppf_tpl_display` values('9','129','name','荣誉称号或奖励名称','0','0');
insert into `ppf_tpl_display` values('10','129','sdate','获奖时间','0','0');
insert into `ppf_tpl_display` values('11','129','sdepart','授奖部门','0','0');
insert into `ppf_tpl_display` values('12','129','pic','证书','0','0');
insert into `ppf_tpl_display` values('13','130','name','处分','0','0');
insert into `ppf_tpl_display` values('14','130','des','原因','0','0');
insert into `ppf_tpl_display` values('15','130','sdate','时间','0','0');
insert into `ppf_tpl_display` values('16','130','sdepart','单位或部门','0','0');
insert into `ppf_tpl_display` values('17','130','pic','证书','0','0');
insert into `ppf_tpl_display` values('18','131','name','姓名','0','0');
insert into `ppf_tpl_display` values('19','131','y','年度','0','0');
insert into `ppf_tpl_display` values('20','131','subject','任教学科','0','0');
insert into `ppf_tpl_display` values('21','131','class','任教班级','0','0');
insert into `ppf_tpl_display` values('22','131','sign','签名','0','0');
insert into `ppf_tpl_display` values('23','132','name','名称','0','0');
insert into `ppf_tpl_display` values('24','132','atime','时间','0','0');
insert into `ppf_tpl_display` values('25','133','name','课题名称','0','0');
insert into `ppf_tpl_display` values('26','133','subject','学科','0','0');
insert into `ppf_tpl_display` values('27','133','class','班级','0','0');
insert into `ppf_tpl_display` values('28','133','teach','授课人','0','0');
insert into `ppf_tpl_display` values('29','133','sdate','时间','0','0');
insert into `ppf_tpl_display` values('30','133','signheadman','教研组长签字','0','0');
insert into `ppf_tpl_display` values('31','133','signpresident','分管校长签字','0','0');
insert into `ppf_tpl_display` values('32','134','name','课题名称','0','0');
insert into `ppf_tpl_display` values('33','134','lvl','课题级别','0','0');
insert into `ppf_tpl_display` values('34','134','sdate','日期','0','0');
insert into `ppf_tpl_display` values('35','134','des','承担的研究内容','0','0');
insert into `ppf_tpl_display` values('36','135','name','成果名称','0','0');
insert into `ppf_tpl_display` values('37','135','sdate','时间','0','0');
insert into `ppf_tpl_display` values('38','135','des','相关情况','0','0');
insert into `ppf_tpl_display` values('39','136','name','名称','0','0');
insert into `ppf_tpl_display` values('40','136','atime','时间','0','0');
insert into `ppf_tpl_display` values('41','137','name','课题','0','0');
insert into `ppf_tpl_display` values('42','137','lessontype','课型','0','0');
insert into `ppf_tpl_display` values('43','138','name','课题','0','0');
insert into `ppf_tpl_display` values('44','138','lvl','活动层次','0','0');
insert into `ppf_tpl_display` values('45','138','lessontype','课型','0','0');
insert into `ppf_tpl_display` values('46','138','atime','时间','0','0');
insert into `ppf_tpl_display` values('47','139','name','主题','0','0');
insert into `ppf_tpl_display` values('48','139','compere','主持人','0','0');
insert into `ppf_tpl_display` values('49','139','speaker','主讲人','0','0');
insert into `ppf_tpl_display` values('50','139','addr','地点','0','0');
insert into `ppf_tpl_display` values('51','139','atime','时间','0','0');
insert into `ppf_tpl_display` values('52','143','name','学校','0','0');
insert into `ppf_tpl_display` values('53','143','major','专业','0','0');
insert into `ppf_tpl_display` values('54','143','systme','学制','0','0');
insert into `ppf_tpl_display` values('55','143','education','学历','0','0');
insert into `ppf_tpl_display` values('56','143','sdate','时间','0','0');
insert into `ppf_tpl_display` values('57','144','corp','单位','0','0');
insert into `ppf_tpl_display` values('58','144','position','职位','0','0');
insert into `ppf_tpl_display` values('59','144','job','从事工作','0','0');
insert into `ppf_tpl_display` values('60','144','sdate','开始时间','0','0');
insert into `ppf_tpl_display` values('61','144','edate','结束时间','0','0');
insert into `ppf_tpl_display` values('62','150','name','名称','0','0');
insert into `ppf_tpl_display` values('63','150','odx','排序','0','0');
insert into `ppf_tpl_display` values('64','150','mininame','短名','0','0');
insert into `ppf_tpl_display` values('65','155','name','名称','0','0');
insert into `ppf_tpl_display` values('66','155','odx','排序','0','0');
insert into `ppf_tpl_display` values('67','156','id','编号','0','0');
insert into `ppf_tpl_display` values('68','156','username','用户名','0','0');
insert into `ppf_tpl_display` values('69','156','name','姓名','0','0');
insert into `ppf_tpl_display` values('70','156','units','单位','0','0');
insert into `ppf_tpl_display` values('71','156','departs','部门','0','0');
insert into `ppf_tpl_display` values('72','156','roles','角色','0','0');
insert into `ppf_tpl_display` values('73','203','name','名称','0','0');
insert into `ppf_tpl_display` values('74','203','odx','排序','0','0');
insert into `ppf_tpl_display` values('81','207','uname','用户名','0','0');
insert into `ppf_tpl_display` values('82','207','name','名称','0','0');
insert into `ppf_tpl_display` values('83','207','lgnums','登录次数','0','0');
insert into `ppf_tpl_display` values('84','207','lasttime','最后登录','0','0');
insert into `ppf_tpl_display` values('85','207','lastip','最后ip','0','0');
insert into `ppf_tpl_display` values('86','208','id','编号','0','0');
insert into `ppf_tpl_display` values('87','208','username','用户名','0','0');
insert into `ppf_tpl_display` values('88','208','nick','昵称','0','0');
insert into `ppf_tpl_display` values('89','208','lgnums','登录次数','0','0');
insert into `ppf_tpl_display` values('90','208','lasttime','最后登录','0','0');
insert into `ppf_tpl_display` values('92','210','sid','标识编号','0','0');
insert into `ppf_tpl_display` values('93','210','name','名称','0','0');
insert into `ppf_tpl_display` values('94','210','url','网址','0','0');
insert into `ppf_tpl_display` values('95','210','ip','ip','0','0');
insert into `ppf_tpl_display` values('96','211','id','id','0','0');
insert into `ppf_tpl_display` values('97','211','scode','组织编号','0','0');
insert into `ppf_tpl_display` values('98','211','name','名称','0','0');
insert into `ppf_tpl_display` values('99','211','mininame','短名称','0','0');
insert into `ppf_tpl_display` values('100','211','odx','排序','0','0');
insert into `ppf_tpl_display` values('101','210','skey','通信key','0','0');
insert into `ppf_tpl_display` values('102','210','pre','数据前缀','0','0');
insert into `ppf_tpl_display` values('103','208','units','单位','0','0');
insert into `ppf_tpl_display` values('104','203','id','编号','0','0');
insert into `ppf_tpl_display` values('105','215','id','编号','1','0');
insert into `ppf_tpl_display` values('106','215','name','名称','1','0');
insert into `ppf_tpl_display` values('107','215','odx','排序','1','0');
insert into `ppf_tpl_display` values('108','216','id','编号','0','0');
insert into `ppf_tpl_display` values('109','216','name','名称','0','0');
insert into `ppf_tpl_display` values('110','216','odx','排序','0','0');
insert into `ppf_tpl_display` values('111','220','id','id','0','0');
insert into `ppf_tpl_display` values('112','220','name','名称','0','0');
insert into `ppf_tpl_display` values('113','220','odx','排序','0','0');
insert into `ppf_tpl_display` values('114','221','id','编号','0','0');
insert into `ppf_tpl_display` values('115','221','idx','索引','0','0');
insert into `ppf_tpl_display` values('116','221','name','名称','0','0');
insert into `ppf_tpl_display` values('117','221','mdl','模块','0','0');
insert into `ppf_tpl_display` values('118','226','id','编号','0','0');
insert into `ppf_tpl_display` values('119','226','name','名称','0','0');
insert into `ppf_tpl_display` values('120','226','key','同步key','0','0');
insert into `ppf_tpl_display` values('121','226','unums','使用次数','0','0');
unlock tables;

drop table if exists `ppf_tpl_unique`;
CREATE TABLE `ppf_tpl_unique` (
  `id` int(11) NOT NULL,
  `ptid` int(11) DEFAULT NULL,
  `col` varchar(60) DEFAULT NULL,
  `note` varchar(60) DEFAULT NULL,
  `odx` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `ppf_tpl_unique` write;
insert into `ppf_tpl_unique` values('1','11','tpl','模板名不能重复','0','1397095314');
insert into `ppf_tpl_unique` values('2','11','id','编号不能重复','0','1397094203');
insert into `ppf_tpl_unique` values('3','118','username','用户名存在重复','1','1397098003');
insert into `ppf_tpl_unique` values('4','141','username','用户名已存在','0','1397197412');
insert into `ppf_tpl_unique` values('5','141','mobile','手机号已存在','0','1397197343');
insert into `ppf_tpl_unique` values('6','141','email','邮箱已存在','0','1397197355');
insert into `ppf_tpl_unique` values('7','141','cardno','身份证已存在','0','1397197368');
insert into `ppf_tpl_unique` values('8','189','tpl','模块名存在相同','0','1397294320');
insert into `ppf_tpl_unique` values('9','210','sid','标识必须唯一','0','1401178310');
insert into `ppf_tpl_unique` values('10','172','username','用户名已存在','0','1401935661');
insert into `ppf_tpl_unique` values('11','172','mobile','手机号已存在','0','1401935687');
insert into `ppf_tpl_unique` values('12','172','email','邮箱已存在','0','1401935695');
insert into `ppf_tpl_unique` values('13','119','id','编号必须唯一2','0','1410231970');
insert into `ppf_tpl_unique` values('14','119','name','你好','0','1410232233');
insert into `ppf_tpl_unique` values('15','237','username','用户名存在','0','1413271925');
insert into `ppf_tpl_unique` values('16','237','mobile','手机号存在','0','1413271937');
insert into `ppf_tpl_unique` values('17','237','email','邮箱存在','0','1413271952');
insert into `ppf_tpl_unique` values('18','228','dns','域名存在重复','0','1441679080');
insert into `ppf_tpl_unique` values('19','228','name','学校名称已存在','0','1443163154');
insert into `ppf_tpl_unique` values('20','228','scode','组织机构代码已存在','0','1443163170');
insert into `ppf_tpl_unique` values('21','228','mininame','简称已存在','0','1443163193');
unlock tables;

drop table if exists `sys_config`;
CREATE TABLE `sys_config` (
  `id` int(11) NOT NULL DEFAULT '1',
  `web_name` varchar(255) DEFAULT NULL,
  `web_url` varchar(255) DEFAULT NULL,
  `web_keyword` varchar(255) DEFAULT NULL,
  `web_des` varchar(255) DEFAULT NULL,
  `web_email` varchar(32) DEFAULT NULL,
  `web_tel` varchar(32) DEFAULT NULL,
  `web_icp` varchar(32) DEFAULT NULL,
  `web_state` tinyint(4) DEFAULT '1',
  `web_close_reason` text,
  `db_database` varchar(32) DEFAULT 'mysql',
  `db_host` varchar(32) DEFAULT 'localhost',
  `db_port` int(11) DEFAULT '3306',
  `db_user` varchar(32) DEFAULT 'root',
  `db_pwd` varchar(32) DEFAULT NULL,
  `db_name` varchar(32) DEFAULT NULL,
  `db_charset` varchar(32) DEFAULT 'utf8',
  `app_state` tinyint(4) DEFAULT '0' COMMENT '是否开启统一登录',
  `app_login` varchar(255) DEFAULT NULL,
  `app_url` varchar(255) DEFAULT NULL,
  `app_id` int(11) DEFAULT NULL,
  `app_key` int(11) DEFAULT NULL,
  `app_orgid` int(11) DEFAULT NULL,
  `app_opta` tinyint(4) DEFAULT '0' COMMENT '统一登录是否对其他机构开放',
  `app_opta_oid` text COMMENT '对指定机构开放的机构id字符串',
  `s_state` tinyint(4) DEFAULT '0',
  `s_root_path` varchar(255) DEFAULT './shtm',
  `s_expir` int(11) DEFAULT '7',
  `s_auto_clean` tinyint(4) DEFAULT '1',
  `s_auto_clean_expir` int(11) DEFAULT '15',
  `timer` int(11) DEFAULT '1490067073',
  `dbback_root_path` varchar(255) DEFAULT './dbback',
  `template_root_path` varchar(255) DEFAULT './html',
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

lock tables `sys_config` write;
insert into `sys_config` values('1','cms测试','','cms测试','cms测试','','025-57217471','苏ICP备09001585号','1','','mysql','localhost','3308','root','','hcms_db','utf8','0','http://uc.jssns.cn/','http://uc.jssns.cn/api/jsonp/','0','0','0','1','','0','./shtm','7','1','15','1490252441','./dbback','./html','1493024494');
unlock tables;

drop table if exists `template`;
CREATE TABLE `template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `fileext` varchar(20) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

lock tables `template` write;
insert into `template` values('1','首页','index','htm','','1','1491662770');
insert into `template` values('2','文章列表页','arts','htm','','1','1491662782');
insert into `template` values('4','测试','arts2','htm','','1','1491896133');
insert into `template` values('5','文章页','art','htm','','2','1492564501');
unlock tables;

drop table if exists `topic`;
CREATE TABLE `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `dname` varchar(100) DEFAULT NULL,
  `odx` smallint(6) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

lock tables `topic` write;
insert into `topic` values('1','专题一','topic1','1','1494210460');
insert into `topic` values('2','专题二','topic2','2','1493263949');
insert into `topic` values('3','专题三','topic3','3','1493273244');
unlock tables;
