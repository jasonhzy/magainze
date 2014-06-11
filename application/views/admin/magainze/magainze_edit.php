<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="/static/css/style.css" rel="stylesheet"/>
<link href="/static/css/jquery-ui/jquery-ui.css" rel="stylesheet"/>
<link href="/static/css/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<link href="/static/css/tagmanager.css" rel="stylesheet"/>
</head>

<body>
	<div class="member_top">
		<div class="m_t_font">杂志管理>><span style="color:rgb(138, 137, 138);">修改</span></div>
		<a href="<?=base_url()."admin/magainze/index" ?>"><div class="m_t_btns">管理</div></a>
	</div>
	<div class="add_member" style="width:800px;">
		<?php 
	    	$attributes = array('class' => 'form-horizontal', 'id' => 'form_add_magainze');
	    	echo form_open_multipart('/admin/magainze/edit_magainze', $attributes); 
	    ?> 
	    <input type="hidden" name="magainze_id" value="<?=isset($magainze['ID'])?$magainze['ID']:'';?>" /> 
		<table cellpadding="5">
			<tr>
				<td class="a_m_font" style="width: 100px;">杂志名：</td>
				<td><input type="text" name="magainze_name" value="<?=isset($magainze['NAME']) ? $magainze['NAME'] : ''?>" class="a_m_txt" /></td>
			</tr>
			<tr>
				<td class="a_m_font" style="width: 100px;">推荐：</td>
				<td>
					<input type="radio" name="is_recommend"  value="1" <?=isset($magainze['RECOMMEND'])&&$magainze['RECOMMEND'] ? 'checked' : ''?>/>是
					<input type="radio" name="is_recommend"  value="0" <?=isset($magainze['RECOMMEND'])&&!$magainze['RECOMMEND'] ? 'checked' : ''?>/>否
				</td>
			</tr>
			<tr>
				<td class="a_m_font" style="width: 100px;">封面：</td>
				<td>
					<input name="image_url" type="file"  accept="image/jpeg,image/png,image/gif,image/jpg" />
					<input type="hidden" name="upload_url" value="<?=isset($magainze['COVER_URL']) ? $magainze['COVER_URL']:'';?>"/> 
					<br/><span style="font-size:12px;">宽*高(202*258)</span>
				</td>
			</tr>
			<?php if(isset($magainze['COVER_URL'])&&$magainze['COVER_URL']):?>
			<tr>
				<td class="a_m_font"></td>
				<td>
					<a id="magainze_image_url" href="<?=isset($magainze['COVER_URL'])?$magainze['COVER_URL']:'';?>" >
						<img src="<?=isset($magainze['COVER_URL'])&&$magainze['COVER_URL']? $magainze['COVER_URL'] : '';?>" style="width:80px;height:70px;" title="请点击查看"/> 
					</a>
				</td>
			</tr>
			<?php endif;?>
			<tr>
				<td class="a_m_font" style="width: 100px;">描述：</td>
				<td>
					<select name="magainze_year" >
						<?php foreach ($year as $v) :?>
							<option value="<?=$v ?>" <?=isset($magainze['YEAR'])&& $v== $magainze['YEAR'] ? 'selected' : '' ?>><?=$v ?></option>
						<?php endforeach;?>
					</select>年 
					<input type="text" name="magainze_periods" value="<?=isset($magainze['PERIODS'])?$magainze['PERIODS']:'';?>" style="width:40px;"/>期
					总第<input type="text" name="total_periods" value="<?=isset($magainze['TOTAL_PERIODS'])?$magainze['TOTAL_PERIODS']:'';?>" style="width:40px;"/>期
					<span id="error_info"></span>
				</td>
			</tr>
			
			<?php $category_count = array(); ?>
			<?php if ($magainze_article) : ?>
				<?php foreach ($magainze_article as $category=>$v) : ?>
					<?php $article_ids = ''; ?>
					<tr>
						<td class="a_m_font" style="width: 100px;"><?=$v['NAME'] ?>：</td>
						<td>
							<?php if ($v['ARTICLE']) :?>
								<?php foreach ($v['ARTICLE'] as $key=>$article) : ?>
									<?php if ($article) :?>
										<?php if ($key==0) :?>
											<?php $category_count[$category] = count($v['ARTICLE']);?>
										<?php endif;?>
										<?php $article_ids .= $article['ARTICLE_ID'] . ',';?>
										<span class=tm-tag id="<?=$article['ARTICLE_ID'] ?>"><span><?=$article['HEADING'] ?></span><a href="#" onclick="removeTag('<?=$article['CATEGORY'] ?>', '<?=$article['ARTICLE_ID'] ?>')"  class="tm-tag-remove">x</a></span>
									<?php endif;?>
								<?php endforeach;?>
							<?php endif;?>
							<input type="hidden" name="tag_<?=$v['ID'] ?>" id="tag_<?=$v['ID'] ?>" value="<?=trim($article_ids, ',') ?>"/>
						</td>
						<td>
							<a href="#" onclick="open_article('<?=$v['ID'] ?>')" class="m_b_img"><img src="/static/images/admin/openbtn.jpg" /></a>
						</td>
						<td>
							<a href="#" onclick="open_article('<?=$v['ID'] ?>')" class="m_b_img"><img src="/static/images/admin/goadd.jpg" /></a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
			<tr>
				<td></td>
				<td>
					<input type="button" value="" id="submit_button" class="a_m_sbt" />
					<input type="reset" value="" class="a_m_resbtn" />
				</td>
			</tr>
		</table>
		</form>
	</div>
	<?php if ($category_article) : ?>
	<?php foreach ($category_article as $category=>$article) : ?>
	<div id="dialog_<?=$category ?>" style="display:none;" title="<?=$article['name'] ?>">
		<span>请点击文章标题实现添加</span>
		<br/><br/>
		<?php if(isset($article['item']) && $article['item']):?>
			<?php foreach ($article['item'] as $key=>$v) : ?>
			<span class="tm-tag" style="cursor:pointer;" onclick="add_tag('<?=$category ?>', '<?=$v['ARTICLE_ID'] ?>', '<?=$v['HEADING'] ?>')"><?=$v['HEADING'] ?> +</span>
			<?php endforeach;?>
		<?php else:?>
			<span>没有可添加的文章</span>
		<?php endif;?>
		<br/><br/>
		<span >您已经添加<label id="label_<?=$category ?>"><?=isset($category_count[$category]) ? $category_count[$category] : '0' ?></label>个</span>
	</div>
	<?php endforeach;?>
	<?php endif;?>
