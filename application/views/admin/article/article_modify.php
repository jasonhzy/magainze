<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="/static/css/style.css" rel="stylesheet"/>
<link href="/static/css/easydialog.css" rel="stylesheet" type="text/css" />
<link href="/static/css/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="member_top">
		<div class="m_t_font">文章管理>><span style="color:rgb(138, 137, 138);"><?=isset($type) && $type=='add' ? '新增' : '修改' ?></span></div>
		<a href="<?=base_url()."admin/article/index" ?>"><div class="m_t_btns">管理</div></a>
	</div>
	<div class="article_edit" style="width:1000px;">
		<?php 
	    	$attributes = array('class' => 'form-horizontal', 'id' => 'form_modifyartice');
	    	echo form_open_multipart('/admin/article/modify_article', $attributes); 
	    ?>
	    <input type="hidden" name="article_id" value="<?=isset($list['ID'])?$list['ID']:'';?>" /> 
	    <input type="hidden" name="add_id" value="1" />
	    <input type="hidden" name="is_verify" value="<?=isset($list['VERIFY']) ? $list['VERIFY']:'0';?>"/>
	    <input type="hidden" name="is_publish" value="<?=isset($list['PUBLISH']) ? $list['PUBLISH']:'0';?>"/>
	    <input type="hidden" name="page_num" value="<?=isset($page_num) ? $page_num : '';?>"/>
		<table cellpadding="5">
			<tr>
				<td class="a_m_font">文章名：</td>
				<td><input type="text" name="name" class="a_e_txt" value="<?=isset($list['NAME'])?$list['NAME']:'';?>"/></td>
			</tr>
			<tr>
				<td class="a_m_font">标题：</td>
				<td><input type="text" name="heading" class="a_e_txt" value="<?=isset($list['HEAD'])?$list['HEAD']:'';?>"/></td>
			</tr>
			<tr>
				<td class="a_m_font">副标题：</td>
				<td><input type="text" name="subheading" class="a_e_txt" value="<?=isset($list['SUBHEAD'])?$list['SUBHEAD']:'';?>"/></td>
			</tr>
			<tr>
				<td class="a_m_font">作者：</td>
				<td><input type="text" name="author" class="a_e_txt" value="<?=isset($list['AUTHOR'])?$list['AUTHOR']:'';?>"/></td>
			</tr>
			<tr>
				<td class="a_m_font">推荐：</td>
				<td>
					<input type="radio" name="is_recommend" value="1" <?=isset($list['RECOMMEND'])&&$list['RECOMMEND'] ? 'checked' : ''?>/>是
					<input type="radio" name="is_recommend" value="0" <?=isset($list['RECOMMEND'])&&!$list['RECOMMEND'] ? 'checked' : ''?>/>否
				</td>
			</tr>
			<tr>
				<td class="a_m_font">关键词：</td>
				<td>
					<input type="text" name="keywords" class="a_e_txt" value="<?=isset($list['KEYWORDS'])?$list['KEYWORDS']:'';?>"/>
					<br/><span style="color: rgb(138, 137, 138);">多个关键字之间用分号(英文)分隔，最多不超过5个</span>
				</td>
			</tr>
			<tr>
				<td class="a_m_font">所属类别：</td>
				<td>
					<select name="category">
						<option value="">请选择...</option>
						<?php if ($category): ?>
						<?php foreach ($category as $key=>$v) : 
								if($key > 0):
						?>
								<option value="<?=$v['ID'] ?>" <?=isset($list['CATEGORY'])&&$list['CATEGORY'] ? ($v['ID']==$list['CATEGORY'] ? 'selected' : '') : '' ?>><?=$v['NAME']?></option>
						<?php endif;endforeach; ?>
						<?php endif;?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="a_m_font">书签图片：</td>
				<td>
					<input name="image_url" type="file"  accept="image/jpeg,image/png,image/gif,image/jpg" /> 
					<input type="hidden" name="upload_url" value="<?=isset($list['IMAGE_URL']) ? $list['IMAGE_URL']:'';?>"/> 
					<br/><span style="font-size:12px;">宽*高(173*125)</span>
				</td>
			</tr>
			<?php if(isset($list['IMAGE_URL'])&&$list['IMAGE_URL']):?>
			<tr>
				<td class="a_m_font"></td>
				<td>
					<a id="article_image_url" href="<?=isset($list['IMAGE_URL'])?$list['IMAGE_URL']:'';?>" >
						<img src="<?=isset($list['IMAGE_URL'])?$list['IMAGE_URL']:'';?>" style="width:80px;height:70px;" title="请点击查看"/> 
					</a>
				</td>
			</tr>
			<?php endif;?>
			<tr>
				<td class="a_m_font">文章背景图片：</td>
				<td>
					<input name="bg_image" type="file"  accept="image/jpeg,image/png,image/gif,image/jpg" /> 
					<input type="hidden" name="bg_upload" value="<?=isset($list['BG_IMAGE']) ? $list['BG_IMAGE']:'';?>"/> 
					<br/><span style="font-size:12px;">宽*高(1000*1415)</span>
				</td>
			</tr>
			<?php if(isset($list['BG_IMAGE'])&&$list['BG_IMAGE']):?>
			<tr>
				<td class="a_m_font"></td>
				<td>
					<a id="article_bg_url" href="<?=isset($list['BG_IMAGE'])?$list['BG_IMAGE']:'';?>" >
						<img src="<?=isset($list['BG_IMAGE'])?$list['BG_IMAGE']:'';?>" style="width:80px;height:70px;" title="请点击查看"/> 
					</a>
				</td>
			</tr>
			<?php endif;?>
			<tr>
				<td class="a_m_font">模板：</td>
				<td>
					<?php if(isset($list['TYPE']) && trim($list['TYPE'])) :?>
						<input type="radio" name="templates" id="temp_one" value="1"  <?php echo $list['TYPE'] == '1' ? 'checked' : '';?> style="height: 60px;"/>
						<label for="temp_one"><img src="/static/images/admin/temp_one.jpg" style="height: 70px;width:60px;"/></label>
						<input type="radio" name="templates" id="temp_two" value="2" <?php echo $list['TYPE'] == '2' ? 'checked' : ''?> style="height: 60px;"/>
						<label for="temp_two"><img src="/static/images/admin/temp_two.jpg" style="height: 70px;width:60px;"/></label>
					<?php else:?>
						<input type="radio" name="templates" id="temp_one" value="1"  style="height: 60px;" checked/>
						<label for="temp_one"><img src="/static/images/admin/temp_one.jpg" style="height: 70px;width:60px;"/></label>
						<input type="radio" name="templates" id="temp_two" value="2"  style="height: 60px;"/>
						<label for="temp_two"><img src="/static/images/admin/temp_two.jpg" style="height: 70px;width:60px;"/></label>
					<?php endif;?>
				</td>
			</tr>
			<tr>
				<td class="a_m_font"></td>
				<td>
					<?php if(isset($list['TYPE']) && $list['TYPE'] == '2') : ?>
						<table  id="table_two" style="display:block;">
							<tr>
								<td class="a_m_font">高度：</td>
								<td><input type="text" value="<?php echo $list['PROFILE_HEIGHT'];?>" name="profile_height" class="a_e_txt" style="width:100px;"  value=""/></td>
							</tr>
							<tr>
								<td class="a_m_font">间距：</td>
								<td>
									<?php 
										$space = explode(',', $list['PROFILE_SPACE']);
										if (count($space) == 4) :
									?>
									上<input type="text" name="profile_up" value="<?php echo $space[0];?>" style="width:45px;"/>
									下<input type="text" name="profile_down" value="<?php echo $space[1];?>" style="width:45px;"/>
									左<input type="text" name="profile_left" value="<?php echo $space[2];?>" style="width:45px;"/>
									右<input type="text" name="profile_right" value="<?php echo $space[3];?>" style="width:45px;"/>
									<?php endif;?>
								</td>
							</tr>
							<tr>
								<td class="a_m_font">内容：</td>
								<td>
									<textarea class="a_edit_box" name="profile"><?=isset($list['PROFILE'])?$list['PROFILE']:'';?></textarea>
								</td>
							</tr>
						</table>
					<?php else :?>
						<table  id="table_two" style="display:none;">
							<tr>
								<td class="a_m_font">高度：</td>
								<td><input type="text" name="profile_height" class="a_e_txt" style="width:100px;"  value=""/></td>
							</tr>
							<tr>
								<td class="a_m_font">间距：</td>
								<td>
									上<input type="text" name="profile_up" value="" style="width:45px;"/>
									下<input type="text" name="profile_down" value="" style="width:45px;"/>
									左<input type="text" name="profile_left" value="" style="width:45px;"/>
									右<input type="text" name="profile_right" value="" style="width:45px;"/>
								</td>
							</tr>
							<tr>
								<td class="a_m_font">内容：</td>
								<td>
									<textarea class="a_edit_box" name="profile"></textarea>
								</td>
							</tr>
						</table>
					<?php endif;?>
				</td>
			</tr>
			<tr>
				<td class="a_m_font">正文间距：</td>
				<td>
					<?php if (isset($list['CONTENT_SPACE']) && trim($list['CONTENT_SPACE'])) :
						$space = explode(',', $list['CONTENT_SPACE']);
						if (count($space) == 4) :?>
								上<input type="text" name="content_up" value="<?php echo $space[0];?>" style="width:45px;"/>
								下<input type="text" name="content_down" value="<?php echo $space[1];?>" style="width:45px;"/>
								左<input type="text" name="content_left" value="<?php echo $space[2];?>" style="width:45px;"/>
								右<input type="text" name="content_right" value="<?php echo $space[3];?>" style="width:45px;"/>
						<?php endif;?>
					<?php else:?>
						上<input type="text" name="content_up" value="" style="width:45px;"/>
						下<input type="text" name="content_down" value="" style="width:45px;"/>
						左<input type="text" name="content_left" value="" style="width:45px;"/>
						右<input type="text" name="content_right" value="" style="width:45px;"/>
					<?php endif;?>
				</td>
			</tr>
			<tr>
				<td class="a_m_font">正文内容：</td>
				<td>
					<textarea class="a_edit_box" name="content"><?=isset($list['CONTENT'])?$list['CONTENT']:'';?></textarea>
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
<script charset="utf-8" src="/static/editor/kindeditor.js"></script>
<script charset="utf-8" src="/static/editor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/static/editor/plugins/code/prettify.js"></script>
<script src="/static/js/easydialog.js" type="text/javascript" ></script>
<script src="/static/js/jquery.fancybox.js" type="text/javascript" ></script>
<script type="text/javascript" >
	KindEditor.ready(function(K) {
	    var content = K.create('textarea[name="content"]',{
	        allowFileManager : true,
	        uploadJson : '/static/editor/php/upload_json.php',
	        fileManagerJson : '/static/editor/php/file_manager_json.php',
	        allowFileManager : true,
	        fontSizeTable : ['9px', '10px', '12px', '14px', '16px', '18px', '22px', '24px', '32px'],
	        width : 680,
	        height : 200,
	        afterBlur: function(){
	        	this.sync(); // key code to sys content when modify info
	        },
	        afterCreate : function() {
	            var self = this;
	            K.ctrl(document, 13, function() {
	                self.sync();
	                K('form[name=form_report]')[0].submit();
	            });
	            K.ctrl(self.edit.doc, 13, function() {
	                self.sync();
	                K('form[name=form_report]')[0].submit();
	            });
	        }
	    });

	    var profile = K.create('textarea[name="profile"]',{
	        allowFileManager : true,
	        uploadJson : '/static/editor/php/upload_json.php',
	        fileManagerJson : '/static/editor/php/file_manager_json.php',
	        allowFileManager : true,
	        items:[
				'source', '|', 'undo', 'redo', '|', 'preview', 'template', 'code', 'cut', 'copy', 'paste',
				'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
				'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
				'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
				'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
				'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat',
				'table', 'hr'
		  	],
		  	fontSizeTable : ['9px', '10px', '12px', '14px', '16px', '18px', '22px', '24px', '32px'],
	        width : 500,
	        height : 200,
	        afterBlur: function(){
	        	this.sync(); // key code to sys content when modify info
	        },
	        afterCreate : function() {
	            var self = this;
	            K.ctrl(document, 13, function() {
	                self.sync();
	                K('form[name=form_report]')[0].submit();
	            });
	            K.ctrl(self.edit.doc, 13, function() {
	                self.sync();
	                K('form[name=form_report]')[0].submit();
	            });
	        }
	    });
	    prettyPrint();
	});
	
	$(function(){
		jQuery.validator.addMethod("wordnum", function(value, element) {   
			var keywords = value;
			if(keywords.lastIndexOf(",") != -1){
				keywords = keywords.substring(0, keywords.lastIndexOf(","));
			}
			word_num = keywords.split(",");
			if(word_num.length > 5){
				return false;
			}
			return true;
		}, "请输入关键字");   
		
		// validate signup form on keyup and submit
		$("#form_modifyartice").validate({
			rules: {
				name: {
					required : true
				},
				heading: {
					required : true
				},
				keywords: {
					required : true,
					maxlength : 100,
					wordnum : 5
				},
				category: {
					required: true
				},
				content: {
					required: true
				},
				content_up: {
					required: true,
					digits : true
				},
				content_down: {
					required: true,
					digits : true
				},
				content_left: {
					required: true,
					digits : true
				},
				content_right: {
					required: true,
					digits : true
				},
				profile_height: {
					digits : true
				},
				profile_up: {
					digits : true
				},
				profile_down: {
					digits : true
				},
				profile_left: {
					digits : true
				},
				profile_right: {
					digits : true
				},
				image_url: {
					required: <?=isset($list['IMAGE_URL'])&&$list['IMAGE_URL'] ? 'false' : 'true';?>,
					accept : 'jpg|jpeg|png|ico|bmp'
				},
				bg_image: {
					required: <?=isset($list['BG_IMAGE']) && $list['BG_IMAGE'] ? 'false' : 'true';?>,
					accept : 'jpg|jpeg|png|ico|bmp'
				}
			},
			messages: {
				name: {
					required : "请输入文章名"
				},
				heading: {
					required: "请输入标题"
				},
				keywords: {
					required: "请输入关键字",
					maxlength : "长度不能超过100的字符",
					wordnum : "关键字不能超过5个"
				},
				category: {
					required: "请选择所属分类"
				},
				content: {
					required: "请输入内容"
				},
				content_up: {
					required: "请输入上边距",
					digits : '请输入整数'
				},
				content_down: {
					required: "请输入下边距",
					digits : '请输入整数'
				},
				content_left: {
					required: "请输入左边距",
					digits : '请输入整数'
				},
				content_right: {
					required: "请输入右边距",
					digits : '请输入整数'
				},
				profile_height: {
					digits : '请输入整数'
				},
				profile_up: {
					digits : '请输入整数'
				},
				profile_down: {
					digits : '请输入整数'
				},
				profile_left: {
					digits : '请输入整数'
				},
				profile_right: {
					digits : '请输入整数'
				},
				image_url: {
					required: "请上传图片",
					accept : '请上传.jpeg，.png，.gif，.jpg文件'
				},
				bg_image: {
					required: "请上传图片",
					accept : '请上传.jpeg，.png，.gif，.jpg文件'
				}
			},
			errorPlacement: function (error, element) {
				error.insertAfter(element); 
			},
			submitHandler : function(form){ 
				//A4 595*842px
				var width = 1000;
					height = 1415;
				var content_up = $('input[name="content_up"]').val();
					content_down = $('input[name="content_down"]').val();
					content_right = $('input[name="content_right"]').val();
					content_left = $('input[name="content_left"]').val();
					profile_height = $('input[name="profile_height"]').val();
					profile_up = $('input[name="profile_up"]').val();
					profile_down = $('input[name="profile_down"]').val();
					profile_right = $('input[name="profile_right"]').val();
					profile_left = $('input[name="profile_left"]').val();
				switch ($('input[name="templates"]:checked').val()) {
					case '1':
						if( parseInt(content_up) + parseInt(content_down) >= height){
							easyDialog.open({
					            container: {
									content: '请重新设置正文的上下边距, 上+下 < 1415'
					            },
								autoClose: 2000
					        });
							return false;
						}
						if( parseInt(content_left) + parseInt(content_right) >= width){
							easyDialog.open({
					            container: {
									content: '请重新设置正文的左右边距, 左+右 < 1000'
					            },
								autoClose: 2000
					        });
							return false;
						}
						break;
					case '2':
						if(profile_height >= 1415){
							easyDialog.open({
					            container: {
									content: '请重新设置高度, 高  < 1415'
					            },
								autoClose: 2000
					        });
							return false;
						}
						if(parseInt(profile_up) + parseInt(profile_down) + parseInt(profile_height) >= 1415){
							easyDialog.open({
					            container: {
									content: '请重新设置上下边距及高度, 上+下+高 < 1415'
					            },
								autoClose: 2000
					        });
							return false;
						}
						if(parseInt(profile_right) + parseInt(profile_left) >= 1000){
							easyDialog.open({
					            container: {
									content: '请重新设置左右边距, 左+右 < 1000'
					            },
								autoClose: 2000
					        });
							return false;
						}
						
						var up_height = parseInt(profile_up) + parseInt(profile_down) + parseInt(profile_height),
							content_height = 1415 - up_height;
						if( parseInt(content_up) + parseInt(content_down) >= content_height){
							easyDialog.open({
					            container: {
									content: '请重新设置正文的上下边距, 上+下 < '+content_height
					            },
								autoClose: 2000
					        });
							return false;
						}
						if( parseInt(content_left) + parseInt(content_right) >= width){
							easyDialog.open({
					            container: {
									content: '请重新设置正文的左右边距, 左+右 < 1000'
					            },
								autoClose: 2000
					        });
							return false;
						}
						break;
					default:
						break;
				}
				form.submit(); 
			} 
		});

		$('.a_m_resbtn').bind('click', function(){
			$('label.error').html('');
		});

		$("#article_image_url").fancybox({
		    'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'titlePosition' : 'inside'
		});
		$("#article_bg_url").fancybox({
		    'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'titlePosition' : 'inside'
		});

		$("#temp_one").click(function(){
			$("#table_two").css('display', 'none');
        });
		$("#temp_two").click(function(){
			$("#table_two").css('display', 'block');
        });
	});
</script>
</html>