$(".main").fadeIn("slow");
function show(){
			
			var input=$(".tags").val();
			var ul=$(".ul").html();
			$(".ul").html(ul+'<li class="li">'+input+' <a href="javascript:;" title="删除该标签" onclick="show1(this)">x</a></li>');
                        var val=$(".tagsval").append(input+",");
                        $(".stags").val($(".tagsval").html());
			show2();                        			
	}
	function show1(obj){		
		$(obj).parent().remove();
        		
	}
	$(".tags").keydown(function(event){
		if(event.keyCode == 13) {
			if($(".tags").val() != ""){
				show();
             $(".tags").focus();                
		        }			     
            }
	});
	function show2(){
		$(".tags").focus();
	}
        $(".tags").focus(function(){
                $(".tags").val("");
  	});
        $(".tags").blur( function () {
                $(".tags").val("最多三个标签，输完后回车");
        } );
	function block(){
		var width=document.getElementById("body").clientWidth;
		var height=document.getElementById("body").clientHeight;
		var nwidth= (width-406) / 2;
		var nheight= (height+300) / 2;
		$(".tanshang").css("left",nwidth);
		$(".tanshang").css("top",nheight);
		$(".tandi").css("display","block");
		$(".tanshang").css("display","block");

 	}
        $(".formt").submit( function () {
		if($(".biaoti").val()==""){
			block();
			$(".divcontent").append("请输入虾米音乐播放地址");
			return false;
		}else if($(".stags").val()==""){
			block();
			$(".divcontent").append("请写入自定义标签");
			return false;
                }else if($(".systagval").val()==""){
			block();
			$(".divcontent").append("请选择系统标签");
			return false;
                }
        });
	function none(){
		$(".tandi").css("display","none");
		$(".tanshang").css("display","none");
		$(".divcontent").empty();
	}
        function xitag(){
		$(".xitag").slideDown("slow");
	}
        function systag(val){
                $(".xitag").slideUp("slow");
                $(".systagval").val(val);

        }
