$(function(){
	//弹出层
	$("#myfollowing_right_two_right").click(function(){ 

		$("#myfollowing_right_two_right_select").css("width","130px");
		$("#myfollowing_right_two_right_select").css("height","110px");
		$("#myfollowing_right_two_right_select").css("display","block");
		$("#myfollowing_right_two_right_select_bg").css("display","block");

	});

	//点击弹出层之后隐藏
	$("#myfollowing_right_two_right_select li").click(function(){
		$("#seach_tag").val($(this).text());
		$("#myfollowing_right_two_right_select").css("display","none");

	});

	/*点击大的DIV背景，使弹出层隐藏*/
	var width=document.documentElement.clientWidth;
        var height=document.documentElement.clientHeight;
	$("#myfollowing_right_two_right_select_bg").css("width",width).css("height",height).click(function(){
		$("#myfollowing_right_two_right_select").css("display","none");   
		$("#myfollowing_right_two_right_select_bg").css("display","none");

	});
	
	//获得焦点事件
	$("#seach_tag").focus(function() {
		v=$("#seach_tag").val();
		$("#seach_tag").val("");
	});

	/*
	 * 失去焦点事件，当鼠标离开的时候里面的内容还是原来的选择的值
	 */
	$("#seach_tag").blur(function() {
		$("#seach_tag").val(v);
	});
	
})
