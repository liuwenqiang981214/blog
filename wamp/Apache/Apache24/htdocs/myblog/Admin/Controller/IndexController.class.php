<?php
//声明命名空间
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\IndexModel;
//定义首页控制器类
final class IndexController extends BaseController{
	


	public function index(){
		
		$this->denyAccess();
		
		$this->smarty->display("index.html");
	}
	public function top(){
		$this->smarty->display("top.html");
	}
	public function left(){
		$this->smarty->display("left.html");
	}
	public function center(){
		$this->smarty->display("center.html");
	}
	public function main(){
		$this->smarty->display("main.html");
	}
}