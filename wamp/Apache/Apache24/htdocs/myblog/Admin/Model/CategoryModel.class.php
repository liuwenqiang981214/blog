<?php
namespace Admin\Model;
use Frame\Libs\BaseModel;

final class CategoryModel extends BaseModel
{
	protected $table='category2';

	public function categoryList($arrs,$level=0,$pid=0)
	{
		//只在第一次调用函数时初始化 保存数据
		static $categorys=array();

		foreach ($arrs as $arr) {
			
			if ($arr['pid']==$pid) {
				
				$arr['level']=$level;
				
				$categorys[]=$arr;
				
				$this->categoryList($arrs,$level+1,$arr['id']);
			}
		}
		return $categorys;
	}
}