<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(document).ready(function( $ ){ //Chargement de la page	
	
	var site = 'http://localhost/writing-stuff/';
	var page = $(location).attr('href');
	var not_article = 	[site, site+'about-me/', site+'privacy/', site+'contact/'];

	
	if(!not_article.includes(page)){
	
	$('.featured-image').on('mouseover', function() {
		$('.entry-title').style.color = 'green';
	});
	
	}
	
}); //Chargement de la page

</script>
<!-- end Simple Custom CSS and JS -->
