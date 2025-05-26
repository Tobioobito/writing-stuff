<?php
/**
 * Nisarg Pro functions and definitions
 *
 * @package NisargPRO
 */
/**
 * Constants
 *
 */
if ( ! defined( 'NISARGPRO_VERSION' ) ) {
	define( 'NISARGPRO_VERSION', '1.12' );
}

if ( ! defined( 'NISARGPRO_AUTHOR' ) ) {
	define( 'NISARGPRO_AUTHOR', 'Falguni Desai' );
}

define( 'NISARGPRO_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'NISARGPRO_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );
/**
 * NisargPRO theme setup
 *
 */
if ( ! function_exists( 'nisargpro_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	/**
	 * Nisarg only works in WordPress 4.9.7 or later.
	 */
	if ( version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
		require get_template_directory() . '/inc/back-compat.php';
	}

	function nisargpro_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Nisarg, use a find and replace
		 * to change 'nisargpro' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'nisargpro', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 604, 270 );
		add_image_size( 'nisargpro-full-width', 850, 999, false );

		function register_nisargpro_menus() {
			// This theme uses wp_nav_menu() in one location.
			register_nav_menus( array(
				'primary' => esc_html__( 'Top Primary Menu', 'nisargpro' ),
			) );
		}
		add_action( 'init', 'register_nisargpro_menus' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'audio',
			'quote',
			'link',
			'gallery',
			'status',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'nisargpro_custom_background_args', array(
			'default-color' => '#eceff1',
			'default-image' => '',
		) ) );

		//Add support for custom logo.
		$defaults = array(
			'height'      => 50,
			'width'       => 150,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( '.navbar-brand' ),
		);
		add_theme_support( 'custom-logo', $defaults );
	}
endif; // nisargpro_setup
add_action( 'after_setup_theme', 'nisargpro_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 */
function nisargpro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nisargpro_content_width', 640 );
}
add_action( 'after_setup_theme', 'nisargpro_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function nisargpro_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'nisargpro' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	/*Register widget are for inserting ad/widgets at the end of post*/
	register_sidebar( array(
		'name'          => esc_html__( 'Widget area at the end of a single post', 'nisargpro' ),
		'id'            => 'nisargpro-ad-after-post-end',
		'description'   => 'Add widgets at the end of the post content on a single post',
		'before_widget' => '<aside id="%1$s" class="ad-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	/*Regsiter widget area for inserting ad/widget after every 5 posts on blog posts listing page*/
	register_sidebar( array(
		'name'          => esc_html__( 'Widget after every 5th post', 'nisargpro' ),
		'id'            => 'nisargpro-ad-after-every5post',
		'description'   => 'The widgets added to this area will be displayed after every 5th post on blog posts listing page. ',
		'before_widget' => '<aside id="%1$s" class="ad-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	//Regsiger fotter widget area left
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area - Left', 'nisargpro' ),
		'id'            => 'nisargpro-footer-widget-area-left',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );
	//Regsiger fotter widget area center
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area - Center', 'nisargpro' ),
		'id'            => 'nisargpro-footer-widget-area-center',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );
	//Regsiger fotter widget area Right
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area - Right', 'nisargpro' ),
		'id'            => 'nisargpro-footer-widget-area-right',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '<span></h4>',
	) );
}
add_action( 'widgets_init', 'nisargpro_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function nisargpro_scripts() {
	//Enqueue Styles
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri().'/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/font-awesome/css/font-awesome.min.css' );
	//style of nisargpro theme
	wp_enqueue_style( 'nisargpro-style', get_stylesheet_uri() );

	//Enqueue Scripts
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'nisargpro-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'nisargpro-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'nisargpro-js', get_template_directory_uri() . '/js/nisargpro.js', array( 'jquery' ), false, true );

	$blog_listing_style = get_theme_mod( 'nisargpro_post_listing_style', 'classic' );
	$archive_listing_style = get_theme_mod( 'nisargpro_archive_posts_listing_style', 'classic' );
	//If post listing style is masonry enqueue masonry related js
	if ( 'masonry' === $blog_listing_style || 'masonry' === $archive_listing_style ) {
		//Scripts for Masonry View
		wp_enqueue_script( 'masonary-image-preload-script', get_template_directory_uri() .  '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'masonary-script', get_template_directory_uri() .  '/js/masonry.pkgd.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'masonary-init-script', get_template_directory_uri() .  '/js/masonry-init.js', array( 'jquery' ), false, true );
	}


	//style  for colorbox (lightbox for gallery post)
	wp_enqueue_style( 'colorbox-css', get_template_directory_uri().'/colorbox/css/colorbox.css' );
	//Scripts and css for lightbox effect in gallery post
	wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/colorbox/js/jquery.colorbox-min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'colorbox-init', get_template_directory_uri() . '/js/colorbox.js', array( 'colorbox' ), '', true );

	wp_enqueue_script( 'html5shiv', get_template_directory_uri(). '/js/html5shiv.js', array(),'3.7.3' ,false );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	wp_localize_script( 'nisargpro-js', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'nisargpro' ),
		'collapse' => __( 'collapse child menu', 'nisargpro' ),
	) );
	//Make the Colorbox text translation-ready
    $current = 'current';
    $total = 'total';
    wp_localize_script( 'colorbox', 'nisargpro_script_vars', array(
    	/* translators: 1: current 2: total. */
        'current'   => sprintf(__( 'image {%1$s} of {%2$s}', 'nisargpro'), $current, $total ),
        'previous'  =>  __( 'previous', 'nisargpro' ),
        'next'      =>  __( 'next', 'nisargpro' ),
        'close'     =>  __( 'close', 'nisargpro' ),
        'xhrError'  =>  __( 'This content failed to load.', 'nisargpro' ),
        'imgError'  =>  __( 'This image failed to load.', 'nisargpro' )
      )
    );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'nisargpro_scripts' );

