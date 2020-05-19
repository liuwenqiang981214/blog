<?php
namespace Frame\Libs;
use \Frame\Vendor\PDOWrapper;

abstract class BaseModel
{
	//私有的静态的保存模型类对象数组属性
	protected static $modelObjArr= array();
	//受保护的pdo对象
	protected $pdo;
	//构造方法
	public function __construct()
	{
		$this->pdo=new PDOWrapper();

	}

	//公共的静态的创建不同模型类对象的方法
	public static function getInstance()
	{
		//获取静态化方式调用的类名
		$modelClassName=get_called_class(); 
		//判断模型对象是否存在，不存在则创建
		if(!isset(self::$modelObjArr[$modelClassName])){
			self::$modelObjArr[$modelClassName]=new $modelClassName();
		}
		return  self::$modelObjArr[$modelClassName];
	}

	public function getCategoryList()
	{
		$categorys=CategoryModel::getInstance()->fetchAll(1,"orderby ASC");
		$categorys=CategoryModel::getInstance()->categoryList($categorys);
		return $categorys;
	}

	public function fetchOne($where="2>1",$orderby='id desc')
	{
		$sql="SELECT * FROM {$this->table} WHERE $where ORDER BY {$orderby} limit 1";
		return $this->pdo->fetchOne($sql);
	}
	public function fetchAll($where="2>1",$orderby='id desc')
	{
		$sql="SELECT * FROM {$this->table} WHERE $where ORDER BY {$orderby}";
		return $this->pdo->fetchAll($sql);
	}
	
	public function insert($data)
	{
		$fields="";
		$values="";
		foreach ($data as $key => $value) {
			$fields.="$key,";
			$values.="'$value',";
		}
		//去除最左侧的逗号
		$fields=rtrim($fields,",");
		$values=rtrim($values,",");
		$sql="INSERT INTO {$this->table}($fields) VALUES ($values)";
		return $this->pdo->exec($sql);
	}
	public function update($data,$id)
	{
		$str="";
		foreach ($data as $key => $value) {
			$str.="$key='$value',";
		}
		//去除最左侧的逗号
		$str=rtrim($str,",");

		$sql="UPDATE {$this->table} SET {$str} WHERE id={$id}";
		return $this->pdo->exec($sql);
	}

	public function delete($id)
	{
		$sql="DELETE FROM {$this->table} WHERE id={$id}";
		return $this->pdo->exec($sql);
	}

	public function rowCount($where="2>1")
	{
		$sql="SELECT * FROM {$this->table} WHERE {$where}";
		return $this->pdo->rowCount($sql);
	}

}