<?php
//Author 华鹏
/**发现更多博客页
 */
class Find {
    function index(){
            //查询最近发表文章的博客            
            $blog=$this->blog();
            //取出博主数量
            $num=count($blog);
            //取博客,标签信息 按照文章中出现的次数倒序排名取10条
            $bloginfo=$this->bloginfo(10);
            //分配SESSION到模板  
            $this -> assign('session',$_SESSION);
            //分配博客数量
            $this-> assign('num',$num);
            //分配blog数组到模板
            $this -> assign('blog',$blog);
            //分配系统标签
            $this-> assign('bloginfo',$bloginfo);
            //分配热门数组到模板
            $this -> assign('fdata',$fdata);
            //前台显示模板页面
            $this->display();
    }
    // 取出博客信息 按照系统标签排名
       function bloginfo($num){
                    $i=0;
                    //执行查询
                    $numarr = $this -> tagid();
                    foreach($numarr as $key){                        
                            //赋给$tag数组
                        $tag[] = $this -> tagblog($key);
                            //控制循环次数            
                        if($i==$num){
                            break;
                      }
                       $i++; 
                    }
                    //加入查询的杰出博客
                    $tag['blog'] = $this->blogs();
                    //加入热度
                    $tag['hot'] = $hot=$this->hot();
                    return $tag;
       } 
    

    //查询标签,自定义标签博客
        function tagblog($tagid){
                    $data=d('contents')->field('u_id,systag_id,tags')
                        ->where(array('systag_id'=>$tagid))
                        ->limit(1)
                        ->order('u_id desc')
                        ->r_select(array('user','u_ico,blogname','u_id','u_id'),array('systags','systag_name','systag_id','systag_id'));
                    return $data;
        }
    //从内容表中查询系统标签ID 按照文章引用次数排名
        function tagid(){
              //取出系统标签ID
                $numarr=D('contents')->field('systag_id')
                                     ->select();
                foreach($numarr as $num){
                                        $numarr1[]=$num['systag_id'];
                    }  
                //取出所有标签ID的出现次数        
                $numarr=array_count_values($numarr1);
                //对ID次数数组进行倒序排序
                arsort($numarr);
                //返回所有的键名(ID)
                $numarr=array_keys($numarr);
                return $numarr;
        }
        //查询文章中发表文章最多的博客
        function blogs(){
                    $blogs=d('contents')
                        ->field('u_id')
                        ->select();
                    foreach($blogs as $num){
                        $blogsa[]=$num['u_id'];
                    }  
                //取出所有标签ID的出现次数        
                $blogs=array_count_values($blogsa);
                //对ID次数数组进行倒序排序
                arsort($blogs);
                //返回所有的键名(ID)
                $blogs=array_keys($blogs);
                $blogs=d('user')
                        ->field('u_id,u_ico,blogname')
                        ->where(array('u_id'=>$blogs))
                        ->select();
                return $blogs;
        }
        //查询发表文章blog 以及系统标签
        function blog(){
                $blog=d('contents')
                ->field('u_id,systag_id')
                ->order('time asc')
                ->r_select(array('systags','systag_name','systag_id','systag_id'),array('user','u_ico,blogname','u_id','u_id'));
                return $blog;
        }
        //查询活跃度
        function hot(){
                    $hot=d('contents')
                        ->field('u_id')
                        ->select();
                    foreach($hot as $num){
                        $hota[]=$num['u_id'];
                    }  
                //取出所有标签ID的出现次数        
                $hot=array_count_values($hota);
                //对ID次数数组进行倒序排序
                arsort($hot);
                //返回所有的值
                $hot=array_values($hot);
                return $hot;
        }
 
 }
