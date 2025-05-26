<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package NisargPRO
 */


if ( ! function_exists( 'nisargpro_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function nisargpro_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'nisargpro' ); ?></h2>
		<div class="nav-links">

			<div class="row">			
			
				<?php if ( get_next_posts_link() ) { ?>	
				<div class="col-md-6 prev-post">		
				<?php next_posts_link( '<i class="fa fa-angle-double-left"></i>'.esc_html__( ' OLDER POSTS', 'nisargpro' ) ); ?>
				</div>
				<?php }	else{
					echo '<div class="col-md-6">';
					echo '<p> </p>';
					echo '</div>';
				} ?>

				<?php if ( get_previous_posts_link() ) { ?>
				<div class="col-md-6 next-post">
				<?php previous_posts_link( esc_html__( 'NEWER POSTS ', 'nisargpro' ).'<i class="fa fa-angle-double-right"></i>' ); ?>
				</div>
				<?php } else {
					echo '<div class="col-md-6">';
					echo '<p> </p>';
					echo '</div>';
				} ?>
			</div><!-- row -->	
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'nisargpro_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function nisargpro_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'nisargpro' ); ?></h2>
		<div class="nav-links">
			<div class="row">
			<!-- Get Previous Post -->
			
			<?php
			$prev_post = get_previous_post();
			if ( !empty( $prev_post ) ) {
			?>
				<div class="col-md-6 prev-post">
					<a class="" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
						<span class="next-prev-text">
							<i class="fa fa-angle-left"></i><?php esc_html_e(' PREVIOUS ','nisargpro'); ?>
						</span><br>
						<?php if( get_the_title( $prev_post->ID ) != '' ) { 
							echo wp_kses_post( get_the_title( $prev_post->ID ) ); 
						} else { esc_html_e('Previous Post','nisargpro'); } ?>
					</a>
				</div>
			<?php } 
			 else { 
				echo '<div class="col-md-6">';
				echo '<p> </p>';
				echo '</div>';
			} ?>

			<!-- Get Next Post -->
			
			<?php
			$next_post = get_next_post();
			if ( !empty( $next_post ) ) { 
			?>
				<div class="col-md-6 next-post">
					<a class="" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
						<span class="next-prev-text">
							<?php esc_html_e(' NEXT ','nisargpro'); ?><i class="fa fa-angle-right"></i>
						</span><br>
						<?php if( get_the_title( $next_post->ID ) != '' ) {
							echo wp_kses_post( get_the_title( $next_post->ID ) );
						} else { esc_html_e('Next Post','nisargpro'); } ?>
					</a>
				</div>
			<?php } 
			 else { 
				echo '<div class="col-md-6">';
				echo '<p> </p>';
				echo '</div>';
			} ?>
			
			</div><!-- row -->
		</div><!-- .nav-links -->
	</nav><!-- .navigation-->
	<?php
}
endif;

if ( ! function_exists( 'nisargpro_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function nisargpro_posted_on() {
  //custom_nisargpro_print_reading_tools_left();
	nisargpro_print_post_category();
	nisargpro_print_post_date();
	nisargpro_print_post_author_name();
	nisargpro_print_post_comments_link();
  //custom_nisargpro_print_reading_tools_right();
}
endif;

/**
 * Print post date if show date option is selected in customizer post meta settings.
 */
 
   function custom_nisargpro_print_reading_tools_left(){
 
 	$post_display_option = get_theme_mod( 'post_display_option', 'post-excerpt' );
 if ( ! is_search() and ('post-excerpt' === $post_display_option and is_single() ) ) {
?>
		<span style="font-size: 16px; float:left; visibility: hidden;"  class="reading_tools">

	<i style="color:white;" class="fa fa-arrows-alt-h change-width-left" aria-hidden="true"></i>
	<i style="color:white;" class="fa fa-minus decrease-font-size-left" aria-hidden="true"></i>
	<i style="color:white;" class="fa fa-plus increase-font-size-left" aria-hidden="true"></i>

		 </span>
					<?php  }	
		    
 }
 
 function custom_nisargpro_print_reading_tools_right(){
 
 	$post_display_option = get_theme_mod( 'post_display_option', 'post-excerpt' );
 if ( ! is_search() and ('post-excerpt' === $post_display_option and is_single() ) ) {
?>
		<span style="font-size: 16px; float:right;" class="reading_tools">

			<i id="change-width" class="fa fa-arrows-alt-h change-width" aria-hidden="true"></i>
			<i id="decrease-font-size" class="fa fa-minus decrease-font-size" aria-hidden="true"></i>
			<i id="increase-font-size" class="fa fa-plus increase-font-size" aria-hidden="true"></i>

		 </span>
					<?php  }	
		    
 }
 

 function custom_nisargpro_print_reading_tools_center(){

 	$post_display_option = get_theme_mod( 'post_display_option', 'post-excerpt' );
 if ( ! is_search() and ('post-excerpt' === $post_display_option and is_single() ) ) {
?>
		<div style="margin-bottom:5px; text-align:center;" class="reading_tools">

			<i id="reader-mode" class="fa fa-book-open reader-mode" aria-hidden="true" title="Reader Mode"></i>
			<i id="change-width" class="fa fa-arrows-alt-h change-width" aria-hidden="true" title="Change Column Size"></i>
			<i id="decrease-font-size" class="fa fa-minus decrease-font-size" aria-hidden="true" title="Decrease Font"></i>
			<i id="increase-font-size" class="fa fa-plus increase-font-size" aria-hidden="true" title="Increase Font"></i>

		</div>
					<?php  }

 }
 

 function nisargpro_print_post_category() {

	$category = get_the_category_list( esc_html__( ', ', 'nisargpro' ) );
 	if( $category ) {
 		$entry_category = '<div class="post-category"><i class="fa fa-folder-open"></i> <a href="%s">%s</a></div>';
 		$entry_category = sprintf($entry_category,
 		esc_url( get_permalink() ),
				$category
         );
         print $entry_category; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
 	}
 }

function nisargpro_print_post_date() {
	$show_date = get_theme_mod( 'nisargpro_display_date_setting', true );
	if( $show_date ) {
		$entry_date = '<div class="post-date"><i class="fa fa-calendar-o"></i> <a href="%s" title="%s" rel="bookmark"><time class="entry-date" datetime="%s" pubdate>%s </time></a></div>';
		$entry_date = sprintf($entry_date,
		esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ) );
        print $entry_date; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}


/**
 * Print post author name if show author name option is selected in customizer post meta settings.
 */
function nisargpro_print_post_author_name() {
	$show_author_name = get_theme_mod( 'nisargpro_display_author_setting', true );
	$viewbyauthor_text = __( 'View all posts by', 'nisargpro' ).' %s';
	$author_by_line = '';
	if( $show_author_name ) {
		$author_by_line = '<span class="byline"><span class="sep"></span><i class="fa fa-user"></i> <span class="author vcard"><a class="url fn n" href="%s" title="%s" rel="author">%s</a></span></span>';
		$author_by_line = sprintf($author_by_line,
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( $viewbyauthor_text, get_the_author() ) ),
        esc_html( get_the_author() ));
		print $author_by_line; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
} 

/**
 * Print post comments link if show comments link option is selected in customizer post meta settings.
 */
function nisargpro_print_post_comments_link() {

	$show_comment_link = get_theme_mod( 'nisargpro_display_comments_link_setting', true );

	if ( comments_open() && $show_comment_link ){	
		printf(' <div class="post-comment"><i class="fa fa-comments-o"></i> <span class="screen-reader-text">%1$s </span> ',esc_html_x( 'Comments', 'Used before post author name.', 'nisargpro' ));
		comments_popup_link( __('0 Comment','nisargpro'), __('1 comment','nisargpro'), __('% comments','nisargpro'), 'comments-link', '');
		printf( '%s', '</div>' );
	}	
}

if( ! function_exists('nisargpro_is_hide_entry_meta') ) :
	/**
	 * Check if all entry meta are disabled. If yes returns true.
	 * @since 1.8
	 */
	function nisargpro_is_hide_entry_meta() {
		$show_date = get_theme_mod( 'nisargpro_display_date_setting', true );
		$show_author_name = get_theme_mod( 'nisargpro_display_author_setting', true );
		$show_comment_link = get_theme_mod( 'nisargpro_display_comments_link_setting', true );
		if( $show_date || $show_author_name ||  $show_comment_link ) {
			return false;
		} else {
			return true;
		}
	}
endif;

if ( ! function_exists( 'nisargpro_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
 
  function show_last_updated( $content ) {
   $u_time = get_the_time('U');
   $u_modified_time = get_the_modified_time('U');
   if ($u_modified_time >= $u_time + 86400) {
     $updated_date = get_the_modified_time('d F Y');

    // $updated_time = get_the_modified_time('h:i a');
		$updated_time = get_the_modified_time('h').':00 '.get_the_modified_time('a');
     $custom_content .= $updated_date . ', '. $updated_time;
   }
   $custom_content .= $content;
   return $custom_content;
 }
 
function nisargpro_entry_footer() {

	$show_cat_tag_on_index_page = get_theme_mod( 'nisargpro_show_post_footer_on_posts_index_page', false );
	
	if( $show_cat_tag_on_index_page || is_single() ) {
			
		if ( 'post' == get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'nisargpro' ) );
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'nisargpro' ) );

                
				echo '<hr>';
				echo '<div class="row">';

        if(show_last_updated( $content )){
			echo '<div class="col-md-6 last-update">Last update : '.show_last_updated( $content ).'</div>';
        }
/*
			if ( $categories_list ) {
				// translators: 1: list of categories.
				printf( '<div class="col-md-6 categories"><span class="cat-links"><i class="fa fa-folder-open"></i>
	 ' . esc_html( '%1$s') . '</span></div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			if ( $tags_list ) {
				// translators: 1: list of tags.
				printf( '<div class="col-md-6 tags"><span class="tags-links"><i class="fa fa-tags"></i>' . esc_html( ' %1$s' ) . '</span></div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

		*/
				echo '</div>';
		}
	}
	
	edit_post_link( esc_html__( 'Edit This Post', 'nisargpro' ), '<br><span>', '</span>' );
	
}
endif;


