<?php $this->load->view('front/header')?>
            <div class="contentsetcent2">
            	<div class="sscontent1"></div>
            	<div class="sscontent2">
                    <img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
                    <div class="sscontent2">
                	<div class="setcontop">
                    	<p style="width:900px;text-align:center;">注册</p>
                    </div>
                    <img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
                    <div class="ssconcon2">
                        <div class="ssconconright4">
	                        <div class="loginlogin">
	                        	<form action="" method="post" id="form_front_register">
	                            	<p>&nbsp;&nbsp;&nbsp;用户名&nbsp;&nbsp;<input type="text" name="username"  placeholder="请输入用户名" class="logininput"/></p>
	                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮箱&nbsp;&nbsp;<input type="text" name="email" placeholder="请输入有效的邮箱"  class="logininput"/></p>
	                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码&nbsp;&nbsp;<input type="password" name="new_pwd"  class="logininput" placeholder="请输密码"/></p>
	                                <p>确认密码&nbsp;&nbsp;<input type="password" name="confirm_pwd"  class="logininput" placeholder="请再次输入密码"/></p>
	                                <p class="shengming"><input type="checkbox" name="approval" class="loginchekbox"  style="vertical-align: middle;" checked/> 同意</p>
	                                <p><input type="button" id="registreg" class="registreg" value=""/></p>
	                            </form>
	                        </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="contentsetfoot">
            </div>
            </div>
            		
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script>
        <script src="/static/js/jquery.validate.min.js" type="text/javascript" ></script>
		<script src="/static/js/easydialog.js" type="text/javascript" ></script>
		<script><!--
			$(function(){
				document.onkeypress = keypress;
				// validate signup form on keyup and submit
				$("#form_front_register").validate({
					rules: {
						username: {
							required : true,
							rangelength : [3, 16],
							remote : '<?= base_url()."admin/member/check_member_exist"?>'
						},
						new_pwd: {
							required : true,
							rangelength : [6, 16]
						},
						confirm_pwd: {
							required : true,
							rangelength : [6, 16],
							equalTo: "input[name='new_pwd']" 
						},
						email: {
							required : true,
							email : true
						}/*,
						approval : {
							required : true
						}*/
					},
					messages: {
						username: {
							required : "请输入用户名",
							rangelength : '请输入3-16个字符',
							remote : '该账户已被注册'
						},
						new_pwd: {
							required : "请输入密码",
							rangelength : '请输入6-16个字符'
						},
						confirm_pwd: {
							required : "请输入确认密码",
							rangelength : '请输入6-16个字符',
							equalTo: "密码输入不一致" 
						},
						email: {
							required : "请输入邮箱",
							email : "请输入有效的邮箱"
						}/*,
						approval : {
							required : "必须选择同意"
						}*/
					},
					errorPlacement: function(error, element) {
						if (element.is(':radio') || element.is(':checkbox')) {
							var eid = element.attr('name');
							error.appendTo(element.parent());
						} else { 
							error.insertAfter(element); 
						} 
					}, 
					submitHandler : function(form){ 
						//form.submit(); 
						form_submit();
					}
				});

				$("#registreg").bind('click', function(){
					$("#form_front_register").submit();
				});
			});

			function form_submit() {
				if($("input[name='approval']").attr('checked') == undefined) return false;
				
				var username = $("input[name='username']").val(),
					new_pwd = $("input[name='new_pwd']").val(),
					confirm_pwd = $("input[name='confirm_pwd']").val(),
					email = $("input[name='email']").val();
	            $.post('<?php echo base_url() . "user/register/register_account" ?>', {username: username, new_pwd: new_pwd, confirm_pwd : confirm_pwd, email : email}, 
    	            function(data){
		            	switch(data.success){
							case 'account':
							case 'password':
							case 'pwd_length':
							case 'email':
							case 'register_success':
								window.location.href = data.url;
								break;
							default:
								easyDialog.open({
						            container: {
										content: data.msg
						            },
									autoClose: 1000
						        });
						        break;
						};
				}, 'json');
			}

			function keypress(e){
				var currKey=0,e=e||event;
				if(e.keyCode==13) document.getElementById("registreg").click();
			}
		--></script> 
	</html>
