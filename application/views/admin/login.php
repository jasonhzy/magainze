<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>网站后台管理 -- 登录</title>
	<link href="/static/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/static/css/easydialog.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="login_dv">
		<div class="l_img"><img src="/static/images/admin/l_img.jpg" /></div>
		<div class="login_bar">
			<div class="login_list" style="width:400px;padding-left:150px;">
			<form action="" method="post" id="form_admin_login">
				<table cellspacing="5">
					<tr>
						<td>用户名：</td>
						<td><input type="text" name="username"/></td>
						<td><span id="username_note"></span></td>
					</tr>
					<tr>
						<td>密&nbsp;&nbsp;码：</td>
						<td><input type="password"  name="password"/></td>
					</tr>
				</table>
				</form>
			</div>
			<div class="login_btn">
				<input type="button" value="" id="login_btn"/>
			</div>
		</div>
	</div>
</body>
<script src="/static/js/jquery.js" type="text/javascript" ></script>
<script src="/static/js/easydialog.js" type="text/javascript" ></script>
<script src="/static/js/jquery.validate.min.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(function() {
		document.onkeypress = keypress;
		// validate signup form on keyup and submit
		$("#form_admin_login").validate({
			rules: {
				username: {
					required : true,
					rangelength : [3, 16]
				},
				password: {
					required : true,
					rangelength : [6, 16]
				}
			},
			messages: {
				username: {
					required : "请输入用户名",
					rangelength : '请输入3-16个字符'
				},
				password: {
					required : "请输入密码",
					rangelength : '请输入6-16个字符'
				}
			},
			submitHandler : function(form){ 
				form_submit();
				//form.submit(); 
			}
		});

		$('#login_btn').bind('click', function () {
			$("#form_admin_login").submit();
		});
	});

	function form_submit() {
		var username = $("input[name='username']").val(),
			pwd = $("input[name='password']").val();
		$.post('<?php echo base_url() . "admin/login/sys_login" ?>', {username: username, pwd: pwd}, function(data){
			easyDialog.open({
	            container: {
					content: data.message
	            },
				autoClose: 2000
	        });
			switch(data.success){
				case 1:
				case 2:
			        setTimeout("window.location.href = '" + data.url + "'", 2000);
			        break;
				case 0:
					break;
			};
		}, 'json');		
	}
	
	function keypress(e){
		var currKey=0,e=e||event;
		if(e.keyCode==13) document.getElementById("login_btn").click();
	}
</script>
</html>
