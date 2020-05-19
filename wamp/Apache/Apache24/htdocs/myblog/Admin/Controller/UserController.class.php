<?php
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\UserModel;
use \Frame\Vendor\Captcha;
class UserController extends BaseController
{	


	public function index()
	{

		$this->denyAccess();
		$modelObj= UserModel::getInstance();

		$users=$modelObj->fetchAll("2>1","id ASC");
		$this->smarty->assign(array(
			'users' => $users,	
		));
		$this->smarty->display("User/Index.html");
	}

	public function login()
	{
		$this->smarty->display("User/Login.html");
	}
	public function loginCheck()
	{
		$username=$_POST['username'];
		$password=md5($_POST['password']);
		$verify  =$_POST['verify'];
		//判断验证码
		if (strtolower($verify)!=$_SESSION['captcha']) {
			$this->jump("验证码输入有误","?c=User&a=login");
		}
		//判断用户名和密码
		$user=UserModel::getInstance()->fetchOne("username='$username' and password='$password'");
		if (!$user) {
			$this->jump("用户名或密码不正确","?c=User&a=login");
		}
		if (!$user['status']) {
			$this->jump("账号被停用,请与大吊强联系","?c=User&a=login");
		}
		//更新用户数据
		$data['last_login_ip']  =$_SERVER['REMOTE_ADDR'];
		$data['last_login_time']=time();
		$data["login_times"]    =$user['login_times']++;
		if (!UserModel::getInstance()->update($data,$user['id'])) {
			$this->jump("登入异常","?c=User&a=login");
		}

		//将用户状态存入SESSION
		$_SESSION['uid']     =$user['id'];
		$_SESSION['username']=$user['username'];
		$_SESSION['role']    =$user['role'];

		if ($user['role']==1) {
			header("location:./admin.php");
			die();
		}
		header("location:./index.php");
	}

	//获取验证码的方法
	public function captcha()
	{
		$captcha=new Captcha();

		$_SESSION['captcha']=$captcha->getCode();
	}

	public function add()
	{
		$this->denyAccess();
		$this->smarty->display("User/add.html");
	}

	public function insert()
	{
		$this->denyAccess();
		$data['username']=$_POST['username'];
		$data['password']=md5($_POST['password']);
		    $data['name']=$_POST['name'];
		     $data['tel']=$_POST['tel'];
		  $data['status']=$_POST['status'];
		    $data['role']=$_POST['role'];
		  $data['addate']=time(); 
		//判断用户是否已经存在
		if (UserModel::getInstance()->rowCount("username='{$data['username']}'")) 
		{
			 $this->jump("用户名{$data['username']}已经被注册了!","?c=User&a=add");
		}
		if ($data['password']!=md5($_POST['confirmpwd'])) 
		{
		 	$this->jump("两次输入密码不一致!","?c=User&a=add");
		}
		if (UserModel::getInstance()->insert($data)) 
		{
		 	$this->jump("用户添加成功","?c=User");
		}else
		{
			$this->jump("用户添加失败","?c=User&a=add");
		} 

	}

	public function delete()
	{
		$this->denyAccess();
		$id=$_GET['id'];
		if (UserModel::getInstance()->delete($id)) 
		{
			$this->jump("id={$id}记录删除成功","?c=User");	
		}else
		{
			$this->jump("id={$id}记录删除失败","?c=User");
		}
	}
	public function Edit()
	{
		$this->denyAccess();
		$id=$_GET['id'];
		//向后台请求该id数据
		$user=UserModel::getInstance()->fetchOne("id=$id");
		$this->smarty->assign("user",$user);
		$this->smarty->display("User/Edit.html");

	}

	public function update()
	{
		$this->denyAccess();
		$id=$_GET['id'];
		

		    $data['name']=$_POST['name'];
		     $data['tel']=$_POST['tel'];
		  $data['status']=$_POST['status'];
		    $data['role']=$_POST['role'];

		if (md5($_POST['password'])!=md5($_POST['confirmpwd'])) 
		  {
		 	$this->jump("两次输入密码不一致!","?c=User&a=Edit&id=$id");
		  }
		if (!empty($_POST['password'])) 
		{
			$data['password']=md5($_POST['password']);
		} 
		
		if (UserModel::getInstance()->update($data,$id)) 
		{
		 	$this->jump("用户修改成功","?c=User");
		}else
		{
			$this->jump("用户修改失败","?c=User&a=Edit&id=$id");
		} 
	}
	
	public function logout()
	{
		unset($_SESSION['username']);
		unset($_SESSION['uid']);
		session_destroy();
		header("location:./admin.php?c=User&a=login");
	}
}