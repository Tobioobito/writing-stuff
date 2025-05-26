<?php
/**
 * The header of NisargPRO theme.
 *
 * Displays all of the head section.
 *
 * @package NisargPRO
 */
?>
<!DOCTYPE html>

<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>

<?php
	$defaults = nisargpro_get_defaults();
		$theme_skin = get_theme_mod( 'nisargpro_skin_select', $defaults['theme_skin'] );
	if(isset($_COOKIE['modenuit']) && $_COOKIE['modenuit'] == true){

			$theme_skin = get_theme_mod( 'nisargpro_skin_select', 'dark' );

	} else {

			$theme_skin = get_theme_mod( 'nisargpro_skin_select', 'light' );

	}
?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<?php
	$skin_words = explode('-', $theme_skin );
?>
<body <?php body_class( $skin_words ); ?>>
<?php wp_body_open(); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'nisargpro' ); ?></a>
<?php
	$hide_header_image = get_theme_mod( 'nisargpro_hide_header_on_single_post', false );
	if( true === $hide_header_image && is_single() ) {
		$add_class = 'class='.'add-margin-bottom';
	} else {
		$add_class = '';
	}
?>
<header id="masthead"  <?php echo esc_attr( $add_class ); ?> role="banner">
	<nav id="site-navigation" class="main-navigation navbar-fixed-top navbar-left" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="container" id="navigation_menu">
			<div class="navbar-header">
				<?php if ( has_nav_menu( 'primary' ) ) { ?>
					<button type="button" class="menu-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				<?php } ?>
				<?php
				//Print custom logo
				if ( function_exists( 'the_custom_logo' ) ) {
				    the_custom_logo();
				}
				/*If no logo is added, then print
				blogname/site title*/
				if ( ! has_custom_logo() ) { ?>
					<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' )?></a>
				<?php } ?>
			</div><!-- .navbar-header -->

			<?php if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location'    => 'primary',
					'container'         => 'div',
					'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
					'menu_class'        => 'primary-menu',
				) ); } ?>
		</div><!--#container-->
	</nav>


	<div id="cc_spacer"></div><!-- used to clear fixed navigation by the theme's nisargpro.js -->
	<?php
	if(  (( false === $hide_header_image )  || ( true === $hide_header_image && is_page() ) || is_home() || is_archive() ||is_author() || is_front_page() || is_search() ) && ( false === is_page_template( 'template-pagebuilder-without-siteheader.php' ) ) ) {
		// site brand part
		get_template_part( 'template-parts/partials/site', 'brand' );
	}
	?>
</header>
<div id="content" class="site-content">
