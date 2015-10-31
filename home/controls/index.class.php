<?php
//Author 华鹏
    /**
     * 首页
     */
class Index {
            const USER_AGENT = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10";
        const CHECK_URL_VALID = "/(youku\.com|tudou\.com|ku6\.com|56\.com|letv\.com|video\.sina\.com\.cn|(my\.)?tv\.sohu\.com|v\.qq\.com)/";
            
            function index(){

            //判断是否有AjaxPOST提交 查询自定义标签 
            if(!empty($_POST['tag']) or !empty($_GET['tag'])){
                $tag = (empty($_POST['tag'])) ? $_GET['tag'] : $_POST['tag'];
                //查询最新发表的20条内容的文章类型,ID             
                $type = d('contents')->limit(20)->order('con_id desc')->field('con_id,type')->select();
                //遍历内容类型数字 匹配执行相应方法 查询包含提交的自定义标签的内容
                foreach($type as $num){
                            switch($num['type']){
                                 case 1:
                                    // 执行遍历文章方法 传文章ID 自定义标签 返回$udata数组
                                    $udata[] = $this->article($num['con_id'],$tag); 
                                    break;
                                case 2:
                                    //执行遍历图片方法 传图片ID 自定义标签 返回$udata数组
                                    $udata[] = $this->image($num['con_id'],$tag);                        
                                    break;
                                case 3:
                                    //执行遍历声音方法 传声音ID 自定义标签 返回$udata数组
                                    $udata[] = $this->sound($num['con_id'],$tag);
                                    break;
                                case 4:
                                    //执行遍历视频方法 传视频ID 自定义标签 返回$udata数组
                                    $udata[] = $this->video($num['con_id'],$tag);
                                    break;
                                case 5:
                                    //执行遍历链接方法 传链接ID 自定义标签 返回$udata数组 
                                    $udata[] = $this->links($num['con_id'],$tag);                          
                            }      
                }   
                //Title信息
                    $this->assign("fmtitle","Follow Me 轻博客首页");
                //首页博客排名 按访问量 取6条
                    $blog=$this->blogrank(6);
                //首页系统标签 按用户文章中次数排名取6条
                    $tag=$this->systag(5);  
                //取发表头像
                    $pushico=$this->uico($_SESSION['u_id']);
                    $this -> assign ('pushico',$pushico[0]['u_ico']);
                //分配SESSION
                    $this ->assign ('session',$_SESSION);
                //分配关注用户发表内容到首页
                    $this -> assign('udata',$udata);
                //分配热门标签排名到首页
                    $this -> assign('systag',$tag);
                //分配博客排名到首页
                    $this -> assign('blog',$blog);
                //首页显示模板
                $this -> display();
            }else{
            /**首页显示用户发表内容
             * $type 内容类型 1-文章 2-图片 3-声音 4-视频 5-链接 
             *          10-文章被屏蔽 20-图片屏蔽 30-声音屏蔽 40-视频屏蔽 50-链接屏蔽
             * $udata 返回到首页的用户发表内容数组
             */
                //查询最新发表的20条内容的文章类型,ID
                $type = d('contents')->limit(20)->order('con_id desc')->field('con_id,type')->select();
                //遍历内容类型数字 匹配执行相应方法
                foreach($type as $num){
                            switch($num['type']){
                                 case 1:
                                    // 执行遍历文章方法 传文章ID 返回$udata数组
                                    $udata[] = $this->article($num['con_id'],$_POST['tag']); 
                                    break;
                                case 2:
                                    //执行遍历图片方法 传图片ID 返回$udata数组
                                    $udata[] = $this->image($num['con_id'],$_POST['tag']);                        
                                    break;
                                case 3:
                                    //执行遍历声音方法 传声音ID 返回$udata数组
                                    $udata[] = $this->sound($num['con_id'],$_POST['tag']);
                                    break;
                                case 4:
                                    //执行遍历视频方法 传视频ID 返回$udata数组
                                    $udata[] = $this->video($num['con_id'],$_POST['tag']);
                                    break;
                                case 5:
                                    //执行遍历链接方法 传链接ID 返回$udata数组 
                                    $udata[] = $this->links($num['con_id'],$_POST['tag']);                          
                            }      
                }
                
                //Title信息
                    $this->assign("fmtitle","Follow Me 轻博客首页");
                //首页博客排名 按访问量 取6条
                    $blog=$this->blogrank(6);
                //首页系统标签 按用户文章中次数排名取6条
                    $tag=$this->systag(5); 
                //取发表头像
                    $pushico=$this->uico($_SESSION['u_id']);
                    $this -> assign ('pushico',$pushico[0]['u_ico']);
                //分配SESSION
                    $this -> assign ('session',$_SESSION);
                //分配关注用户发表内容到首页
                    $this -> assign('udata',$udata);
                //分配热门标签排名到首页
                    $this -> assign('systag',$tag);
                //分配博客排名到首页
                    $this -> assign('blog',$blog);
                //首页显示主页模板
                    $this -> display();
            }

        }

