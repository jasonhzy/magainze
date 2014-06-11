<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="/static/css/style.css" />
</head>
<body >
	<div class="leftsidebar">
		<?php if (isset($menus) && count($menus)):
			foreach ($menus as $v):
				if ($v['category'] == 'title') :
		?>
		<div class="leftsidebar_title"><img src="/static/images/admin/ico1.jpg" /><span><?=$v['remark'] ?></span></div>
		<?php endif;endforeach;endif;?>
		<div class="lsb_list">
			<ul>
				<?php if (isset($menus) && count($menus)):
					foreach ($menus as $key=>$v):
						if ($v['category'] == 'item') :
				?>
					<li>
						<img src="/static/images/admin/ico2.jpg" />
						<a <?=$key==1 ? 'id="autoclick"' : '' ?> href="<?=base_url().$v['menu_url']?>" target="right"><?=$v['menu_title']?></a>
					</li>
				<?php endif;endforeach;endif;?>
			</ul>
		</div>
	</div>
</body>
<script type="text/javascript" >
	function show(url){
		location.href = url;
	    
	}
</script>
</html>