/**
 *  Display featured image of the post
 */
function nisargpro_featured_image_disaplay() {
	if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) {  // check if the post has a Post Thumbnail assigned to it. 
		if( is_archive() ) {
			$blog_listing_style = get_theme_mod( 'nisargpro_archive_posts_listing_style', 'classic' );
		} else {
			$blog_listing_style = get_theme_mod( 'nisargpro_post_listing_style', 'classic' );
		}
		if( !is_single() && !is_page() && !has_post_format('image') && 'posts-list' === $blog_listing_style ){
			$list_img_class = 'col-md-5';
		} else {
			$list_img_class = '';
		}
	?>
	<div class="featured-image <?php echo esc_attr( $list_img_class ); ?>">
		<?php if ( ! is_single() ) { ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark">
	    <?php }
	    the_post_thumbnail( 'nisargpro-full-width' ); ?>
	    <?php if ( ! is_single() ) { ?>
	    </a> <?php } ?>
	    <?php if( 'image' === get_post_format() && !is_single()  ) { ?>
	    	<header class="entry-header">
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<div class="entry-meta">
					<h5 class="entry-date"><?php nisargpro_posted_on(); ?></h5>
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->
		<?php } ?>
	</div>
	<?php
	}
}

/**
 * Display author social media profile icons.
 * @since 1.0
 */
