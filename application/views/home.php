<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name=Keywords content=""/>
	<meta name=Description content=""/>
	<title><?=isset($title) ? $title : '首页' ?></title>
	<link rel=stylesheet type=text/css href="/static/css/front/style.css"/>
	<link rel=stylesheet type=text/css href="/static/css/front/link.css"/>
	<link rel="stylesheet" href="/static/css/front/lib.css" type="text/css" media="screen" charset="utf-8"/>
	<link rel="stylesheet" href="/static/css/front/jQuery.css" type="text/css" media="screen" charset="utf-8"/>
<!--	<script src="http://www.google.com/jsapi"></script>-->
<!--	<script>google.load("jquery", "1");</script>-->
	<script src="/static/js/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script src="/static/js/jquery-image-scale-carousel.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="/static/js/jquery.jslides.js"></script>  
	<script type="text/javascript" src="/static/js/ScrollPic.js"></script>  
	<script>
		<?php if ($count = count($banner)): ?>
			var carousel_images = [
				<?php foreach ($banner as $key=>$v) :?>
					<?php if ($key == $count): ?>
						"<?php echo $v['image_url']?>"
					<?php else :?>
						"<?php echo $v['image_url']?>",
					<?php endif;?>
				<?php endforeach;?>
			];
		<?php else:?>
			var carousel_images = [
				"/static/images/front/1.jpg",
				"/static/images/front/2.jpg",
				"/static/images/front/3.jpg"
			];
		<?php endif;?>
		$(window).load(function() {
			$("#photo_container").isc({
				imgArray: carousel_images,
				autoplay: true,
				autoplayTimer: 2000
			});	
		});
	</script>
</head>

<body>
<div class="index_bg">
	<div class="index_top">
		<div class="index_t_img"></div>
		<div class="index_t_c">
			<div class="index_t_c_img">
				<div class="index_logo_login">
					<div class="index_logo">
						<img src="/static/images/front/logo.png" />
					</div>
					<div class="index_login">
						<?php if ($logined): ?>
							<a href="<?=base_url().'home/login' ?>"><img src="/static/images/front/loginbtn.png" /></a>
							<a href="<?=base_url().'home/register' ?>"><img src="/static/images/front/registbtn.png" /></a>
						<?php endif; ?>
					</div>
				</div>
				<div class="banner_dv">
					<div id="photo_container"></div>
				</div>
			</div>
		</div>
	</div>
	<!--滚动图片 start-->
	<div class="index_zz_show">
		<div class="linkimg">
			<div class=rollphotos>
				<div class=blk_29>
					<div class="LeftBotton" id="LeftArr"></div>
					<div class="Cont" id="ISL_Cont_1">
						<?php if ($magainze ) : ?>
                        	<?php foreach ($magainze as $v) : ?>
								<div class=box>
									<a class="imgBorder" href="<?=base_url().'home/homepage?magainze_id='.$v['ID'] ?>" target=_blank>
										<img src="<?=$v['COVER_URL']?>" width="90px"  height="115px" border="1px soild #cccccc"/>
									</a> 
								</div>
                        	<?php endforeach;?>
                        <?php endif;?>
                        <!-- 
							<div class=box>
								<a class="imgBorder" href="http://www.magainze.com/home/homepage?magainze_id=1" target=_blank>
									<img src="/static/images/front/img2.jpg" width="90px"  height="115px" border="1px soild #cccccc"/>
								</a> 
							</div>
							<div class=box>
								<a class="imgBorder" href="http://www.magainze.com/home/homepage?magainze_id=1" target=_blank>
									<img src="/static/images/front/img3.jpg" width="90px"  height="115px" border="1px soild #cccccc"/>
								</a> 
							</div>
							<div class=box>
								<a class="imgBorder" href="http://www.magainze.com/home/homepage?magainze_id=1" target=_blank>
									<img src="/static/images/front/img4.jpg" width="90px"  height="115px" border="1px soild #cccccc"/>
								</a> 
							</div>
							<div class=box>
								<a class="imgBorder" href="http://www.magainze.com/home/homepage?magainze_id=1" target=_blank>
									<img src="/static/images/front/img5.jpg" width="90px"  height="115px" border="1px soild #cccccc"/>
								</a> 
							</div>
						 -->
					</div>
					<div class="RightBotton" id="RightArr"></div>
				</div>
				<script language=javascript type=text/javascript>
						var scrollPic_02 = new ScrollPic();
						scrollPic_02.scrollContId   = "ISL_Cont_1"; 
						scrollPic_02.arrLeftId      = "LeftArr";
						scrollPic_02.arrRightId     = "RightArr"; 
						scrollPic_02.frameWidth     = 908;
						scrollPic_02.pageWidth      = 152; 
						scrollPic_02.speed          = 10; 
						scrollPic_02.space          = 10; 
						scrollPic_02.autoPlay       = false; 
						scrollPic_02.autoPlayTime   = 3; 
						scrollPic_02.initialize(); 
				</script>
			</div>
		</div>
	</div>
	<!--滚动图片 end-->
	<div class="footer_dv">
		<span>苏州教育信息中心 维护 技术支持：0512-81877705 （工作日9:00-17:00）苏ICP备05015133号 E-Mail: Web@szedu.com </span>
	</div>
</div>		
</body>
</html>
