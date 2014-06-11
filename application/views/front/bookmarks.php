<?php $this->load->view('front/header')?>
            <div class="contentsetcent2">
            	<div class="sscontent1"></div>
            	<div class="sscontent2">
					<div class="sscontent2s">
                	<div class="setcontop">
                    	<p style="text-align:center;">书&nbsp;&nbsp;签 </p>
                    </div>
                    <img class="bottomimg" border="0" src="/static/images/front/tabbottom.png"/>
                    <ul class="lablelist">
                    	<?php if ($bookmarks) : ?>
                    	<?php foreach ($bookmarks as $v) :?>
                    	<li>
                    		<div class="lablelb">
                            	<div class="lablelbimg">
                            		<a href="<?=base_url().'front/bookmarks/del_bookmarks?bookmarks_id='.$v['ID'] ?>"><img src="/static/images/front/lablelba.png"></a>
                            	</div>
                    			<a href="<?=base_url().'front/article/index?bookmarks_id='.$v['ID'] ?>">
                    				<img src="<?=$v['IMAGE_URL'] ?>"  style="width:173px;height:125px;">
                    			</a>
                        		<div class="labletime"><?='' ?></div>
                        		<div class="labletitle"><?=$v['HEADING'] ?></div>
                    		</div>
                    	</li>
						<?php endforeach;?>
						<?php endif;?>
                    </ul>
                    </div>
                </div>
                <div class="contentsetfoot">
	            	<a href="#"  style="display:none;"><img src="/static/images/front/fanhuimulu.png" border="0"></a>
	            </div>
            </div>
            		
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script> 
	</html>
