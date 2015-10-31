<?php
/**
 * 杨航
 **/
class Login extends Action {
        function Index(){
                debug(0);
                $this->display();
        }
        //用户登陆
        function login(){

                $user=D("user")
                        ->where(array("u_name"=>$_POST["u_name"],"password"=>md5($_POST["password"])))
                        ->find();
                if($user){
                        if($user['status']==1){
                                $this->error("不好意思被封号，请联系管理!",1,"index");
                        }else{
                                
                                $_SESSION=$user;
                                $_SESSION["isLogin"]=1;
                                $this->success("用户登陆成功",1,"index/index");
                        }
                }else{
                        $this->error("用户或者密码错误!",1,"index");
                }
        }
        //用户注册
        function register(){
                $_POST['password']=md5($_POST['password']);
                $check=D("user");
                        
                if($check->where(array("u_name"=>$_POST["u_name"]))->find()){
                        $this->success("{$_POST["u_name"]}用户名已经存在！",5,"index");
                }elseif($check->where(array("email"=>$_POST["email"]))->find()){
                        $this->success("{$_POST["email"]}邮箱已经存在!",5,"index");

                }else{
                        $user=D("user");
                        if($user->insert($_POST)){
                                $this->success("{$_POST["u_name"]}注册成功,请登陆！",2,"index");
                        }else{
                                $this->error("{$_POST["u_name"]}注册失败,请重新注册！",2,"index");
                        }
                }

        }
        //用户退出
        function logout(){
                $username=$_SESSION["u_name"];
                $_SESSION=array();
                if(isset($_COOKIE[session_name()])){
                        setCookie(session_name(),'',time()-3600,'/');
                }
                session_destroy();
                $this->success("退出成功,再见{$username}",1,"index");
        }
 }
