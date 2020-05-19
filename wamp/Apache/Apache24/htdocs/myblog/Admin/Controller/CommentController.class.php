<?php
namespace Admin\Controller;
use Frame\Libs\BaseController;
use Admin\Model\CommentModel;
use Frame\Vendor\Pager;
final class CommentController extends BaseController
{
	public function index()
	{
		$this->denyAccess();
		//文章分页
		$pagesize=10;//每页显示十条数据
		$page=isset($_GET['page'])?$_GET['page']:1;//获取当前页码
		$startrow=($page-1)*$pagesize;//开始行号
		$params=array('c'=>CONTROLLER,'a'=>ACTION);

		$where="1 ";
		$search="";
		if (!empty($_POST['keyword'])) {
			$where.=" AND 
			username LIKE '%{$_POST['keyword']}%' OR 
			comment.content LIKE '%{$_POST['keyword']}%' OR 
			title LIKE '%{$_POST['keyword']}%' ";
			$search=$_POST['keyword'];
		}
		$records=CommentModel::getInstance()->rowCount($where);

		$pageObj=new Pager($records,$pagesize,$page,$params);
		$pageStr=$pageObj->showPage();

		$comments=CommentModel::getInstance()->fetchWithJoin($startrow,$pagesize,$where);

		$this->smarty->assign(array(
			'search'=>$search,
			'pageStr'=>$pageStr,
			'comments'=>$comments,
			));
		$this->smarty->display("Comment\Index.html");
	}
	public function delete()
	{
		$id=$_GET['id'];
		if (CommentModel::getInstance()->delete($id)) {
			$this->jump("删除成功","?c=Comment&a=index");
		}
	}
}