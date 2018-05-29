<?php
/**
 * Enqueue the required styles from the parent theme,
 * then enqueue our child's custom style sheet
 */
function engage_child_styles() {
   // Enqueue parent themes required style sheets
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css', false, '5.7.1' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/scripts/animate.min.css' );	
	
   // Enqueue this themes style sheet
	wp_enqueue_style( 'engage-child-styles', get_stylesheet_directory_uri() . '/style.css', array( 'engage-styles' ), '1.0.1' );
   
   // Scripts
   wp_enqueue_script('orc-disable-parallax', get_stylesheet_directory_uri() . '/js/disableparallax.js', array('jquery'), '1.0.0.0', true);
   wp_enqueue_script('orc-general', get_stylesheet_directory_uri() . '/js/general.js', array('jquery'), '1.0.0.0', true);

}
add_action( 'wp_enqueue_scripts', 'engage_child_styles' );

/**
 * Override the engage Logo URL since it doesn't work with Wordpress being in
 * it's own subdirectory.  Changed the site_url() call to home_url().
 * 
 * Since this function will be installed first and the parent theme uses 
 * pluggable functions this function will be installed first.
 * 
 * This function is defined in framework/header/header-functions.php in the parent theme
 * 
 * @return string Home URL
 */
function engage_logo_url() {
   $url = '';
   if ( !is_front_page() ) {
      $url = home_url();
   }
   return $url;
}

/**
 * Engage theme custom post types since we are replacing
 * them with our own types or not using them
 */
function orc_remove_cpt() {
	unregister_post_type('testimonials');					// Engage testimonials
   unregister_post_type('portfolio');						// Engage portfolios
   unregister_post_type('veented_slider');				// Engage portfolios
}
add_action('init', 'orc_remove_cpt');

// Replaces the excerpt "Read More" text by a link
function orc_excerpt_more($more) {
	global $post;
	return '<a class="moretag" href="'. get_permalink($post->ID) . '"><br />[Read more ...]</a>';
}
add_filter('excerpt_more', 'orc_excerpt_more');

/**
 * Override engage_blog_post for our purposes ... we don't want the post meta
 * used in our blogs
 */
if( !function_exists( 'engage_blog_post' ) ) {
	function engage_blog_post( $page_layout = 'no_sidebar', $blog_style = 'classic' ) {
		
		$post_id = get_the_ID();		
		$post_format = get_post_format( $post_id );
		$extra_classes = array(); // Additional classes for the post
		
		// Define is post has any media
		$post_has_media = false;
		$extra_classes[] = 'post-holder';
		
		if( has_post_thumbnail() || get_post_gallery() || $post_format == 'quote' || $post_format == 'link' || $post_format == 'audio' || $post_format == 'video' ) {
			$post_has_media = true;
		} else {
			$extra_classes[] = 'post-no-media';
		}
		
		// Masonry blog style
		if( $blog_style == 'masonry' ) {
			$extra_classes[] = 'item';
			$extra_classes[] = 'grid-item cbp-item';
		}
		
		$post_meta = false;			/***** Changed to false for ORC *****/
		
		?>
		
		<div <?php post_class( $extra_classes ); ?>>
		
			<?php
			
			if ( $post_has_media ) {
			
				// Image Size
				$img_size = 'engage-masonry-regular';
				
				if ( $blog_style == 'grid' ) {
					
				} elseif ( $blog_style == 'classic' ) {
					if ( $page_layout == 'no_sidebar' ) {
						$img_size = 'engage-fullwidth-crop';
					} else {
						$img_size = 'engage-sidebar-wide';
					}
				} elseif ( $blog_style == 'left_image' ) {
					$img_size = 'engage-masonry-regular';
				} elseif ( $blog_style == 'masonry' ) {
					$img_size = 'engage-masonry-auto';
				}
				
				if( is_single() ) $img_size = 'engage-sidebar-auto';
				if ( has_filter( 'engage_blog_index_img_size' ) ) {
					 $img_size = apply_filters( 'engage_blog_index_img_size', $img_size );
				}
				engage_post_media( $post_id, $post_format, $img_size ); // Print post media
			}
			
			?>
		
			<div class="post-info">
            <?php do_action( 'engage_blog_index_before_post_title' ); ?>
				<h4 class="post-title"><a href="<?php echo get_permalink( $post_id ); ?>"><?php echo get_the_title( $post_id ); ?></a></h4>
				
				<?php 				
					// Post meta:
					if ( $post_meta == true && get_post_type( $post_id ) != 'page' ) engage_post_meta(); 		
				?>
				
				<div class="post-content <?php echo ( is_single() ? 'single-post-content' : 'post-excerpt' ); ?>">
					
					<?php
					
					if ( is_single( $post_id ) ) { // Single Post
						the_content();
					} else { // Blog Index page: display excerpt
						$excerpt_size = 40;						
						if( $blog_style == 'masonry' ) {
							$excerpt_size = 25;
						}
						echo engage_excerpt( $excerpt_size, true );	
					}
					
					?>
					
				</div>
			</div>
		</div>
		
		<?php
	
	}
}

