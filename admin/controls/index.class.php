<?php
/*
 *杨航  框架 调用页面
 * */
	class Index {
        function index(){
                debug(0);
		        $this -> display(); 
        }	
        function top(){
                debug(0);
                $this -> display();
        }    
        function left(){
                debug(0);
                $this -> display();
        }
        //记录管理员来访IP
        function right (){
                $user=D("user");
                $ip=$_SERVER['REMOTE_ADDR'];
                $this->assign("ip",$ip);
                $data=$user->select();
                $this->assign("data",$data);
                $this -> display();
        }
        //管理员向所有用户快速发布广播
        function insert(){
                $broadcast=D('broadcasts');
                $_POST['type']=1;
                $_POST['time']=time();
                if($broadcast->insert($_POST)){
                        $this->success("发布广播成功",2,"index/right");
                }
        }
}
