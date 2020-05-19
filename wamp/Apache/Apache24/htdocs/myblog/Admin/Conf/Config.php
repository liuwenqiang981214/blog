<?php
//返回配置的数组
return array(
	//数据库配置信息
	'db_type' => 'mysql',
	'db_host' => 'localhost',
	'db_port' => '3306',
	'db_user' => 'root',
	'db_pass' => 'root',
	'db_name' => 'blog',
	'charset' => 'utf8',
	//默认路由设置
	'default_platform'   => 'Admin',
	'default_controller' => 'Index',
	'default_action'     => 'index',
	);