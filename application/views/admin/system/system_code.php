<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="/static/css/style.css" />
<link href="/static/css/easydialog.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="member_top">
		<div class="m_t_font">网站设置</div>
		<a href="<?=base_url().'admin/system/sys_setting' ?>"><div class="m_t_btns">系统设置</div></a>
		<a href="<?=base_url().'admin/system/sys_info' ?>"><div class="m_t_btns">基本信息</div></a>
		<a href="<?=base_url().'admin/system/sys_email' ?>"><div class="m_t_btns">Email</div></a>
		<a href="<?=base_url().'admin/system/sys_code' ?>"><div class="m_t_font">二维码</div></a>
	</div>
	<div class="add_member">
		<table cellpadding="5">
			<tr>
				<td class="a_m_font">二维码生成内容：</td>
				<td><input type="text" class="a_m_txt" name="content"/><input type="button" name="generate" value="生成"/></td>
			</tr>
			<tr>
				<td class="a_m_font">二维码生成图片：</td>
				<td><input type="button" name="download" value="下载"/></td>
			</tr>
		</table>
	</div>
</body>
<script src="/static/js/jquery.js" type="text/javascript" ></script>
<script src="/static/js/easydialog.js" type="text/javascript" ></script>
<script type="text/javascript"> 
	$(function(){
		$('input[name="generate"]').bind('click', function(){
			var content = $('input[name="content"]').val();
			$.post('<?php echo base_url() . "admin/system/generate_code" ?>', {content: content}, function(data){
				easyDialog.open({
		            container: {
						content: data.msg
		            },
					autoClose: 1000
		        });
			}, 'json');			
		});
		$('input[name="download"]').bind('click', function(){
			window.location.href = '<?=base_url()."admin/system/download_code" ?>';		
		});
	});
</script>
</html>
