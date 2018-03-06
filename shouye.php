<?php
	include_once 'config.php';
	$code = $_REQUEST['code'];
	$res = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APPID.'&secret='.APPSECRET.'&code='$code'&grant_type=authorization_code');
	echo $res['openid'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		<title>首页</title>
	</head>
	<link rel="stylesheet" type="text/css" href="http://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
	
	<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="php_js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
	<script src="php_js/md5.js" type="text/javascript" charset="utf-8"></script>
    <script src="php_js/Common.js" type="text/javascript" charset="utf-8"></script>
	<style type = 'text/css'>
        .thumb_bar{
        	width:20px;
            margin-right:5px;
            float:left;
            margin-top:13px;
        }
        .weui-panel__hd:after{
        	left:0;
        }
        .span_Hi{
        	margin-left:15px;
        }
        body{
        	font-family: "微软雅黑";
        }
    </style>
    <script type="text/javascript">
			$(document).ready(function(){
                var auth = $.cookie('Authorization');
                var name = (auth.split(','))[0];
                $('#alink_user').html(name);
            	$('#alink_logout').click(function(){
                	loginOut();
                    location.href = 'sample.html';
                });
                var info = auth.split(',');
        		var hid = info[1].substr(0,8);
                
            });
        
	</script>
	<body>
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd"><a href="#"><img src="Img/1405499025485.png" id="head_Toho" alt="点击这里跳转到首页"></a></div>
			
            <div class="weui-panel__ft">
                <span class = "weui-cell__ft span_Hi">欢迎您，</span><a href = 'ziliao.html' id = 'alink_user'>测试用户max</a>
                <span class = "weui-cell__ft" style = 'position:fixed; right:15px;'><a href = 'javascript:;' id = 'alink_logout'>注销</a></span>
            </div>
        </div>
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">
				<a href="ziliao.html" class="weui-btn weui-btn_default"><img class = "weui-media-box__thumb thumb_bar" src = 'Img/demo1.png' alt = "个人资料" />个人资料</a>
                <a href="check.html" class="weui-btn weui-btn_default"><img class = "weui-media-box__thumb thumb_bar" src = 'Img/demo2.png' alt = "查看检查" />查看检查</a>
                <a href="http://www.lzzyy.com" class="weui-btn weui-btn_default"><img class = "weui-media-box__thumb thumb_bar" src = 'Img/demo4.png' alt = "医院简介" />医院简介</a>
                <a href="lianxi.html" class="weui-btn weui-btn_default"><img class = "weui-media-box__thumb thumb_bar" src = 'Img/demo5.png' alt = "联系我们" />联系我们</a>
            </div>
        </div>
        
    <div class="weui-footer weui-footer_fixed-bottom">
        <p class="weui-footer__links">
            <a href="www.lzzyy.com" class="weui-footer__link" id = "footer_link">XX医院首页</a>
        </p>
        <p class="weui-footer__text">Copyright &copy; 2008-2018 Magic.com</p>
    </div>
	</body>
</html>
