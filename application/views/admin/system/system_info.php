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
		<a href="<?=base_url().'admin/system/sys_info' ?>"><div class="m_t_font">基本信息</div></a>
		<a href="<?=base_url().'admin/system/sys_email' ?>"><div class="m_t_btns">Email</div></a>
		<a href="<?=base_url().'admin/system/sys_code' ?>"><div class="m_t_btns">二维码</div></a>
	</div>
	<div class="add_member">
		<table cellpadding="5">
			<tr>
				<td class="a_m_font">网站名称：</td>
				<td><input type="text" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font">网站标题：</td>
				<td><input type="text" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font">网站描述：</td>
				<td><textarea class="s_web_des"></textarea></td>
			</tr>
			<tr>
				<td class="a_m_font">网站关键字：</td>
				<td><input type="text" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font">网站logo：</td>
				<td>
					<input type="file" />
				</td>
			</tr>
			<tr>
				<td class="a_m_font">ICP证书号：</td>
				<td><input type="text" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font">网站状态：</td>
				<td>
					<input type="radio" />关闭
					<input type="radio" />开启
				</td>
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
