<?php $this->load->view('front/header')?>
            <div class="contentsetcent2">
            	<div class="sscontent1"></div>
            	<div class="sscontent2">
                	<div class="setcontop">
                    <p style="width:991px; margin:0 auto; text-align:center">登&nbsp;&nbsp;录</p>
                    </div>
                    <img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
                    <div class="ssconcon2">
                    	
                        <div class="ssconconright4">
	                        <div class="loginlogin">
	                        	<form action="" method="post" id="form_front_login">
	                        		<input type="hidden" value="<?=isset($redirect)&&$redirect ? $redirect : '' ; ?>" name="redirect"/>
	                            	<p>用户名&nbsp;&nbsp;<input type="text" name="username"   class="logininput"/></p>
	                                <p>&nbsp;&nbsp;&nbsp;&nbsp;密码&nbsp;&nbsp;<input type="password" name="pwd"  class="logininput"/></p>
	                                <p class="loginfont"><input type="checkbox" name="autologin" value="1" class="loginchekbox" style="vertical-align: middle;"/> 是否下次自动登录</p>
	                                <p><input type="button" id="front_login" class="loginsub" value=""/></p>
	                                <p class="loginreg">
		                                <a href="<?=base_url().'home/register' ?>"><img src="/static/images/front/regist.png"/></a>
		                                <a href="<?=base_url().'home/forget' ?>"><img src="/static/images/front/findpassword.png"/></a>
	                                </p>
	                            </form>
	                        </div>
                        </div>
                    </div>
                </div>
                <div class="contentsetfoot">
	            	<a href=""><img style="display:none;" src="/static/images/front/fanhuimulu.png" border="0"/></a>
	            </div>
            </div>
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script> 
		<script src="/static/js/jquery.validate.min.js" type="text/javascript" ></script>
		<script src="/static/js/easydialog.js" type="text/javascript" ></script>
		<script>
			$(function(){
				document.onkeypress = keypress;
				// validate signup form on keyup and submit
				$("#form_front_login").validate({
					rules: {
						username: {
							required : true,
							rangelength : [3, 16]
						},
						pwd: {
							required : true,
							rangelength : [6, 16]
						}
					},
					messages: {
						username: {
							required : "请输入用户名",
							rangelength : '请输入3-16个字符'
						},
						pwd: {
							required : "请输入密码",
							rangelength : '请输入6-16个字符'
						}
					},
					submitHandler : function(form){ 
						//form.submit(); 
						form_submit();
					}
				});

				$('#front_login').bind('click', function(){
					$("#form_front_login").submit();
				});
			});

			function form_submit() {
				var username = $('input[name="username"]').val(),
					pwd = $('input[name="pwd"]').val(),
					autologin = $('input[name="autologin"]:checked').val(),
					redirect = $('input[name="redirect"]').val();
	            if (autologin == undefined){
	            	autologin = 0;
	            }
	            $.post('<?php echo base_url() . "user/login/verify" ?>', {username: username, pwd: pwd, autologin : autologin, redirect : redirect}, function(data){
					switch(data.success){
						case 0:
							easyDialog.open({
					            container: {
									content: data.message
					            },
								autoClose: 1000
					        });
							break;
						case 1:
							window.location.href = data.url;
					        break;
					};
				}, 'json');
			}

			function keypress(e){
				var currKey=0,e=e||event;
				if(e.keyCode==13) document.getElementById("front_login").click();
			}
		</script>
</html>
