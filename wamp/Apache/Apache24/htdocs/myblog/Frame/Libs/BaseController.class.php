<?php
namespace Frame\Libs;

//基础控制器
abstract class BaseController
{
	protected $smarty;

	public function __construct()
	{
		//创建Smarty类的对象
		$smarty= new \Frame\Vendor\Smarty();
		//配置Smarty
		$smarty->left_delimiter="<{";
		$smarty->right_delimiter="}>";
		$smarty->setCompileDir(sys_get_temp_dir().DS."view_c".DS);
		//指定视图目录
		$smarty->setTemplateDir(VIEW_PATH);
		$this->smarty= $smarty;
	}

	protected function denyAccess()
	{
		if (empty($_SESSION['username'])) {
			$this->jump("您还未登录,请先登录","?c=User&a=login",1);
		}
		if ($_SESSION['role']==0) {
			$this->jump("权限不足","./index.php");
		}
	}

	//跳转方法
	protected function jump($message,$url='?',$time=3)
	{
		/*echo "<h2 align='center'>{$message}</h2>";
		header("refresh:{$time};url={$url}");*/
		$this->smarty->assign(array(
			'message'=>$message,
			'url'	 =>$url,
			'time'	 =>$time
			));
		$this->smarty->display("jump.html");
		die();
	}
}