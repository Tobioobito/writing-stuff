<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(document).ready(function( $ ){ //Chargement de la page

	$('.wp-dark-mode-switcher').on("click", function(){
		var twitterContainer = document.querySelector(".custom-html-widget");
    
    // Clear the content of the div
    while (twitterContainer.firstChild) {
        twitterContainer.removeChild(twitterContainer.firstChild);
    }
		load_twitter_widget(check_theme_mode());
		
	});	
	
	
function check_theme_mode(){
var classExists = document.documentElement.classList.contains('wp-dark-mode-active');
    if(classExists) {
        // Set your variable to true
        var theme = "dark";
    } else {
        // Set your variable to false
        var theme = "light";
    }
	return theme;
}
	check_theme_mode();
function load_twitter_widget(theme){
		// Create the <a> element
var twitterLink = document.createElement("a");
twitterLink.classList.add("twitter-timeline");
twitterLink.setAttribute("data-height", "360");
twitterLink.setAttribute("data-chrome", "noheader transparent");
twitterLink.setAttribute("data-theme", theme);
twitterLink.setAttribute("href", "https://twitter.com/wr_stuff?ref_src=twsrc%5Etfw");
twitterLink.textContent = "Tweets by wr_stuff";

// Create the <script> element
var twitterScript = document.createElement("script");
twitterScript.setAttribute("async", "");
twitterScript.setAttribute("src", "https://platform.twitter.com/widgets.js");
twitterScript.setAttribute("charset", "utf-8");

// Append the <a> element and <script> element to the container div
var twitterContainer = document.querySelector(".custom-html-widget");
twitterContainer.appendChild(twitterLink);
twitterContainer.appendChild(twitterScript);

}
	
load_twitter_widget(check_theme_mode());

	
}); //Chargement de la page</script>
<!-- end Simple Custom CSS and JS -->
