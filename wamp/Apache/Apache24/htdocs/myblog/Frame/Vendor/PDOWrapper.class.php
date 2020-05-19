<?php
namespace Frame\Vendor;
use \PDO;
use \PDOException;
final class PDOWrapper
{
	private $db_type;//数据库类型
	private $db_host;
	private $db_port;
	private $db_user;
	private $db_pass;
	private $db_name;
	private $charset;
	private $pdo;

	public function __construct()
	{
		$this->db_type=$GLOBALS['config']['db_type'];
		$this->db_host=$GLOBALS['config']['db_host'];
		$this->db_port=$GLOBALS['config']['db_port'];
		$this->db_user=$GLOBALS['config']['db_user'];
		$this->db_pass=$GLOBALS['config']['db_pass'];
		$this->db_name=$GLOBALS['config']['db_name'];
		$this->charset=$GLOBALS['config']['charset'];
		$this->createPDO();//设置pdo对象
		$this->setErrMode();//设置报错格式
	}
	
	//私有的创建PDO对象的方 法
	private function createPDO()
	{
		try
		{
			$dsn="{$this->db_type}:host={$this->db_host};port={$this->db_port};dbname={$this->db_name};charset={$this->charset}";
			//pdo默认根目录下的pdo 加了命名空间后需要加一个前缀"\"
			$this->pdo=new PDO($dsn,$this->db_user,$this->db_pass);
		}catch(PDOException $e)
		{
			echo "<h2>创建PDO对象失败</h2>";
			$this->showErrMsg($e);
		}
	}

	private function setErrMode()
	{
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}

	//执行SQL语句：非select;
	public function exec($sql)
	{
		try
		{
			return $this->pdo->exec($sql);
		}catch(PDOException $e)
		{
			echo "<h2>执行SQL语句失败</h2>";
			$this->showErrMsg($e);
		}
	}
	//获取单行数据
	public function fetchOne($sql)
	{
		try
		{
				//执行sql语句
			$PDOStatement=$this->pdo->query($sql);
			return $PDOStatement->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e)
		{
			echo "<h2>执行SQL语句失败</h2>";
			$this->showErrMsg($e);	
		}
	}
	//获取多行数据
	public function fetchAll($sql)
	{
		try
		{
			//执行sql语句
			$PDOStatement=$this->pdo->query($sql);
			return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e)
		{
			echo "<h2>执行SQL语句失败</h2>";
			$this->showErrMsg($e);	
		}
	}
	//获取记录数
	public function rowCount($sql)
	{
		try
		{
			$PDOStatement=$this->pdo->query($sql);
			return $PDOStatement->rowCount();
		}catch(PDOException $e)
		{
			$this->showErrMsg($e);
		}
	}
	//显示错误信息的方法
	private function showErrMsg($e)
	{
			echo "错误编号:".$e->getCode();
			echo "<br>错误行号:".$e->getLine();
			echo "<br>错误文件:".$e->getFile();
			echo "<br>错误信息:".$e->getMessage();
			die();
		
	}
	
}