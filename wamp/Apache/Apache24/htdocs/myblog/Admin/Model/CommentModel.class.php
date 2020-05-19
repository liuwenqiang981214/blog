<?php
namespace Admin\Model;
use Frame\Libs\BaseModel;

final class CommentModel extends BaseModel
{
	protected $table="comment";

	public function fetchWithJoin($startrow=0,$pagesize=5,$where="1")
	{
		$sql="SELECT comment.*,user.username,article.title,a.content AS parent_content FROM {$this->table} ";
		$sql.="LEFT JOIN user ON comment.user_id=user.id ";
		$sql.="LEFT JOIN article ON comment.article_id=article.id ";
		$sql.="LEFT JOIN comment AS a ON a.id=comment.pid ";
		$sql.="WHERE {$where} ";
		$sql.="ORDER BY id ASC ";
		$sql.="LIMIT {$startrow},{$pagesize} ";
		

		return $this->pdo->fetchAll($sql);
	}
	public function rowCount($where=1)
	{
		$sql="SELECT comment.*,user.username,article.title,a.content AS parent_content FROM {$this->table} ";
		$sql.="LEFT JOIN user ON comment.user_id=user.id ";
		$sql.="LEFT JOIN article ON comment.article_id=article.id ";
		$sql.="LEFT JOIN comment AS a ON a.id=comment.pid ";
		$sql.="WHERE {$where} ";

		return $this->pdo->rowCount($sql);
	}

}