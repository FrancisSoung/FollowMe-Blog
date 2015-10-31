<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""
"http://www.w3.org/TR/html4/loose.dtd">
<?php
//杨航
mysql_query("set names utf8");
$files="../config.inc.php";
$filesa="../index.php";
if(!is_writable($files)){
        echo "<b style='color:red;font-size:22px'>config.inc.php 不可写!!!!请先修改其权限 为可写 谢谢!!</b>";
}else
if(isset($_POST[install])){
        $config_str.="<?php";
        $config_str.="\n";
        //是否开启debug
        $config_str.="define('DEBUG',1);";
        $config_str.="\n";
        //是否开启dbo
        $config_str.="define('DRIVER','pdo');";
        $config_str.="\n";
        //数据库主机
        $config_str.='define("HOST","'.$_POST["db_host"].'");';
        $config_str.="\n";
        //数据库用户名
        $config_str.="define('USER','".$_POST['db_user']."');";
        $config_str.="\n";
        //数据库密码
        $config_str.="define('PASS','".$_POST['db_pass']."');";
        $config_str.="\n";
        //数据库名称
        $config_str.="define('DBNAME','".$_POST['db_dbname']."');";
        $config_str.="\n";
        //前缀
        $config_str.="define('TABPREFIX','".$_POST['db_tag']."');";
        $config_str.="\n";
        //缓存开关
        $config_str.="define('CSTART',0);";
        $config_str.="\n";
        //缓存时间
        $config_str.="define('CTIME',60*60*24*7);";
        $config_str.="\n";
        //模板文件的后缀名
        $config_str.="define('TPLPREFIX','htm');";
        $config_str.="\n";
        //默认的模板目录
        $config_str.="define('TPLSTYLE','default');";
        $config_str.="\n";
        $config_str.="";
        $ff=fopen($files,"w+");
        fwrite($ff,$config_str);
        
        
        $index.="<?php";
        $index.="\n";
        $index.="define('BROPHP','./brophp');";
        $index.="\n";
        $index.='define("APP","./home");';
        $index.="\n";
        $index.='require(BROPHP."/brophp.php");';
        $index.="\n";
        $ffa=fopen($filesa,"w+");
        fwrite($ffa,$index);                
                
        include("../config.inc.php");
        if(!@$link=mysql_connect(HOST,USER,PASS)){
                echo "<b style='color:red;font-size:30px'>数据库连接失败，请检查配置</b>";
        }else{
                mysql_query("CREATE DATABASE `".DBNAME."`");
                mysql_select_db(DBNAME);
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."actions` (
                                `act_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                `type` int(1) unsigned NOT NULL DEFAULT '0',
                                `u_id` int(11) unsigned NOT NULL DEFAULT '0',
                                `ucon_id` int(11) unsigned NOT NULL DEFAULT '0',
                                `time` varchar(40) NOT NULL DEFAULT '',
                                PRIMARY KEY (`act_id`)
                        )ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."blacklist` (
                                `list_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                `u_id` int(11) NOT NULL DEFAULT '0',
                                `su_id` int(11) NOT NULL DEFAULT '0',
                                PRIMARY KEY (`list_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;"; 
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."broadcasts` (
                               `bro_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                `type` int(1) NOT NULL DEFAULT '1',
                                `status` int(11) NOT NULL DEFAULT '0',
                                `u_id` int(11) NOT NULL DEFAULT '0',
                                `content` text NOT NULL,
                                `time` varchar(40) NOT NULL DEFAULT '',
                                PRIMARY KEY (`bro_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."contents` (
                                  `con_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `u_id` int(11) unsigned NOT NULL DEFAULT '0',
                                  `systag_id` int(11) unsigned NOT NULL DEFAULT '0',
                                  `type` int(2) unsigned NOT NULL DEFAULT '0',
                                  `title` varchar(50) NOT NULL DEFAULT '',
                                  `image` varchar(30) NOT NULL DEFAULT '',
                                  `sound` varchar(50) NOT NULL,
                                  `link` varchar(120) NOT NULL DEFAULT '',
                                  `video` varchar(120) NOT NULL DEFAULT '',
                                  `content` text NOT NULL,
                                  `tags` varchar(20) NOT NULL,
                                  `time` varchar(40) NOT NULL DEFAULT '',
                                  PRIMARY KEY (`con_id`)
                          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."messages` (
                                  `mes_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `status` int(1) NOT NULL DEFAULT '0',
                                  `su_id` int(11) unsigned NOT NULL DEFAULT '0',
                                  `gu_id` int(11) NOT NULL,
                                  `content` text NOT NULL,
                                  `type` int(1) NOT NULL DEFAULT '3',
                                  `time` int(11) NOT NULL,
                                  PRIMARY KEY (`mes_id`)
                          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";   
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."reviews` (
                                  `rev_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `con_id` int(11) unsigned NOT NULL DEFAULT '0',
                                  `u_id` int(11) unsigned NOT NULL DEFAULT '0',
                                  `content` varchar(120) NOT NULL,
                                  `time` int(11) NOT NULL,
                                  `ip` char(15) NOT NULL DEFAULT '0',
                                  PRIMARY KEY (`rev_id`)
                          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."root` (
                                `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
                                `name` varchar(20) NOT NULL COMMENT '管理员名称',
                                `password` varchar(32) NOT NULL COMMENT '管理员密码',
                                PRIMARY KEY (`id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=3;"; 
                $sql_query[]="INSERT INTO `".TABPREFIX."root` (`id`, `name`, `password`) VALUES
                        (1, '".$_POST['username']."', '".md5($_POST['password'])."');";
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."broread` (
                                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                `r_id` int(11) NOT NULL,
                                `ru_id` int(11) NOT NULL DEFAULT '0',
                                PRIMARY KEY (`id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."systags` (
                                `systag_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                `systag_name` varchar(20) NOT NULL,
                                `seque` varchar(24) NOT NULL,
                                `sort` int(2) NOT NULL,
                                `time` varchar(40) NOT NULL DEFAULT '0',
                                PRIMARY KEY (`systag_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;";
                $sql_query[]="CREATE TABLE IF NOT EXISTS `".TABPREFIX."user` (
                                 `u_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                 `u_name` varchar(30) NOT NULL DEFAULT '',
                                 `u_ico` varchar(30) NOT NULL DEFAULT 'photo.png',
                                 `email` varchar(30) NOT NULL DEFAULT '',
                                 `password` char(32) NOT NULL DEFAULT '',
                                 `blogname` varchar(50) NOT NULL DEFAULT '',
                                 `info` varchar(120) NOT NULL DEFAULT '',                                 
                                 `count` int(10) NOT NULL DEFAULT '0',
                                 `status` int(2) NOT NULL,
                                 PRIMARY KEY (`u_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;";
                foreach($sql_query as $v){
                        mysql_query($v);
                }

                @rename("./install.php","./install.lock");
                echo "<script>alert('安装成功');top.location.href='../index.php';</script>";
         
        }

}
?>

<html>
<head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>followme 安装程序</title>
        <link rel="stylesheet" href="style.css" type="text/css" media="screen" charset="utf-8">
        <script src="jquery.js" type="text/javascript" charset="utf-8"></script>      
</head>
<body>
        <div class="main">
        <div class="logo"><img src="images/logo.png"><img src="images/boke.png"></div>
        <div class="form">        
                <div class="bbb">马上填写信息，安装FollowMe轻博客</div>
                <div class="ccc">
                <form action="" method="post" onsubmit="return error(true)">
                        <table>
                        <tr><td>填写主机</td><td><input type="text" class="db_host" name="db_host" value="localhost"></td></tr>
                        <tr><td>用 户 名</td><td><input type="text" class="db_user" name="db_user" value="root"></td></tr>
                        <tr><td>密    码</td><td><input type="password" class="db_pass" name="db_pass" value=""></td></tr>
                        <tr><td>数据库名</td><td><input type="text" class="db_dbname" name="db_dbname" value=""></td></tr>
                        <tr><td>前    缀</td><td><input type="text" class="db_tag" name="db_tag" value="fm_"></td></tr>
                        <tr><td>后台用户名</td><td><input type="text" class="username" name="username" value=""></td></tr>
                        <tr><td>后台用户密码</td><td><input type="text" class="password" name="password" value=""></td></tr>
                        <tr><td colspan="2" style="text-align:right;margin-top:10px;"><button type="submit" class="sub" name=install value=""></button></td></tr>
                        </table>
                </form>
                </div>
                <div class="error"></div>
        </div>
        </div>        
</body>
<script type="text/javascript" charset="utf-8">
$(".main").fadeIn("slow");
function error(){
        if($(".db_host").val()==""){
                $(".error").html("请填写主机");
                $(".error").slideDown("slow");
                return false;
        }else if($(".db_user").val()==""){
                $(".error").html("请填写用户名");
                $(".error").slideDown("slow");
                return false;
        }else if($(".db_pass").val()==""){
                $(".error").html("请填写数据库密码");
                $(".error").slideDown("slow");
                return false;
        }else if($(".db_dbname").val()==""){
                $(".error").html("请填写数据库名");
                $(".error").slideDown("slow");
                return false;
        }else if($(".db_tag").val()==""){
                $(".error").html("请填写前缀");
                $(".error").slideDown("slow");
                return false;
        }else if($(".username").val()==""){
                $(".error").html("请填写用户名");
                $(".error").slideDown("slow");
                return false;
        }else if($(".password").val()==""){
                $(".error").html("请填写用户密码");
                $(".error").slideDown("slow");
                return false;
        }
}
$(".db_host").focus(function(){
        $(".error").slideUp("slow");
        $(".db_host").val(""); 
});
$(".db_user").focus(function(){
        $(".error").slideUp("slow");
        $(".db_user").val("");  
});
$(".db_pass").focus(function(){
        $(".error").slideUp("slow");
        $(".db_pass").val("");  
});
$(".db_dbname").focus(function(){
        $(".error").slideUp("slow"); 
        $(".db_dbname").val(""); 
});
$(".db_tag").focus(function(){
        $(".error").slideUp("slow");
        $(".db_tag").val("");  
});
$(".username").focus(function(){
        $(".error").slideUp("slow");
        $(".username").val("");  
});
$(".password").focus(function(){
        $(".error").slideUp("slow");
        $(".password").val("");  
});

</script>
</html>

