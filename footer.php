<?php 

if (function_exists('engage_print_extra_content')) {
	engage_print_extra_content();
}

$footer_style = 'classic';
$footer_width = 'boxed';
$container_width = '';

if ( engage_option('footer_width') ) {
	$footer_width = engage_option('footer_width');
}

if ( $footer_width == 'stretched' ) {
	$container_width = '-large';
} elseif ( $footer_width == 'stretched_no_padding') {
	$container_width = '-fluid';
}

// Footer widgets disable/enable

$footer_widgets = true;

if ( engage_option('footer_widgets') == false ) {
	$footer_widgets = false;
}

// Footer copyright section

$footer_enabled = true;

if ( engage_option( 'footer_enabled' ) == false ) {
    $footer_enabled = false;
}

?>

	</div>

    <?php if ( $footer_enabled || $footer_widgets ) { ?>
	
	<!-- BEGIN FOOTER -->
	<footer id="footer" class="footer">
	
		<?php
		
		if ( $footer_widgets == true && ( is_active_sidebar( 'footer1' ) || is_active_sidebar( 'footer2' ) || is_active_sidebar( 'footer3' ) ) ) { 
		
		$footer_column_class = 'col-lg-3 col-md-6';
		
		$footer_widgets_layout = '4cols';
		
		if ( engage_option( 'footer_widgets_layout' ) ) {
			$footer_widgets_layout = engage_option( 'footer_widgets_layout' );
		}
		
		switch( $footer_widgets_layout ) {
			case '3cols':
				$footer_column_class = 'col-lg-4 col-md-6';
				break;
            case '1col':
                $footer_column_class = 'col-lg-12 col-md-12';
                break;
			case '5cols':
				$footer_column_class = 'col-lg-fifth col-lg-3 col-md-6';
				break; // Default 4 columns
			case '5cols2':
				$footer_column_class = 'col-lg-2 col-md-6';
				break;
			case '2cols':
				$footer_column_class = 'col-lg-6 col-md-6';
				break; // Default 4 columns
		}
		
		$footer_main_classes = '';
		
		if ( engage_option( 'footer_list_separator' ) == 'no' ) {
			$footer_main_classes .= ' lists-no-separators';
		} else {
			$footer_main_classes .= ' lists-with-separators';
		}
		
		// Lists style
		
		if ( engage_option( 'footer_list_style' ) == 'none' ) {
			$footer_main_classes .= ' lists-style-none';
		} else {
			$footer_main_classes .= ' lists-arrow';
		}
				
		// Footer Main Skin
		
		if ( engage_option( 'footer_skin' ) == 'light' ) {
			$footer_main_classes .= ' footer-light';
		} else {
			$footer_main_classes .= ' footer-dark';
		}
		
		// Footer Main inline CSS
		
		$footer_main_css = '';
		
		if ( engage_option( 'footer_main_bg_image' ) != '' ) {
		
			$bg_image = engage_option( 'footer_main_bg_image' );
			$bg_image = $bg_image['url'];
			
			if( $bg_image != '' ) { 
				$footer_main_css .= 'background-image: url(' . esc_url( $bg_image ) . ');';
			}
			
		}
		
		?>
	
		<div id="footer-main" class="footer-main <?php echo esc_attr( $footer_main_classes ); ?>"<?php if ( $footer_main_css != '' ) echo 'style="' . esc_attr( $footer_main_css ) . '"'; ?>>
		
			<div class="container<?php echo esc_attr( $container_width ); ?>">
		
				<div class="row">
				
				<?php 
				
				// 1st Widget Column 
				
				$footer_column_first_class = $footer_column_class;
				
					if ( $footer_widgets_layout == '3cols2' ) {
						$footer_column_first_class = 'col-lg-6 col-md-12';
					}
				
					?>
			
					<div class="<?php echo esc_attr( $footer_column_first_class ); ?>">
						<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('footer1') ); ?>
					</div>
				
				<?php 
				
				// 2nd Widget Column 
				
				?>
			
					<div class="<?php echo esc_attr( $footer_column_class ); ?>">
						<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('footer2') ); ?>
					</div>
			
				<?php
				
				// 3rd Widget Column
				
				if ( $footer_widgets_layout != '2cols' ) {
				
				?>
				
					<div class="<?php echo esc_attr( $footer_column_class ); ?>">
						<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('footer3') ); ?>
					</div>
				
				<?php
				
				}
				
				// 4th Widget Column
				
				if ( $footer_widgets_layout == '4cols' || $footer_widgets_layout == '5cols' || $footer_widgets_layout == '5cols2' ) {
				
					?>
					
					<div class="<?php echo esc_attr( $footer_column_class ); ?>">
						<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('footer4') ); ?>
					</div>
					
					<?php
				
				}
				
				// 5th Widget Column
				
				if ( $footer_widgets_layout == '5cols' || $footer_widgets_layout == '5cols2' ) {
				
					if ( $footer_widgets_layout == '5cols2' ) {
						$footer_column_class = 'col-lg-4 col-md-12';
					}
				
					?>
					
					<div class="<?php echo esc_attr( $footer_column_class ); ?>">
						<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('footer5') ); ?>
					</div>
					
					<?php
				
				}
				
				?>
	
				</div>
			
			</div>
		
		</div>
		
		<?php 
		
		} // End Footer Widgets 
		
		// Copyright section
		
		$footer_style = 'classic';
		$copyright_container_class = 'col-md-6';
		
		if ( engage_option('footer_style') ) {
			$footer_style = engage_option('footer_style');
		}
		
		if ( $footer_style == 'centered' ) {
			$copyright_container_class = 'col-md-12';
		}
		
		if ( engage_option( 'copyright_skin' ) == 'light' ) {
			$footer_style .= ' footer-light';
		}

		if ( $footer_enabled == true ) {
		
		?>
	  
		<div id="footer-bottom" class="footer-bottom footer-style-<?php echo esc_attr( $footer_style ); ?>">
		
			<div class="container<?php echo esc_attr( $container_width ); ?>">
			
				<div class="row f-bottom">
				
					<?php 
					
					if ( $footer_style == 'centered' && engage_option( 'footer_logo', 'url' ) ) {
					
						echo '<div class="footer-image"><img src="' . esc_url( engage_option( 'footer_logo', 'url' ) ) . '" alt></div>';
					
					}
					
					?>
				
					<div class="<?php echo esc_attr( $copyright_container_class ); ?>">
						<p class="copyright">
						<?php 
						
						if ( engage_option( 'copyright' ) ) {
						
							$allowed_tags = array(
							    'a' => array( // allow anchor tags
							        'href' => array()
							    ),
                                'img' => array(
                                    'src' => array(),
                                    'title' => array(),
                                    'alt' => array(),
                                    'srcset' => array(),
                                    'target' => array()
                                )
							);
							
							echo wp_kses( engage_option( 'copyright' ), $allowed_tags );
							
						} elseif ( !class_exists( 'Engage_Core' ) || engage_option( 'copyright' ) == null ) {
							echo esc_html( 'Copyright 2002-' . date('Y') . ' Orchard Recovery Center', 'engage' );
						}
						
						?>
						</p>
					</div>
					
					<?php
					
					if ( $footer_style != 'centered' ) {
					
						echo '<div class="' . esc_attr( $copyright_container_class ) . '">';
						
					}
					
					if ( engage_option( 'footer_icons' ) != false ) {
						
						$icon_duplicate = false;
						$icon_size = 'small';
						$icon_border = 'circle';
						
						if ( engage_option( 'copyright_icons_size' ) ) {
							$icon_size = engage_option( 'copyright_icons_size' );
						}
						
						if ( engage_option( 'copyright_icons_border' ) ) {
							$icon_border = engage_option( 'copyright_icons_border' );
						}
						
						if ( engage_option( 'copyright_icons_hover' ) == 'slide_over' ) {
							$icon_duplicate = true;
						}
						
						engage_social_profiles( $icon_duplicate, $icon_size, $icon_border );
						
					}
					
					if ( $footer_style != 'centered' ) {
						echo '</div>';
					} 
					
					?>
					
				</div>
			</div>
		</div>

        <?php } ?>
	  
	</footer>
	<!-- END FOOTER -->

    <?php } ?>
	
</div>
<!-- End #wrapper -->

<!-- Back To Top Button -->

<?php if (engage_option('stt')) echo '<a href="#" id="scrollup" class="scrollup" style="display: block;"><i class="fa fa-angle-up"></i></a>'; ?>	

<!-- End Back To Top Button -->


<?php if ( engage_option('header_search') || !class_exists( 'Engage_Core' ) ) { ?>

<!-- BEGIN OFF FULLSCREEN SEARCH -->

<div class="search-overlay overlay-dark">
  <a href="#" class="search-overlay-close"><i class="engage-icon-icon engage-icon-simple-remove"></i></a>
  <form action="<?php echo esc_url( home_url( '/' ) ); ?>/">
    <input type="text" name="s" type="text" value="" placeholder="<?php echo engage_translate( 'search-placeholder' ); ?>">
    <button type="submit" id="overlay-search-submit"><i class="engage-icon-icon engage-icon-zoom-2"></i></button>
  </form>
</div>

<!-- END OFF FULLSCREEN SEARCH -->

<?php 

} 

// Custom PHP

if ( engage_option( 'custom_html' ) != '' ) {
	add_action( 'wp_footer', 'engage_custom_html' );
}

?>

<?php wp_footer(); ?>

</body>
</html>