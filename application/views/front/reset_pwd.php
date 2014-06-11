<?php $this->load->view('front/header')?>
            <div class="contentsetcent2">
            	<div class="sscontent1"></div>
            	<div class="sscontent2">
                    <div class="setcontop">
                        <p style="text-align:center;">修改密码</p>
                    </div>
                    <img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
                    <div class="ssconcon2">
                        
                        <div class="ssconconright4">
                            <div class="registemaillogin">
                                <form action="" method="get">
                                    <p>新密码&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="new_pwd" class="logininput"/></p>
                                    <p>密码确认<input type="password" name="confirm_pwd" class="logininput"/></p>
                                    <p><input type="button" id="forget_pwd" class="changepassbtn" value="" style="margin-left: 60px;"/></p>
                                </form>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="contentsetfoot">
           			 <a href=""><img src="/static/images/front/fanhuimulu.png" border="0" style=""></a>
           		</div>
            </div>
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script> 
		<script src="/static/js/easydialog.js" type="text/javascript" ></script>
		<script type="text/javascript" >
			function trim(str){ //remove space 
				return str.replace(/(^\s*)|(\s*$)/g, "");
			}
			$(function(){
				$("input[name='new_pwd']").blur(function() {
					var new_pwd = $(this).val();
					if(!trim(new_pwd)){
						easyDialog.open({
							container: {
								content: '请输入密码'
							},
							autoClose: 1000
						});
						$("input[name='new_pwd']").focus();
					}else{
						if(new_pwd.length > 16 || new_pwd.length < 6){
							easyDialog.open({
								container: {
									content: '请输入6-16位字符'
								},
								autoClose: 1000
							});
							$("input[name='new_pwd']").focus();
						}
					}
				});
				$("input[name='confirm_pwd']").blur(function() {
					var confirm_pwd = $(this).val();
					if(!trim(confirm_pwd)){
						easyDialog.open({
							container: {
								content: '请输入密码'
							},
							autoClose: 1000
						});
						$("input[name='confirm_pwd']").focus();
					}else{
						if(confirm_pwd.length > 16 || confirm_pwd.length < 6){
							easyDialog.open({
								container: {
									content: '请输入6-16位字符'
								},
								autoClose: 1000
							});
							$("input[name='confirm_pwd']").focus();
						}
					}
				});
				$("#forget_pwd").bind('click', function(){
					var new_pwd = $("input[name='new_pwd']").val(),
						confirm_pwd = $("input[name='confirm_pwd']").val();
					if(!trim(new_pwd)){
						easyDialog.open({
							container: {
								content: '请输入密码'
							},
							autoClose: 1000
						});
						$("input[name='new_pwd']").focus();
						return false;
					}else{
						if(new_pwd.length > 16 || new_pwd.length < 6){
							easyDialog.open({
								container: {
									content: '请输入6-16位字符'
								},
								autoClose: 1000
							});
							$("input[name='new_pwd']").focus();
							return false;
						}
					}
					if(!trim(confirm_pwd)){
						easyDialog.open({
							container: {
								content: '请输入密码'
							},
							autoClose: 1000
						});
						$("input[name='confirm_pwd']").focus();
						return false;
					}else{
						if(confirm_pwd.length > 16 || confirm_pwd.length < 6){
							easyDialog.open({
								container: {
									content: '请输入6-16位字符'
								},
								autoClose: 1000
							});
							$("input[name='confirm_pwd']").focus();
							return false;
						}
					}
					if(new_pwd != confirm_pwd){
						easyDialog.open({
							container: {
								content: '两次密码输入不止一致'
							},
							autoClose: 1000
						});
						return false;
					}
				    $.post('<?php echo base_url() . "user/forget/reset_pwd" ?>', {new_pwd : new_pwd, user_uid : "<?=$user_uid ?>", salt : "<?=$salt ?>"}, function(data){
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
								easyDialog.open({
						            container: {
										content: data.msg
						            },
									autoClose: 2000
						        });
					        	//window.location.href = data.url;
						        break;
						};
					}, 'json');
				});
			});
		</script>
	</html>
