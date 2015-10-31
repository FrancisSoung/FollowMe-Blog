<?php
//Author 华鹏
    class User{
        function Index(){
            //是否是页面点击博主访问
            if(!empty($_GET['uid'])){
                //查询博主 以及全部发表的文章
                $personal=$this->personal($_GET['uid']);
                //加访问量 
                $this->counts($_GET['uid']);
                //分配主页信息到首页
                $this -> assign('personal',$personal);
                //首页显示个人主页模板
                $this -> display();
            }elseif(!empty($_GET['conid'])){
                //如果是点击文章              
                $blog=$this->author($_GET['conid']);
                //加访问量 
                $this->counts($blog[0]['u_id']);
                //分配博主信息及单篇文章到首页
                $this -> assign('blog',$blog);
                //首页显示文章页模板
                $this -> display();
            }else{
                //非指定操作提交
                    $this->error('你这是非法提交呀! 回去!',3,'/index/index');
            }

    
        }

        //查找博主信息 以及单篇文章
        function author($conid){
            $blog=d('contents')
                        ->field('u_id,title,type,image,sound,link,video,content,time')
                        ->where(array('con_id'=>$conid))
                        ->r_select(array('user','u_ico,blogname,info,count','u_id','u_id'));
       
                //加入文章类型区别以博主ID访问
            $blog[0]['article']='yes';
            return $blog;
        }
        //查找博主发表的全部文章
        function personal($uid){
                $personal=d('user')
                        ->field('u_id,u_ico,blogname,info,count')
                        ->where(array('u_id'=>$uid))
                        ->r_select(array('contents','con_id,title,type,title,image,sound,link,video,content,time','u_id'));
                $personal=$this->arrsort($personal);
            return $personal;
        }
        //按照时间排序
        function arrsort($data){
                foreach($data as $key){
                    $datab[]=$key['time'];
                }
                array_multisort($datab,SORT_DESC,$data);
                return $data;
        }
        //访问量
        function counts($uid){
                    $mess=d('user')
                            ->where(array('u_id'=>$uid))
                            ->update('count=count+1');
                    return $uid;
        }
}


