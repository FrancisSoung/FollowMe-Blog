<?php
	/**
	 * 用户设置类
	 * @author	宋朝可
	 */
	class Userset {
		/**
		 * 显示用户设置信息
		 * @param	$data	array	查询用户表的结果
		 */
		function index() {
			debug(0);
		        $this->logincheck();
			$data = D('user')
			       -> where(array('u_id'=>$_SESSION['u_id']))
			       -> field('u_ico,email,password,blogname,info') 
			       -> select();
		
			//分配数据
			$this -> assign('data',$data);
			//分配头像
			$this -> assign('u_ico',$data[0]['u_ico']);
			$this -> assign('session',$_SESSION);
			$this -> display();
		}

		/**
		 * 关注量
		 */
		function attentionnum(){
			debug(0);
			$data = D('actions') 
				-> where(array('ucon_id'=>$_SESSION['u_id'],'type'=>1)) 
				-> field('act_id,u_id') 
				-> r_select(array('user','u_ico,blogname,info','u_id','u_id'));

			//计算关注量的总数
			$num = count($data);
			$_SESSION['attention_num'] = $num;

			//分配session变量
			$this -> assign('session',$_SESSION);
			//分配结果集
			$this -> assign('data',$data);
            		$this -> display();
		}

		/**
		 * 访问统计
		 * 
		 */
		function visited() {
			debug(0);
			//查询用户表
			$data = D('user') 
				-> where(array('u_id'=>$_SESSION['u_id'])) 
				-> field('count') 
				-> find();
			//把访问总数写到session中，方便以后调用
			$_SESSION['visited_num'] = $data['count'];
			$count = $data['count'];
			//计算日访问量
			$year = fmod(1,$count);
			//计算周访问量
			$month = fmod(7,$count);
			//计算月访问量
			$week = fmod(30,$count);
			//计算年访问量
			$day = fmod(360,$count);
			
			//分配变量
			$this -> assign('day',$day);
			$this -> assign('week',$week);
			$this -> assign('month',$month);
			$this -> assign('year',$year);
			$this -> assign('session',$_SESSION);
			$this -> assign('data',$data);
			$this -> display();
		}

		/**
		 * 用户设置提交检查
		 * @param	$pwdnow		用户当前密码
		 * @param	$user		用户表的查询结果
		 * @param	$data		用户表的修改结果
		 * @param	$email		用户邮箱
		 * @param	$password	用户密码
		 * @param	$info		博客介绍
		 * @param	$blogname	博客名称
		 * @param	$uico		用户的头像
		 */
		function check() {

			debug(0);
			//判断是否提交，避免重复提交
			if(isset($_POST['sub'])){
				//md5加密密码
				$pwdnow = md5($_POST['pwdnow']);
				//查询数据库验证密码
				$user = D('user') 
					//这里是限制用户为已经登录的用户
					-> where(array('u_id'=>$_SESSION['u_id'])) 
					-> field('u_ico,password') 
					-> find();

				//判断当前密码为空的情况，如果为空则提示错误消息
				if($user['password']!=$pwdnow){
					$this -> error('密码输入有误！',3,'/userset/index');
				}else{
					
					//调用上传类，实现图片上传，返回值是文件的名称
					$up = $this -> upload();
					$img = new Image('./upload/bigimg/');
					//循环遍历，实现多个图片的剪切，分别放到相应的目录下
					foreach($up as $v){
						$_POST['pic'] = $v;
						//先把上传的头像缩放，然后再剪切
                                                $imgname = $img -> thumb($v,150,150,'','./upload/bigico/','no');
                                                $cut = new Image('./upload/bigico/');
                                                $imgname = $cut -> cut($v,150,150,'','./upload/bigico/');
                                                $imgname = $img -> thumb($v,38,38,'','./upload/littleico/','no');
                                                $cut = new Image('./upload/littleico/');
                                                $imgname = $cut -> cut($v,38,38,'','./upload/littleico/');
                                                $imgname = $img -> thumb($v,20,20,'','./upload/microico/','no');
                                                $cut = new Image('./upload/microico/');
						$imgname = $cut -> cut($v,20,20,'','./upload/microico/');
						$imgname = $img -> thumb($v,60,60,'','./upload/normalico/','no');
						$cut = new Image('./upload/normalico/');
                                                $imgname = $cut -> cut($v,60,60,'','./upload/normalico/');
                                                $imgname = $img -> thumb($v,215,215,'','./upload/systagico/','no');
                                                $cut = new Image('./upload/systagico/');
						$imgname = $cut -> cut($v,215,162,'','./upload/systagico/');
					}
					//把接收到的信息重新赋值到变量里
					$uico=$up[1];
					$email=$_POST['email'];
					$password=$_POST['pwdnew1'];
					$blogname=$_POST['blogname'];
					$info=$_POST['info'];
					//重新组合一下数组，方便修改数据库使用
					if($_POST['pwdnew1']==''){
						$a['u_ico'] = $uico;
						$a['email'] = $email;
						$a['blogname'] = $blogname;
						$a['info'] = $info;
					}else{
						$a['u_ico'] = $uico;
						$a['email'] = $email;
						$a['password'] = md5($password);
						$a['blogname'] = $blogname;
						$a['info'] = $info;
					}
					//执行修改语句，修改用户信息
					$data = D('user')
						-> where(array('u_id'=>$_SESSION['u_id']))
						-> update($a);
					//返回消息并跳转页面
					if($data){
						$this -> success('修改成功！',3,'/userset/index');
					}else{
						$this -> error('修改失败！',3,'/userset/index');
					}
					
				}

			}
		}

		/**
		 * 用户头像上传
		 * @return	成功返回文件名，失败返回失败消息
		 */
		private function upload() {
			$up = new FileUpload();
			$up -> set('path','./upload/bigimg/') //设置源目录
				-> set('maxSize',1000000)	//设置最大上传的值
				-> set("allowtype", array("gif", "jpg","png")) //设置允许上传的图片类型
				-> set('israndname',true)	//开启随机设置名
				-> set('thumb',array('width'=>500,'newpath'=>'./upload/normalimg/'));	//设置缩放
			//成功返回文件名，失败返回消息
			if($up -> upload('pic')){
				return array(true,$up -> getFileName());
			}else{
				return array(false,$up ->getErrorMsg());
			}
		}
		/**
		 * 如果登录成功跳转到后台首页
		 */
                function logincheck(){
                if(!(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"]==1)){
                        $this->redirect("login/index");
		}
		}
	}
