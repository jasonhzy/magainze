<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=isset($title) ? $title : '会员管理'?></title>
    <link href="/static/css/style.css" rel="stylesheet"/>
    <link href="/static/css/easydialog.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="member_top">
		<div class="m_t_font">会员管理</div>
		<div class="m_t_font">管理</div>
		<a href="<?=base_url()."admin/member/modify_member?type=add&is_super=".$is_super ?>"><div class="m_t_btns">新增</div></a>
	</div>
	<div class="member_search">
		<div class="m_s_search">
			<select id='search_field'>
				<option value="username" <?= isset($search_field)&&$search_field == 'username' ? 'selected' : '' ?>>会员名</option>
			</select>
			<input type="text" id="field_content" value="<?=isset($field_content)&&$field_content ? $field_content : '' ?>" class="m_s_txt"/>&nbsp;&nbsp;
			排序：
			<select  id='sort_field'>
				<option value="join_time" <?= isset($search_field)&&$search_field == 'join_time' ? 'selected' : '' ?>>注册时间</option>
			</select>
			<input type="button" id="member_search" class="m_s_seabtn"/>
		</div>
	</div>
	<div class="member_list">
		<table cellpadding="10" cellspacing="0">
			<tr>
				<td class="m_l_t_title">
					<input type="checkbox" id="checkall" class="m_l_c"/>会员名&nbsp;|&nbsp;真实姓名
				</td>
				<td class="m_l_t_title">电子邮箱</td>
				<td class="m_l_t_title">联系方式</td>
				<td class="m_l_t_title">注册时间</td>
				<td class="m_l_t_title">最后登录</td>
				<td class="m_l_t_title">登录次数</td>
				<td class="m_l_t_title">是否是管理员</td>
				<?php if ($is_super == 'member') :?>
		         <th class="m_l_t_title">操作</th>
		        <?php endif;?>
			</tr>
			<?php foreach($members as $key=>$v):?>
	            <tr>
	            	<td class="m_l_t_l">
	            		<input type="checkbox"  name="object" value="<?=$v['user_uid']?>" class="m_l_c ids"/>
						<?=$v['name'] ? $v['username'].'&nbsp;|&nbsp;'.$v['name'] : $v['username']?>
					</td>
					<td class="m_l_t_l"><?=$v['email']?></td>
					<td class="m_l_t_l"><?=$v['phone']?></td>
					<td class="m_l_t_l"><?=$v['join_time']?></td>
					<td class="m_l_t_l"><?=$v['last_login']?><br/><?=$v['ip']?></td>
					<td class="m_l_t_l"><?=$v['login_num']?></td>
					<td class="m_l_t_l"><?=$v['super'] ? '是' : '<a href="'.base_url().'admin/member/change_to_super?user_uid='.$v['user_uid'].'">设为管理员</a>'?></td>
					<?php if ($is_super == 'member') :?>
	                <td class="m_l_t_l">
	                    <a href="<?php echo site_url('admin/member/modify_member'); ?>?type=update&is_super=<?=$is_super?>&modify_id=<?=$v['user_uid']?>">修改</a>&nbsp;
	                    <a href="<?php echo site_url('admin/member/delete_member');?>?delete_id=<?=$v['user_uid']?>" onclick="return confirm('确认删除?')" >删除</a>
	                </td>
	                <?php endif;?>
	            </tr>
	        <?php endforeach;?>
			<tr>
				<td class="table_page" colspan="8">
					<div class="m_l_t_dtbn">
						<input type="button" value=""  id="batchdel"/>
						<input type="hidden" name="del_url" value="<?php echo base_url().'admin/member/batchDel';?>"></input>
					</div>
					<?php if($is_super == 'member'):?>
						<div class="table_pagenav">
							<?=$this->hpages->create_links(1) ?>  
						</div>
		            <?php endif;?>
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
		$('#member_search').bind('click', function(){
			var search_field = $('#search_field').val(),
				field_content = $('#field_content').val(),
				sort_field = $('#sort_field').val();
			var strParams = '&search_field='+search_field+'&field_content='+field_content+'&sort_field='+sort_field;
		    <?php if($is_super == 'super'):?>
				window.location.href = '<?=base_url()."admin/member/member_search?is_super=".$is_super?>' + strParams;
			<?php else:?>
				window.location.href = '<?=base_url()."admin/member/common_member?is_super=".$is_super?>' + strParams;
			<?php endif;?>
		});
	});
</script>
</html>
