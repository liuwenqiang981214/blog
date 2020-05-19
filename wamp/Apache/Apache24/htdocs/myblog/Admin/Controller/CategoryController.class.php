<?php
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\CategoryModel;

final class CategoryController extends BaseController
{
	private function getCategoryList()
	{
		$categorys=CategoryModel::getInstance()->fetchAll(1,"orderby ASC");
		$categorys=CategoryModel::getInstance()->categoryList($categorys);
		return $categorys;
	}

	public function index()
	{
		$this->denyAccess();
		$categorys=$this->getCategoryList();
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("Category\Index.html");
	}
	public function add()
	{
		$this->denyAccess();
		$categorys=$this->getCategoryList();
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("Category\Add.html");

	}
	public function insert()
	{
		$this->denyAccess();
		$data['classname']=$_POST['classname'];
		$data['orderby']  =$_POST['orderby'];
		$data['pid']      =$_POST['pid'];
		if (CategoryModel::getInstance()->insert($data)) {
			$this->jump("添加分类成功","?c=Category&a=index");
		}
	}
	public function edit()
	{
		$this->denyAccess();
		$id=$_GET['id'];

		$oldCategory=CategoryModel::getInstance()->fetchOne($id);
		$this->smarty->assign("oldCategory",$oldCategory);

		$categorys=$this->getCategoryList();
		$this->smarty->assign("categorys",$categorys);

		$this->smarty->display("Category\Edit.html");
	}
	public function update()
	{
		$this->denyAccess();
		$id=$_GET['id'];
		$data['classname']=$_POST['classname'];
		$data['orderby']  =$_POST['orderby'];
		$data['pid']      =$_POST['pid'];
		if (CategoryModel::getInstance()->update($data,$id)) {
			$this->jump("修改数据成功","?c=Category&a=index");
		}
	}
	public function delete()
	{
		$this->denyAccess();
		$id=$_GET['id'];
		if (CategoryModel::getInstance()->delete($id)) {
			$this->jump("删除数据成功","?c=Category&a=index");
		}
	}

}