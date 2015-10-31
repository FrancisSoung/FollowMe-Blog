 $(function(){   

	//点击全选
	 $(".checked").click(function(){
		if($(this).attr("checked")=="checked"){
				$(":checkbox").attr("checked", true);
			}else{
				$(":checkbox").attr("checked", false);
			}
	});
		
    	//checkbox全选 
   	 $("#all").click(function(){         
			if($(":checkbox").attr("checked")=="checked"){
                		$(":checkbox").attr("checked", false);
                	}else{
				$(":checkbox").attr("checked", true);

			}
	});

    	//checkbox反选
    	$("#not").click(function(){      
        	var qx=$("input:checked");
			$("input:not(:checked)").attr("checked", true);
			qx.attr("checked",false);

    	});
 });
	//显示删除和屏蔽
	function review_show(obj) {
		$(obj).children(".review_content_list_action").children(".review_content_list_action_span").css("display","block");
	}
	//隐藏删除和屏蔽
	function review_hidden(obj) {
		$(obj).children(".review_content_list_action").children(".review_content_list_action_span").css("display","none");
	}
	//显示编辑
	function showmod(obj){
        $(obj).children().children(".showmod").css("display","block");
	}
	//隐藏编辑
	function hiddenmod(obj){
        $(obj).children().children(".showmod").css("display","none");
	}
	
	//删除事件
	function review_delete(obj) {
		return confirm("你确定要删除吗？");
	}

	//隔行换色
    	function bg(){
		$("tr:even").css("background-color", "#efefef");
		$("tr:odd").css("background-color", "#ffffff");
	}
	bg();
	//换背景
	function showbg(obj){
		$(obj).css("background-color","#dcdcdc");
	}
	function hiddenbg(obj){
		bg();
	}



	
