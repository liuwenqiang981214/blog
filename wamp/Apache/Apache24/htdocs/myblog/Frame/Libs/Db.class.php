<?php
namespace Frame\Libs;
//定义一个final单例操作数据库的类
final class Db{
	private static $obj=NULL;

	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	private $charset;

	//私有构造方法 组织类外new
	private function __construct(){
		$this->db_host=$GLOBALS['config']['db_host'];
		$this->db_user=$GLOBALS['config']['db_user'];
		$this->db_pass=$GLOBALS['config']['db_pass'];
		$this->db_name=$GLOBALS['config']['db_name'];
		$this->charset=$GLOBALS['config']['charset'];
		$this->connMySQL();
		$this->selectDb();
		$this->setCharacter();
	}
	//私有克隆方法 防止类外clone
	private function __clone(){}

	//公共静态创建对象的方法
	public static function getInstance()
	{
		//判断对象是否存在？返回：创建
		if (!self::$obj instanceof self) {
			self::$obj=new self();
		}
		return self::$obj;
	}

	//私有的连接数据库方法
	private function connMySQL(){
		if (!$link=@mysql_connect($this->db_host,$this->db_user,$this->db_pass)) 
		{
			exit("PHP连接数据库失败");
		}
	}

	private function setCharacter()
	{
		$this->exec("set names {$this->charset}");
	}

	//公共的执行sql语句方法 insert update delete set
	public function exec($sql=NULL)
	{
		$sql=strtolower($sql);

		if(substr($sql,0,6)=="select")
		{
			exit("select语句请调用其他方法")
		}
		return mysql_query($sql);
	}

	private function query($sql=NULL)
	{
		$sql=strtolower($sql);

		if(substr($sql,0,6)!="select")
		{
			exit("非select语句请调用其他方法")
		}
		return mysql_query($sql);
	}
	//公共的返回多行记录
	public function fetchAll($sql,$type=3)
	{
		$tpeys=array(
			1=>MYSQL_NUM,
			2=>MYSQL_BOTH,
			3=>MYSQL_ASSOC
			);
		
		$result=$this->query($sql);

		while ($row=mysql_fetch_array($result,$typrs[$type])) {
			$arr[]=$row;
		}

		return $arr;
	}

	public function fetchOne($sql,$type=3)
	{
		$tpeys=array(
			1=>MYSQL_NUM,
			2=>MYSQL_BOTH,
			3=>MYSQL_ASSOC
			);
		$result=$this->query($sql);

		return mysql_fetch_array($result,$typrs[$type]);
	}

	public function getRecords($sql)
	{
		$result=$this->query($sql);
		$arr=mysql_fetch_row($result);
		return $arr[0];
	}

	//析构
	public function __destruct()
	{
		mysql_close();
	}
}