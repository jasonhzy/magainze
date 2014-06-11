<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="/static/css/style.css" />
</head>
<body>
	<div class="sayhello">
		<span>您好，<?=$username?>,欢迎使用管理平台。您上次登录的时间是 <?=$login_time?> , IP是<?=$clientIP?></span>
	</div>
	<div class="sy_details">
		<div class="sy_d_title"><span>一周动态</span></div>
		<div class="sy_d_list">
			<div>新增会员数 : <?=$persionNum?> </div>
			<div>新增空间数/申请数 : <?=$applyNum?></div>
			<div>新增文章数 : <?=$articleNum?></div> 
		</div>
	</div>
	<div class="sy_details">
		<div class="sy_d_title"><span>统计信息</span></div>
		<div class="sy_d_list">
			<div>会员总数 : <?=$persionTotalNum?> </div>
			<div>空间总数/申请总数 : <?=$applyTotalNum?> </div>
			<div>文章总数 : <?=$articleTotalNum?></div> 
		</div>
	</div>
	<div class="sy_details">
		<div class="sy_d_title"><span>系统信息</span></div>
		<div class="sy_d_lists">
			<div class="sy_d_list01">服务器操作系统 : <?=$system?> </div>
			<div class="sy_d_list02">WEB 服务器 : <?=$webServer?> </div>
			<div class="sy_d_list01">PHP 版本 : <?=$phpVersion?></div>
			<div class="sy_d_list02">安装日期 : <?=$installDate?> </div> 
		</div>
	</div>
</body>
</html>
