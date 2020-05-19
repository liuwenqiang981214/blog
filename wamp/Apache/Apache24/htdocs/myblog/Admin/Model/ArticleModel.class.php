<?php
namespace Admin\Model;
use Frame\Libs\BaseModel;

final class ArticleModel extends BaseModel
{
	protected $table="article";

	public function fetchWithJion($startrow=0,$pagesize=10,$where="1")
	{
		$sql="SELECT article.*,category2.classname,user.username FROM {$this->table} ";
		$sql.="LEFT JOIN category2 ON article.category_id=category2.id ";
		$sql.="LEFT JOIN user ON article.user_id=user.id " ;
		$sql.="WHERE {$where} ";
		$sql.="ORDER BY article.top DESC,article.orderby ASC,article.id ASC ";
		$sql.="LIMIT {$startrow},{$pagesize}";

		return $this->pdo->fetchAll($sql);
	}
}