<?php $this->load->view('front/header')?>
            <div class="contentsetcent3">
            	<div class="sscontent4">
				<div class="sscontent2s2">
                    <div class="ssconcon">
                    	<div class="ssconconleft2" >
	                        <div class="ssconconletop">
		                        <img src="<?php echo isset($cover_url) ? $cover_url : '';?>" style="width: 202px;height:258px;">
		                        <p style="margin: 15px 0 0 50px; " id="context"><?php echo isset($desc) ? $desc : '';?></p>
	                        </div>
							<div class="ssconconlebottom">
								  <div class="mod-menu f-l">
									<div id="column-left">  
										<ul class="menu-item">
											<?php foreach ($category as $v) : ?>
												<li class=""><a href="#"><?=$v['NAME'] ?></a></li>
											<?php endforeach;?>
										</ul><!--一级菜单列表-->
										<div class="menu-cont hide" style="display: none; top: 241px;">
											<div class="menu-cont-list" style="display: none;">
												<ul>
													<?php if($contents):?>
														<?php foreach ($contents as $v) : ?>
															<?php if($v['ARTICLE_ID']):?>
																<li>
																	<h3>
																		<a href="<?= base_url().'front/article/index?magainze_id='.$magainze_id.'&article_id='.$v['ARTICLE_ID'] ?>" target="_blank">
																			<?=my_cus_substr($v['HEADING'], 30) ?>
																		</a>
																	</h3>
															    </li>
															<?php endif;?>
													    <?php endforeach; ?>
													<?php else:?>
														<li>
															<h3>没有文章可浏览</h3>
													    </li>
													<?php endif;?>
												</ul>
											</div>
											<?php foreach ($article as $category) : ?>
											<div class="menu-cont-list" style="display: none;">
												<ul>
													<?php foreach ($category as $v):?>
														<li>
															<h3>
																<?php if ($v['HEADING']): ?>
																	<a href="<?=empty($v['ARTICLE_ID']) ? '#' : base_url().'front/article/index?magainze_id='.$magainze_id.'&article_id='.$v['ARTICLE_ID'] ?>" target="_blank"><?=my_cus_substr($v['HEADING'], 30) ?></a>
																<?php else : ?>
																	没有文章可浏览
																<?php endif; ?>
															</h3>
														</li>
													<?php endforeach;?>
												</ul>
											</div>
											<?php endforeach;?>
										</div>
									</div><!--二级菜单内容-->
								</div> 
							</div>
                        </div>
                        <div class="ssconconright3">
                        	<div class="aboutcont">
                            	<div class="aboutcon">
                                	<div class="about1title"><p>&nbsp;&nbsp;&nbsp;主管&nbsp;/主办</p><p></p></div>
	                                <div class="aboutcontent1">
		                                <div class="aboutcontent1le">
		                                <p class="about_textp1">主管 </p><br/>
		                                <p class="about_textp1">主办 </p><br/>
		                                <p class="about_textp1">承办 </p>
		                                </div>
		                                <div class="aboutcontent1ri">
		                                	苏州市教育局<br/>
		                                	江苏省叶圣陶教育思想研究所<br/>
		                                	《苏州教育》编辑部<br/>
		                                	叶圣陶教师团队
		                                </div>
	                                </div>
	                                <div class="aboutcontent1">
		                                <div class="aboutcontent1le">
		                                	<p class="about_textp1">编委会主任 </p><br/>
		                                	<p class="about_textp1">副主任 </p>
		                                </div>
		                                <div class="aboutcontent1ri">顾月华 <br/>周春良 </div>
	                                </div>
	                                <div class="aboutcontent1">
		                                <div class="aboutcontent1le">
			                                <p class="about_textp1">主编 </p><br/>
			                                <p class="about_textp1">副主编 </p></div>
		                                <div class="aboutcontent1ri">周春良 <br/>徐&nbsp;&nbsp;卫 <br/>胡&nbsp;&nbsp;明 <br/>周祖华 <br/>项春雷 <br/>殷建华 </div>
	                                </div>
                                </div>
                                <div class="aboutcon2">
	                                <div class="about1title"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;采编中心&nbsp;</p><p>Editorial Center</p></div>
	                                <div class="aboutcontent1">
		                                <div class="aboutcontent1le"><p class="about_textp1">责任编辑 </p></div>
		                                <div class="aboutcontent1ri">任苏民 <br/>承益群 <br/>袁卫星 <br/>杨&nbsp;&nbsp;斌 <br/>邢奇志 <br/>丁宇红 <br/>董&nbsp;&nbsp;晨 <br/>徐&nbsp;&nbsp;晖 </div>
	                                </div>
	                                <div class="aboutcontent1">
		                                <div class="aboutcontent1le"><p class="about_textp1">电话 </p></div>
		                                <div class="aboutcontent1ri">0512-65151235</div>
	                                </div>
	                                <div class="aboutcontent1">
		                                <div class="aboutcontent1le"><p class="about_textp1">邮箱 </p></div>
		                                <div class="aboutcontent1ri">szsjyjxc@126.com</div>
	                                </div>
	                                <div class="aboutcontent1">
		                                <div class="aboutcontent1le"><p class="about_textp1">网页 </p></div>
		                                <div class="aboutcontent1ri">&nbsp;&nbsp;&nbsp;&nbsp;</div>
	                                </div>
	                                <div class="aboutcontent1">
		                                <div class="aboutcontent1le"><p class="about_textp1">排版设计 </p></div>
		                                <div class="aboutcontent1ri">苏州禧天广告设计有限公司</div>
	                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
               
            </div>
            		
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
	    <script type="text/javascript" src="/static/js/overview.js"></script> 
		<script src="/static/js/memn.js?v=5" type="text/javascript"></script>
	</html>