</body>
<script src="/static/js/jquery-ui/jquery-1.7.1.js" type="text/javascript" ></script>
<script src="/static/js/jquery-ui/dialog/jquery.ui.core.js" type="text/javascript" ></script>
<script src="/static/js/jquery-ui/dialog/jquery.ui.widget.js" type="text/javascript" ></script>
<script src="/static/js/jquery-ui/dialog/jquery.ui.mouse.js" type="text/javascript" ></script>
<script src="/static/js/jquery-ui/dialog/jquery.ui.draggable.js"></script>
<script src="/static/js/jquery-ui/dialog/jquery.ui.position.js"></script>
<script src="/static/js/jquery-ui/dialog/jquery.ui.resizable.js"></script>
<script src="/static/js/jquery-ui/dialog/jquery.ui.dialog.js" type="text/javascript" ></script>
<script src="/static/js/jquery.validate.min.js" type="text/javascript" ></script>
<script src="/static/js/jquery.fancybox.js" type="text/javascript" ></script>
<script type="text/javascript">
$(document).ready(function(){
		$("#form_add_magainze").validate({
			rules: {
				magainze_name: {
					required : true
				},
				image_url: {
					accept : 'gif|jpg|png'
				},
				magainze_periods : {
					required : true,
					number : true
				},
				total_periods : {
					required : true,
					number : true
				}
			},
			messages: {
				magainze_name: {
					required : "请输入杂志名"
				},
				image_url: {
					accept : '请上传正确格式的图片文件'
				},
				magainze_periods : {
					required : "请输入期数",
					number : "请输入数字"
				},
				total_periods : {
					required : "请输入总期数",
					number : "请输入数字"
				}
			},
			errorPlacement: function (error, element) {
			    switch (true) {
			        case element.attr("name") === 'magainze_periods':
			        case element.attr("name") === 'total_periods':
			            error.insertAfter($("#error_info"));
			            break;
			        default:
			        	error.insertAfter(element); 
			        	break;
			    }
			},
			submitHandler : function(form){ 
				form.submit(); 
			} 
		});
	
		$('.a_m_resbtn').bind('click', function(){
			$('label.error').html('');
			$('tr td span').remove();
			clearAllTags();
			$("#form_add_magainze")[0].reset();
		});

	    $("#submit_button").click(function () {
	        $("#form_add_magainze").submit();
	    });

	    $("#magainze_image_url").fancybox({
		    'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'titlePosition' : 'inside'
		});
	});

	function open_article(category){
		$( "#dialog_"+category ).dialog({
			width : 500,
			modal: true
		});
	};

	function add_tag(category, article_id, title) {
		if($('#'+article_id).size()>0){
			return;
		}
		html = '<span class=tm-tag id="' + article_id + '">';
        html+= '<span>' + title + '</span>';
        html+= '<a href="#" onclick="removeTag(\''+category+'\', \''+article_id+'\')"  class="tm-tag-remove">';
        html+= 'x' + '</a></span>';
		$("#tag_"+category).before($(html));
		$("#label_"+category).html( parseInt($("#label_"+category).html()) + 1 );

		var ids = [],
			allids = $("#tag_"+category).val();
		if(allids){
			ids = allids.split(',');
			ids.push(article_id);
		}else{
			ids.push(article_id);
		}
		$("#tag_"+category).val(ids.toString());
	}
	
	function removeTag(category, span_id) {
		$("#"+span_id).remove();
		$("#label_"+category).html( parseInt($("#label_"+category).html()) - 1 );
		var	ids = $("#tag_"+category).val();
		if(ids){
			allids = ids.split(',');
			var index = getIndexofArray(allids, span_id);
			allids.splice(index, 1);
			$("#tag_"+category).val(allids.toString());
		}
	}

	function getIndexofArray(arr, article_id){
		for (var i = 0, len = arr.length; i < len; i++) {
			if(arr[i] == article_id) return i;
		}
	}
</script>
</html>
