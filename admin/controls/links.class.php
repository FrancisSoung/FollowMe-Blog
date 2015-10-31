<?php
	/**
	 * 链接管理
	 * @author	宋朝可
	 */
	class Links {
		/**
		 * @param	$data	链接的内容
		 * @param	$nnum	屏蔽的总数
		 * @param	$sum	链接总数
		 * @param	$user	查询用户表返回的结果集
		 * @param	$review	查询评论表返回的结果集
		 * @param	$time	时间数组
		 * @param	$year	存放所有的年份
		 * @param	$month	存放所有的月份
		 *
		 */
		function index(){
			
			//分页
			$page = new Page(D('contents') -> where(array("type"=>"5"),array("type"=>'50')) -> total(),10);
			//查询主表，获取链接的内容
			$data = D("contents") 
				-> where(array("type"=>"5"),array("type"=>"50"))
			        -> limit($page -> limit)	
				-> order("time desc") 
				-> field("con_id,u_id,link,type,tags,time") 
				-> select();

			//查询表中屏蔽的总数
			$nnum = D("contents")
				-> where(array("type"=>"50"))
				-> total();
			//查询显示总数
			$mnum = D("contents")
				-> where(array("type"=>"5"),array("type"=>"50"))
				-> total();

			//遍历主表结果，调用私有方法
			foreach($data as &$v) {
				$user = $this -> user($v['u_id']);
				$review = $this -> review($v['con_id']);
				$v["blogname"] = $user['blogname'];
				$v["total"] = $review;
				$time[] = $v['time'];
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
			$this -> assign("num",$mnum);
			$this -> assign("nnum",$nnum);
			$this -> assign("data",$data);
			//发送分页变量
			$this -> assign("fpage",$page -> fpage());
			$this -> display();
		}
		/**
		 * 查询用户表
		 * @param	$uid	主方法传过来的关联字段值
		 * @return	array	关联数组
		 */
		private function user($uid) {

			return D("user") 
				-> field("blogname") 
				-> where(array("u_id"=>$uid)) 
				-> find();
		}
		/**
		 * 查询评论表
		 * @param	$conid	主方法传过来的关联字段值
		 * @return	int 	评论的总数
		 */
		private function review($conid) {

			return D("reviews")
				-> where(array("con_id"=>$conid)) 
				-> total();
		}

		/**
		 * ajax按日期查询
		 * @param	$y	存放接收过来的年份
		 * @param	$m	存放接收过来的月份
		 * @param	$t	起始时间，即传过来的时间
		 * @param	$tt	月底时间
		 * @param	$res	匹配之后的结果集
		 * @param	$ww	存放提示信息
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
			$page = new Page(D("contents") 
				-> where(array("time <="=>$tt,"time >="=>$t,"type"=>"5"),array("time <="=>$tt,"time >="=>$t,"type"=>"50")) 
				-> total(),10);

			//查询内容表符合时间条件的内容
			$res = D("contents") 
				-> where(array("time <="=>$tt,"time >="=>$t,"type"=>"5"),array("time <="=>$tt,"time >="=>$t,"type"=>"50")) 
				-> order("time desc") 
				-> limit($page -> limit)
				-> field("con_id,u_id,link,tags,time") 
				-> r_select(array("user", 'blogname', 'u_id', "u_id"));
			
			//判断是否取得值
			$ww=array();
			if($res){
				//查询评论表，计算符合条件的评论的总数
				foreach($res as $val ){
					$val["total"] = D("reviews") 
						-> where(array('con_id'=>$val['con_id']))
					       	-> total();
					$ww[] = $val;
				}
			}else{
				
				$ww = '抱歉，没有查找到您要的结果！';
			}
			
			//分配给ajax模板
			$data = $ww;
			$this -> assign("data",$data);
			$this -> assign('fpage',$page -> fpage());
			$this -> display("ajax");
			
		}

		/**
		 * ajax删除单个链接
		 * @return	这里用return返回的话ajax接收不到，只能用echo返回值
		 */
		function deletes() {
			
			debug(0);
			//执行删除操作，并返回给ajax一个状态值
			if(D("contents") -> delete($_GET['conid'])){

				$data = "success";
				echo $data;
	
			}else{

				$data = "false";
				echo $data;
			}
		}

		/**
		 * 删除选中链接
		 * @return 1 代表真，2 代表假
		 */
		function checkdel() {
			debug(0);
			$rdd = trim($_GET['rd']);
			$del = trim($_GET['del']);
			//分割数组，循环删除相应的数据
			if(!empty($rdd)){
				$arr_id = explode(",",$rdd);
				foreach($arr_id as $key => $val){
					$delete = D("contents") -> delete($val);
				}
				//设置返回值
				$reback = '0';
 				if($delete){
     					$reback = '1';
 				}
 				echo $reback;
			}
        	
		}

		/**
		 * 屏蔽链接
		 * @param	$conid	接收文章的ID
		 * @param	$status	文章的额状态（shield是屏蔽，display是显示）
		 */
		function shield() {
			debug(0);
			$conid = $_GET['conid'];
			$status = $_GET['status'];
			//屏蔽操作
			if($status == 'shield'){
				$rowsone = D('contents') 
				-> where(array('con_id'=>$conid,$_GET["s"]=>$_GET["val"])) 
				-> update('type=50');
				if($rowsone){
				 	$mess='a';
				}
			}
			//显示操作
			if($status == 'display'){
				$rowstwo = D('contents') 
				-> where(array('con_id'=>$conid,$_GET["s"]=>$_GET["val"])) 
				-> update('type=5');
				if($rowsone){
				 	$mess='';
				}
			}
			 
			echo $mess;
		}

		/**
		 * 显示已屏蔽
		 */
		function shielded() {
			debug(0);

			//用于分页
			$page = new Page(D("contents")
				-> where(array("type"=>'50'))
				-> total(),10);

			//查询内容表符合时间条件的内容
			$data = D("contents") 
				-> where(array("type"=>'50')) 
				-> order("time desc")
				-> limit($page -> limit)
				-> field("con_id,u_id,link,type,tags,time") 
				-> r_select(array("user", 'blogname', 'u_id', "u_id"));
			//查询评论表，计算符合条件的评论的总数
			foreach($data as &$val ){
				$val["total"] = D("reviews") 
					-> where(array('con_id'=>$val['con_id'])) 
					-> total();
			}
			//分配变量到模板
			$this -> assign("data",$data);
			$this -> assign('fpage',$page -> fpage());
			$this -> display("shielded");
		}
	}