function nisargpro_author_social_links() {
	$userid = get_the_author_meta( 'ID' );
	$twitter_link = get_the_author_meta( 'twitter', $userid );
	$fb_link = get_the_author_meta( 'facebook', $userid );
	$gplus_link = get_the_author_meta( 'googleplus', $userid );
	$linkedin_link = get_the_author_meta( 'linkedin', $userid );
	$dribble_link = get_the_author_meta( 'dribble', $userid );?>
	<ul class="author-social-links">
	<?php
	if ( isset( $twitter_link ) && '' !== $twitter_link ) { ?>
		<li><a href="<?php echo esc_url( $twitter_link ); ?>" title="twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
	<?php }
	if ( isset( $fb_link ) && '' !== $fb_link ) { ?>
		<li><a href="<?php echo esc_url( $fb_link ); ?>" title="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
	<?php }
	if ( isset( $gplus_link ) && '' !== $gplus_link ) { ?>
		<li><a href="<?php echo esc_url( $gplus_link ); ?>"  title="googleplus" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
	<?php }
	if ( isset( $instagram_link ) && '' !== $instagram_link ) { ?>
		<li><a href="<?php echo esc_url( $instagram_link ); ?>" title="instagram" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
	<?php }
	if ( isset( $linkedin_link ) && '' !== $linkedin_link ) { ?>
		<li><a href="<?php echo esc_url( $linkedin_link ); ?>"  title="linkedin" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
	<?php }
	if ( isset( $dribble_link ) && '' !== $dribble_link ) { ?>
			<li><a href="<?php echo esc_url( $dribble_link ); ?>" title="dribble" target="_blank"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
	<?php } ?>
	</ul>
	<?php
}


