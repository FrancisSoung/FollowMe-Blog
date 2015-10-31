$(".main").fadeIn("slow");
$(function(){

	//弹出层
	$("#list_content_right_center_select").click(function(){ 

		$("#list_content_right_center_select_tc").css("width","130px");
		$("#list_content_right_center_select_tc").css("height","110px");
		$("#list_content_right_center_select_tc").css("display","block");
		$("#list_content_right_center_select_bg").css("display","block");

	});

	//点击弹出层之后隐藏
	$("#list_content_right_center_select_tc li").click(function(){
		$("#list_content_right_center_text").val($(this).text());
		$("#list_content_right_center_select_tc").css("display","none");
	});

	/*点击大的DIV背景，使弹出层隐藏*/
	var width=document.documentElement.clientWidth;
        var height=document.documentElement.clientHeight;
	$("#list_content_right_center_select_bg").css("width",width).css("height",height).click(function(){
		$("#list_content_right_center_select_tc").css("display","none");   
		$("#list_content_right_center_select_bg").css("display","none");

	});

	//获得焦点事件
	$("#list_content_right_center_text").focus(function() {
		v=$("#list_content_right_center_text").val();
		$("#list_content_right_center_text").val("");
	});	
	
	//失去焦点事件，当鼠标离开的时候里面的内容还是原来的选择的值
	$("#list_content_right_center_text").blur(function() {
		$("#list_content_right_center_text").val(v);
	});
	
	//点击设置列表背景变色
	$(".list_content_right_top li").click(function() {
		$(".list_content_right_down li").css("background","#E0E1E3");
		$(".list_content_right_top li").css("background","#E0E1E3");
		$(this).css("background","#103D5E");
		//字体变色
		$(".list_content_right_down li").css("color","#000");
		$(".list_content_right_top li").css("color","#000");
		$(this).css("color","#FFF")	
	});
	
	//点击统计列表背景变色
	$(".list_content_right_down  li").click(function() {
		$(".list_content_right_top li").css("background","#E0E1E3");
		$(".list_content_right_down li").css("background","#E0E1E3");
		$(this).css("background","#103D5E");
		//字体变色
		$(".list_content_right_top li").css("color","#000");
		$(".list_content_right_down li").css("color","#000");
		$(this).css("color","#FFF");	
	});	
});

	/**
	 * 图标变色
	 * 点击任意一个列表项，使其自身的图标变成白色的图标
	 */ 

	function show(obj){
			for(var i=0;i<8;i++){
				var bgPosition = $("#id"+i).css('background-position');
				if(typeof(bgPosition) == 'undefined'){
				if($("#id"+i).css("backgroundPositionY")=="-100px"){
						$("#id"+i).css("backgroundPositionY","0px");
					}
				}else{
					if(bgPosition.split(" ")[1]=="-100px"){
						$("#id"+i).css("background-position",bgPosition.split(" ")[0] +" 0px");
					}
				}
			}
			
			$(obj).children("#id0").css("background","url('"+res+"/images/sidemenu.png') -302px -100px");
			$(obj).children("#id1").css("background","url('"+res+"/images/header.png') -194px -98px");
			$(obj).children("#id2").css("background","url('"+res+"/images/sidemenu.png') -337px -100px");
			$(obj).children("#id3").css("background","url('"+res+"/images/sidemenu.png') -370px -100px");
			$(obj).children("#id4").css("background","url('"+res+"/images/sidemenu.png') -472px -100px");
			$(obj).children("#id5").css("background","url('"+res+"/images/sidemenu.png') -405px -100px");
			$(obj).children("#id6").css("background","url('"+res+"/images/sidemenu.png') -540px -100px");
			$(obj).children("#id7").css("background","url('"+res+"/images/sidemenu.png') -507px -100px");
		}

