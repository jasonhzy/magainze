<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=isset($title) ? $title : '文章管理'?></title>
<link href="/static/css/style.css" rel="stylesheet"/>
<link href="/static/css/easydialog.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="member_top">
		<div class="m_t_font">文章管理<?=isset($title) ? '>><span style="color:rgb(138, 137, 138);">'.$title.'</span>' : ''?></div>
		<?php if ($publish == '0') :?>
			<div class="m_t_font">屏蔽(<?=$total ?>)</div>
		<?php else:?>
			<a href="<?=base_url()."admin/article/publish?publish=0" ?>"><div class="m_t_btns">屏蔽</div></a>
		<?php endif;?>
		<?php if ($publish == '1') :?>
			<div class="m_t_font">发布(<?=$total ?>)</div>
		<?php else:?>
			<a href="<?=base_url()."admin/article/publish?publish=1" ?>"><div class="m_t_btns">发布</div></a>
		<?php endif;?>
	</div>
	<div class="member_search">
		<div class="m_s_search">
			所属分类：
			<select id="category_name">
				<option value="">请选择...</option>
				<?php if ($category): ?>
				<?php foreach ($category as $v) : ?>
						<option value="<?=$v['ID'] ?>" <?=isset($category_name)&&$category_name ? ($v['ID']==$category_name ? 'selected' : '') : '' ?>><?=$v['NAME'] ?></option>
				<?php endforeach; ?>
				<?php endif;?>
			</select>
			文章名：
			<input type="text" id="article_name" value="<?=isset($article_name)&&$article_name ? $article_name : '' ?>" class="m_s_txt"/>&nbsp;&nbsp;
			<input type="button" value="" id="article_search" class="m_s_seabtn"/>
		</div>
	</div>
	<div class="member_list">
		<table cellpadding="10" cellspacing="0">
			<tr>
				<td class="m_l_t_title">
					<input type="checkbox" id="checkall" class="m_l_c"/>文章名
				</td>
				<td class="m_l_t_title">审核状态</td>
				<td class="m_l_t_title">发布状态</td>
				<td class="m_l_t_title">添加时间</td>
				<td class="m_l_t_title">推荐</td>
				<td class="m_l_t_title">操作</td>
			</tr>
			<?php foreach($article as $key=>$v):?>
	            <tr>
	            	<td class="m_l_t_l">
	            		<input type="checkbox"  name="object" value="<?=$v['ID']?>" class="m_l_c ids"/>
						<?=$v['NAME']?>
					</td>
					<td class="m_l_t_l">
						<?php 
	                		switch ($v['VERIFY'] ) {
	                			case 1:
		                			echo '通过';
		                			break;
	                			case 2:
		                			echo '未通过';
		                			break;
	                			default:
	                				break;
	                		}
	                	?>
					</td>
					<td class="m_l_t_l">
						<?php 
	                		switch ($v['PUBLISH'] ) {
	                			case 0:
		                			echo '屏蔽';
		                			break;
	                			case 1:
		                			echo '发布';
		                			break;
	                			default:
	                				echo '屏蔽';
	                				break;
	                		}
	                	?>
					</td>
					<td class="m_l_t_l"><?=$v['JOIN_TIME']?></td>
					<td class="m_l_t_l"><?=$v['RECOMMEND'] ? '<image src="/static/images/admin/ico5.jpg"/>' : ''?></td>
					<td class="m_l_t_l">
		                <a href="<?php echo site_url('admin/article/publish_article'); ?>?page_type=publish_page&publish=<?=$v['PUBLISH'] == 1 ? '0' : '1'?>&publish_id=<?=$v['ID']?>">
	                		<?=$v['PUBLISH'] == 1 ? '屏蔽' : '发布'?>
	                	</a>
					</td>
	            </tr>
	        <?php endforeach;?>
			<tr>
				<td class="table_page" colspan="8">
					<div class="table_pagenav">
						<?=$this->hpages->create_links(1) ?>  
					</div>
				</td>
			</tr>
		</table>
	</div>
</body>
<script src="/static/js/jquery.js" type="text/javascript" ></script>
<script src="/static/js/easydialog.js" type="text/javascript" ></script>
<script src="/static/js/common.js" type="text/javascript" ></script>
<script>
	$(document).ready(function(){
		$('#article_search').bind('click', function(){
			var category_name = $('#category_name').val(),
				article_name = $('#article_name').val();
			var strParams = '?category_name='+category_name+'&article_name='+article_name;
			window.location.href = '<?=base_url()."admin/article/publish"?>' + strParams;
		});
	});
</script>
</html>