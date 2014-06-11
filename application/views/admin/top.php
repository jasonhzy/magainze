<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="/static/css/style.css" />
</head>
<body>
	<div class="header_dv">
		<div class="nav">
			<div class="mainnav">
				<ul>
					<?php if (isset($menus) && count($menus)):
						foreach ($menus as $v):
					?>
						<li>
							<a href="<?=base_url().$v['child']['menu_url'] ?>" target="right"  onClick="left('<?=base_url().$v['menu_url'].'/'.$v['menu_id']?>');">
								<div class="<?= $v['menu_id']=='MENU_HOME' ? 'topnav' : 'topnavs' ?>"><?=$v['menu_title']?></div>
							</a>
						</li>
					<?php endforeach;endif;?>
				</ul>
			</div>
			<div class="login_after">
				您好,<?=$username?> 
				<a href="javascript:void(0)" target="_self" onClick="logout();" style="text-decoration:none;"> [退出]</a> | 
				<a href="<?=base_url() ?>" target="_blank" style="text-decoration:none;">网站主页</a>
			</div>
		</div>
	</div>
</body>
<script src="/static/js/jquery.js" type="text/javascript" ></script>
<script language="JavaScript">
	function logout() {
		if (confirm("您确认要退出吗?")){
			top.location = "<?=site_url()?>admin/login/logout";
		}
	}
	$(function(){
		$(".mainnav li div").click(function(){ 
		  $(".mainnav li").siblings().children().children('.topnav').removeClass('topnav').addClass('topnavs');
		  //$('.topnav').removeClass('topnav').addClass('topnavs');
		  $(this).removeClass('topnavs').addClass('topnav'); 
		});
	});
	//default load left first menu
	function left(url){
		parent.left.show(url);
	}
</script>
</html>