/**
 * Modify user contact methods.
 */
function nisargpro_modify_user_contact_methods( $user_contact ) {

	// Add user contact methods
	$user_contact['skype']   	= 	__( 'Skype', 'nisargpro' );
	$user_contact['facebook'] 	= 	__( 'Facebook', 'nisargpro' );
	$user_contact['twitter'] 	= 	__( 'Twitter', 'nisargpro' );
	$user_contact['instagram'] 	= 	__( 'Instagram', 'nisargpro'  );
	$user_contact['googleplus']	=	__( 'GooglePlus', 'nisargpro'  );
	$user_contact['dribble'] 	= 	__( 'Dribble', 'nisargpro'  );
	$user_contact['linkedin'] 	= 	__( 'LinkedIn', 'nisargpro'  );

	return $user_contact;
}
add_filter( 'user_contactmethods', 'nisargpro_modify_user_contact_methods' );
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Change Read More link.
 */
function nisargpro_new_excerpt_more( $more ) {
	$excerpt_length = get_theme_mod( 'post_excerpt_length', 54 );
	$post_display_option = get_theme_mod( 'post_display_option', 'post-excerpt' );
	if( $excerpt_length === 0 && 'post-excerpt' === $post_display_option ) {
		return '';
	} else {
		return '...<p class="read-more"><a class="btn btn-default" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">' . __( ' Read More', 'nisargpro' ) . '<span class="screen-reader-text"> '. __( ' Read More', 'nisargpro' ).'</span></a></p>';
	}
}
add_filter( 'excerpt_more', 'nisargpro_new_excerpt_more' );

/**
 * Change excerpt character length to the length entered by user.
 */