/**
 * Display footer section.
 * @since 1.0
 */
function nisargpro_footer_copyright_display() {
	?>
	<?php $footer_copyright_text = get_theme_mod( 'nisargpro_custom_footer_text_setting', __( ' All Rights Reserved.', 'nisargpro' ) ); ?>
	<span class="footer-copyright" data-customizer="copyright-credit">
		<?php echo esc_html( '&copy; '.date( 'Y' ) ); ?>
		<span class="sep"> &nbsp; </span>
		<?php echo nisargpro_sanitize_html( $footer_copyright_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</span>
<?php
}

/**
 * Find Primary Content Area width.
 * @return string $class CSS class for primary content area.
 */
function nisargpro_find_primary_content_width() {
	$sidebar_width = get_theme_mod( 'nisargpro_sidebar_width_setting', 'default' );
	if( is_single() ) {
		$sidebar_pos = get_theme_mod( 'nisargpro_sidebar_position_single_post_setting', 'right-sidebar' );
	} else {
		$sidebar_pos = get_theme_mod( 'nisargpro_sidebar_position_setting', 'right-sidebar' );
	}
	$class = 'col-md-9';
	//Set 'css' class for primary content area
	if ( isset( $sidebar_width ) and 'wide' === $sidebar_width ) {
		$class = 'col-md-8';
		$push_class = ' col-md-push-4';
	} else {
		$class = 'col-md-9';
		$push_class = ' col-md-push-3';
	}

	if ( ( isset( $sidebar_pos ) && 'left-sidebar' === $sidebar_pos ) or is_page_template( 'template-left-sidebar.php' ) ) {
		$class = $class.' '.$push_class.' left-sidebar';
	} elseif ( ( isset( $sidebar_pos ) && 'right-sidebar' === $sidebar_pos ) or is_page_template( 'template-right-sidebar.php' ) ) {
		$class = $class.' right-sidebar';
	} elseif ( isset( $sidebar_pos ) && 'no-sidebar' === $sidebar_pos ) {
		$class = 'col-sm-12 no-sidebar';
	} else {
		$class = $class.' right-sidebar';
	}
	return $class;
}

/**
 * Find Secondary Content Area width.
 * @return string $class CSS class for seconday content area
 */
function nisargpro_find_sidebar_width() {
	$sidebar_width = get_theme_mod( 'nisargpro_sidebar_width_setting', 'default' );
	if( is_single() ) {
		$sidebar_pos = get_theme_mod( 'nisargpro_sidebar_position_single_post_setting', 'right-sidebar' );
	} else {
		$sidebar_pos = get_theme_mod( 'nisargpro_sidebar_position_setting', 'right-sidebar' );
	}
	$sidebar_class = 'col-md-3';
	//Set 'css' class for secondary content area
	if ( 'wide' === $sidebar_width ) {
		$sidebar_class = 'col-md-4';
	} else {
		$sidebar_class = 'col-md-3';
	}
	if (  ( isset( $sidebar_pos ) and 'left-sidebar' === $sidebar_pos ) or is_page_template( 'template-left-sidebar.php' ) ) {
		if ( 'col-md-4' === $sidebar_class ) {
			$pull_col_class = 'col-md-pull-8';
		} else {
			$pull_col_class = 'col-md-pull-9';
		}
		$sidebar_class = $sidebar_class.' '.$pull_col_class;
	} elseif ( 'no-sidebar' === $sidebar_pos and ! is_page_template( 'template-right-sidebar.php' ) ) {
		$sidebar_class = '';
	}
	return $sidebar_class;
}

/**
 *  Display author bio data.
 *
 * @since nisargpro 1.0
 *
 */
function nisargpro_display_author_bio() { ?>
	<div class="author-bio clearfix">
		<h2 class="author-box-title">Author</h2>
		<div class="row">
			<div class="author-avatar col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
				<?php echo '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'nisargpro_author_bio_avatar_size', 100 ) ) . '</a>'; ?>
			</div><!-- .author-avatar -->
			<div class="author-info-box col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
				<h3 class="author-name"><a class="author-url url fn n" href="<?php echo esc_url( get_the_author_meta( 'user_url' ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>" rel="me"  target="_blank"><?php printf( esc_html( '%s' ), get_the_author() ); ?></a></h3>
				<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
				<!-- .author-description	-->
				<?php nisargpro_author_social_links(); ?>
			</div><!-- author-info-box -->
		</div><!--row-->
	</div><!--author-bio-->
	<?php
}

/**
 * Get embeded media(audio & video) from the post content.
 *@param  array $type type of the media format format that need to be retrieved.
 */
function nisargpro_get_embedded_media( $type = array() ) {
	$content = apply_filters( 'the_content', get_the_content() );
	$embed = false;

	// Only get video from the content if a playlist isn't present.
	if ( false === strpos( $content, 'wp-playlist-script' ) ) {
		$embed = get_media_embedded_in_content( $content, $type );
	}

	$output = false;

	if ( ! empty( $embed ) ) {
		if ( in_array( 'audio' , $type) ) {
			$output = str_replace( '?visual=true', '?visual=false', $embed[0] );
		} else {
			$output = $embed[0];
		}
	}
	return $output;
}

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Convert HEX to RGB.
 *
 * @since 1.7
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function nisargpro_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) == 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) == 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		$r = hexdec( '12' );
		$g = hexdec( '34' );
		$b = hexdec( '56' );
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}

