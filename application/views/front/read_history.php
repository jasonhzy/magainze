<?php $this->load->view('front/header')?>
            <div class="contentsetcent">
            	<div class="sscontent1"></div>
            	<div class="sscontent">
                	<div class="setcontop">
	                    <a href="javascript: history.go(-1);"><img src="/static/images/front/fanhui.png" border="0"/></a>
                    	设&nbsp;&nbsp;置
                    </div>
                    <img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
                    <div class="ssconcon">
                    	<div class="ssconconleft">
                        	<ul>
                            <li><a href="<?=base_url().'home/login_info' ?>">账户管理</a></li>
                            <li><a href="<?=base_url().'home/read_history' ?>">阅读记录</a></li>
                            <li><a href="<?=base_url().'home/func_setting' ?>">功能设置</a></li>
                            <li><a href="<?=base_url().'home/about_us' ?>">关于我们</a></li>
                            </ul>
                        </div>
                        <div class="ssconconleftimg"><img src="/static/images/front/conbg2.png"></div>
                        <div class="ssconconright">
                        	<div class="readtext">阅读记录</div>
                            <div class="readlist">
	                            <ul>
	                            	<?php if ($history): ?>
										<?php foreach ($history as $key=>$v) :?>
											<li><a href="#"><?=$v['NAME'] ?></a></li>
										<?php endforeach; ?>
									<?php else:?>
										没有阅读记录
									<?php endif;?>
	                            </ul>
                            </div>
                            <span style="float:right;font-size:12px;"><?=$this->hpages->create_links(1) ?></span>
                        </div>
                    </div>
                </div>
                <div class="contentsetfoot">
	            	<a href="<?=$url ?>"><img  style="display:none;" src="/static/images/front/fanhuimulu.png" border="0"></a>
	            </div>
            </div>
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script>
	</html>
