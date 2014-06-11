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
		<a href="<?=base_url().'admin/system/sys_setting' ?>"><div class="m_t_font">系统设置</div></a>
		<a href="<?=base_url().'admin/system/sys_info' ?>"><div class="m_t_btns">基本信息</div></a>
		<a href="<?=base_url().'admin/system/sys_email' ?>"><div class="m_t_btns">Email</div></a>
		<a href="<?=base_url().'admin/system/sys_code' ?>"><div class="m_t_btns">二维码</div></a>
	</div>
	<div class="add_member">
		<table cellpadding="5">
			<tr>
				<td class="a_m_font">时区设置：</td>
				<td>
					<select>
						<option>请选择</option>
					</select>
					设置系统使用的时区，中国为+8
				</td>
			</tr>
			<tr>
				<td class="a_m_font">时间格式（简单）：</td>
				<td><input type="text" class="a_m_txt"  value="Y-m-d"/></td>
			</tr>
			<tr>
				<td class="a_m_font">时间格式（完整）：</td>
				<td><input type="text" class="a_m_txt"  value="Y-m-d H:i:s"/></td>
			</tr>
			<tr>
				<td class="a_m_font">金额格式：</td>
				<td><input type="text" class="a_m_txt"  value="￥%s"/></td>
			</tr>
			<tr>
				<td class="a_m_font">默认标志：</td>
				<td>
					<input type="file" />
				</td>
			</tr>
			<tr>
				<td class="a_m_font">默认会员头像：</td>
				<td><input type="file" /></td>
			</tr>
			<tr>
				<td class="a_m_font">流量统计代码：</td>
				<td>
					<textarea class="s_web_des"></textarea>
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