/**
 * Convert RGB to HSL.
 *
 * @since 1.11
 *
 * @param string $color The original color, .
 * @return 
 */
function nisargpro_rgb2hsl( $color ) {

	// Make r, g, and b fractions of 1
  $r = $color['red']/255;
  $g = $color['green']/255;
  $b = $color['blue']/255;
  
  // Find greatest and smallest channel values
  $cmin = min($color)/255;
  $cmax = max($color)/255;
  $delta = $cmax - $cmin;
  $h = $s = $l = 0;

  // Calculate hue
  // No difference
  if ($delta == 0) {
    $h = 0;
  // Red is max
  } elseif ($cmax == $r) {
    $h = (($g - $b) / $delta) % 6;
    $h = ($g - $b) / $delta + ($g < $b ? 6 : 0);
  // Green is max
  } elseif ($cmax == $g) {
    $h = ($b - $r) / $delta + 2;
  // Blue is max
  } else {
    $h = ($r - $g) / $delta + 4;
  }

  $h = round($h * 60);
    
  // Make negative hues positive behind 360°
  if ($h < 0) {
      $h += 360;
  }

  // Calculate lightness
  $l = ($cmax + $cmin) / 2;

  // Calculate saturation
  $s = $delta == 0 ? 0 : $delta / (1 - abs(2 * $l - 1));
    
  // Multiply l and s by 100
  $s = intval($s * 100);
  $l = intval($l * 100);
  $hsl_arr = array(
  	'heu' => $h,
  	'saturation' => $s,
  	'lightness' => $l
  );

  return  $hsl_arr;
}
