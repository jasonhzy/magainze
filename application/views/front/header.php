<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name=Keywords content="<?=isset($keywords) ? $keywords : '圣陶教育@第一线'?>"/>
        <meta name=Description content="<?=isset($desc) ? $desc : '圣陶教育@第一线'?>"/>
		<title><?=isset($title) ? $title : '圣陶教育@第一线 '?></title>
        <link rel=stylesheet type=text/css href="/static/css/front/style.css?v=10"/> 
        <link href="/static/css/easydialog.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 7]>
		<script src="/static/js/IE7.js" type="text/javascript"></script>
		<![endif]-->
		<body <?php if(isset($is_article)){
					switch ($is_article) {
						case '1':
							echo 'class="magainze_home"';
						break;
						default:
							echo 'class=""';
						break;
					}
				}else{
					echo 'class="set_body"';
				}
			?>
		>
			<div class="contentsettop">
            	<div class="contentsettop1">
                <div class="contentsettopleft">
                	<div class="contentsettopleft1" id="overview">
                		<a href="#">主办编辑出版<img src="/static/images/front/settop.png" border="0"/></a>
                        <div id="overviewcon">
                        	<ul>
                        		<?php if ($magainze ) : ?>
	                        		<?php foreach ($magainze as $v) : ?>
		                            	<li><a href="<?=base_url().'home/homepage?magainze_id='.$v['ID'] ?>"><?=$v['NAME']?></a></li>
	                        		<?php endforeach;?>
                        		<?php endif;?>
                            </ul>
                        </div>
                	</div>
                </div>
                <div class="contentsettopright">
	                <div class="contentsettopright2">
	                	<?php 
	                		$ci = &get_instance();
	                		$ci->load->model('base_model');
	                		$userinfo = $ci->base_model->check_valid(); 
	                	?>
	                	<?php if (!$userinfo) :?>
		                	<a href="<?=base_url().'home/register' ?>">注册</a>
	                		<a href="<?=base_url().'home/login' ?>">登录</a>
		                <?php endif;?>
	                	<?php if ($userinfo) :?>
		                	<a href="<?=base_url().'home/about_us' ?>">设置</a>
		                <?php endif;?>	
		                	<a href="<?=base_url().'front/search/index' ?>">搜索</a>
		                	<a href="<?=base_url().'front/bookshelf/index' ?>">书架</a>
		                <?php if ($userinfo) :?>
		                	<a href="<?=base_url().'front/bookmarks/index' ?>">书签</a>
	                		<a href="<?=base_url().'user/login/logout' ?>">[退出]</a>
	                	<?php endif;?>
	                </div>
	                <?php
						if (isset($userinfo['FRONT_USERNAME']) && $userinfo['FRONT_USERNAME']) :
					?>
						<div class="contentsettopright1"><?=$userinfo['FRONT_USERNAME'] ?></div>
					<?php else:?>
		                <div class="contentsettopright1"></div>
					<?php endif;?>
                </div>
                </div>
            </div>