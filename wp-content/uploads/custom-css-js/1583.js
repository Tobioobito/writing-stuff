<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(document).ready(function( $ ){ //Chargement de la page	
	var site = 'http://localhost/writing-stuff/';
	var page = $(location).attr('href');
	var not_article = 	[site, site+'about-me/', site+'privacy/', site+'contact/'];

	
	if(!not_article.includes(page)){
		setTimeout(function() {$('#secondary').css({"transition": "opacity 0.5s","opacity": "45%"});}, 1000);
		
		$('.widget').on('mouseenter', function() {
    		$('#secondary').css("opacity", "100%");
	});
			$('.widget').on('mouseleave', function() {
    		setTimeout(function() {$('#secondary').css("opacity", "45%"); }, 3500);
	});		
			
	}

}); //Chargement de la page</script>
<!-- end Simple Custom CSS and JS -->
