<?php $this->load->view('front/header')?>
            <div class="contentsetcent2">
            	<div class="sscontent1"></div>
            	<div class="sscontent2">
                    <div class="setcontop">
                        <p style="text-align:center;">找回密码</p>
                    </div>
                    <img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
                    <div class="ssconcon2">
                        <div class="ssconconright4">
                            <div class="registemaillogin">
                                <form action="<?php echo base_url() . "user/login/verify" ?>" method="get" id="form_forget_pwd">
                                    <p>注册邮箱&nbsp;&nbsp;<input type="text" name="email" class="logininput"/></p>
                                    <p><input type="button"  class="registemail" value="" id="email_btn"/></p>
                                </form>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="contentsetfoot">
           			 <a href=""><img  style="display:none;"  src="/static/images/front/fanhuimulu.png" border="0"></a>
           		</div>
            </div>
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script> 
		<script src="/static/js/jquery.validate.min.js" type="text/javascript" ></script>
		<script src="/static/js/easydialog.js" type="text/javascript" ></script>
		<script type="text/javascript" >
			function trim(str){ //remove space 
				return str.replace(/(^\s*)|(\s*$)/g, "");
			}
		
			$(function(){
				$("input[name='email']").blur(function() {
					var email = $(this).val();
					if(!trim(email)){
						easyDialog.open({
							container: {
								content: '请输入邮箱'
							},
							autoClose: 1000
						});
						$("input[name='email']").focus();
					}else{
						if(!(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/.test(email))){
							easyDialog.open({
								container: {
									content: '请输入正确的邮箱地址'
								},
								autoClose: 1000
							});
							$("input[name='email']").focus();
						}
					}
				});
				$("#email_btn").bind('click', function(){
					var email = $("input[name='email']").val();
					if(!email){
						easyDialog.open({
							container: {
								content: '用户名不能为空'
							},
							autoClose: 1000
						});
						$("input[name='email']").focus();
						return false;
					}else if(!(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/.test(email))){
						easyDialog.open({
							container: {
								content: '请输入正确的邮箱地址'
							},
							autoClose: 1000
						});
						$("input[name='email']").focus();
						return false;
					}
				    $.post('<?php echo base_url() . "user/forget/get_pwd" ?>', {email: email}, function(data){
						switch(data.success){
							case 0:
								easyDialog.open({
						            container: {
										content: data.msg
						            },
									autoClose: 1000
						        });
								break;
							default:
								window.location.href = data.url;
						        break;
						};
					}, 'json');
				});
			});
		</script>
	</html>
