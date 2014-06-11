<?php $this->load->view('front/header')?>
            <div class="contentsetcent2">
            	<div class="sscontent1"></div>
            	<div class="sscontent2">
					<div class="sscontent2s">
						<div class="setcontop">
							<p style="text-align:center;">书&nbsp;&nbsp;架 </p>
						</div>
						<img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
						<div class="shujiatime">
							<ul>
							<?php if ($years) : ?>
	                    	<?php foreach ($years as $v) :?>
	                    		<li><a href="<?=base_url().'front/bookshelf/index?year='.$v['DAY_YEAR'] ?>"><?=$v['DAY_YEAR'] ?></a></li>
							<?php endforeach;?>
							<?php endif;?>
							</ul>
						</div>
						<ul class="lablelist">
							<?php if ($bookshelf) : ?>
	                    	<?php foreach ($bookshelf as $v) :?>
	                    		<li>
									<div class="lablelb">
										<div class="lablelbimg"><a href="<?=base_url().'front/bookshelf/del_bookshelf?year='.$year.'&magainze_id='.$v['ID'] ?>"><img src="/static/images/front/lablelba.png"></a></div>
										<a href="<?=base_url().'home/homepage?magainze_id='.$v['ID'] ?>">
											<img src="<?=$v['IMAGE_URL'] ?>" style="width:173px;height:125px;">
										</a>
										<div class="labletime"><?='' ?></div>
										<div class="labletitle"><?=$v['TITLE'] ?></div>
									</div>
								</li>
							<?php endforeach;?>
							<?php endif;?>
						</ul>
                    </div>
                </div>
                <div class="contentsetfoot">
            	<a href="" style="display:none;"><img src="/static/images/front/fanhuimulu.png" border="0"></a>
            </div>
            </div>
            		
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script>
        <script src="/static/js/jquery.fancybox.js" type="text/javascript" ></script>
	</html>
