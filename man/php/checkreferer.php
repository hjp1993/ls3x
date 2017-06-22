<?php
/*主站 管理中心 */
header("Content-type: text/html; charset=utf-8;");
if(empty($_SERVER['HTTP_REFERER']))
{
echo "文件禁止直接访问！";
exit;
}