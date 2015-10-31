<?php
	/**
	 * 文章管理
	 * @author	宋朝可
	 */
	class Article {

		/**
		 * 主方法	查询内容表，并调用私有方法，进行关联查询
		 * @param	$page	用于分页
		 * @param	$data	查询所有包括隐藏和显示的结果集
		 * @param	$ndata	查询隐藏的结果集
		 * @param	$mdata	查询隐藏和显示的结果集
		 * @param	$nnum	屏蔽文章的总数
		 * @param	$num	全部文章的总数
		 * @param	$year	存储年
		 * @param	$month	存储月
		 * @return	array	二维数组（关联数组）
		 */
		function index(){

			//分页
			$page = new Page(D('contents') 
				-> where(array("type"=>"1"),array("type"=>'10')) 
				-> total(),8);
			//执行查询
			$data = D('contents') 
				-> where(array("type"=>"1"),array("type"=>'10'))
			        -> limit($page -> limit)
				-> order("time desc") 
				-> field("con_id,u_id,title,tags,type,time") 
				-> select();
			$ndata = D('contents') 
				-> where(array("type"=>'10')) 
				-> select();
			$mdata = D('contents') 
				-> where(array("type"=>'1'),array("type"=>'10')) 
				-> select();

			//计算屏蔽文章的个数
			$nnum = count($ndata);

			//计算全部文章的个数
			$num=count($mdata);

			//遍历数组
			foreach($data as &$v){
				$user = $this->user($v['u_id']);
				$total = $this->total($v['con_id']);
				$v['blogname'] = $user['blogname'];
				$v['total'] = $total;
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

			//重新排列数组（改变数组原有的键）
			$year = array_values($year);
			$month = array_values($month);

			//分配变量并调用模板
			$this -> assign("year",$year);
			$this -> assign("month",$month);
			$this -> assign("time",$time);
			$this -> assign("num",$num);
			$this -> assign("nnum",$nnum);
			$this -> assign("data",$data);
			$this -> assign("title", $dat);

			//分配分页变量
			$this -> assign('fpage',$page -> fpage());

			//显示输出模板
			$this -> display();
		}
		
		/**
		 * 查询用户表
		 * @param	$uid	主方法中传过来的用户的ID
		 * @return	array	关联数组
		 */
		private function user($uid){

			return D("user")
				-> field('blogname')
				-> where(array("u_id"=>$uid))
				-> find();
		}

		/**
		 * 查询评论表
		 * @param	$conid	主方法中传过来的内容的ID
		 * @return	array	关联数组
		 */
		private function total($conid){

			return D("reviews")
				-> where(array('con_id'=>$conid))
				-> total();
		}

		/**
		 * ajax按日期查询
		 * @param	$t	当前的时间戳
		 * @param	$tt	月末的时间戳
		 * @param	$page	用于分页
		 * @param	$res	查询符合时间条件的结果集
		 * @param	$ww	临时数组，用于存储符合条件的评论的信息
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
			$page = new Page(D('contents') 
				-> where(array("time <="=>$tt,"time >="=>$t,"type"=>"1"),array("time <="=>$tt,"time >="=>$t,"type"=>10))
				-> total(),10);

			//查询内容表符合时间条件的内容
			$res = D("contents") 
				-> where(array("time <="=>$tt,"time >="=>$t,"type"=>"1"),array("time <="=>$tt,"time >="=>$t,"type"=>10)) 
				-> limit($page -> limit)
				-> order("time desc") 
				-> field("con_id,u_id,title,tags,time") 
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

			//分配变量
			$this -> assign("hello",$dat[0]['title']);
			$data = $ww;
			$this -> assign("data",$data);
			$this -> assign('fpage',$page -> fpage());
			$this -> display("ajax");
			
		}

		/**
		 * 删除单个文章
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
		 * 选中删除文章
		 * @param	$rdd	接收过来的文章的ID
		 * @return 1 代表真，2 代表假
		 */
		function checkdel() {
			debug(0);
			$rdd = trim($_GET['rd']);
			if(!empty($rdd)){
				//分割接收过来的文章ID
				$arr_id = explode(",",$rdd);
				foreach($arr_id as $key => $val){
					$delete = D("contents") -> delete($val);
				}
				//返回相应值
 				if($delete){
     					$reback = '1';
 				}
 				echo $reback;
			}
        	
		}
		
		/**
		 * 查看用户的文章详情
		 * @param	$dat	查询表的结果集
		 * @param	$id	接收过来的文章ID
		 * @param	$title	文章的标题
		 * @param	$uico	用户的头像
		 * @param	$blogname	博客名称
		 * @param	$time	发表时间
		 * @param	$arr	文章信息的数组
		 *
		 */
		function look() {
			debug(0);
			$id = $_GET['id'];
			$dat = D('contents') 
				-> where(array('type'=>'1','con_id'=>$id),array('type'=>'10','con_id'=>$id)) 
				-> field('con_id,u_id,title,content,time') 
				-> r_select(array('user','u_ico,blogname','u_id','u_id'));
			//遍历结果集，并处理
			foreach($dat as &$v){
				$title = $v['title'];
				$uico = $v['u_ico'];
				$blogname = $v['blogname'];
				$time = $v['time'];
				//删除内容中HTML标签
				$content = strip_tags($v['content']);
				//删除内容中的两端空格
				$content = trim($content);

			}
			//格式化本地时间
			$time=date('Y-m-d',$time);
			//把查询的结果转换成json格式
			$arr = array('title'=>$title,'uico'=>$uico,'blogname'=>$blogname,'time'=>$time,'content'=>$content);
			//返回json格式的数组
			echo json_encode($arr);			
		}

		/**
		 * 屏蔽文章
		 * @param	$conid	接收文章的ID
		 * @param	$status	文章的额状态（shield是屏蔽，display是显示）
		 *
		 */
		function shield() {
			debug(0);
			$conid = $_GET['conid'];
			$status = $_GET['status'];
			//判断是否为屏蔽
			if($status == 'shield'){
				$rowsone = D('contents') 
				-> where(array('con_id'=>$conid,$_GET["s"]=>$_GET["val"])) 
				-> update('type=10');
				if($rowsone){
				 	$mess='a';
				}
			}
			//判断是否为显示
			if($status == 'display'){
				$rowstwo = D('contents') 
				-> where(array('con_id'=>$conid,$_GET["s"]=>$_GET["val"])) 
				-> update('type=1');
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
			
			//分页
			$page = new Page(D('contents') 
				-> where(array("type"=>'10')) 
				-> total(),10);

			//查询内容表符合时间条件的内容
			$data = D("contents") 
				-> where(array("type"=>'10')) 
				-> order("time desc") 
				-> limit($page -> limit)
				-> field("con_id,u_id,title,type,tags,time") 
				-> r_select(array("user", 'blogname', 'u_id', "u_id"));

			//查询评论表，计算符合条件的评论的总数
			foreach($data as &$val ){
				$val["total"] = D("reviews") -> where(array('con_id'=>$val['con_id'])) -> total();
			}
			//分配变量和选择模板
			$this -> assign('fpage',$page -> fpage());
			$this -> assign("data",$data);
			$this ->display("shielded");
		}
		
	}

