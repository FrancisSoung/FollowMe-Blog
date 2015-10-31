<?php
    //Author 华鹏
    /*
     *index() 关注博客页 attention()系统标签博客页
     *$blog 关注页当前用户关注博客列表信息数组
     *$blogs 系统标签页博客列表信息数组
     *$systag 系统标签页 系统标签数组
     */
	class Actioned {
        function index() {
             //判断是否点击提交
                if(!empty($_GET['id'])){    
            //查询当前用户关注博客列表 调用findblog方法 传当前用户ID参数
                $blog= $this -> findblog($_GET['id']);
            //计算用户关注的博客数量
                $num=count($blog);         
            //分配SESSION
                $this ->assign ('session',$_SESSION);
            //分配关注数量到前台
                $this -> assign('num',$num);
            //分配博客列表到前台模板
                $this -> assign('blog',$blog);
            //前台显示模板
                $this -> display();
            }else{
                    //非指定操作提交
                    $this->error('你这是非法提交呀! 回去!',3,'/index/index');
                }

		}
        function attention() {
                /*系统标签博客页
                 * $systag 返回到前台模板的系统标签数字
                 *
                 */ 
                //查询系统标签 按照排序字段升序排序
                $systag=d('systags')
                        ->field('systag_id,systag_name,seque')
                        ->order('sort')
                        ->select();

               /**博客列表 
                * $blog 返回到前台博客排名数组
                * 关联动作表 查询是否已关注,添加关注
                * 列表按照访问量排序
                */

                //如果有GET ID提交  调用uid方法查询发表过文章里包含这个系统标签的博主
                if(isset($_GET['id'])){
                    //返回博主ID一维数组                    
                            $uid=$this -> uid($_GET['id']);
                            //返回博主信息                           
                    $blogs=$this->blog(array('u_id'=>$uid));
                    }else{ 
                        $blogs=$this->blog(false);
                    }

            //分配SESSION
                $this ->assign ('session',$_SESSION); 
            //分配系统标签变量到前台模板
                $this -> assign('systag',$systag);
            //分配博客列表到前台模板
                $this -> assign('blogs',$blogs);
            //前台显示模板
                $this -> display();
        }

        //查询发表过文章里包含这个系统标签的博主
         function uid($id){
                        $uid=d('contents')
                                ->field('u_id,systag_id')
                                ->where(array('systag_id'=>$id))
                                ->select();
                        //遍历博主ID
                        foreach($uid as $key){
                             $uid[]=$key['u_id']; 
                        }
                        //去掉重复值 合并
                        $uid=array_unique($uid);
                        //删除无用的元素
                        unset($uid[0]);
                        //返回值 *起到重新赋键名的作用
                        $uid=array_values($uid);
                        return $uid;
                    }
        //关联关注表 查询博主信息 倒序 取10条以内
        function blog($uid){
                $blog=d('user')->field('u_id,u_ico,blogname,info')
                                ->limit(10) 
                                ->where($uid)
                                ->order('count desc')
                                ->r_select(array('actions','type,u_id','ucon_id','u_id'));
                return $blog;
        }
        //添加/取消博客关注
        function addblog(){
            debug(0);
            //判断是否有POST传参 
            if($_POST){
                //有传参 执行分割ID方法 返回ID数组
                $data=$this->backid($_POST['id']);
                //不能对自己加关注
                if($data[0]!=$data[1]){
                //查询数据库中是否存在记录 判断是否已经加了关注
               $mess=d('actions')
                   ->field('act_id')
                   ->where(array('type'=>1,'u_id'=>$data[1],'ucon_id'=>$data[0])) 
                   ->select();
                if(!empty($mess)){
                    //如果查询出数据 说明已经加了关注
                    //执行删除
                     $mess=d('actions')
                            ->where(array('type'=>1,'u_id'=>$data[1],'ucon_id'=>$data[0]))
                            ->delete();
                    if($mess!=false){
                            //成功返回c 失败返回d
                            $mess='c';
                    }else{
                            $mess='d';
                        }
                }else{
                    //没有查询出 执行 添加
                    $time=time();
                    $mess=d('actions')
                        ->insert(array('type'=>1,'u_id'=>$data[1],'ucon_id'=>$data[0],'time'=>$time));
                    if($mess!=false){
                            //成功返回a 失败返回b
                            $mess='a';
                    }else{
                            $mess='b';
                        }
                }
                }else{
                    $mess='e';
                }
            echo $mess;
           }
        }
       
        //返回截取后的博客ID数组
        function backid($data){
            $data=$_POST['id'];
            $data=explode(',',$data);
            return $data;            
        }

        //查询我关注的博客列表 
        function findblog($u_id){
            //查询关注表中我关注的博客ID    
            $fblog=d('actions')
                     ->field('ucon_id')
                     ->where(array('type'=>1,'u_id'=>$u_id))
                     ->select();
            //遍历博客ID
                foreach($fblog as $key){
                    $fblogs[]=$key['ucon_id'];
                    }
            //以博客ID数组查询博客信息 以访问量排序
            $blogs=d('user')
                    ->field('u_id,blogname,u_ico,info')
                    ->order('count desc')
                    ->where(array('u_id'=>$fblogs))
                    ->select();
            //返回博客信息
            return $blogs;
        }
	}
