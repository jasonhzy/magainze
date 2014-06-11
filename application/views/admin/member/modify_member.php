<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=isset($title) ? $title : '会员管理'?></title>
    <link href="/static/css/style.css" rel="stylesheet"/>
</head>
<body>
	<div class="member_top">
		<div class="m_t_font">会员管理</div>
		<a href="<?=base_url().'admin/member/'. ($is_super=='super' ? 'super_member' : 'common_member')?>"><div class="m_t_btns">管理</div></a>
		<div class="m_t_font"><?=$type=='add' ? '新增' : '修改' ?></div>
	</div>
	<div class="add_member">
		<?php 
	    	$attributes = array('class' => 'form-horizontal', 'id' => 'form_modifymember');
	    	echo form_open_multipart('/admin/member/modify_member?type='.$type, $attributes); 
	    ?>
	    <input type="hidden" name="member_id" value="<?=isset($list['user_uid'])?$list['user_uid']:'';?>" /> 
	    <input type="hidden" name="add_id" value="1" />
	    <input type="hidden" name="is_super" value="<?=$is_super?>" />
		<table cellpadding="5">
			<tr>
				<td class="a_m_font">会员名：</td>
				<td>
					<input type="text"  class="a_m_txt" name="username" value="<?=isset($list['username'])?$list['username']:'';?>" />
				</td>
			</tr>
			<tr>
				<td class="a_m_font">密码：</td>
				<td>
					<input type="password" class="a_m_txt" name="pwd" value="<?=isset($list['password']) ? $list['password']:'';?>" />
				</td>
			</tr>
			<tr>
				<td class="a_m_font">电子邮箱：</td>
				<td>
					<input type="text" class="a_m_txt" name="email" value="<?=isset($list['email'])?$list['email']:'';?>" /> 
				</td>
			</tr>
			<tr>
				<td class="a_m_font">真实姓名：</td>
				<td>
					<input type="text" class="a_m_txt" name="name" value="<?=isset($list['name'])?$list['name']:'';?>" /> 
				</td>
			</tr>
			<tr>
				<td class="a_m_font">性别：</td>
				<td>
					<input type="radio" name="sex" value="0" <?=isset($list['sex'])&&!$list['sex'] ? 'checked' : ''?>>男</input>
					<input type="radio" name="sex" value="1" <?=isset($list['sex'])&&$list['sex'] ? 'checked' : ''?>>女</input> 
				</td>
			</tr>
			<tr>
				<td class="a_m_font">电话：</td>
				<td>
					<input type="text" class="a_m_txt" name="phone" value="<?=isset($list['phone'])?$list['phone']:'';?>" /> 
				</td>
			</tr>
			<tr>
				<td class="a_m_font">传真：</td>
				<td>
					<input type="text" class="a_m_txt" name="fax" value="<?=isset($list['fax'])?$list['fax']:'';?>" /> 
				</td>
			</tr>
			<tr>
				<td><input type="hidden" name="super" value="<?=isset($list['super'])?$list['super']:'';?>" /></td>
				<td>
					<input type="submit" value="" class="a_m_sbt" />
					<input type="reset" value="" class="a_m_resbtn" />
				</td>
			</tr>
		</table>
		</form>
	</div>
</body>
<script src="/static/js/jquery.js" type="text/javascript" ></script>
<script src="/static/js/jquery.validate.min.js" type="text/javascript" ></script>
<script>
	$(function(){
		// validate signup form on keyup and submit
		$("#form_modifymember").validate({
			rules: {
				username: {
					required : true,
					rangelength : [3, 15],
					remote: '<?= base_url()."admin/member/check_member_exist?user_uid=".(isset($list['user_uid']) ? $list['user_uid'] : '')?>'
				},
				pwd: {
					required : true,
					rangelength : [6, 15]
				},
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				username: {
					required: "请输入会员名",
					rangelength: "请输入3-16位会员名",
					remote: '会员名已被注册'
				},
				pwd: {
					required: "请输入密码",
					rangelength: "请输入6-16位密码"
				},
				email: {
					required: "请输入邮箱",
					email : "请输入正确的邮箱"
				}
			},
			submitHandler : function(form){ 
				form.submit(); 
			} 
		});

		$('.a_m_resbtn').bind('click', function(){
			$('label.error').html('');
		});
	});
</script>
</html>