            /**博客排名
             * $blog 返回到首页博客排名数组
             *列表按照访问量排序
             *$num 要取的数量
             */
        function blogrank($num){
                    $blog=d('user')->field('u_id,u_ico,blogname,info')
                                   ->limit($num) 
                                   ->order('count desc')
                                   ->select();
                    return $blog;
        }

            /**侧栏热门标签栏
             * $tag 返回首页侧栏热门标签数组
             * $numarr 标签ID数组
             * $num 取的条数
             */
        function systag($num){
                    $i=0;
                    //执行查询
                    $numarr = $this -> tagid();
                    foreach($numarr as $key){                        
                            //赋给$tag数组
                            $tag[] = $this -> findtag($key);                                            
                        if($i==$num){
                            break;
                        }
                        $i++; 
                    }
                    return $tag;
        } 

        //查询遍历文章
        function article($num,$tag){
            //判断是否要查询自定义标签
            if(!empty($tag)){
                $where=array('con_id'=>$num,'type'=>1,'tags'=>"%$tag%");
            }else{
                $where=array('con_id'=>$num,'type'=>1); 
            }
            $udata = d('contents')->field('u_id,systag_id,title,content,tags')
                                  ->where($where)
                                  ->r_select(array('user','u_ico,blogname','u_id','u_id'),array('systags','systag_name','systag_id','systag_id'));
             //合并热度与回应数组 
            $udata[0]['arr']=array_merge_recursive($this->review($num),$this->hot($num));
            //执行按照时间排序后的热度与回应数组
            $udata[0]['arr']=$this->arrsort($udata[0]['arr']);
            //回应数
            $udata[0]['revnum']=count($this->review($num));
            //热度总数
            $udata[0]['hotnum']=count($udata[0]['arr']);
            //加入类型,文章ID
            $udata[0]['type']=1;
            $udata[0]['con_id']=$num;
            //截取自定义标签
            $udata[0]['tags']= $this->extags($udata[0]['tags']);
            //销毁重复的值
            unset($udata[0]['user_u_id']);
            unset($udata[0]['systags_systag_id']);
            //查询自定义标签 如果为空 数组赋空
            if(!empty($udata[0]['u_id'])){
                return $udata;
            }else{
                $udata='';
                return $udata;
            }
        }
        //查询遍历图片   
        function image($num,$tag){
            //判断是否要查询自定义标签
            if(!empty($tag)){
                $where=array('con_id'=>$num,'type'=>2,'tags'=>"%$tag%");
            }else{
                $where=array('con_id'=>$num,'type'=>2);
            }
            $udata = d('contents')->field('u_id,systag_id,title,image,content,tags')
                                  ->where($where)
                                  ->r_select(array('user','u_ico,blogname','u_id','u_id'),array('systags','systag_name','systag_id','systag_id'));
             //合并热度与回应数组 
            $udata[0]['arr']=array_merge_recursive($this->review($num),$this->hot($num));
            //执行按照时间排序后的热度与回应数组
            $udata[0]['arr']=$this->arrsort($udata[0]['arr']);     
            //回应数
            $udata[0]['revnum']=count($this->review($num));
            //热度总数
            $udata[0]['hotnum']=count($udata[0]['arr']); 
            //加入类型,图片文章ID
            $udata[0]['type']=2;
            $udata[0]['con_id']=$num;
            //截取自定义标签
            $udata[0]['tags']=$this->extags($udata[0]['tags']);          
            //销毁重复的值
            unset($udata[0]['user_u_id']);
            unset($udata[0]['systags_systag_id']);
            //查询自定义标签 如果为空 数组赋空
            if(!empty($udata[0]['u_id'])){
                return $udata;
            }else{
                $udata='';
                return $udata;
            }
        }
        //查询遍历声音
        function sound($num,$tag){
            //判断是否要查询自定义标签
            if(!empty($tag)){
                $where=array('con_id'=>$num,'type'=>3,'tags'=>"%$tag%");
            }else{
                $where=array('con_id'=>$num,'type'=>3);
            }
            $udata = d('contents')->field('u_id,systag_id,title,sound,content,tags')
                                  ->where($where)
                                  ->r_select(array('user','u_ico,blogname','u_id','u_id'),array('systags','systag_name','systag_id','systag_id'));
             //合并热度与回应数组 
            $udata[0]['arr']=array_merge_recursive($this->review($num),$this->hot($num));
            //执行按照时间排序后的热度与回应数组
            $udata[0]['arr']=$this->arrsort($udata[0]['arr']);  
            $udata[0]['sound']=$this->music($udata[0]['sound']);        
            //回应数
            $udata[0]['revnum']=count($this->review($num));
            //热度总数
            $udata[0]['hotnum']=count($udata[0]['arr']);
            //加入类型,声音文章ID
            $udata[0]['type']=3;
            $udata[0]['con_id']=$num;
            //截取自定义标签
            $udata[0]['tags']= $this->extags($udata[0]['tags']);
            //销毁重复的值
            unset($udata[0]['user_u_id']);
            unset($udata[0]['systags_systag_id']);
            //查询自定义标签 如果为空 数组赋空
            if(!empty($udata[0]['u_id'])){
                return $udata;
            }else{
                $udata='';
                return $udata;
            }
        }
        //查询遍历视频
        function video($num,$tag){
            //判断是否要查询自定义标签
            if(!empty($tag)){
                $where=array('con_id'=>$num,'type'=>4,'tags'=>"%$tag%");
            }else{
                $where=array('con_id'=>$num,'type'=>4);
            }
             $udata = d('contents')->field('u_id,systag_id,title,video,content,tags')
                                  ->where($where)
                                  ->r_select(array('user','u_ico,blogname','u_id','u_id'),array('systags','systag_name','systag_id','systag_id'));
             //合并热度与回应数组 
             $udata[0]['arr']=array_merge_recursive($this->review($num),$this->hot($num));
            //执行按照时间排序后的热度与回应数组
            $udata[0]['arr']=$this->arrsort($udata[0]['arr']);             
            //解析视频地址，发布到前台
            $udata[0]['video']=$this->parse($udata[0]['video']);
            //回应数
            $udata[0]['revnum']=count($this->review($num));
            //热度总数
            $udata[0]['hotnum']=count($udata[0]['arr']);
             //加入类型,链接文章ID
            $udata[0]['type']=4;
            $udata[0]['con_id']=$num;
            //截取自定义标签
            $udata[0]['tags']= $this->extags($udata[0]['tags']);
            //销毁重复的值
            unset($udata[0]['user_u_id']);
            unset($udata[0]['systags_systag_id']);
            //查询自定义标签 如果为空 数组赋空
            if(!empty($udata[0]['u_id'])){
                return $udata;
            }else{
                $udata='';
                return $udata;
            }
        }
        //查询遍历链接
        function links($num,$tag){
            //判断是否要查询自定义标签
            if(!empty($tag)){
                $where=array('con_id'=>$num,'type'=>5,'tags'=>"%$tag%");
            }else{
                $where=array('con_id'=>$num,'type'=>5);
            }
            $udata = d('contents')->field('u_id,systag_id,title,link,content,tags')
                                  ->where($where)
                                  ->r_select(array('user','u_ico,blogname','u_id','u_id'),array('systags','systag_name','systag_id','systag_id'));
             //合并热度与回应数组 
            $udata[0]['arr']=array_merge_recursive($this->review($num),$this->hot($num));
            //回应数
            $udata[0]['revnum']=count($this->review($num));
            //热度总数
            $udata[0]['hotnum']=count($udata[0]['arr']);  
            //加入类型,链接文章ID
            $udata[0]['type']=5;
            $udata[0]['con_id']=$num;
            //截取自定义标签
            $udata[0]['tags']= $this->extags($udata[0]['tags']);
            //销毁重复的值
            unset($udata[0]['user_u_id']);
            unset($udata[0]['systags_systag_id']);
            //查询自定义标签 如果为空 数组赋空
            if(!empty($udata[0]['u_id'])){
                return $udata;
            }else{
                $udata='';
                return $udata;
            }
        }

