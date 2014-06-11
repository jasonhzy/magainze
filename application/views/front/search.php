<?php $this->load->view('front/header')?>
            <div class="contentsetcent">
            	<div class="sscontent1"></div>
            	<div class="sscontent2">
					<div class="sscontent2s">
						<div class="setcontop">
						<a href="javascript: history.go(-1);"><img src="/static/images/front/fanhui.png" border="0"></a>
						搜&nbsp;&nbsp;索
						</div>
						<img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
						<div class="searchsearch">
							<form action="" method="get">
							<div class="searchanniu">
								<a href="<?=base_url().'front/search/index' ?>"><img src="/static/images/front/searchsearch.png"></a>
							</div>
							<div class="searchshuru">
								<input type="text" value="<?=$keyword ?>" placeholder="请输入关键字" class="searchinput" />
							 </div>
							<div class="searchsousuo">
								<a href="#"><img src="/static/images/front/searsousuo.png"></a>
							</div>
							</form>
						</div>
						<div class="searchjieguo">
							<?php if ($keyword) :?>
								您搜索“<?=$keyword ?>”获大约<?=$total ?>条结果，以下是<?=$num?>条
							<?php else :?>
								共有<?=$total ?>条结果，以下是<?=$num?>条
							<?php endif;?>
						</div>
						<div class="searchjieguolist">
							<div class="searchjieguolistcon">
								<ul>
									<?php if ($article): ?>
									<?php foreach ($article as $key=>$v) :?>
										<li>
											<div class="searjgleft">
												<a href="<?=base_url().'front/article/index?article_id='.$v['ID'] ?>"><img src="<?=$v['IMAGE_URL'] ?>" style="width:174px;height:98px;"></a>
											</div>
											<div class="searjgright">
												<a href="<?=base_url().'front/article/index?article_id='.$v['ID'] ?>"><b><?=$v['HEAD'] ?></b></a>
												<p><?=my_cus_substr(strip_tags($v['CONTENT']), 150) ?></p>
											</div>
										</li>
									<?php endforeach; ?>
									<?php endif;?>
								</ul>
								<div class="searchfenye">
	                            	
	                            </div>
							</div>
                        </div>
                        <div class="searchjieguolistconright">
                        </div>
                    </div>
                </div>
                 <div class="contentsetfoot2">
		            <span style="float:right;font-size:12px;padding-right:10px;"><?=$this->hpages->create_links(1) ?></span>
                </div>
                <div class="contentsetfoot">
            		<a href="" style="display:none;"><img src="/static/images/front/fanhuimulu.png" border="0"></a>
            	</div>
            </div>
            		
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script>
        <script type="text/javascript" >
			$(document).ready(function(){
				$('.searchsousuo a').bind('click', function(){
					var keyword = $('.searchshuru .searchinput').val();
					window.location.href = '<?=base_url()."front/search/index"?>' + '?keyword='+keyword;
				});
			});
		</script>
        
	</html>
