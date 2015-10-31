<?php
	/**
	 * 评论管理
	 * @author	宋朝可
	 *
	 */
	class Review {
		
		/**
		 * 查询评论表
		 * @param	$data	查询评论表的结果集
		 * @param	$num	评论总数
		 * @param	$content 查询内容表的结果集
		 */
		function index() {

			//分页
			$page = new Page(D('reviews') -> total(),7);
			// 查询评论表
			$data=D('reviews') 
				-> field('rev_id,con_id,u_id,content,time,ip') 
				-> limit($page -> limit)
				-> order('time desc') 
				-> select();

			//统计全部总数
			$num=D('reviews') -> total();

			//循环插入数据
			foreach($data as &$v){
				//调用内容函数，把结果赋给数组$contents
				$contents = $this -> contents($v['con_id']);
				//把内容中的标题追加到数组$data中
				$v['title'] = $contents['title'];
				//把内容中的被评论者追加到数组$data中
				$v['bu_name'] = $contents['bu_name'];
				$user = $this -> user($v['u_id']);
				$v['u_name'] = $user['u_name'];
				$v['email'] = $user['email'];
				$v['u_ico'] = $user['u_ico'];
				$time[]	= $v['time'];
			}

			//循环遍历并格式化时间戳
			for ($i=0; $i <count($time); $i++) {

				$year[] = date("Y",$time[$i]);
				$month[]=date("m",$time[$i]);

			}

			//删除重复的时间
			$year = array_unique($year);
			$month = array_unique($month);

			//重新排列数组（改变数组原有的键）
			$year = array_values($year);
			$month = array_values($month);

			//发送数据，并调用模板
			$this -> assign("year",$year);
			$this -> assign("month",$month);
			$this -> assign("time",$time);
			$this -> assign('data',$data);
			$this -> assign('num',$num);
			//分配分页变量
			$this -> assign("fpage",$page -> fpage());
			$this -> display();
			
		}

		/**
		 * ajax查询
		 * @param	$y	接收过来的年
		 * @param	$m	接收过来的月
		 * @param	$t	接收过来的用户选择的时间戳
		 * @param	$tt	月末最后一天的时间戳
		 * @param	$time	时间
		 * 
		 * 
		 */
		function date() {

			debug(0);

			//接收ajax传过来的值
			$y = $_POST['year'];
			$m = $_POST['month'];

			//传过来的时间，生成时间戳
			$t = mktime(0,0,0,$m,1,$y);
			$tt = mktime(0,0,0,$m+1,0,$y);

			//用于分页
			$page=new Page(D('reviews') 
				-> where(array("time <="=>$tt,"time >="=>$t))
				-> total(),10);

			// 查询评论表
			$data=D('reviews') 
				-> where(array("time <="=>$tt,"time >="=>$t))
				-> order("time desc")
				-> limit($page -> limit)
				-> field('rev_id,con_id,u_id,content,time,ip')
				-> select();

			//循环插入数据
			foreach($data as &$v){
				//调用内容函数，把结果赋给数组$contents
				$contents = $this -> contents($v['con_id']);
				//把内容中的标题追加到数组$data中
				$v['title'] = $contents['title'];
				//把内容中的被评论者追加到数组$data中
				$v['bu_name'] = $contents['bu_name'];
				$user = $this -> user($v['u_id']);
				$v['u_name'] = $user['u_name'];
				$v['email'] = $user['email'];
				$v['u_ico'] = $user['u_ico'];
				$time[]	= $v['time'];
			}

			if(!$data){
				$data = '抱歉，没有查找到您要的结果！';
			}

			//分配给ajax模板
			$this -> assign("data",$data);
			$this -> assign('fpage',$page);
			$this -> display("ajax");
			
		}

		/**
		 * ajax删除
		 * @return	这里用return返回的话ajax接收不到，只能用echo返回值
		 */
		function deletes() {
			
			debug(0);

			//执行删除操作，并返回给ajax一个状态值
			if(D("reviews") -> delete($_GET['revid'])){

				$data = "success";
				echo $data;
	
			}else{
				$data = "false";
				echo $data;
			}
		}

		/**
		 * 选中删除
		 * @param	$rdd	接收过来的评论的ID
		 * @return 1 代表真，2 代表假
		 */
		function checkdel() {
			debug(0);
			$rdd = trim($_GET['rd']);
			p($rdd);
			//循环删除数组中的值
			if(!empty($rdd)){
				$arr_id = explode(",",$rdd);
				foreach($arr_id as $key => $val){
					$delete = D("reviews") -> delete($val);
				}

				if($delete){
					$reback = '1';
				}
 				echo $reback;
			}
		}

		/**
		 * 查询内容表
		 * @param 		$conid 		array 	评论表中的con_id
		 * @return		$contents 	array 	$contents['title']		被评论内容的的标题
		 * @return		$contents 	array	$contents['bu_name'] 	被评论者，即被评论内容的博主
		 */
		function contents($conid) {

			$contents = D('contents') 
				-> where(array('con_id'=>$conid)) 
				-> field('u_id,title') 
				-> find();

			//调用被评论者的方法
			$buser = $this -> buser($contents['u_id']);
			//从返回的数组中获得被评论者的名字加到数组$contents中
			$contents['bu_name']=$buser['bu_name'];
			//将数组返回
			return $contents;

		}

		/**
		 * 查询用户表  获得发表评论的用户信息
		 * @param 		$uid 		评论表中的u_id
		 * @return 	array 		数组中包含着发表评论的用户的名字和邮箱
		 */
		function user($uid) {
			
			return D('user') 
				-> where(array('u_id'=>$uid)) 
				-> field('u_ico,u_name,email') 
				-> find();
		}

		/**
		 * 查询用户表	获得被评论的用户名字
		 *  @param 		$uid 		内容表中的u_id,也就是查询出谁发表的内容（例：文章），即被评论者
		 *  @param 		array 		数组中包含着被评论者的名字
		 */
		function buser($uid) {
			
			return D('user') -> where(array('u_id'=>$uid)) -> field('u_name bu_name') -> find();
		}

		
	}


