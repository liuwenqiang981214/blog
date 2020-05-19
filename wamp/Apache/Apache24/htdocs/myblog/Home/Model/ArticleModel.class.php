<?php
namespace Home\Model;
use Frame\Libs\BaseModel;

final class ArticleModel extends BaseModel
{
	protected $table="article";

	public function fetchWithJoin($startrow=0,$pagesize=10,$where="1",$ORDER='id ASC')
	{
		$sql="SELECT article.*,category2.classname,user.username FROM {$this->table} ";
		$sql.="LEFT JOIN category2 ON article.category_id=category2.id ";
		$sql.="LEFT JOIN user ON article.user_id=user.id " ;
		$sql.="WHERE {$where} ";
		$sql.="ORDER BY {$ORDER} ";
		$sql.="LIMIT {$startrow},{$pagesize}";

		return $this->pdo->fetchAll($sql);
	}
	public function showArticle($id=1)
	{
		$sql="SELECT article.*,category2.classname,user.username FROM {$this->table} ";
		$sql.="LEFT JOIN category2 ON article.category_id=category2.id ";
		$sql.="LEFT JOIN user ON article.user_id=user.id " ;
		$sql.="WHERE article.id={$id} ";

		return $this->pdo->fetchOne($sql);
	}
}