<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=isset($title) ? $title : '首页Banner'?></title>
    <link href="/static/css/style.css" rel="stylesheet"/>
    <link href="/static/css/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="member_top">
		<div class="m_t_font">首页Banner</div>
		<a href="<?=base_url().'admin/system/sys_banner'?>"><div class="m_t_btns">管理</div></a>
		<div class="m_t_font"><?=$type=='add' ? '新增' : '修改' ?></div>
	</div>
	<div class="add_member">
		<?php 
	    	$attributes = array('class' => 'form-horizontal', 'id' => 'form_modifybanner');
	    	echo form_open_multipart('/admin/system/banner_modify?type='.$type, $attributes); 
	    ?>
	    <input type="hidden" name="banner_id" value="<?=isset($list['id'])?$list['id']:'';?>" /> 
	    <input type="hidden" name="add_id" value="1" />
		<table cellpadding="5">
			<tr>
				<td class="a_m_font">标题：</td>
				<td>
					<input type="text"  class="a_m_txt" name="title" value="<?=isset($list['title'])?$list['title']:'';?>" />
				</td>
			</tr>
			<tr>
				<td class="a_m_font">图片：</td>
				<td>
					<input name="image_url" type="file"  accept="image/jpeg,image/png,image/gif,image/jpg" /> 
					<input type="hidden" name="upload_url" value="<?=isset($list['image_url']) ? $list['image_url']:'';?>"/> 
				</td>
			</tr>
			<?php if(isset($list['image_url'])&&$list['image_url']):?>
			<tr>
				<td class="a_m_font"></td>
				<td>
					<a id="banner_image_url" href="<?=isset($list['image_url'])?$list['image_url']:'';?>" >
						<img src="<?=isset($list['image_url'])?$list['image_url']:'';?>" style="width:80px;height:70px;" title="请点击查看"/> 
					</a>
				</td>
			</tr>
			<?php endif;?>
			<tr>
				<td class="a_m_font">排序：</td>
				<td>
					<input type="text" class="a_m_txt" name="sort" value="<?=isset($list['sort'])?$list['sort']:'';?>" /> 
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
		</form>
	</div>
</body>
<script src="/static/js/jquery.js" type="text/javascript" ></script>
<script src="/static/js/jquery.validate.min.js" type="text/javascript" ></script>
<script src="/static/js/jquery.fancybox.js" type="text/javascript" ></script>
<script>
	$(function(){
		// validate signup form on keyup and submit
		$("#form_modifybanner").validate({
			rules: {
				image_url: {
					required: <?=isset($list['image_url'])&&$list['image_url'] ? 'false' : 'true';?>,
					accept : 'jpg|jpeg|png|gif'
				},
				title: {
					required: true
				},
				sort: {
					required: true,
					digits : true
				}
			},
			messages: {
				image_url: {
					required: '请选择图片',
					accept : '请上传.jpg，.jpeg，.png，.gif格式的图片'
				},
				title: {
					required: '请填写标题'
				},
				sort: {
					required: '请填写排序',
					digits : '请输入整数'
				}
			},
			submitHandler : function(form){ 
				form.submit(); 
			} 
		});

		$('.a_m_resbtn').bind('click', function(){
			$('label.error').html('');
		});

		$("#banner_image_url").fancybox({
		    'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'titlePosition' : 'inside'
		});
	});
</script>
</html>
