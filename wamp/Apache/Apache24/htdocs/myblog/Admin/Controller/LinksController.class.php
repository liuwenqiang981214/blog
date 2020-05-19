<?php
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\LinksModel;

final class LinksController extends BaseController
{
	public function index()
	{
		$this->denyAccess();
		$links=LinksModel::getInstance()->fetchAll();
		$this->smarty->assign("links",$links);
		$this->smarty->display("Links\index.html");
	}

	public function add()
	{
		$this->denyAccess();
		$this->smarty->display("Links\add.html");
	}
	public function insert()
	{
		$this->denyAccess();
		$data['domain'] =$_POST['domain'];
		$data['url']    =$_POST['url'];
		$data['orderby']=$_POST['orderby'];
		$modelobj = LinksModel::getInstance();
		//判断域名是否已经存在
		if ($modelobj->rowCount("domain='{$data['domain']}'")) 
		{
			 $this->jump("域名{$data['domain']}已经存在","?c=Links&a=add");
		}
		if ($modelobj->insert($data)) 
		{
		 	$this->jump("链接添加成功","?c=Links");
		}else
		{
			$this->jump("链接添加失败","?c=Links&a=add");
		} 
	}
	public function edit()
	{
		$id=$_GET['id'];
		$link=LinksModel::getInstance()->fetchOne("id=$id");
		$this->smarty->assign("link",$link);
		$this->smarty->display("Links\linkedit.html");
	}
	public function delete()
	{
		$id=$_GET['id'];
		if (LinksModel::getInstance()->delete($id)) 
		{
			$this->jump("删除成功","?c=Links&a=index");
		}
	}
}
