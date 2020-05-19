<?php
namespace Admin\Controller;
use Frame\Libs\BaseController;
use Admin\Model\ArticleModel;
use Admin\Model\CategoryModel;
use Frame\Vendor\Pager;

final class ArticleController extends BaseController
{
	public function index()
	{
		$this->denyAccess();
		$categorys=CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll(1,"orderby ASC"));

		//文章分页
		$pagesize=10;//每页显示十条数据
		$page=isset($_GET['page'])?$_GET['page']:1;//获取当前页码
		$startrow=($page-1)*$pagesize;//开始行号
		$params=array('c'=>CONTROLLER,'a'=>ACTION);//指定需要分页的控制器与方法路径

		//搜索过滤
		//初始化搜索条件
		$search['category']=-1;
		$search['keyword']="";

		$where="1";
		if (!empty($_POST['category_id'])) {
			$where.=" AND category_id={$_POST['category_id']} ";
			$search['category']=$_POST['category_id'];
		}
		if (!empty($_POST['keyword'])) {
			$where.=" AND title Like '%{$_POST['keyword']}%'";
			$search['keyword']=$_POST['keyword'];
		}
		
		$records=ArticleModel::getInstance()->rowCount($where);

		$Articles=ArticleModel::getInstance()->fetchWithJion($startrow,$pagesize,$where);

		
		$PageObj=new Pager($records,$pagesize,$page,$params);
		$PageStr=$PageObj->showPage();

		$this->smarty->assign(array(
			"search"=>$search,
			"PageStr"=>$PageStr,   
			"Articles"=>$Articles,
			"categorys"=>$categorys,
			));
		$this->smarty->display("Article\Index.html");
	}
	public function add()
	{
		$this->denyAccess();
		$categorys=CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll(1,"orderby ASC"));
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("Article\Add.html");
	}
	public function edit()
	{
		$this->denyAccess();
		$id=$_GET['id'];

		$oldArticle=ArticleModel::getInstance()->fetchOne("id=$id");

		$categorys=CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll(1,"orderby ASC"));

		$this->smarty->assign("oldArticle",$oldArticle);
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("Article\Edit.html");
	}
	public function update()
	{
		$this->denyAccess();
		$id=$_POST['id'];
		$data['category_id']=$_POST['category_id'];
		$data['title']=$_POST['title'];
		$data['orderby']=$_POST['orderby'];
		$data['content']=$_POST['content'];
		if (isset($_POST['top'])) {
			$data['top']=1;
		}else
		{
			$data['top']=0;
		}
		if (ArticleModel::getInstance()->update($data,$id)) {
			$this->jump("修改完成","?c=Article&a=index");
		}
	}
}