<?php
//声明命名空间
namespace Home\Controller;
use \Frame\Libs\BaseController;
use \Home\Model\IndexModel;
use \Home\Model\ArticleModel;
use \Home\Model\CommentModel;
use \Frame\Vendor\Pager;
//定义首页控制器类
final class IndexController extends BaseController{
	
	public function index()
	{
		$this->show("index.html",3);
	}

	public function list()
	{
		$this->show("list.html",28);

	}
	public function content()
	{
		$id=$_GET['id'];
		$Article=ArticleModel::getInstance()->showArticle($id);

		$pageArr[] = ArticleModel::getInstance()->fetchOne("id>$id","id asc");
		
		$pageArr[] = ArticleModel::getInstance()->fetchOne("id<$id");

		$comments=CommentModel::getInstance()->commentList(
			CommentModel::getInstance()->fetchAllWithJoin("article_id=$id")
			);

		$this->smarty->assign(array(
			'comments'=>$comments,
			'pageArr'=>$pageArr,
			'Article'=>$Article,
			));
		$this->smarty->display("content.html");
	}
	private function show($target="index.html",$size=5)
	{
		$id=$_SESSION['uid'];
		$records=ArticleModel::getInstance()->rowCount('user_id='.$id);		
		
		
		$pagesize=$size;
		$page=isset($_GET['page'])?$_GET['page']:1;
		$startrow=($page-1)*$pagesize;
		$params=array('c'=>CONTROLLER,'a'=>ACTION);

		$articles=ArticleModel::getInstance()->fetchWithJoin(
			$startrow,$pagesize,'user_id='.$id,'addate DESC');

		$PageObj=new Pager($records,$pagesize,$page,$params);
		$PageStr=$PageObj->showPage();
		$PageCount=ceil($records/$pagesize);
		$this->smarty->assign(array(
			'PageCount'=>$PageCount,
			'articles'=>$articles,
			'PageStr'=>$PageStr,
			));
		$this->smarty->display($target);
	}
}