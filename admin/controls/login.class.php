<?php
	/**
	 * 登录
	 * @author	宋朝可
	 */
	class Login extends Action {
		//载入登录页
                function index(){
                        debug(0);
			$this -> display();
		}
		/**
		 * 登录验证
		 * @param	$name		管理员名字
		 * @param	$password	管理员密码
		 * @param	$root		查询管理员表的结果集
		 *
		 */
		function login() {
			//判断是否点击登录按钮
			if($_POST['wp-submit']){
				//过滤下表单内容
				$name = trim($_POST['log']);
				$password = trim($_POST['pwd']);
				//查询管理员表
				$root = D('root')
					-> where(array('name'=>$name,'password'=>md5($password)))
					-> find();
				if($root){
					//把结果集放到session里面
					$_SESSION = $root;
					$_SESSION['isLogin'] = 2;
					$this -> success('登录成功',1,'index/index');
				}else{
					$this -> error('用户名或密码错误',1,'login/index');
				}
			}
		}

		/**
		 * 退出登录
		 * @param	$name	管理员名字
		 */
		function logout() {
			$name = $_SESSION['name'];
			//把session清空
			$_SESSION = array();
			//销毁cookie
			if(isset($_COOKIE[session_name()])){
				setCookie(session_name(),'',time()-3600,'/');
			}
			//销毁session
			session_destroy();
			$this -> success('退出成功,再见'.$name,2,'index');
		}
	}
