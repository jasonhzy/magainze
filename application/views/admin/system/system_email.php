<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="/static/css/style.css" />
</head>

<body>
	<div class="member_top">
		<div class="m_t_font">网站设置</div>
		<a href="<?=base_url().'admin/system/sys_setting' ?>"><div class="m_t_btns">系统设置</div></a>
		<a href="<?=base_url().'admin/system/sys_info' ?>"><div class="m_t_btns">基本信息</div></a>
		<a href="<?=base_url().'admin/system/sys_email' ?>"><div class="m_t_font">Email</div></a>
		<a href="<?=base_url().'admin/system/sys_code' ?>"><div class="m_t_btns">二维码</div></a>
	</div>
	<div class="add_member"  style="width:530px;">
		<table cellpadding="5">
			<tr>
				<td class="a_m_font">邮件发送方式：</td>
				<td>
					<input type="radio" name="send_type" class="a_m_font"/>采用其他的SMTP服务
					<input type="radio" name="send_type" class="a_m_font"/>采用服务器内置的Mail服务
				</td>
			</tr>
			<tr>
				<td class="a_m_font">SMTP服务器：</td>
				<td><input type="text" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font">SMTP端口：</td>
				<td><input type="text" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font">发件人邮件地址：</td>
				<td><input type="text" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font">SMTP身份验证用户名：</td>
				<td><input type="text" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font">SMTP身份验证密码：</td>
				<td><input type="password" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font">测试邮件地址：</td>
				<td><input type="text" class="a_m_txt" /><input type="button" value="测试"/></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="" class="a_m_sbt" />
					<input type="reset" value="" class="a_m_resbtn" />
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
