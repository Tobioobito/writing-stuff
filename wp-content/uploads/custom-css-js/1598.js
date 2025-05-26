<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(document).ready(function($) {
	
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

	if(getCookie('modenuit') == null){
		setCookie('modenuit','1','10');
	}
	
	var	modenuit = getCookie('modenuit');
	
        const nightModeElements = [
            'button',
            'input',
            'select',
            'textarea',
			'#reader-mode',
			'#change-width',
			'#increase-font-size',
			'#decrease-font-size'
        ];
	
	
	/*
			'body',
			'header',
            'footer',
            'main',
			'aside',
			'a',
			'p',
			'i',
			'li',
			'h2',
			'.home',
            '.entry-summary',
            '.entry-content',
            '#secondary .widget',
            '#secondary .widget a',
            '#secondary .widget #recentcomments a',
            '.btn-default',
            '.btn-default:visited',
            '.pagination .page-numbers',
            '.next-post a',
            '.prev-post a',
            '.light code',
            '.light #primary thead',
            '.light #secondary thead',
            '.light .nav-links .fa',
            '.light.flat .nav-links a',
            '.light.flat .nav-links .fa',
            '.author-info-box .author-social-links .fa',
			'.sub-menu'
			*/
	
    // Replace the menu item text with the custom switch including icons
    $('.menu-item a:contains("Night")').html(`
        <label class="switch">
            <input type="checkbox" id="menu-switch">
            <span class="slider round">
                <i class="left-icon fa fa-sun"></i>
                <i class="right-icon fa fa-moon"></i>
            </span>
        </label>
    `);

        if (modenuit==1) { // Cookie
			
			     nightModeElements.forEach(elementOrSelector => {
                    if (elementOrSelector instanceof HTMLElement) {
                        $(elementOrSelector).addClass('mode-nuit');
                    } else {
                        $(elementOrSelector).each(function() {
                            $(this).addClass('mode-nuit');
                        });
                    }
                });
			
            $('.left-icon').show();  // Hide left icon (e.g., sun)
            $('.right-icon').show(); // Show right icon (e.g., moon)
			document.getElementById("menu-switch").checked = true;

        }

    // Add functionality for showing/hiding the icons when the switch is toggled
    $('#menu-switch').on('change', function() {
        if ($(this).is(':checked')) { // Mode nuit activé
				setCookie('modenuit','1','10');
			
				$('body').removeClass('light');
			      $('body').addClass('dark');
			
			     nightModeElements.forEach(elementOrSelector => {
                    if (elementOrSelector instanceof HTMLElement) {
                        $(elementOrSelector).addClass('mode-nuit');
                    } else {
                        $(elementOrSelector).each(function() {
                            $(this).addClass('mode-nuit');
                        });
                    }
                });
			
            $('.left-icon').show();  // Hide left icon (e.g., sun)
            $('.right-icon').show(); // Show right icon (e.g., moon)
			
        } else {
			
			                // Désactiver le mode nuit
			setCookie('modenuit','0','10');

						$('body').removeClass('dark');
			$('body').addClass('light');
			
                nightModeElements.forEach(elementOrSelector => {
                    if (elementOrSelector instanceof HTMLElement) {
                        $(elementOrSelector).removeClass('mode-nuit');
                    } else {
                        $(elementOrSelector).each(function() {
                            $(this).removeClass('mode-nuit');
                        });
                    }
                });
          
			

			
            $('.left-icon').show();  // Show left icon (e.g., sun)
            $('.right-icon').show(); // Hide right icon (e.g., moon)
        }
    });

    // Initialize with the correct icon visibility
    $('.right-icon').show(); // Start with right icon hidden (moon)
});

</script>
<!-- end Simple Custom CSS and JS -->
