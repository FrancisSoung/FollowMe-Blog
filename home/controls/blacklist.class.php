<?php
		/**
		 * 黑名单
		 * @author	宋朝可
		 */
		class blacklist {
			/**
			 * @param	$num	黑名单的总数
			 */
			function index(){

				//查询黑名单表和用户表
				$data = D('blacklist') 
					-> where(array('u_id'=>$_SESSION['u_id'])) 
					-> field('list_id,u_id,su_id') 
					-> r_select(array('user','u_ico,blogname,info','u_id','su_id'));
				//计算黑名单的总数
				$num = count($data);
				//把黑名单的总数写到session数组中，可以在其他页面也显示
				$_SESSION['blacklist_num'] = $num;
				$this -> assign('data',$data);
				//分配session变量到页面
				$this -> assign('session',$_SESSION);
				$this -> display();
			}

		/**
		 * ajax解除黑名单
		 * @return	1	代表真
		 * @return	0	代表假
		 */
		function remove() {
			debug(0);
			//接收ajax数据，并解除黑名单
			if($_GET['list_id']!=''){
				$data = D('blacklist') 
					-> where(array('u_id'=>$_SESSION['u_id'])) 
					-> delete($_GET['list_id']);
				//给ajax一个返回值，反映当前状态 
				if($data){
					echo 1;
				}else{
					echo 0;
				}
			}
			
			
		}
		
		/**
		 * 添加黑名单
		 * @return	真返回1，假返回相应的提示信息
		 *
		 */
		function add() {

			debug(0);
			
			$_GET['u_id'] = $_SESSION['u_id'];
		
			//查询用户表
			$user = D('user') -> field('u_id') -> select();

			//循环遍历，把查询到的博主的ID放到一个数组中，便于以下判断
			foreach($user as &$v){
				$uid[] = $v['u_id'];
			}

			//执行判断验证
			if($_SESSION['isLogin']=1){
				if($_GET['su_id']!=''){
					if($_GET['su_id']!=$_SESSION['u_id']){
						if(in_array($_GET['su_id'],$uid)){

						//执行添加操作
						$dat = D('blacklist') 
							-> where(array('u_id'=>$_SESSION['u_id'])) 
							-> insert($_GET);

						//给ajax一个返回值	
						if($dat){
							echo 1;
						}else{
							echo '添加失败！';
						}
						}else{
							echo '你输入的博主不存在哦~';	
						}
					}else{
						echo '不能添加自己哦~~';
					}
				}else{
					echo 'ID不能为空哦,请输入(*^__^*)';
				}
			}else{
				echo '对不起，您没请登录之后再操作！';
			}

		}
			
			
	}

	
