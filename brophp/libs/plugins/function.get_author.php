<?php

function smarty_function_get_author($params, &$smarty)
{
        P($params);
        D('contents') -> where(array("type"=>"1")) -> field("con_id,u_id,title,tags,time") -> select();
        foreach($data as &$v){
		$user = $this -> user($v['u_id']);
		$total = $this -> total($v['con_id']);
		
        }
        private function user($uid){
		return D("user")->field('blogname')->where(array("u_id"=>$uid))->find();
	}

		/**
		 * 查询评论表
		 * @param	$conid	主方法中传过来的内容的ID
		 * @return	array	关联数组
		 */
	private function total($conid){
		return D("reviews")->where(array('con_id'=>$conid))->total();
	}


}

?>
