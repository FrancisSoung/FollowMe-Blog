$(function(){
	//显示隐藏删除和屏蔽动作
	$(".user_content_list_username").mouseover(function(){
		$(this).children(".user_content_list_action").children(".user_content_list_ac").css("display","block");
	}).mouseout(function(){
		$(this).children(".user_content_list_action").children(".user_content_list_ac").css("display","none");
	});
	});

