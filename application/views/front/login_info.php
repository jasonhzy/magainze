<?php $this->load->view('front/header')?>
            <div class="contentsetcent2">
            	<div class="sscontent1"></div>
            	<div class="sscontent2">
                	<div class="setcontop">
                    <a href="javascript: history.go(-1);"><img src="/static/images/front/fanhui.png" border="0"/></a>
                    	设&nbsp;&nbsp;置
                    </div>
                    <img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
                     <div class="ssconcon2">
                    	<div class="ssconconleft">
                        	<ul>
	                            <li><a href="<?=base_url().'home/login_info' ?>">账户管理</a></li>
	                            <li><a href="<?=base_url().'home/read_history' ?>">阅读记录</a></li>
	                            <li><a href="<?=base_url().'home/func_setting' ?>">功能设置</a></li>
	                            <li><a href="<?=base_url().'home/about_us' ?>">关于我们</a></li>
                            </ul>
                        </div>
                        <div class="ssconconleftimg"><img src="/static/images/front/conbg1.png"></div>
                        <div class="ssconconright2">
                        <div class="loginlogin">
                        	<div class="registemaillogin">
                                <form action="" method="get">
                                	<p>用户名 &nbsp;&nbsp;&nbsp;：<label><?=$username ?></label></p>
                                    <p>注册邮箱：<label><?=$email ?></label></p>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="contentsetfoot">
	            	<a href=""><img style="display:none;" src="/static/images/front/fanhuimulu.png" border="0"/></a>
	            </div>
            </div>
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script> 
</html>
