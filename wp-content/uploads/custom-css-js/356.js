<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(document).ready(function( $ ){ //Chargement de la page

	var site = 'http://localhost/writing-stuff/';
	var page = $(location).attr('href');
	var not_article = 	[site, site+'about-me/', site+'privacy/', site+'contact/'];
	
	function setCookie(key, value, expiry) {
		var expires = new Date();
		expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
		document.cookie = key + '=' + value + ';expires=' + expires.toUTCString() + ";domain=;path=/";
    }

    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }

    function eraseCookie(key) {
        var keyValue = getCookie(key);
        setCookie(key, keyValue, '-1');
    }

	if(getCookie('state') == null){
		setCookie('state','1','10');
	}
		
	if(getCookie('reader') == null){
		setCookie('reader','1','10');
	}
		
	if(getCookie('size') == null){
		setCookie('size','18px','10');
	}
		
	var	reader = getCookie('reader'); 
	var	state = getCookie('state');
	var	size = getCookie('size');
	
	//////////////////////////////////
	//Si n'est pas la page principal//
	//////////////////////////////////
	
	if($(location).attr('href') != site){ 
		if($(document).scrollTop() == 0){		   
				window.scrollTo(0, $('.site-header').height()-50);
		}
	}
	
	///////////////////////////////
	// Si la page est un article//
	//////////////////////////////
	 if(!not_article.includes(page)){ 
	 	 
		 $('.entry-content').css('font-size', size);

		if(size == '24px'){
			$('#increase-font-size').css('color', '#fb2056');
		}

		if(size == '10px'){
			$('#decrease-font-size').css('color', '#fb2056');
		}
		 
		if (state == 2){
			$('.widget-area').css("width", "25%");
			$('.content-area').css("width", "75%");
		    $('#change-width').css("color", "#fb2056");
			setCookie('state','2','10');
		}
		
		if (reader == 2){
			$('.widget-area').hide();
			$('.content-area').css("width", "100%");
		    $('#reader-mode').css("color", "#fb2056");
			setCookie('reader','2','10');
		}
			if (window.innerWidth <= 992){
			$('.widget-area').css("width", "100%");
			$('.content-area').css("width", "100%");
			$('#change-width').hide();
			$('#reader-mode').hide();
		}
	
	$(window).on("resize", function(){

		if (window.innerWidth <= 992){
			$('.widget-area').css("width", "100%");
			$('.content-area').css("width", "100%");
			$('#change-width').hide();
			$('#reader-mode').hide();
		}
		else if(window.innerWidth > 992){
			$('#change-width').show();
			$('#reader-mode').show();
			
			$('.widget-area').css("width", "33.33%");
			$('.content-area').css("width", "66.67%");
			setCookie('reader','1','10');
			setCookie('state','1','10');
			state = 1;
			reader = 1;
			$('#change-width').css("color", "black");
			$('#reader-mode').css("color", "black");
			$('.widget-area').show();
		}
	
	});	 
 
		$('#reader-mode').on("click", function(){
			
			state = 1;
			setCookie('state','1','10');
			$('#change-width').css("color", "black");
			
			if(reader == 1){
			$('.widget-area').hide();
			$('.content-area').animate({"width" : "100%"}, 250);
		    $('#reader-mode').css("color", "#fb2056");
			reader = 2;
			setCookie('reader','2','10');
			}
			else if(reader == 2){
			$('#reader-mode').css("color", "black");
			$('.widget-area').show();
			$('.content-area').animate({"width" : "66.67%"}, 250);
			$('.widget-area').animate({"width" : "33.33%"}, 250);
			reader = 1;
			setCookie('reader','1','10');
		}	
	});
		
		
	$('#change-width').on("click", function(){

		reader = 1;
		setCookie('reader','1','10');
		$('.widget-area').show();
		$('#reader-mode').css("color", "black");
		
		if(state == 1){
			$('.content-area').animate({"width" : "75%"}, 250);
			$('.widget-area').animate({"width" : "25%"}, 250);
			//$('.FixedWidget__fixed_widget').animate({"width" : "262.5px"}, 250);
			
		    $('#change-width').css("color", "#fb2056");
			state = 2;
			setCookie('state','2','10');
		}
		else if(state == 2){

			$('.content-area').animate({"width" : "66.67%"}, 250);
			$('.widget-area').animate({"width" : "33.33%"}, 250);
			//$('.FixedWidget__fixed_widget').animate({"width" : "360px"}, 250);
			
		    $('#change-width').css("color", "black");
			state = 1;
			setCookie('state','1','10');
		}	
	});

	$('#increase-font-size').on("click", function(){
				if(parseInt($(".entry-content").css('font-size')) == 24){
			setCookie('size','18px','10');
		   	$('.entry-content').css('font-size', '18px');
			$('#increase-font-size').css('color', 'black');
		}else{
		$('#decrease-font-size').css('color', 'black');
		var size_entry_content = parseInt($(".entry-content").css('font-size'));
		var new_size = size_entry_content + 1;
		$('.entry-content').css('font-size', new_size+'px');
		setCookie('size',new_size+'px','10');
		if(parseInt($(".entry-content").css('font-size')) >= 24){
		   		setCookie('size','24px','10');
		   		$('.entry-content').css('font-size', '24px');
				$('#increase-font-size').css('color', '#fb2056');
		
		   }
			else if(parseInt($(".entry-content").css('font-size')) == 24){
			   	setCookie('size','18px','10');
		   		$('.entry-content').css('font-size', '18px');
				$('#decrease-font-size').css('color', 'black');
		   }
		}
	});
	
	$('#decrease-font-size').on("click", function(){
		if(parseInt($(".entry-content").css('font-size')) <= 10){
			setCookie('size','18px','10');
		   	$('.entry-content').css('font-size', '18px');
			$('#decrease-font-size').css('color', 'black');
		}
		else{
		$('#increase-font-size').css('color', 'black');
		var size_entry_content = parseInt($(".entry-content").css('font-size'));
		var new_size = size_entry_content - 1;
		$('.entry-content').css('font-size', new_size+'px');
				setCookie('size',new_size+'px','10');
				if(parseInt($(".entry-content").css('font-size')) <= 10){
		   		setCookie('size','10px','10');
		   		$('.entry-content').css('font-size', '10px');
				$('#decrease-font-size').css('color', '#fb2056');
				
		   }
		}
	});
} //Si la page est un article
	//$('aside').css("width", "100px");
}); //Chargement de la page</script>
<!-- end Simple Custom CSS and JS -->
