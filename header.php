<?php
	$content_links_color_array = engage_option('content_link_color');
	$content_links_color = esc_attr($content_links_color_array['regular']);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">    

    <?php
	
	wp_head(); 
		
	?>        

</head>

<body <?php body_class(); ?>>
	
	<?php 
	if ( engage_option( 'page_loader' ) == true || !class_exists( 'Engage_Core' ) ) {
		engage_page_loader();
	}
	?>
	
	<div id="wrapper" class="<?php engage_wrapper_classes(); ?>">
	
	<?php

    do_action( 'engage_before_header' );
	
	$header_position = engage_header_position();
	
	if ( $header_position == 'aside' ) { 
		
		$aside_nav_classes = array();
		
		if ( engage_option( 'sideh_skin' ) == 'dark' ) {
			$aside_nav_classes[] = 'header-dark';
		} else {
			$aside_nav_classes[] = 'header-light';
		}
		
		if ( engage_option( 'sideh_align' ) != '' ) {
			$aside_nav_classes[] = 'text-align-' . engage_option( 'sideh_align' );
		}
	
	?>
	
	<!-- BEGIN LATERAL NAVIGATION -->
	
	<aside id="aside-nav" class="aside-nav <?php echo esc_attr( implode( ' ', $aside_nav_classes ) ); ?>">
	
		<div id="main-aside-navigation">
		
			<div class="main-nav-wrapper">
			
				<div class="aside-nav-top">
			
					<div class="container">
					
						<div id="aside-logo" class="aside-logo">
						
						 	<?php engage_site_logo( 'lateral' ); ?>
						  
						</div>
						
						<div id="mobile-menu-toggle" class="toggle-menu toggle-menu-mobile" data-toggle="mobile-menu" data-effect="hover"><div class="btn-inner"><span></span></div></div>
						
					</div>
				
				</div>
				
				<div class="aside-nav-main">
				
					<div class="container">
					
						<nav id="main-aside-menu">
						
							<?php engage_nav_menu(); ?>
						  
						</nav>
						
						<?php
						
						// Social Icons
						
						if ( engage_option( 'sideh_icons' ) != false ) {
							
							echo '<div class="aside-social-icons">';
							
							$icon_duplicate = false;
							$icon_size = 'medium';
							$icon_border = 'circle';
							
							engage_social_profiles( $icon_duplicate, $icon_size, $icon_border );
							
							echo '</div>';
							
						}
						
						?>
					
					</div>
					
				</div>
			
			</div>
		  
		</div>
		  
	</aside>
	<?php  ?>
	<!-- END LATERAL NAVIGATION -->
	
	<?php 
	
	} 
	
	if ( $header_position == 'top' ) {
	
		$header_style = engage_header_style();
        
        // Scroll after style
        
        $data_sticky_amount = '';
        
        if ( engage_option( 'header_sticky' ) == 'sticky-appear' ) {
            $data_sticky_amount = '500';
            if ( engage_option( 'header_sticky_scroll' ) != '' ) {
                $data_sticky_amount = engage_option( 'header_sticky_scroll' );
            }
        }
	?>


	
	<header id="header" class="<?php engage_header_classes(); ?>" data-scroll-height="<?php engage_header_scroll_height(); ?>" data-scroll-animation="<?php engage_header_scroll_animation(); ?>" data-skin="<?php echo esc_attr( engage_header_skin() ); ?>" data-scroll-skin="<?php echo esc_attr( engage_header_scroll_skin() ); ?>"<?php if ( $data_sticky_amount != '' ) echo ' data-scroll-amount="' . esc_attr( $data_sticky_amount ) . '"'; ?>>
	
		<?php
		
		$container_classes = '';
		
		if ( engage_header_container() == 'fullwidth' ) {
			$container_classes .= '-fluid';
		}
		
		// Header BG Color
		
		$header_color = '';
		
		if ( ( $head_color = engage_header_color() ) != '' ) {
			$header_color = $head_color;
		}
		
		// Top Bar
		
		if ( engage_option('topbar') && $header_position != 'aside' && get_post_meta( get_the_ID(), 'page_header_topbar_c', true ) != 'no' || get_post_meta( get_the_ID(), 'page_header_topbar_c', true ) == 'yes' ) {
		
			engage_print_topbar( $container_classes );
		} 
		
		// Header itself
		
		if ( $header_style == 'top-logo' || $header_style == 'top-logo-center' ) {
			?>
			
			<div id="main-navigation" class="main-nav bottom-nav"<?php if ( $header_color != '' ) echo ' style="background-color:' . esc_attr( $header_color ) . ';"'; ?>>
			
				<div class="main-nav-wrapper upper-nav-wrapper">
					<div class="container<?php echo esc_attr( $container_classes ); ?>">
						<div class="nav-left">
							<div id="logo">
							
								<?php engage_site_logo(); ?>
								
                     <ul class="movephonenumber">
                        <li>
                        <?php echo do_shortcode("[orc_contact contacts='tollfree' fonticon=true prefix='Toll Free: ' makelink=true fontcolor='" . $content_links_color . "']"); ?>
                        </li>
                     </ul>
							</div>
						</div>
						
						<div id="mobile-menu-toggle" class="toggle-menu toggle-menu-mobile" data-toggle="mobile-menu" data-effect="hover"><div class="btn-inner"><span></span></div></div>
						
						<?php
						
						if ( $header_style == 'top-logo' ) {
							echo '<div class="nav-right">';
							engage_header_top_content();
							echo '</div>';
						}
						
						?>
					</div>
				</div>
				
				<div class="bottom-nav-wrapper">
					<div class="container<?php echo esc_attr( $container_classes ); ?>">
						<nav id="main-menu" class="main-menu<?php if ( $header_style == 'overlay-simple' ) echo ' off-main-menu'; ?>">
							<?php 
                                engage_nav_menu(); 
                                engage_nav_tools(); 
                            ?>
						</nav>
					</div>
				</div>
			
			</div>
			
			<?php
			
			
		} else {
		
			// Classic Header
			
			$nav_position = 'right';
			
			if ( $header_style == 'overlay-fullscreen' ) {
				engage_print_fullscreen_menu();
			}

			$mobile_nav_style = '';

			?>
		
			<div id="main-navigation" class="main-nav"<?php if ( $header_color != '' ) echo ' style="background-color:' . esc_attr( $header_color ) . ';"'; ?>>
			
				<div class="main-nav-wrapper">
				
					<div class="container<?php echo esc_attr( $container_classes ); ?>">
					
						<?php 
						
						echo '<div class="nav-left">'; 
						
						if ( $header_style == 'split-menu' ) {

						    $mobile_nav_style = 'mobile-split';

						?>
						
							<nav class="main-menu">
								<?php engage_nav_menu( 'split-nav' ); ?>
							</nav>
						
						</div>
						
						<div class="nav-center">
						
						<?php } ?>
						
							<div id="logo">
							
								<?php engage_site_logo(); ?>
								
							</div>
							
							<?php if ( $header_style == 'top-left' ) { ?>
							<nav id="main-menu">
								<?php engage_nav_menu(); ?>
							</nav>
							<?php } ?>
							
                  <ul class="movephonenumber">
                     <li>
                     <?php echo do_shortcode("[orc_contact contacts='tollfree' makelink=true fontcolor='" . $content_links_color . "']"); ?>
                     </li>
                  </ul>
						<?php echo '</div>'; ?>
						
						<div class="nav-<?php echo esc_attr( $nav_position ); ?>">
						
							<?php if ( $header_style != 'top-left' && $header_style != 'overlay-fullscreen' ) { ?>
							<nav id="main-menu" class="main-menu<?php if ( $header_style == 'overlay-simple' ) echo ' off-main-menu'; ?>">
								<?php engage_nav_menu(); ?>
							</nav>
							<?php } ?>
							
							<?php 
							
							engage_nav_tools(); 
							
							?>
							
						</div>
					
					</div>
				
				</div>
			
			</div>
		
		<?php
		
		}
		
		?>
		
		<nav id="mobile-nav" class="mobile-nav">
			<div class="container">
			<?php

            engage_nav_menu( $mobile_nav_style );

			?>
			</div>
		</nav>
	
	</header>
	
	<?php 
	
	}
	
	engage_general_styles();

    do_action( 'engage_before_main_content' );
	
	?>
	
	<div id="main-content" <?php engage_content_class(); ?>>
	
	<?php 
	
	if ( engage_option( 'header_title' ) != 0 && get_post_meta( engage_get_id(), "custom_pagetitle", TRUE ) != 'disable' || !class_exists( 'Engage_Core' ) || engage_option( 'header_title' ) == null ) {		
		get_template_part( 'page-title' );
	}

	do_action( 'engage_after_page_title_area' );
	
	?>