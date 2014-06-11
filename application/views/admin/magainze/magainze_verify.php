<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=isset($title) ? $title : '杂志管理'?></title>
     <link href="/static/css/style.css" rel="stylesheet"/>
    <link href="/static/css/easydialog.css" rel="stylesheet" type="text/css" />
    <link href="/static/css/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="member_top">
		<div class="m_t_font">杂志管理<?=isset($title) ? '>><span style="color:rgb(138, 137, 138);">'.$title.'</span>' : ''?></div>
		<?php if (isset($verify) && $verify == '2') :?>
			<div class="m_t_font">未通过(<?=$total ?>)</div>
		<?php else:?>
			<a href="<?=base_url()."admin/magainze/verify?verify=2" ?>"><div class="m_t_btns">未通过</div></a>
		<?php endif;?>
		<?php if (isset($verify) && $verify == '1') :?>
			<div class="m_t_font">通过(<?=$total ?>)</div>
		<?php else:?>
			<a href="<?=base_url()."admin/magainze/verify?verify=1" ?>"><div class="m_t_btns">通过</div></a>
		<?php endif;?>
	</div>
	<div class="member_search">
		<div class="m_s_search">
			杂志名：
			<input type="text"  value="<?=isset($field_content)&&$field_content ? $field_content : '' ?>" id="field_content" class="m_s_txt"/>&nbsp;&nbsp;
			<input type="button" id="member_search" class="m_s_seabtn"></input>
		</div>
	</div>
	<div class="member_list">
		<table cellpadding="10" cellspacing="0">
			<tr>
				<td class="m_l_t_title">
					<input type="checkbox" id="checkall" class="m_l_c"/>杂志名
				</td>
				<td class="m_l_t_title">审核状态</td>
				<td class="m_l_t_title">发布状态</td>
				<td class="m_l_t_title">添加时间</td>
				<td class="m_l_t_title">推荐</td>
				<td class="m_l_t_title">操作</td>
			</tr>
			<?php if(count($magainze)>0) : ?>
		        <?php foreach($magainze as $key=>$v):?>
			<tr>
				<td class="m_l_t_l">
					<input type="checkbox"  name="object" value="<?=$v['ID']?>" class="magazine_c ids"/>
					<div class="magaimg_font">
						<?php if(isset($v['COVER_URL'])&&$v['COVER_URL']) :?>
							<a id="magainze_image_url" href="<?=$v['COVER_URL']?>" >
								<img src="<?=$v['COVER_URL']?>" class="magazineimg"/>
							</a><br/>
						<?php endif;?>
		        		<?=$v['NAME']?>
					</div>
				</td>
				<td class="m_l_t_l">
					<?php 
                		switch ($v['VERIFY'] ) {
                			case 0:
	                			echo '未审核';
	                			break;
                			case 1:
	                			echo '通过';
	                			break;
                			case 2:
	                			echo '未通过';
	                			break;
                			default:
                				echo '未审核';
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
					<a href="<?php echo site_url('admin/magainze/verify_magainze'); ?>?page_type=verify_page&verify=<?=$v['VERIFY'] == 1 ? '2' : '1'?>&verify_id=<?=$v['ID']?>">
                		<?=$v['VERIFY'] == 1 ? '未通过' : '通过'?>
                	</a>
				</td>
			</tr>
			 <?php endforeach;?>
		    <?php endif;?>
			<tr>
				<td class="table_page" colspan="8">
					<div class="m_l_t_dtbn">
						<input type="button" value=""  id="batchdel"/>
						<input type="hidden" name="del_url" value="<?php echo base_url().'admin/member/batchDel';?>"></input>
					</div>
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
<script src="/static/js/jquery.fancybox.js" type="text/javascript" ></script>
<script src="/static/js/common.js" type="text/javascript" ></script>
<script>
	$(document).ready(function(){
		$("#magainze_image_url").fancybox({
		    'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'titlePosition' : 'inside'
		});
		
		$('#member_search').bind('click', function(){
			var field_content = $('#field_content').val();
				strParams = '?search_field=name'+'&field_content='+field_content;
			window.location.href = '<?=base_url()."admin/magainze/verify"?>' + strParams;
		});
	});
</script>
</html>