        //查询系统标签
        function findtag($sys_id){
            $systags = d('systags')->field('systag_id,systag_name')
                                   ->where(array('systag_id'=>$sys_id))
                                   ->select();
            return $systags;
        }
        //从内容表中查询系统标签ID
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
    
         //分割自定义标签
        function extags($data){   
                        //除去最后一个',' 并且以','分割 返回数组
                $data = explode(',',trim($data,', '));
                return $data;
        }
        //分割音乐url地址
        function music($surl){
                $pieces = explode("/", $surl);
                $pieces=array_pop($pieces);
                return $pieces;
        }        
        //取出文章的评论
        function review($conid){
                 $rev=d('reviews')
                                ->field('u_id,content,time')
                                ->where(array('con_id'=>$conid))
                                ->order('rev_id desc')
                                ->limit(10)
                                ->r_select(array('user','u_ico,blogname','u_id','u_id'));
                 return $rev;
        }
 //添加/取消对文章的喜欢
        function addlike(){
            debug(0);
            //判断是否有POST传参 
            if($_POST){
                //有传参 执行分割ID方法 返回ID数组
                $data=$this->backid($_POST['id']);
                //查询数据库中是否存在记录 判断是否已经标注喜欢
               $mess=d('actions')
                   ->field('act_id')
                   ->where(array('type'=>3,'u_id'=>$data[1],'ucon_id'=>$data[0])) 
                   ->select();
                if(!empty($mess)){
                    //如果查询出数据 说明已经标注喜欢
                    //执行删除
                     $mess=d('actions')
                            ->where(array('type'=>3,'u_id'=>$data[1],'ucon_id'=>$data[0]))
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
                        ->insert(array('type'=>3,'u_id'=>$data[1],'ucon_id'=>$data[0],'time'=>$time));
                    if($mess!=false){
                            //成功返回a 失败返回b
                            $mess='a';
                    }else{
                            $mess='b';
                        }
                }
                echo $mess;
           }
        }
 //返回截取后的文章/博客ID数组
        function backid($data){
            $data=$_POST['id'];
            $data=explode(',',$data);
            return $data;            
        }

