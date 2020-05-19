<?php
namespace Home\Model;
use Frame\Libs\BaseModel;

final class CommentModel extends BaseModel
{
	protected $table="comment";

	public function fetchAllWithJoin($where="2>1")
	{
		$sql = "SELECT comment.*,user.username FROM comment ";
		$sql .= "LEFT JOIN user ON comment.user_id=user.id ";
		$sql .= "WHERE {$where} ORDER BY id DESC";
		return $this->pdo->fetchAll($sql);
	}

	//获取评论的无限级分类数据
	public function commentList($arrs,$pid=0)
	{
		$comments = array();
		foreach($arrs as $arr)
		{
			//先查找顶级评论
			if($arr['pid']==$pid)
			{
				$arr['son'] = $this->commentList($arrs,$arr['id']);
				$comments[] = $arr;
			}
		}
		return $comments;
	}
}
