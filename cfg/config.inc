<?php
//网站信息配置
define('WEB_NAME', '溧水区第三小学');//网站名称
define('WEB_URL', '');//网站地址
define('WEB_KEYWORD', '溧水区第三小学');//网站关键词，多个用逗号隔开
define('WEB_DES', '溧水区第三小学');//网站描述
define('WEB_EMAIL', '');//管理员邮箱
define('WEB_TEL', '025-57217471');//联系电话
define('WEB_ICP', '苏ICP备09001585号');//备案信息
define('WEB_STATE', '1');//网站状态
define('WEB_CLOSE_REASON', '');//网站关闭原因

//数据库配置
define('DB_DATABASE', 'mysql');//数据库类型
define('DB_HOST', 'localhost');//主机名
define('DB_PORT', '3306');//端口
define('DB_USER', 'root');//用户名
define('DB_PWD', '');//密码
define('DB_NAME', 'ls3x_db');//数据库名
define('DB_CHARSET', 'utf8'); //数据库字符集 utf8

//统一登录配置
define('APP_STATE', '0');//是否开启统一登录
define('APP_LOGIN', 'http://uc.jssns.cn/');//统一登陆地址
define('APP_URL', 'http://uc.jssns.cn/api/jsonp/');//统一登录接口地址
define('APP_ID', '0');//当前网站ID
define('APP_KEY', '0');//当前网站key
define('APP_ORGID', '0');//当前网站所属机构ID
define('APP_OPTA', '1');//是否对其他机构开放
define('APP_OPTA_OID', '');//指定可统一登录的其他机构id

//公共全局变量
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DATA_PRE', 'a');
define('LR_NAME', '冠邦CMS');  
define('LR_VER', 'ver1.0');

//静态化
define('S_STATE', '0');//是否开启静态化功能
define('S_ROOT_PATH', './shtm');//静态文件目录
define('S_EXPIR', '7');//静态文件有效期(整数天，超过有效期则重新创建该文件)
define('S_AUTO_CLEAN', '1');//是否开启自动清理(默认开启)
define('S_AUTO_CLEAN_EXPIR', '15');//自动清理的间隔时间(整数天，默认15，即15天清理一次超过有效期的静态文件)
define('TIMER', '1490067073');//定时器任务时间戳

//数据库备份
define('DBBACK_ROOT_PATH', './dbback');//备份数据库文件目录

//模板相关设置
define('TEMPLATE_ROOT_PATH', './html');//模板文件目录

//文件缓存(与静态化的文件缓存分开,存储栏目数据、标签数据等,重要配置,不允许用户自定义)
define('CACHE_ROOT_PATH', './cache');//缓存目录
define('CACHE_EXPIR', '7');//缓存有效期

?>