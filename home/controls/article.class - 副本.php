<?php
	/**
	 * 文章页
	 * @author	宋朝可
	 */
	class article{
		function index(){
			debug(0);
			//关联查询内容表、系统标签表、用户表，获取文章内容
			$data = D('contents') 
				-> where(array('u_id'=>$_SESSION['u_id'],'type'=>1))
				-> order('time desc')
				-> field('con_id,u_id,title,content,systag_id,tags') 
				-> r_select(array('systags','systag_name','systag_id','systag_id'),array('user','u_ico','u_id','u_id'));

			//循环查询结果数组，把自定义标签用逗号分割一下，再存入数组
			foreach($data as &$v){

				$a=explode(',',$v['tags']);
				array_pop($a);
			 	$v['tags'] = $a;
			}

			//计算文章总数，并写到session数组中，便于浏览其他页面时数据还在
			$num = count($data);
			$_SESSION['article_num'] = $num;
			//分配关联查询结果
			$this -> assign('data',$data);
			//分配session变量给页面
			$this -> assign('session',$_SESSION);
			$this -> display();
		}

		/**
		 * 执行删除
		 */
		function del() {
			debug(0);
			$data = D('contents') 
				-> where(array('u_id'=>$_SESSION['u_id'])) 
				-> delete($_GET['con_id']);
			//返回值给ajax
			if($data!=''){
				echo 1;
			}else{
				echo 0;
			}

		}
		
	}
