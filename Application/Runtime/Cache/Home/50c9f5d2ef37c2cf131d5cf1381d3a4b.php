<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <title>新生报到管理系统-登录</title>
        <link href="<?php echo CSS ?>/login.css" type="text/css" rel="stylesheet">
        <script src="<?php echo JS ?>/jquery-3.2.0.min.js"></script>
    </head>

    <body>
        <div class="login">
            <div class="message">新生报到-管理系统登录</div>
            <div id="darkbannerwrap"></div>
            <form method="post" action="<?php echo U('Home/Login/loginset','','');?>">
                <input name="username" id="username" placeholder="用户名" required="" type="text">
                <hr class="hr15">
                <input name="userpwd" id="userpwd" placeholder="密码" required="" type="password">
                <hr class="hr15">
                <input name="verify" id="verify" placeholder="验证码" required="" type="text" maxlength="4" style="width:140px;">
                <span style="padding:20px auto auto 10px;vertical-align: middle;">
                    <img src="/nsrms/Home/Login/veryimg"style="cursor:pointer;position:absolute;width:120px;height:45px;margin-left:20px;" alt="看不清？点击更换" title="点我更换验证码" id='verify-img'
                         onclick="this.src = '/nsrms/Home/Login/veryimg?' + Math.random();"/>
                </span>
                <hr class="hr15">
			<input value="登录" style="width:100%;" type="submit">
		<hr class="hr20">
            </form>
        </div>
        <div class="copyright">© 2018 Copy Rights Reserved
        </div>
    </body>
</html>