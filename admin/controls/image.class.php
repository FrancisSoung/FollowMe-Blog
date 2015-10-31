<?php
	class Image {
	    /** Author 华鹏
		 *	图片管理
		 *	 $date 查询图片后返回的数组
		 */
		function index() {
			//查询遍历图片
            $data=d('contents')
                            ->field('con_id,u_id,title,image,tags,time')  
					        ->where(array('type'=>2))
					        ->order('time desc')
					        ->r_select(array('user','blogname','u_id','u_id'));
            //计算图片的个数
			$num=count($data);
			//分配图片数组给模板
			$this -> assign("data",$data);
			//分配总数
            $this -> assign("num",$num);
            //显示模板页面
			$this -> display();
        }
        function delimg(){
            debug(0);
            //取得Ajax传的图片数组
            $conid=$_POST['con_id'];
            $conid=explode(',',$conid);
            //循环删除
            foreach($conid as $key){
                    $mess=d('contents')->delete($key);
            }
            if($mess!=false){
                $mess=1;
            }else{
                $mess=2;
            }
            echo $mess;
        }

}
