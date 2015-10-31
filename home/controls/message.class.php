<?php
//Author 华鹏
/**用户私信页面
 * 
 **/
class Message{
    function index(){
               //判断是否点击提交
        if(!empty($_GET['uid'])){
			if($_GET['uid']!=$_GET['guid']){
            if(!empty($_GET['blogname'])){          
                    //发信者ID
                    $uid=$_GET['uid'];
                    //接收者ID
                    $guid=$_GET['guid'];
                    //接受者名称
                    $blogname=$_GET['blogname'];

                    //分配发送者ID到模板
                    $this->assign('uid',$uid);

                    //分配接受者ID到模板
                    $this->assign('guid',$guid);
                    $this->assign('session',$_SESSION);
                    //动作
                    $this->assign('action','发送私信');

                    //分配接受者名称到到模板页
                    $this->assign('user',$blogname);
                    
                    //首页显示模板
                    $this->display();
            }else{
                    $blogname=d('user')
                                    ->field('blogname')
                                    ->where(array('u_id'=>$_GET['guid']))
                                    ->select();
                    //发信者ID
                    $uid=$_GET['uid'];
                    //接收者ID
                    $guid=$_GET['guid'];
                     $blogname=$blogname[0]['blogname'];
                    //分配发送者ID到模板
                    $this->assign('uid',$uid);
                    $this->assign('session',$_SESSION);
                    //分配接受者ID到模板
                    $this->assign('guid',$guid);
                    //动作
                    $this->assign('action','回复私信');
                    //分配接受者名称到到模板页
                    $this->assign('user',$blogname);
                
                //首页显示模板
                    $this->display();
            }
			}else{
					//非指定操作提交
                    $this->error('自己还用给自己发私信呀?!',3,'/index/index');
			}

                }else{
                    //非指定操作提交
                    $this->error('你这是非法提交呀! 回去!',3,'/index/index');
                }
    }
    //消息提交
    function send(){
        debug(0);
        if($_POST){
            //查找黑名单表 判断是否在黑名单表中
            $list=$this->black($_POST['su_id'],$_POST['gu_id']);
                if($_POST['su_id']!=$_POST['gu_id']){
                //如果不在黑名单 执行插入
                if(empty($list[0]['list_id'])){
                    if(!empty($_POST['content'])){
                        //加入消息状态 0 未读
                        $_POST['status']=0;
                        //加入当前时间
                            $_POST['time']=time();
                            $mess=d('messages')
                                    ->insert($_POST);
                            if($mess!=""){
                                $mess='a';
                            }else{
                                $mess='b';
                            }                 
                        }else{
                            $mess='c';
                        }
                }else{
                    $mess='d';
                }
            }else{
                $mess='f';
            }
        }
        echo $mess;
    }
     //查找黑名单表 
        function black($suid,$guid){
            $list=d('blacklist')
                ->field('list_id')
                ->where(array('su_id'=>$suid,'u_id'=>$guid))
                ->select();
            return $list;
        }
    //查看消息
    function mess(){
            //判断是否点击提交
        if(!empty($_GET['uid'])){
            //取出用户的系统消息
            $sysmess=$this->sysmess($_GET['uid']);
            //取出用户私信
            $mess=$this->umess($_GET['uid']);

            if(!empty($sysmess)){
            //合并用户私信与系统私信
            $message=array_merge_recursive($sysmess,$mess);
            $message=$this->arrsort($message);
            //统计消息总数 放入SESSION
            $_SESSION['number']=count($message);
                    //分配合成后的消息列表到前台模板
                    $this->assign('mess',$message); 
            }else{
                    //统计消息总数 放入SESSION
                    $_SESSION['munber']=count($mess);
                    //分配消息列表到前台模板
                    $this->assign('mess',$mess); 
            }
                    //分配SESSION
                    $this->assign('session',$_SESSION);
                    //首页显示模板
                    $this->display();
                }else{
                    //非指定操作提交
                    $this->error('你这是非法提交呀! 回去!',3,'/index/index');
                }
    }
    //查询系统消息
    function sysmess($uid){
            /*取出系统广播
             */
                //先查出当前用户屏蔽的广播编号
                 $num=d('broread')
                ->field('r_id')
                ->where(array('ru_id'=>$uid))
                ->select();

                //查询除了屏蔽广播编号以外的全部系统广播
                 $gb=d('broadcasts')
                     ->field('bro_id,type,content,time')
                     ->where(array('type'=>1,'bro_id !='=>$num[0]['r_id']))
                     ->select();
 
            //取出系统私信
           $mess=d('broadcasts')
                ->field('bro_id,content,type,time')
                                ->where(array('type'=>2,'u_id'=>$uid))
                                ->select();
            //合并广播数组
             $mess=array_merge_recursive($mess,$gb);
            return$mess;
    }

    //查询用户私信
    function umess($uid){
        $mess=d('messages')
            ->field('mes_id,status,su_id,content,type,time')
            ->where(array('gu_id'=>$uid))
            ->r_select(array('user','u_ico','u_id','su_id'));
        return $mess;
    }
      //消息数组 按照时间排序
        function arrsort($data){
                foreach($data as $key=>$v){
                    $datab[]=$v['time'];
                }
                array_multisort($datab,SORT_DESC,$data);
                return $data;

        }
    //删除用户私信
    function closeu(){
        debug(0);
        if(!empty($_POST['id'])){
        $id=$_POST['id'];
        $mess=d('messages')
            ->delete($_POST['id']);
        if($mess!=false){

            $mess=1;
        }else{
            $mess=2;
        }
        }
        echo $mess;
    }
    //屏蔽系统广播
    function closesys(){
            debug(0);
            if(!empty($_POST['r_id']) ||  !empty($_POST['ru_id'])){
                        $mess=d('broread')
                            ->insert($_POST);
                        if($mess!=false){
                            $mess=1;
                        }else{
                            $mess=2;
                        }
                    echo $mess;
            }
    }
    //屏蔽系统私信
    function closesysmess(){
            debug(0);
            if(!empty($_POST['bro_id']) || !empty($_POST['uid'])){
                 $mess=d('broadcasts')
                        ->delete($_POST['bro_id']);
                if($mess!=false){
                    $mess=1;
                    }else{
                        $mess=2;
                    }
            }
        echo $mess;
                
    }
    

}
