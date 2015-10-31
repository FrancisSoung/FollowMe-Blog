<?php
class User{
                //遍历所有用户,并且创建分页
                function index(){
                        $page = new Page(D('user') -> total(),7);
                        $data = D('user') 
			        -> limit($page -> limit)
				-> select();
                        debug(0);
                        $this -> assign('fpage',$page -> fpage());
                        $this->assign("data",$data);
			$this -> display();
                }

                //修改用户登陆状态 0为允许登陆 1为不能登陆
		function shield() {
                        debug(0);
			$u_id = $_GET['u_id'];
                        $status = $_GET['status'];
                        p($u_id);
			
			if($status == '0'){
				$user = D('user') 
				-> where(array('u_id'=>$u_id)) 
				-> update('status=1');
			}else{
				$user = D('user') 
				-> where(array('u_id'=>$u_id)) 
				-> update('status=0');
			}
			echo $mess;
                }
		function deletes() {			
			debug(0);
			//执行删除操作，并返回给ajax一个状态值
                        D("user") -> delete($_GET['u_id']);
                        D("contents") ->where(array("u_id"=>$_GET['u_id'])) -> delete();

                }
                //修改用户
                function mod(){
                        $_POST['password']=md5($_POST['password']);
                        $mod=D('user')->where(array('u_id'=>$_POST['u_id']))->update($_POST);
                }
	}