function custom_excerpt_length( $length ) {
	$excerpt_length = get_theme_mod( 'post_excerpt_length', '54' );
	if( $excerpt_length > 500 || $excerpt_length < 0 ) {
		return 54;
	}
	return $excerpt_length;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Add Search button/box to the primary memu produced by 'wp_nav_menu' function.
 * @since 1.0
 *
 */
function nisargpro_add_search_box_to_navbar( $items, $args ) {

	$show_serchbox = get_theme_mod( 'nisargpro_searchbox_display_setting', true );
	$show_social_menu = get_theme_mod( 'nisargpro_social_media_menu_enable', false);

	if ( 'primary' === $args->theme_location && true == $show_social_menu ) {
		$items .= '<li class="menu-item page-item menu-item-social-media">';
		$items .= '<span id="socialMenuResponsive">';
		for($i=1; $i<=6; $i++ ){
			$social_media_icon[$i] = get_theme_mod( 'nisargpro_social_media_icon_'.$i, 'facebook-f' );
			$social_media_url[$i] = get_theme_mod( 'nisargpro_social_media_url_'.$i, '' );

			if ( '' !== $social_media_url[$i]  ) :
				$items .= '<a href="'.esc_url( $social_media_url[$i] ).'" class="primary-social-icon" target="_blank">
				<i class="fa fa-'.esc_attr( $social_media_icon[$i] ).'"></i></a>';
			endif;
		} //for loop end
		$items .= '</span>';
		$items .= '</li>';
	}
	if ( 'primary' === $args->theme_location && true == $show_serchbox ) {
		$items .= '<li  class="menu-item menu-item-search" id="nav-search" style="margin-left:25px; font-size:21px;">
			<span id="desktop-search-icon"><span class="screen-reader-text">Search Icon</span><i class="fas fa-search"></i></span>
        <div id="navbar-search-box">
            <form name="main_search" method="get" action="'.esc_url(home_url( '/' )).'">
                <input type="text" name="s" class="form-control" placeholder="'. esc_attr(__('Search For','nisargpro')).'" />
            </form>
        </div></li>';
	}

	return $items;
}
add_filter( 'wp_nav_menu_items','nisargpro_add_search_box_to_navbar', 10, 2 );

/**
 * Load google fornts selected by user.
 * @since 1.0
 *
 */
function nisargpro_google_fonts() {

	$font_host = get_theme_mod( 'nisargpro_google_font_load_setting', 'cdn' );
	$defaults = nisargpro_get_defaults();
	$google_fontArr = nisargpro_get_google_fonts();

	$fonts_url = '';

	// Load google fonts based on Customizer settings
	$body_font_family = get_theme_mod( 'nisargpro_body_font_setting', $defaults['body_font_family'] );
	if ( 'Others' === $body_font_family ) {
		$body_font_family = get_theme_mod( 'nisargpro_body_other_font_value', $defaults['body_font_family'] );
	}
	$heading_font_family = get_theme_mod( 'nisargpro_heading_font_setting', $defaults['heading_font_family'] );
	if ( 'Others' === $heading_font_family ) {
		$heading_font_family = get_theme_mod( 'nisargpro_heading_other_font_value', $defaults['heading_font_family'] );
	}
	if( array_key_exists( $heading_font_family, $google_fontArr) || array_key_exists( $body_font_family, $google_fontArr) ) {
		//get body font weight
		$body_font_weight = get_theme_mod( 'nisargpro_body_font_weight_setting', $defaults['body_font_weight'] );
		$body_font_weight = str_replace( 'italic', 'i', $body_font_weight );

		//get heading font weight
		$heading_font_weight = get_theme_mod( 'nisargpro_heading_font_weight_setting', $defaults['heading_font_weight'] );
		$heading_font_weight = str_replace( 'italic', 'i', $heading_font_weight );

		//get menu font weight
		$menu_item_font_family = get_theme_mod( 'nisargpro_menuitem_font_family_setting', $defaults['menu_item_font_family'] );
		$menu_item_font_weight = get_theme_mod( 'nisargpro_menuitem_font_weight_setting', $defaults['menu_item_font_weight'] );
		$menu_item_font_weight = str_replace( 'italic', 'i', $menu_item_font_weight );
		//$menu_item_font_weight .= ',700';

		$fonts_url = '';

		if ( '' !== $body_font_family ) {
			$body_font_family = esc_html( $body_font_family );
		}
		if ( '' !== $heading_font_family ) {
			$heading_font_family = esc_html( $heading_font_family );
		}

		/** Translators: If there are characters in your language that are not
		 * supported by Lora, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$body_font_on = _x( 'on', 'Google font for body text: on or off', 'nisargpro' );

		/* Translators: If there are characters in your language that are not
		* supported by heading font, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$heading_font_on = _x( 'on', 'Google font for heading: on or off', 'nisargpro' );

		// Construct url query based on chosen fonts
		if ( 'off' !== $body_font_on || 'off' !== $heading_font_on ) {
			$font_families = array();
			if ( 'off' !== $body_font_on && array_key_exists( $body_font_family, $google_fontArr) ) {
				if( 'body' === $menu_item_font_family ) {
					if( $body_font_weight != $menu_item_font_weight ) {
						$body_font_weight .= ','.$menu_item_font_weight.',700';
					} else {
						$body_font_weight .= ',700';
					}
				}
				$font_families[] = $body_font_family.':'.$body_font_weight;
			}
			if ( 'off' !== $heading_font_on && array_key_exists( $heading_font_family, $google_fontArr) ) {
				if( 'heading' === $menu_item_font_family ) {
					if ( $heading_font_weight != $menu_item_font_weight ) {
						$heading_font_weight .= ','.$menu_item_font_weight.',700';
					} else {
						$heading_font_weight .= ',700';
					}
				}
				$font_families[] = $heading_font_family.':'.$heading_font_weight;
			}


			//$font_families = array_unique( $font_families );
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'display' => 'swap',
			);
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			$fonts_url = esc_url( $fonts_url );
		}

		if( 'cdn' === $font_host ) {
			wp_register_style( 'nisargpro-google-fonts', $fonts_url, array(), null );
			wp_enqueue_style( 'nisargpro-google-fonts' );
		} elseif('local-host' === $font_host ) {

			// Include the file.
			require_once get_template_directory().'/inc/self-host-fonts/class-nisargpro-wptt-webfont-loader.php';

			$local_google_fonts_url = wptt_get_webfont_url( $fonts_url, 'woff' );
			$local_google_fonts_url = esc_url( $local_google_fonts_url );

			// Load the webfont.
			wp_enqueue_style(
				'nisargpro-google-fonts',
				$local_google_fonts_url,
				array(),
				NISARGPRO_VERSION
			);
		}
	}
}

add_action( 'wp_enqueue_scripts', 'nisargpro_google_fonts' );

/**
 * Display gallery images as image grid for the gallery post.
 */
function nisargpro_show_gallery_image( $content ) {
 	global $post;

 	// Retrieve the first gallery in the post
 	$gallery = get_post_gallery_images( $post );
	$image_list = '<div class="grow">';

	// Loop through each image in each gallery
	foreach( $gallery as $image_url ) {

		$image_list .= '<div class="gcolumn">' . '<img src="' . esc_url( $image_url ). '">' . '</div>';

	}

	$image_list .= '</div>';
 	echo $image_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
/**
 * Load theme updater functions.
 * Action is used so that child themes can easily disable.
 */

function nisargpro_theme_updater() {
    require( get_template_directory() . '/updater/theme-updater.php' );
}
add_action( 'after_setup_theme', 'nisargpro_theme_updater' );

/**
 * Return the list of Google Fonts from our json file. Unless otherwise specfied, list will return all fonts.
 * @since 1.9
 */
function nisargpro_get_google_fonts( $count = 'all' ) {

	$google_fontArr = include get_template_directory().'/inc/custom-controls/typography/google-fonts.php';

	if( $count == 'all' ) {
		return $google_fontArr;
	} else {
		return array_slice( $google_fontArr, 0, $count );
	}

}

/**
 * Google Font sanitization
 *
 * @param  string	JSON string to be sanitized
 * @return string	Sanitized input
 */
if ( ! function_exists( 'nisargpro_google_font_sanitization' ) ) {
	function nisargpro_google_font_sanitization( $input ) {
		$val =  json_decode( $input, true );
		if( is_array( $val ) ) {
			foreach ( $val as $key => $value ) {
				$val[$key] = sanitize_text_field( $value );
			}
			$input = json_encode( $val );
		}
		else {
			$input = json_encode( sanitize_text_field( $val ) );
		}
		return $input;
	}
}

/**
 * Find the index of the saved font in our multidimensional array of Google Fonts
 */
function nisargpro_getFontIndex( $haystack, $needle ) {
	foreach( $haystack as $key => $value ) {
		if( $key == $needle ) {
			return $key;
		}
	}
	return false;
}

function nisargpro_get_system_fonts() {
	$system_fonts = array(
					'Helvetica' => array(
						'family'   => 'Helvetica',
						'fallback' => 'Verdana, Arial, sans-serif',
						'variants'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Verdana'   => array(
						'family'   => 'Verdana',
						'fallback' => 'Helvetica, Arial, sans-serif',
						'variants'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Arial'     => array(
						'family'   => 'Arial',
						'fallback' => 'Helvetica, Verdana, sans-serif',
						'variants'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Times'     => array(
						'family'   => 'Times',
						'fallback' => 'Georgia, serif',
						'variants'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Georgia'   => array(
						'family'   => 'Georgia',
						'fallback' => 'Times, serif',
						'variants'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Courier'   => array(
						'family'   => 'Courier',
						'fallback' => 'monospace',
						'variants'  => array(
							'300',
							'400',
							'700',
						),
					),
				);
	return $system_fonts;
}

/**
 * Migrate typography options from old version to new version.
 * @since 1.9
 *
 */
function nisargpro_typography_migration() {

	//obtain defaul values for different customizer settings
	$defaults = nisargpro_get_defaults();

	//get body font family
	$body_font_family = '';

	$body_font_family = get_theme_mod( 'nisargpro_body_font_setting', $defaults['body_font_family'] );
	$body_other_font = get_theme_mod( 'nisargpro_body_other_font_value', $defaults['body_font_family'] );

	$google_fontArr = nisargpro_get_google_fonts();


	if( $body_font_family === 'Others' ) {
		$body_font_family = $body_other_font;
		set_theme_mod( 'nisargpro_body_font_setting', $body_font_family );
	}
	$body_font_index = nisargpro_getFontIndex( $google_fontArr, $body_font_family );

	if( false === $body_font_index ) {
		$system_fontArr = nisargpro_get_system_fonts();
		$body_font_index = nisargpro_getFontIndex( $system_fontArr, $body_font_family );
		if( false === $body_font_index ) {
			$body_font_family = 'Source Sans Pro';
		}
		set_theme_mod( 'nisargpro_body_font_setting', $body_font_family );
	}

	//get heading font family
	$heading_font_family = '';

	$heading_font_family = get_theme_mod( 'nisargpro_heading_font_setting', $defaults['heading_font_family'] );
	$heading_other_font = get_theme_mod( 'nisargpro_heading_other_font_value', $defaults['heading_font_family'] );

	if( $heading_font_family === 'Others' ) {
		$heading_font_family = $heading_other_font;
		set_theme_mod( 'nisargpro_heading_font_setting', $heading_font_family );
	}

	$heading_font_index = nisargpro_getFontIndex( $google_fontArr, $heading_font_family );
	if( false === $heading_font_index ) {
		$system_fontArr = nisargpro_get_system_fonts();
		$heading_font_index = nisargpro_getFontIndex( $system_fontArr, $heading_font_family );
		if( false === $heading_font_index ) {
			$heading_font_family = 'Lato';
		}
		set_theme_mod( 'nisargpro_heading_font_setting', $heading_font_family );
	}

	//get font weights
	$body_font_weight = get_theme_mod( 'nisargpro_body_font_weight_setting', $defaults['body_font_weight'] );
	$heading_font_weight = get_theme_mod( 'nisargpro_heading_font_weight_setting', $defaults['heading_font_weight'] );
	$menu_font_weight = get_theme_mod( 'nisargpro_menuitem_font_weight_setting', $defaults['menu_item_font_weight'] );

	if( $body_font_weight === 'normal' ) {
		set_theme_mod( 'nisargpro_body_font_weight_setting', '400' );
	} else if( $body_font_weight === 'bold' ) {
		set_theme_mod( 'nisargpro_body_font_weight_setting', '700' );
	}
	if( $heading_font_weight === 'normal' ) {
		set_theme_mod( 'nisargpro_heading_font_weight_setting', '400' );
	} else if( $heading_font_weight === 'bold' ) {
		set_theme_mod( 'nisargpro_heading_font_weight_setting', '700' );
	}
	if( $menu_font_weight === 'normal' ) {
		set_theme_mod( 'nisargpro_menuitem_font_weight_setting', '400' );
	} else if( $heading_font_weight === 'bold' ) {
		set_theme_mod( 'nisargpro_menuitem_font_weight_setting', '700' );
	}
}
add_action( 'init', 'nisargpro_typography_migration' );

/**
 * Return font weight and corresponding name of the font weight.
 * @since 1.9
 *
 */
function nisargpro_get_all_font_weight_map() {
	return array(
		'100'       => __( 'Thin 100', 'nisargpro' ),
		'100italic' => __( 'Thin 100 Italic', 'nisargpro' ),
		'200'       => __( 'Extra-Light 200', 'nisargpro' ),
		'200italic' => __( 'Extra-Light 200 Italic', 'nisargpro' ),
		'300'       => __( 'Light 300', 'nisargpro' ),
		'300italic' => __( 'Light 300 Italic', 'nisargpro' ),
		'400'   	=> __( 'Normal 400', 'nisargpro' ),
		'400italic' => __( 'Normal 400 Italic', 'nisargpro' ),
		'500'       => __( 'Medium 500', 'nisargpro' ),
		'500italic' => __( 'Medium 500 Italic', 'nisargpro' ),
		'600'       => __( 'Semi-Bold 600', 'nisargpro' ),
		'600italic' => __( 'Semi-Bold 600 Italic', 'nisargpro' ),
		'700'       => __( 'Bold 700', 'nisargpro' ),
		'700italic' => __( 'Bold 700 Italic', 'nisargpro' ),
		'800'       => __( 'Extra-Bold 800', 'nisargpro' ),
		'800italic' => __( 'Extra-Bold 800 Italic', 'nisargpro' ),
		'900'       => __( 'Ultra-Bold 900', 'nisargpro' ),
		'900italic' => __( 'Ultra-Bold 900 Italic', 'nisargpro' ),
	);
}

// Remove the Author column
function remove_author_column($columns) {
    unset($columns['author']);
    return $columns;
}
add_filter('manage_posts_columns', 'remove_author_column');

// Add custom column to display word count
function custom_word_count_column($columns) {
    $columns['word_count'] = 'Word Count';
    return $columns;
}
add_filter('manage_posts_columns', 'custom_word_count_column');

// Populate custom column with word count
function custom_word_count_column_content($column_name, $post_id) {
    if ($column_name == 'word_count') {
        $post_content = get_post_field('post_content', $post_id);

        $word_count = str_word_count(strip_tags($post_content));
        echo $word_count;
    }
}

add_action('manage_posts_custom_column', 'custom_word_count_column_content', 10, 2);

// Make custom column sortable
function custom_word_count_column_sortable($columns) {
    $columns['word_count'] = 'word_count'; // Add column to sortable columns array
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'custom_word_count_column_sortable');

// Handle custom column sorting
function custom_word_count_column_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ('word_count' === $orderby) {
        // Sorting will be done after retrieving posts, so no need to modify the query
    }
}
add_action('pre_get_posts', 'custom_word_count_column_orderby');

// Custom sorting function
function custom_word_count_column_sort($posts, $query) {
    // Check if we're sorting by our custom column
    if ('word_count' === $query->get('orderby')) {
        // Determine sorting order
        $order = strtoupper($query->get('order')) === 'DESC' ? -1 : 1;

        // Sort posts by word count
        usort($posts, function($a, $b) use ($order) {
            $word_count_a = get_word_count_for_post($a->ID);
            $word_count_b = get_word_count_for_post($b->ID);
            return ($word_count_a - $word_count_b) * $order;
        });
    }

    return $posts;
}
add_filter('posts_results', 'custom_word_count_column_sort', 10, 2);

// Function to get word count for a post
function get_word_count_for_post($post_id) {
    $post_content = get_post_field('post_content', $post_id);
    return str_word_count(strip_tags($post_content));
}

function add_infobubble_to_content( $content ) {
    // Determine if we're dealing with a preview or the full article
    $isPreview = is_home() || is_archive() || is_search(); // Adjust conditions as needed

    if ($isPreview) {
        // Return the original content for previews without adding infobulles
        return $content;
    }

    // Get the post ID
    $post_id = get_the_ID();
    global $wpdb;

    // Fetch infobulles data for the current post
    $infobulles = $wpdb->get_results("SELECT * FROM geE_plugin_infobulles WHERE article = $post_id");

    // Loop through each infobulle and modify the content
    foreach($infobulles as $infobulle) {
        $pattern = '/\b' . preg_quote($infobulle->mot, '/') . '\b/i';

        $insertBeforeText = '<span class="infobulle-mot">';
        $insertAfterText = '<span class="infobulle-contenu">' . $infobulle->contenu . '</span></span>';
        $occurrence = (int) $infobulle->numero_iteration;

        $count = 0;
        $content = preg_replace_callback($pattern, function($matches) use ($insertBeforeText, $insertAfterText, $occurrence, &$count) {
            $count++;
            if ($count === $occurrence) {
                $match = $matches[0];
                return $insertBeforeText . $match . $insertAfterText;
            }
            return $matches[0];
        }, $content);
    }

    return $content;
}

add_filter( 'the_content', 'add_infobubble_to_content' );
