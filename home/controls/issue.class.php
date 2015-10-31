<?php
/**
 * 杨航
 * 发布内容页面
 **/
class Issue{
        function Index(){
                $this->assign("fmtitle","Follow Me发布文章");
		if(!empty($_GET['conid'])){
			//宋朝可飘过，把俺的文章页中的ID传过来查询数据库，借用此页编辑一下
			$dat = D('contents') -> field('title,content') -> where(array('con_id'=>$_GET['conid'])) -> select();
			foreach($dat as &$v){
				$title = $v['title'];
				$content = $v['content'];
			}
			$this -> assign('title',$title);
                        $this -> assign('content',$content);
                        $this->common();

		}else{
                        $this->common();
		}

        }
        //发布图片
        function images(){
                //设置该页title
                $this->assign("fmtitle","Follow Me发布图片");
                $this->common();
        }
        function link(){
                $this->assign("fmtitle","Follow Me发布音乐");
                $this->common();
        }
        function music(){
                $this->assign("fmtitle","Follow Me发布视频");
                $this->common();
        }
        function video(){
                $this->assign("fmtitle","Follow Me发布链接");
                $this->common();
        }
        //调用编辑器
        function editor(){
                return $this->assign("editor", Form::editor("content", "basic","250","#FFFFFF","0"));
        }
        //将内容插入数据库
        function insert() {
                $issue=D("contents");
                $_POST['time']=time();
                $_POST['u_id']=$_SESSION['u_id'];
                //传入隐藏type类型为1 则插入文章
                if($_POST['type']==1){                        
                        if($issue->insert($_POST,0,1)){
                                $this->success("发布文章{$_POST["title"]}成功！",1,"index/index");
                        }
                //传入隐藏表单type类型为2 则添加图片
                }else if($_POST['type']==2){
                        $up=$this->upload();
                        $img=new Image("./upload/bigimg/");
                        foreach($up as $p){
                                $_POST['image']=$p;
                                $img->thumb($p, 500,500, "","./upload/normalimg/","ok");
                                $img->thumb($p, 150,150, "","./upload/microimg/","ok");
                                $img->thumb($p, 200,200, "","./upload/wallimg/","ok");
                                
                        }
                        //如果上传图片成功 则发布成功
                        if($up){
                                if($issue->insert($_POST,0,1)){
                                        $this->success("发布图片成功！",1,"index/index");
                                }
                        }else{
                                $this->error("上传图片失败，请换一张！",1,"issue/images");
                        }
                //隐藏表单type为3 则添加音乐
                }else if($_POST['type']==3){
                        if($issue->insert($_POST,0,1)){
                                $this->success("添布声音成功！",1,"index/index");
                        }
                //隐藏表单type为4 则添加视频
                }else if($_POST['type']==4){
                        if($issue->insert($_POST,0,1)){
                                $this->success("发布视频成功！",1,"index/index");
                        }
                //隐藏表单type为5 则添加链接
                }else if($_POST['type']==5){
                        if($issue->insert($_POST,0,1)){
                                $this->success("发布链接成功！",1,"index/index");
                        }
                }

        }
        //获取系统标签id
        function systag(){
                $issue=D("systags");
                $data = $issue->field("systag_id,systag_name")->order("systag_id desc")->select();
                return $this->assign("data",$data);
        }
        //图片上传
        private function upload(){
                $up = new FileUpload();
                
                $up->set("path", "./upload/bigimg/")
                   ->set("maxsize", 1000000000)
                   ->set("allowtype", array("gif", "jpg","png"))
                   ->set("israndname", true)
                   ->set("thumb",array("width"=>500,"","newpath"=>"./upload/normalimg/"));
                if($up->upload("pic")) {
                        return array(true, $up->getFileName());
                }else {
                        return array(false, $up->getErrorMsg());
                }	
        }
        //检查是否登录，如果没登录则跳转到登陆页面
        function logincheck(){
                if(!(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"]==1)){
                        $this->redirect("login/index");
                }
        }
        function common(){
                $this ->assign ('session',$_SESSION);
                $this->logincheck();
                $this->editor();
                $this->systag();
                $this->display();
        }
}
