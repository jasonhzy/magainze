<?php $this->load->view('front/header')?>
            <div class="textcontent">
            	<div class="textcon1"><?=$article_detail['category'] ?></div>
                <div class="textcon2">
                	<div class="textcon22"><?=$article_detail['author'] ?>：</div>
                	<div class="textcon222"><?=$article_detail['heading'] ?></div>
                	<div class="textcon2223">
                		<a href="#"><img src="/static/images/front/<?=isset($article_detail['is_love'])&&$article_detail['is_love']? 'shuqian2.png' : 'shuqian1.png' ?>"></a>
                		<a href="#"><img src="/static/images/front/shuqian.png" border="0"/></a>
                	</div>
                </div>
                <div class="ny_a41">
                	<img src="<?=$article_detail['bg_url'] ?>">
	                <div class="ny_content" style="margin:<?=$article_detail['content_space'] ?>;height:<?=$article_detail['content_height']?>px;">
	                	<span style="font-size:<?=$fontsize ?>px;"><?=$article_detail['content'] ?>  
	                </div>
                </div>
                 <div class="textcon4">
	                <a href="<?=base_url().'home/homepage?magainze_id='.$magainze_id ?>">
	                	<img src="/static/images/front/fanhui2.png">
	                </a>
                </div>
            </div>
		</body>
		<script type="text/javascript" src="/static/js/jquery-1.8.0.min.js"></script> 
        <script type="text/javascript" src="/static/js/overview.js"></script> 
        <script src="/static/js/easydialog.js" type="text/javascript" ></script>
        <script type="text/javascript">
        	$(function(){
        		$('.textcon2223 a:eq(0)').click(function(){
        			var picture = $(".textcon2223 a:eq(0) img").attr("src"),
    					path = picture.split('/');
					switch (path[path.length-1]) {
						case 'shuqian1.png':
							img = '/static/images/front/shuqian2.png';
							is_love = 1;
							break;
						default:
							img = '/static/images/front/shuqian1.png';
							is_love = 0;
							break;
					}
	        		$(".textcon2223 a:eq(0) img").attr("src", img);
					$.post('<?php echo base_url() . "front/bookmarks/add_love" ?>', {is_love : is_love, article_id: "<?=isset($article_id) ? $article_id : ''?>", magainze_id: "<?=isset($magainze_id) ? $magainze_id : ''?>"}, function(data){
						if(!data.success){
							window.location.href = data.url;
						};
					}, 'json');
				});
            	
				$('.textcon2223 a:eq(1)').click(function(){
					$.post('<?php echo base_url() . "front/bookmarks/add_bookmarks" ?>', {article_id: "<?=isset($article_id) ? $article_id : ''?>", magainze_id: "<?=isset($magainze_id) ? $magainze_id : ''?>"}, function(data){
						switch(data.success){
							case 0:
								window.location.href = data.url;
								break;
							default:
								easyDialog.open({
						            container: {
										content: data.msg
						            },
									autoClose: 1000
						        });
						        break;
						};
					}, 'json');
				});
    		});			
        </script> 
	</html>
