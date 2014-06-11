$(function() {
	var  cf=14;
	var startSize = $.cookie('fontSize');
	var startSize = parseFloat(startSize, 14);
	$('#text p').css('font-size', startSize);
	$('#slider_caption').css('left', startSize*19.75 - 158-118.5).text(Math.round(startSize ));
	$('.slider_handle').css('left', startSize*19.75 - 158-118.5);
	
		$('#slider_caption').hide();
		var captionVisible = false;
		/*$('.slider_bar').slider({
			handle: '.slider_handle',
			startValue: startSize*100/15 - 53.3 ,
			minValue: 0,
			maxValue: 100,
			start: function(e, ui) {
				$('#slider_caption').fadeIn('fast', function() { captionVisible = true;});
				$('#font_indicator').fadeIn('slow');
			},
			stop: function(e, ui) { 
				if (captionVisible == false) {
					$('#slider_caption').fadeIn('fast', function() { captionVisible = true;});
					$('#font_indicator').fadeIn('slow');
					$('#slider_caption').css('left', ui.handle.css('left')).text(Math.round(ui.value * 15/100 + 8 ));
					$('#font_indicator b').text(Math.round(ui.value * 15/100 + 8 ));
					$("div#text p").animate({fontSize: ui.value * 15/100 + 8 }).fadeIn("slow");
				}
				$('#slider_caption').fadeOut('fast', function() { captionVisible = false; });
				$('#font_indicator').fadeOut('slow');
			},
		
			slide: function(e, ui) {
				$('#slider_caption').css('left', ui.handle.css('left')).text(Math.round(ui.value * 15/100 + 8 ));
				$('#font_indicator b').text(Math.round(ui.value * 15/100 + 8 ));
				$("div#text p").css({fontSize: ui.value * 15/100 + 8 }).fadeIn("slow");
	
			}
		});*/
		
	  $(".add").click(function(){
	    var currentFontSize = $('#text p').css('font-size');
	    var currentFontSizeNum = parseFloat(currentFontSize, 14);
	    var newFontSize = currentFontSizeNum+1;
		if (newFontSize < 29) {
		    $('#text p').css('font-size', newFontSize);
			$('#slider_caption').css('left', newFontSize*19.75 - 158-118.5).fadeIn('fast').text(Math.round(newFontSize )).fadeOut();
			$('.slider_handle').css('left', newFontSize*19.75 - 158-118.5);
			$('#font_indicator').fadeIn('slow');
			$('#font_indicator b').text(Math.round(newFontSize ));
			$('#font_indicator').fadeOut('slow');
			//save font size
			set_font(newFontSize);
		}
		else{
			$('#font_indicator').fadeIn('slow');
			$('#font_indicator b').text("Isn't 23 big enough?");
			$('#font_indicator').fadeOut('slow');
		}
	    return false;
	  });
	  $(".minus").click(function(){
	    var currentFontSize = $('#text p').css('font-size');
	    var currentFontSizeNum = parseFloat(currentFontSize, 14);
	    var newFontSize = currentFontSizeNum-1;
		if (newFontSize > 13) {
		    $('#text p').css('font-size', newFontSize);
			$('#slider_caption').css('left', newFontSize*19.75 - 158-118.5).fadeIn('fast').text(Math.round(newFontSize )).fadeOut();
			$('.slider_handle').css('left', newFontSize*19.75 - 158-118.5);
			$('#font_indicator').fadeIn('slow');
			$('#font_indicator b').text(Math.round(newFontSize ));
			$('#font_indicator').fadeOut('slow');
			//save font size
			set_font(newFontSize);
		}
		else{
			$('#font_indicator').fadeIn('slow');
			$('#font_indicator b').text("Isn't 8 small enough?");
			$('#font_indicator').fadeOut('slow');
		}
		return false;
	  });
});
window.onbeforeunload = leaveCookie;

function leaveCookie(){
	//var FontSize = $('#text p').css('font-size');
	//var IntFontSize = parseFloat(FontSize, 14);
	//$.cookie('fontSize', IntFontSize);
}

/*
 * set_font : save font size
 * 
 * @author Jason Hu
 * @since 2014-04-08
 */
function set_font(fontsize) {
	var font_url = $("input[name='font_url']").val();
	$.post(font_url, {font_size: fontsize}, function(data){
		if(!data.success){
			window.location.href = data.url;
		}
	}, 'json');
}