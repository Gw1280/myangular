<?php
	include_once 'config.php';
	$code = $_GET['code'];
	$res = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type=authorization_code');
    $res = json_decode($res, true);
    $openid = $res['openid'];
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		<title>欢迎登陆</title>
	</head>
	<link rel="stylesheet" type="text/css" href="http://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
	
	<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="php_js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
	<script src="php_js/md5.js" type="text/javascript" charset="utf-8"></script>
    <script src="php_js/Common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
       $(document).ready(function () {
           	var openid = $('#oid').attr('valu');
           	getRela(openid);
            $('#btn_login').click(function () {
                var user = $('#input_user').val();
                user = $.trim(user);
                var pass = $('#input_pass').val();
                var ide = getIDE();
                if (ide == 1) {
                    getAuth('Web', user, pass, ide, pass);
                }
                else {
                    var auth = getAuthTest2(ide);
                    var validate = md5(pass + auth);
                    getAuth('Web', user, auth + ',' + validate, ide, pass);
			}
        });
       	window.history.forward(1);		//防止注销后后退
	});
        //关联验证
        function getRela(openid){
        	var str = $.cookie('Authorization');
            var info = str.split(',');
            var hid = info[1].substr(0,8);
            var pid = info[1].substr(8,8);
        	$.$.ajax({
        		url: 'http://' + comServerIP + '/Web/WxInfo/'+openid+'/'+hid+''+pid,
        		type: 'GET',
        		async:false,
                headers:{'Authorization':$.cookie('Authorization')},
                beforeSend:	function(xhr){
                    xhr.setRequestHeader('XXX',$.cookie('ide'));
                },
                success:function (data) {
                	alert(data);
                },
                error:function (xhr,status,errorThrown) {
                    console.log(xhr.getAllResponseHeaders());
                }
        	});
        	
        }
        //登录验证
		function getAuth(url, user, pass, ide, passed) {
            //console.log(url + ',' + pass + 'ide' + passed);
			$.ajax({
				type: 'get',
				url: 'http://' + comServerIP + '/Home/' + url + '/Authorization',
				async: false,
                //dataType: 'jsonp',
				headers: {
					'Authorization': user + ',' + pass
				},
				beforeSend: function(xhr) {
					xhr.setRequestHeader('XXX', ide);
				},
				success: function(data, status, xhr) {
					//应加上区分ide的代码
					if (ide == 1) {
						if (data.Auth == 200) {
							$.cookie('Authorization', user + ',' + pass);
							$.cookie('ide', ide);
						}
						else {
							alert('账号或密码错误，请重试');
							return false;
						}
					}
					else {
						var noce = xhr.getResponseHeader('WWW-Authenticate');
						$.cookie('Authorization', user + ',' + noce + ',' + md5(passed + noce));
						$.cookie('ide', ide);
					}
					var i = $('#REM').is(':checked');
					if (true == i) {
						var expiresDate = new Date();
						expiresDate.setTime(expiresDate.getTime() + (7 * 24 * 60 * 60 * 1000));
						$.cookie(user, enCode(user, passed), {
							expires: expiresDate
						});
						$.cookie(user + 'ide', ide, {
							expires: expiresDate
						});
					}
					location.href = ('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx3a51c643ee04cbfa&redirect_uri=http%3a%2f%2f1.mdk0205.applinzi.com%2fshouye.php&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect');
				},
				error: function(xhr, status, errorThrown) {
					if (xhr.status == 401) {
						alert('账号或密码错误，请重试');
					}
					else {
						alert('连接服务器失败，请稍后重试1');
					}
				}
			});
		}
        
        //医生登录首次验证
		function getAuthTest2(ide) {
			var xhr = new XMLHttpRequest();
			xhr.open('get', 'http://' + comServerIP + '/Web/Authorization', false);
			xhr.setRequestHeader('XXX', ide);
			var auth = '';
			xhr.onload = function() {
				if (xhr.status == 401) {
					auth = xhr.getResponseHeader('WWW-Authenticate');
				}
				else {
					alert('连接服务器失败，请稍后重试2');
				}
			}
			try {
				xhr.send();
			}
			catch (e) {
				if (e.name == 'NetworkError') {
					alert('连接服务器失败，请稍后重试3');
				}
			}
			return auth;
		}
        
        function getIDE() {
			var ide = $('#sel_ide option:selected').val();
			return ide;
		}
    </script>

    <style type="text/css">
        html,body{
        	font-family: "微软雅黑";
        }
        #main_tittle{
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            font-family: "微软雅黑";
		}
	</style>
	<body>
	<article class="weui-article">
		<h1 id="main_tittle">医院登陆</h1>
	</article>
	<div class="weui-cells__title">账号:</div>
	<div class="weui-cells weui-cells_form">
	    <div class="weui-cell">
	        <div class="weui-cell__bd">
	             <input class="weui-input" type="text" placeholder="用户名/手机号/邮箱"/ id="input_user">
	        </div>
	    </div>
	</div>
	<div class="weui-cells__title">密码:</div>
	<div class="weui-cells weui-cells_form">
	    <div class="weui-cell">
	        <div class="weui-cell__bd">
	             <input class="weui-input" type="password" placeholder="" id="input_pass"/>
	        </div>
	    </div>
	</div>
	<div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">登陆身份</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="select2" id="sel_ide">
                <option value="1">用户</option>
                <option value="2">医生</option>
            </select>
        </div>
    </div>
    <?php echo '<div id = "oid" valu =" '.$openid.'" style = "display:none"></div>'?>
	<div class="weui-btn-area">
	    <a class="weui-btn weui-btn_primary" href="javascript:" id="btn_login">登陆</a>
	</div>
	</body>
</html>
