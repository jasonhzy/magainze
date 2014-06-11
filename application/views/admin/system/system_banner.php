<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=isset($title) ? $title : '首页Banner'?></title>
     <link href="/static/css/style.css" rel="stylesheet"/>
    <link href="/static/css/easydialog.css" rel="stylesheet" type="text/css" />
    <link href="/static/css/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
		table .del{ width:120px;z-index:1000;position:absolute;border:1px #EC7C00 solid;background-color:#FFF3E6;display:none;padding:8px 8px 8px 8px;text-align:center;margin-left:-160px;}
		#banner_url:hover {color: red} 
	</style>
</head>
<body>
	<div class="member_top">
		<div class="m_t_font">首页Banner</div>
		<div class="m_t_font">管理</div>
		<a href="<?=base_url().'admin/system/banner_modify?type=add'?>"><div class="m_t_btns">新增</div></a>
	</div>
	<div class="member_search">
		<div class="m_s_search">
			
		</div>
	</div>
	<div class="member_list">
		<table cellpadding="10" cellspacing="0">
			<tr>
				<td class="m_l_t_title">
					<input type="checkbox" id="checkall" class="m_l_c"/>标题
				</td>
				<td class="m_l_t_title">图片</td>
				<td class="m_l_t_title">排序</td>
				<td class="m_l_t_title">操作</td>
			</tr>
			<?php if (count($banner)): ?>
				<?php foreach ($banner as $v) :?>
					<tr>
						<td class="m_l_t_l">
							<input type="checkbox"  name="object" value="<?=$v['id'] ?>" class="magazine_c ids"/><?=$v['title'] ?>
						</td>
						<td class="m_l_t_l"><a id="banner_url" href="<?=$v['image_url'] ?>"  style="text-decoration: none;" title="<?=$v['title'] ?>"><?=$v['image_url'] ?></a></td>
						<td class="m_l_t_l"><?=$v['sort'] ?></td>
						<td class="m_l_t_l">
							<a href="<?php echo base_url(); ?>admin/system/banner_modify?type=edit&modify_id=<?=$v['id'] ?>" title="修改"><img alt="修改" src="<?php echo base_url(); ?>static/images/admin/edit.png"/></a>&nbsp;
							<a href="javascript:void(0);" onclick="document.getElementById('no_<?=$v['id'] ?>').style.display = 'inline'" title="删除"><img src="<?php echo base_url(); ?>static/images/admin/delete.png"/></a>
							<div class="del" id="no_<?=$v['id'] ?>">
								请确认是否<b>删除?</b><br/>(永久删除不能恢复)<br/>
								<input name="queren" type="button" value="确认" onclick="window.open('<?php echo base_url(); ?>admin/system/banner_del/<?=$v['id'] ?>', '_self');" />
								<input name="quxiao" type="button" value="取消" onclick="document.getElementById('no_<?=$v['id'] ?>').style.display = 'none'" />
							</div>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
					<tr>
						<td class="table_page" colspan="8">
							<div class="m_l_t_dtbn">
								<input type="button" value=""  id="batchdel"/>
								<input type="hidden" name="del_url" value="<?php echo base_url().'admin/system/batchDel';?>"></input>
							</div>
						</td>
					</tr>
		</table>
	</div>
</body>
<script src="/static/js/jquery.js" type="text/javascript" ></script>
<script src="/static/js/easydialog.js" type="text/javascript" ></script>
<script src="/static/js/jquery.fancybox.js" type="text/javascript" ></script>
<script src="/static/js/common.js" type="text/javascript" ></script>
<script>
	$(document).ready(function(){
		$("#banner_url").fancybox({
		    'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'titlePosition' : 'inside'
		});
	});
</script>
</html>
