<?php
//图墙遍历
//杨航
class Wall{
        function Index(){
                //如果获得标签id就拿出该id下的图片
                //如果没有 就获得所有图片
                if($_GET['tag_id']){
                $data=d('contents')
                            ->field('con_id,u_id,title,image,tags,time')  
					        ->where(array('type'=>2,'systag_id'=>$_GET['tag_id']))
					        ->order('time desc')
                                                ->r_select(array('user','u_ico,u_name','u_id','u_id'));
                        $tags=D('systags')->select();
                        $this->assign("tags",$tags);
                        $this->assign("session",$_SESSION);
                        $this->assign("data",$data);
                        $this->display();
                }else{
                        $data=d('contents')
                            ->field('con_id,u_id,title,image,tags,time')  
					        ->where(array('type'=>2))
					        ->order('time desc')
					        ->r_select(array('user','u_ico,u_name','u_id','u_id'));
                        $tags=D('systags')->select();
                        $this->assign("tags",$tags);
                        $this->assign("session",$_SESSION);
                        $this->assign("data",$data);
                        $this->display();
                

            //计算图片的个数
		
                //分配图片数组给模板
                


                }
        }
}