        //博文热度 (喜欢,转载,回应)
        function hot($conid){
                $hot=d('actions')
                    ->field('u_id,type,time')
                    ->where(array('ucon_id'=>$conid))
                    ->limit(10)
                    ->order('act_id desc')
                    ->r_select(array('user','u_ico,blogname','u_id','u_id'));
                return $hot;
            
        }
        //回应,热度数组 按照时间排序
        function arrsort($data){
                foreach($data as $key=>$v){
                    $datab[]=$v['time'];
                }
                array_multisort($datab,SORT_DESC,$data);
                return $data;

        }

        //添加回应
        function addrev(){
            debug(0);
            //判断是否有POST提交
            if($_POST){
                //判断用户是否被设置黑名单 
                $list=$this->black($_POST['con_id']);
                if(!empty($list)){
                    $mess=5;
                    }else{
                        //判断提交的内容是否为空
                        if(!empty($_POST['content'])){
                            //限制长度!
                            $len=strlen($_POST['content']); 
                                if($len < 120){
                                    $_POST['time']=time();
                                    $_POST['ip']=$_SERVER['REMOTE_ADDR'];
                                    //执行插入 
                                        $mess=d('reviews')
                                        ->insert($_POST);

                            if($mess!=false){
                                    $mess=1;
                                }else{
                                    $mess=2;
                                }
                            }else{
                                $mess=3;
                            }

                        }else{
                            $mess=4;
                        }
                    }
                }
            echo $mess;

        }
        //查找黑名单表 
        function black($conid){
            $list=d('contents')
                ->field('u_id')
                ->where(array('con_id'=>$conid))
                ->r_select(array('blacklist','list_id','u_id','u_id'));
            return $list[0]['blacklist_u_id'];
        }

        
          //添加/取消博客关注
        function addblog(){
            debug(0);
            //判断是否有POST传参 
            if($_POST){
                //有传参 执行分割ID方法 返回ID数组
                $data=$this->backid($_POST['id']);
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
            echo $mess;
           }
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

        //查询登录用户 返回ico
        function uico($uid){
                $uico=d('user')
                        ->field('u_ico')
                        ->where(array('u_id'=>$uid))
                        ->select();
                return $uico;
        }

        //以下为视频地址解析：杨航
        function parse($url='', $createObject=true){
        $lowerurl = strtolower($url);
        preg_match(self::CHECK_URL_VALID, $lowerurl,$matches);
        if(!$matches) return false;

        switch($matches[1]){
        case 'youku.com':
            $data = self::_parseYouku($url);
            break;
        case 'tudou.com':
            $data = self::_parseTudou($url);
            break;
        case 'ku6.com':
            $data = self::_parseKu6($url);
            break;
        case '56.com':
            $data = self::_parse56($url);
            break;
        case 'letv.com':
            $data = self::_parseLetv($url);
            break;
        case 'video.sina.com.cn':
            $data = self::_parseSina($url);
            break;
        case 'my.tv.sohu.com':
        case 'tv.sohu.com':
        case 'sohu.com':
            $data = self::_parseSohu($url);
            break;
        case 'v.qq.com':
            $data = self::_parseQq($url);
            break;
        default:
            $data = false;
        }

        if($data && $createObject) $data['object'] = "<embed src=\"{$data['swf']}\" quality=\"high\" width=\"480\" height=\"400\" align=\"middle\" allowNetworking=\"all\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\"></embed>";
        return $data;
    }
    /**
     * 腾讯视频 
     * http://v.qq.com/cover/o/o9tab7nuu0q3esh.html?vid=97abu74o4w3_0
     * http://v.qq.com/play/97abu74o4w3.html
     * http://v.qq.com/cover/d/dtdqyd8g7xvoj0o.html
     * http://v.qq.com/cover/d/dtdqyd8g7xvoj0o/9SfqULsrtSb.html
     * http://imgcache.qq.com/tencentvideo_v1/player/TencentPlayer.swf?_v=20110829&vid=97abu74o4w3&autoplay=1&list=2&showcfg=1&tpid=23&title=%E7%AC%AC%E4%B8%80%E7%8E%B0%E5%9C%BA&adplay=1&cid=o9tab7nuu0q3esh
     */ 
    private function _parseQq($url){
        if(preg_match("/\/play\//", $url)){
            $html = self::_fget($url);
            preg_match("/url=[^\"]+/", $html, $matches);
            if(!$matches); return false;
            $url = $matches[0];
        }
        preg_match("/vid=([^\_]+)/", $url, $matches);
        $vid = $matches[1];
        $html = self::_fget($url);
        // query
        preg_match("/flashvars\s=\s\"([^;]+)/s", $html, $matches);
        $query = $matches[1];
        if(!$vid){
            preg_match("/vid\s?=\s?vid\s?\|\|\s?\"(\w+)\";/i", $html, $matches);
            $vid = $matches[1];
        }
        $query = str_replace('"+vid+"', $vid, $query);
        parse_str($query, $output);
        $data['img'] = "http://vpic.video.qq.com/{$$output['cid']}/{$vid}_1.jpg";
        $data['url'] = $url;
        $data['title'] = $output['title'];
        $data['swf'] = "http://imgcache.qq.com/tencentvideo_v1/player/TencentPlayer.swf?".$query;
        return $data;
    }
    

    /**
     * 优酷网 
     * http://v.youku.com/v_show/id_XMjI4MDM4NDc2.html
     * http://player.youku.com/player.php/sid/XMjU0NjI2Njg4/v.swf
     */ 
    function _parseYouku($url){
        preg_match("#id\_(\w+)#", $url, $matches);

        if (empty($matches)){
            preg_match("#v_playlist\/#", $url, $mat);
            if(!$mat) return false;

            $html = self::_fget($url);

            preg_match("#videoId2\s*=\s*\'(\w+)\'#", $html, $matches);
            if(!$matches) return false;
        }

        $link = "http://v.youku.com/player/getPlayList/VideoIDS/{$matches[1]}/timezone/+08/version/5/source/out?password=&ran=2513&n=3";

        $retval = self::_cget($link);
        if ($retval) {
            $json = json_decode($retval, true);

            $data['img'] = $json['data'][0]['logo'];
            $data['title'] = $json['data'][0]['title'];
            $data['url'] = $url;
            $data['swf'] = "http://player.youku.com/player.php/sid/{$matches[1]}/v.swf";

            return $data;
        } else {
            return false;
        }
    }

    /**
     * 土豆网
     * http://www.tudou.com/programs/view/Wtt3FjiDxEE/
     * http://www.tudou.com/v/Wtt3FjiDxEE/v.swf
     * 
     * http://www.tudou.com/playlist/p/a65718.html?iid=74909603
     * http://www.tudou.com/l/G5BzgI4lAb8/&iid=74909603/v.swf
     */
    private function _parseTudou($url){
        preg_match("#view/([-\w]+)/#", $url, $matches);

        if (empty($matches)) {
            if (strpos($url, "/playlist/") == false) return false;

            if(strpos($url, 'iid=') !== false){
                $quarr = explode("iid=", $lowerurl);
                if (empty($quarr[1]))  return false;
            }elseif(preg_match("#p\/l(\d+).#", $lowerurl, $quarr)){
                if (empty($quarr[1])) return false;
            }

            $html = self::_fget($url);
            $html = iconv("GB2312", "UTF-8", $html);

            preg_match("/lid_code\s=\slcode\s=\s[\'\"]([^\'\"]+)/s", $html, $matches);
            $icode = $matches[1];

            preg_match("/iid\s=\s.*?\|\|\s(\d+)/sx", $html, $matches);
            $iid = $matches[1];

            preg_match("/listData\s=\s(\[\{.*\}\])/sx", $html, $matches);
            
            $find = array("/\n/", '/\s/', "/:[^\d\"]\w+[^\,]*,/i", "/(\{|,)(\w+):/");
            $replace = array("", "", ':"",', '\\1"\\2":');
            $str = preg_replace($find, $replace, $matches[1]);
            //var_dump($str);
            $json = json_decode($str);
            //var_dump($json);exit;
            if(is_array($json) || is_object($json) && !empty($json)){
                foreach ($json as $val) {
                    if ($val->iid == $iid) {
                        break;
                    }
                }
            }

            $data['img'] = $val->pic;
            $data['title'] = $val->title;
            $data['url'] = $url;
            $data['swf'] = "http://www.tudou.com/l/{$icode}/&iid={$iid}/v.swf";

            return $data;
        }

        $host = "www.tudou.com";
        $path = "/v/{$matches[1]}/v.swf";

        $ret = self::_fsget($path, $host);

        if (preg_match("#\nLocation: (.*)\n#", $ret, $mat)) {
            parse_str(parse_url(urldecode($mat[1]), PHP_URL_QUERY));

            $data['img'] = $snap_pic;
            $data['title'] = $title;
            $data['url'] = $url;
            $data['swf'] = "http://www.tudou.com/v/{$matches[1]}/v.swf";

            return $data;
        }
        return false;
    }

    /**
     * 酷6网 
     * http://v.ku6.com/film/show_520/3X93vo4tIS7uotHg.html
     * http://v.ku6.com/special/show_4926690/Klze2mhMeSK6g05X.html
     * http://v.ku6.com/show/7US-kDXjyKyIInDevhpwHg...html
     * http://player.ku6.com/refer/3X93vo4tIS7uotHg/v.swf
     */
    private function _parseKu6($url){
        if(preg_match("/show\_/", $url)){
            preg_match("#/([-\w]+)\.html#", $url, $matches);
            $url = "http://v.ku6.com/fetchVideo4Player/{$matches[1]}.html";
            $html = self::_fget($url);

            if ($html) {
                $json = json_decode($html, true);
                if(!$json) return false;
                
                $data['img'] = $json['data']['picpath'];
                $data['title'] = $json['data']['t'];
                $data['url'] = $url;
                $data['swf'] = "http://player.ku6.com/refer/{$matches[1]}/v.swf";

                return $data;
            } else {
                return false;
            }
        }elseif(preg_match("/show\//", $url, $matches)){
            $html = self::_fget($url);
            preg_match("/ObjectInfo\s?=\s?([^\n]*)};/si", $html, $matches);
            $str = $matches[1];
            // img
            preg_match("/cover\s?:\s?\"([^\"]+)\"/", $str, $matches);
            $data['img'] = $matches[1];
            // title
            preg_match("/title\"?\s?:\s?\"([^\"]+)\"/", $str, $matches);
            $jsstr = "{\"title\":\"{$matches[1]}\"}";
            $json = json_decode($jsstr, true);
            $data['title'] = $json['title'];
            // url
            $data['url'] = $url;
            // query
            preg_match("/\"(vid=[^\"]+)\"\sname=\"flashVars\"/s", $html, $matches);
            $query = str_replace("&amp;", '&', $matches[1]);
            preg_match("/\/\/player\.ku6cdn\.com[^\"\']+/", $html, $matches);
            $data['swf'] = 'http:'.$matches[0].'?'.$query;
            
            return $data;
        }
    }

    /**
     * 56网
     * http://www.56.com/u73/v_NTkzMDcwNDY.html
     * http://player.56.com/v_NTkzMDcwNDY.swf
     */
    private function _parse56($url){
        preg_match("#/v_(\w+)\.html#", $url, $matches);
        if (empty($matches)) return false;

        $link="http://vxml.56.com/json/{$matches[1]}/?src=out";
        $retval = self::_cget($link);

        if ($retval) {
            $json = json_decode($retval, true);

            $data['img'] = $json['info']['img'];
            $data['title'] = $json['info']['Subject'];
            $data['url'] = $url;
            $data['swf'] = "http://player.56.com/v_{$matches[1]}.swf";

            return $data;
        } else {
            return false;
        } 
    }

    /**
     * 乐视网 
     * http://www.letv.com/ptv/vplay/1168109.html
     * http://www.letv.com/player/x1168109.swf
     */
    private function _parseLetv($url){
        $html = self::_fget($url);
        preg_match("#http://v.t.sina.com.cn/([^'\"]*)#", $html, $matches);
        parse_str(parse_url(urldecode($matches[0]), PHP_URL_QUERY));
        preg_match("#vplay/(\d+)#", $url, $matches);
        $data['img'] = $pic;
        $data['title'] = $title;
        $data['url'] = $url;
        $data['swf'] = "http://www.letv.com/player/x{$matches[1]}.swf";

        return $data;
    }

    // 搜狐TV http://my.tv.sohu.com/u/vw/5101536
    private function _parseSohu($url){
        $html = self::_fget($url);
        $html = iconv("GB2312", "UTF-8", $html);
        preg_match_all("/og:(?:title|image|videosrc)\"\scontent=\"([^\"]+)\"/s", $html, $matches);
        $data['img'] = $matches[1][1];
        $data['title'] = $matches[1][0];
        $data['url'] = $url;
        $data['swf'] = $matches[1][2];
        return $data;
    }
        
    /*
     * 新浪播客
     * http://video.sina.com.cn/v/b/48717043-1290055681.html
     * http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=48717043_1290055681_PUzkSndrDzXK+l1lHz2stqkP7KQNt6nki2O0u1ehIwZYQ0/XM5GdatoG5ynSA9kEqDhAQJA4dPkm0x4/s.swf
     */
    private function _parseSina($url){
        preg_match("/(\d+)(?:\-|\_)(\d+)/", $url, $matches);
        $url = "http://video.sina.com.cn/v/b/{$matches[1]}-{$matches[2]}.html";
        $html = self::_fget($url);
        preg_match("/video\s?:\s?([^<]+)}/", $html, $matches);
        $find = array("/\n/", "/\s*/", "/\'/", "/\{([^:,]+):/", "/,([^:]+):/", "/:[^\d\"]\w+[^\,]*,/i");
        $replace = array('', '', '"', '{"\\1":', ',"\\1":', ':"",');
        $str = preg_replace($find, $replace, $matches[1]);
        $arr = json_decode($str, true);

        $data['img'] = $arr['pic'];
        $data['title'] = $arr['title'];
        $data['url'] = $url;
        $data['swf'] = $arr['swfOutsideUrl'];
        
        return $data;
    }

    /*
     * 通过 file_get_contents 获取内容
     */
    private function _fget($url=''){
        if(!$url) return false;
        $html = file_get_contents($url);
        // 判断是否gzip压缩
        if($dehtml = self::_gzdecode($html))
            return $dehtml;
        else
            return $html;
    }

    /*
     * 通过 fsockopen 获取内容
     */
    private function _fsget($path='/', $host='', $user_agent=''){
        if(!$path || !$host) return false;
        $user_agent = $user_agent ? $user_agent : self::USER_AGENT;

        $out = <<<HEADER
GET $path HTTP/1.1
Host: $host
User-Agent: $user_agent
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: zh-cn,zh;q=0.5
Accept-Charset: GB2312,utf-8;q=0.7,*;q=0.7\r\n\r\n
HEADER;
        $fp = @fsockopen($host, 80, $errno, $errstr, 10);
        if (!$fp)  return false;
        if(!fputs($fp, $out)) return false;
        while ( !feof($fp) ) {
            $html .= fgets($fp, 1024);
        }
        fclose($fp);
        // 判断是否gzip压缩
        if($dehtml = self::_gzdecode($html))
            return $dehtml;
        else
            return $html;
    }

    /*
     * 通过 curl 获取内容
     */
    private function _cget($url='', $user_agent=''){
        if(!$url) return;

        $user_agent = $user_agent ? $user_agent : self::USER_AGENT;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if(strlen($user_agent)) curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

        ob_start();
        curl_exec($ch);
        $html = ob_get_contents();        
        ob_end_clean();

        if(curl_errno($ch)){
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        if(!is_string($html) || !strlen($html)){
            return false;
        }
        return $html;
        // 判断是否gzip压缩
        if($dehtml = self::_gzdecode($html))
            return $dehtml;
        else
            return $html;
    }
    
    private function _gzdecode($data) {
        $len = strlen ( $data );
        if ($len < 18 || strcmp ( substr ( $data, 0, 2 ), "\x1f\x8b" )) {
            return null; // Not GZIP format (See RFC 1952) 
        }
        $method = ord ( substr ( $data, 2, 1 ) ); // Compression method 
        $flags = ord ( substr ( $data, 3, 1 ) ); // Flags 
        if ($flags & 31 != $flags) {
            // Reserved bits are set -- NOT ALLOWED by RFC 1952 
            return null;
        }
        // NOTE: $mtime may be negative (PHP integer limitations) 
        $mtime = unpack ( "V", substr ( $data, 4, 4 ) );
        $mtime = $mtime [1];
        $xfl = substr ( $data, 8, 1 );
        $os = substr ( $data, 8, 1 );
        $headerlen = 10;
        $extralen = 0;
        $extra = "";
        if ($flags & 4) {
            // 2-byte length prefixed EXTRA data in header 
            if ($len - $headerlen - 2 < 8) {
                return false; // Invalid format 
            }
            $extralen = unpack ( "v", substr ( $data, 8, 2 ) );
            $extralen = $extralen [1];
            if ($len - $headerlen - 2 - $extralen < 8) {
                return false; // Invalid format 
            }
            $extra = substr ( $data, 10, $extralen );
            $headerlen += 2 + $extralen;
        }
     
        $filenamelen = 0;
        $filename = "";
        if ($flags & 8) {
            // C-style string file NAME data in header 
            if ($len - $headerlen - 1 < 8) {
                return false; // Invalid format 
            }
            $filenamelen = strpos ( substr ( $data, 8 + $extralen ), chr ( 0 ) );
            if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
                return false; // Invalid format 
            }
            $filename = substr ( $data, $headerlen, $filenamelen );
            $headerlen += $filenamelen + 1;
        }
     
        $commentlen = 0;
        $comment = "";
        if ($flags & 16) {
            // C-style string COMMENT data in header 
            if ($len - $headerlen - 1 < 8) {
                return false; // Invalid format 
            }
            $commentlen = strpos ( substr ( $data, 8 + $extralen + $filenamelen ), chr ( 0 ) );
            if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
                return false; // Invalid header format 
            }
            $comment = substr ( $data, $headerlen, $commentlen );
            $headerlen += $commentlen + 1;
        }
     
        $headercrc = "";
        if ($flags & 1) {
            // 2-bytes (lowest order) of CRC32 on header present 
            if ($len - $headerlen - 2 < 8) {
                return false; // Invalid format 
            }
            $calccrc = crc32 ( substr ( $data, 0, $headerlen ) ) & 0xffff;
            $headercrc = unpack ( "v", substr ( $data, $headerlen, 2 ) );
            $headercrc = $headercrc [1];
            if ($headercrc != $calccrc) {
                return false; // Bad header CRC 
            }
            $headerlen += 2;
        }
     
        // GZIP FOOTER - These be negative due to PHP's limitations 
        $datacrc = unpack ( "V", substr ( $data, - 8, 4 ) );
        $datacrc = $datacrc [1];
        $isize = unpack ( "V", substr ( $data, - 4 ) );
        $isize = $isize [1];
     
        // Perform the decompression: 
        $bodylen = $len - $headerlen - 8;
        if ($bodylen < 1) {
            // This should never happen - IMPLEMENTATION BUG! 
            return null;
        }
        $body = substr ( $data, $headerlen, $bodylen );
        $data = "";
        if ($bodylen > 0) {
            switch ($method) {
                case 8 :
                    // Currently the only supported compression method: 
                    $data = gzinflate ( $body );
                    break;
                default :
                    // Unknown compression method 
                    return false;
            }
        } else {
            //...
        }
     
        if ($isize != strlen ( $data ) || crc32 ( $data ) != $datacrc) {
            // Bad format!  Length or CRC doesn't match! 
            return false;
        }
        return $data;
    }

    }
