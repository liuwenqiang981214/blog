<?php
//声明命名空间
namespace Frame;
//定义最终的框架初始类
final class Frame
{
	//公共静态方法框架初始化方法
	public static function run(){
		//初始化字符集
		self::initCharset();
		//初始化错误显示方式
		self::initPhpErr();
		//初始化配置信息
		self::initConfig();
		//初始化路由参数
		self::initRoute();
		//初始化常量定义
		self::initConst();
		//初始化类的自动加载
		self::initAutoLoad();
		//初始化请求分发
		self::initDispatch();
	}
	private static function initCharset(){
		header("content-type:text/html;charset=utf-8");
	}
	private static function initPhpErr(){
		//修改php的脚本级配置:是否显示错误
		ini_set("display_errors","on");
		ini_set("error_reporting",E_ALL|E_STRICT);
	}
	private static function initConfig(){

		//开启session
		session_start();

		$GLOBALS['config'] = require_once(APP_PATH."Conf".DS."Config.php");
	}
	private static function initRoute(){
		$p=$GLOBALS['config']['default_platform'];
		$c=isset($_GET['c']) ? $_GET['c']:$GLOBALS['config']['default_controller'];
		$a=isset($_GET['a']) ? $_GET['a']:$GLOBALS['config']['default_action'];
		define("PLAT",$p);
		define("CONTROLLER",$c);
		define("ACTION",$a);
	}
	private static function initConst(){
		define("FRAME_PATH", ROOT_PATH."Frame".DS);
		define("VIEW_PATH", APP_PATH."View".DS);
	}
	private static function initAutoLoad(){
		spl_autoload_register(function($classname){
			$fliename=ROOT_PATH.str_replace("\\",DS,$classname).".class.php";
			if (file_exists($fliename)) {
				require_once($fliename);
			}
		});
	}
	private static function initDispatch(){
		$c=PLAT."\\Controller\\".CONTROLLER."Controller";
		$controllerObj=new $c();
		$a=ACTION;
		$controllerObj->$a();
	}
}
