// res 页面声明路径参数
//显示title-more箭头
function sico(obj){
    $(obj).children(".moreico").css("background","url('"+res+"/images/content-head-aaico.png')");
}
//隐藏title-more箭头
function hico(obj){
    $(obj).children(".moreico").css("background","url('"+res+"/images/content-head-ico.png')");
   
}


//获取宽高
    var setwidth=document.documentElement.clientWidth;
    var setheight=document.documentElement.clientHeight;
//点击热度
function showhot(obj){
    $(obj).parent().parent().siblings(".hottab").slideDown("400");
    $(obj).parent().parent().siblings(".confooter").css("background","url('"+res+"/images/content-bottom-b.png')");    
    $(obj).parent().parent().siblings(".close").css("width",setwidth).css("height",setheight).css("display","block");
}
//收起动作
function upshow(obj){
        $(obj).parent().parent().parent().slideUp("400");
        $(obj).parent().parent().parent().siblings(".confooter").css("background","url('"+res+"/images/content-bottom.png')");
        $(".close").css("display","none");
        $(".reviewtab").css("display","none");
}
//点击回应
function showcomm(obj){

    $(obj).parent().parent().siblings(".commenttab").slideDown("400");
    $(obj).parent().parent().siblings(".confooter").css("background","url('"+res+"/images/content-bottom-c.png')");
    $(obj).parent().parent().siblings(".close").css("width",setwidth).css("height",setheight).css("display","block");
}
//页面任意处关闭热度回应
function closed(obj){
    $(obj).siblings(".hottab").slideUp("400");
    $(obj).siblings(".commenttab").slideUp("400");
    $(obj).siblings(".confooter").css("background","url('"+res+"/images/content-bottom.png')");
    $(obj).css("display","none");
    $(".reviewtab").css("display","none");
}
//头像弹出层
  function showinfo(obj){
               $(obj).children(".showinfo").css("display","block");
  } 
//返回头像
function showico(obj){
    $(obj).children(".showinfo").css("display","none");
}
//发私信 加/取消关注
function showmessage(obj){
        $(obj).siblings(".showtab").css("display","block").css("z-index","4");
        $(obj).siblings(".message").css("display","block").css("z-index","6");
}
//显示私信,关注
function showself(obj){
        $(obj).css("display","block");
}
//隐藏私信,关注
function hiddenall(obj){
        $(obj).css("display","none");
        $(obj).siblings(".showinfo").css("display","none");
        $(obj).siblings(".message").css("display","block");
}

//隐藏私信,关注
function hiddenself(obj){
        $(obj).parent(".message").css("display","none");
        $(obj).css("display","none");
}


//页面加载完后执行
$(function(){
   //发表换背景
    $(".ucontent").children("a").children("li").mouseover(
        function(){
            selfclass=this.className;
       $(this).attr("class",this.className+"a");
       
        }
    );
    $(".ucontent").children("a").children("li").mouseout(
        function(){
       $(this).attr("class",selfclass);
        }
    );
    //显示回应框
        $(".reviewtab_a").children(".intext_a").children("tt").children("a").click(
            function(){
                        $(".reviewtab").slideToggle("400");
            });

    
});

