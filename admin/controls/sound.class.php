<?php
	/**
	 * 声音管理
	 * @author	宋朝可
	 * @param	$page	用于分页
	 * @param	$data	查询声音表的结果集
	 * @param	$nnum	屏蔽的总数
	 * @param	$num	全部的总数
	 * @param	$year	存放年的数组
	 * @param	$month	存放月的数组
	 *
	 */
	class Sound {
		function index(){

			//分页
			$page = new Page(D('contents') -> where(array("type"=>"3"),array("type"=>'30')) -> total(),10);
			//获取类型为声音的内容
			$data = D("contents") 
				-> where(array("type"=>"3"),array("type"=>"30")) 
				-> limit($page -> limit)
				-> field("con_id,u_id,sound,type,tags,time") 
				-> select();
			//计算屏蔽的总数
			$nnum = D('contents') 
				-> where(array('type'=>'30'))
				-> total();
			//计算全部的总数
			$num = D('contents') 
				-> where(array('type'=>'3'),array('type'=>'30'))
				-> total();

			//遍历结果
			foreach($data as &$v) {
				//调用下面查询用户表方法
				$user = $this -> user($v['u_id']);
				//调用下面查询评论表方法
				$review = $this -> review($v['con_id']);
				//把以上两个方法返回的值重新赋值到数组中
				$v['blogname'] = $user['blogname'];
				$v['total'] = $review;
				$time[]=$v['time'];	
			}

			//循环遍历并格式化时间戳
			for($i=0;$i<count($time);$i++){

				$year[]=date("Y",$time[$i]);
				$month[]=date("m",$time[$i]);

			}

			//删除重复的时间	
			$year=array_unique($year);
			$month=array_unique($month);

			//对数组排序（按时间大小排序）
			rsort($year);
			sort($month);
			$year = array_values($year);
			$month = array_values($month);

			//分配变量并调用模板
			$this -> assign("year",$year);
			$this -> assign("month",$month);
			$this -> assign("time",$time);
			//分配数组到模板
			$this -> assign("data",$data);
			//分配结果总数到模板
			$this -> assign("num",$num);
			$this -> assign("nnum",$nnum);
			$this -> assign('fpage',$page -> fpage());
				$this -> display();
		}

		/**
		 * 查询用户表
		 * @param	$uid	用户的ID
		 * @return	array	二维数组
		 */
		private function user($uid) {
			return D("user") 
					-> where(array("u_id"=>$uid)) 
					-> find();
		}

		/**
		 * 查询评论表
		 * @param	$conid 	内容的ID
		 * @return	int 	返回计算的评论总数
		 */
		private function review($conid) {
			return D("reviews") 
					-> where(array("con_id"=>$conid)) 
					-> total();
		}

		/**
		 * ajax查询
		 * @param	$y	接收过来的年
		 * @param	$m	接收过来的月
		 * @param	$t	当前的时间戳
		 * @param	$tt	月末的时间戳
		 * @param	$ww	存储ajax返回值
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

			//分页
			$page = new Page(D("contents") 
				-> where(array("time <="=>$tt,"time >="=>$t,"type"=>"3"),array("time <="=>$tt,"time >="=>$t,"type"=>"30")) 
				-> total(),10);

			
			//查询内容表符合时间条件的内容
			$res = D("contents") 
					-> where(array("time <="=>$tt,"time >="=>$t,"type"=>"3"),array("time <="=>$tt,"time >="=>$t,"type"=>"30"))
					-> limit($page -> limit)
					-> order("time desc") 
					-> field("con_id,u_id,sound,tags,time") 
					-> r_select(array("user", 'blogname', 'u_id', "u_id"));
			$ww=array();
			//判断是否取得值
			if($res){
				//查询评论表，计算符合条件的评论的总数
				foreach($res as $val ){
					$val["total"] = D("reviews") -> where(array('con_id'=>$val['con_id'])) -> total();
					$ww[] = $val;
				}
			}else{
				
				$ww = '抱歉，没有查找到您要的结果！';
			}
			
			//分配给ajax模板
			$data = $ww;
			$this -> assign("data",$data);
			$this -> assign('fpage',$page -> fpage());
			$this -> assign("sorry",$sorry);
			$this -> display("ajax");
			
		}

		/**
		 * ajax删除
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
		 * 选中删除
		 * @param	$rdd	接收过来的声音的ID
		 * @return 1 代表真，2 代表假
		 */
		function checkdel() {
			debug(0);
			//过滤一下（删除两端的空格）
			$rdd = trim($_GET['rd']);
			//循环遍历删除
			if(!empty($rdd)){
				$arr_id = explode(",",$rdd);
				foreach($arr_id as $key => $val){
					$delete = D("contents") -> delete($val);
				}
				//设置返回值
				if($delete){
     					$reback = '1';
 				}
 				echo $reback;
			}
        	
		}

		/**
		 * 屏蔽文章
		 * @param	$conid	接收声音的ID
		 * @param	$status	接收用户要操作的状态（shield代表屏蔽，display代表显示）
		 * @return	$mess	返回操作之后的状态，便于模板处理
		 */
		function shield() {
			debug(0);
			$conid = $_GET['conid'];
			$status = $_GET['status'];
			//屏蔽操作
			if($status == 'shield'){
				$rowsone = D('contents') 
				-> where(array('con_id'=>$conid,$_GET["s"]=>$_GET["val"])) 
				-> update('type=30');
				if($rowsone){
				 	$mess='a';
				}
			}

			//显示操作
			if($status == 'display'){
				$rowstwo = D('contents') 
				-> where(array('con_id'=>$conid,$_GET["s"]=>$_GET["val"])) 
				-> update('type=3');
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
			
			//查询内容表用于分页
			$page = new Page(D("contents") -> where(array("type"=>'30')) -> total());

			//查询内容表符合时间条件的内容
			$data = D("contents")
				-> where(array("type"=>'30'))
				-> order("time desc") 
				-> limit($page -> limit)
				-> field("con_id,u_id,sound,type,tags,time")
			       	-> r_select(array("user", 'blogname', 'u_id', "u_id"));
			//查询评论表，计算符合条件的评论的总数
			foreach($data as &$val ){
				$val["total"] = D("reviews") 
					-> where(array('con_id'=>$val['con_id']))
				       	-> total();
			}
			//分配变量到shielded页
			$this -> assign("data",$data);
			$this -> assign('fpage',$page -> fpage());
			$this -> display("shielded");
		}
	}
