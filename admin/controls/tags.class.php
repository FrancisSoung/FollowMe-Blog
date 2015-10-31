<?php
/**
 * 作者:杨航
 **/
class Tags {
        //主页面
        function index(){

                $this->sys3d();
                $this->display();
        }
        //添加标签页面
        function add(){
                $this->sys3d();
                $this->display();
        }
        //添加新标签
        function insert(){
                $issue=D("systags");
                $_POST['time']=date("Y-m-d H:i:s");
                if($issue->insert($_POST,array("systag_name","seque","sort","time"),1)){
                        $this->success("添加标签{$_POST["systag_name"]}成功！",1,"index");
                }                
        }
        //更新标签
        function update(){
                $issue=D("systags");
		if($issue->update($_POST,1,1)) {
                        $this->success("修改成功", 1, "index");
                }
			                
        }
        //删除标签
        function delete(){
			$id=!empty($_POST["id"]) ? $_POST["id"] : $_GET["id"];
			if(D("systags")->delete($id)) {
				//删除记录对应的图片
				$this->redirect("index");
			}
        }
        //修改标签
        function mod(){
                debug(0);
                $this->sys3d();
                $this->assign("systag", D("systags")->find($_GET['id']));
                $this->display();
        }
        //遍历所有系统标签，用于3D云标签
        function sys3d(){
                $page = new Page(D('systags') -> total(),7);
                $issue=D("systags");
                $data = $issue->field("systag_id,systag_name,seque,sort,time")->order("systag_id desc")-> limit($page -> limit)->select();
                $this -> assign("fpage",$page -> fpage());
                return $this->assign("data",$data);
        }
 }
