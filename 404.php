<?php 
get_header();

$layout = 'no_sidebar';
$general_layout = engage_general_layout( $layout );
$sidebar_width = engage_sidebar_width();
$page_width = engage_page_width();
$container_class = engage_container_class( $page_width );

?>

<section class="section-page <?php echo esc_attr( $general_layout ); ?> page-layout-<?php echo esc_attr( $layout ); ?> sidebar-width-<?php echo esc_attr( $sidebar_width ); ?> page-width-<?php echo esc_attr( $page_width ); ?>"<?php engage_page_content_styles(); ?>>
	
	<div class="container<?php echo esc_attr( $container_class ); ?>">
	
		<div class="row main-row">
		
			<div id="page-content" class="page-content page-content-404">
		
				<div class="vntd-not-found-texts">
					<h2 class="not-found-title"><?php esc_html_e('Page Not Available.','engage'); ?></h2>
					<p class="not-found-description"><?php esc_html_e('It looks like nothing was found at this location.','engage'); ?><br><?php esc_html_e('Please try searching?','engage'); ?></p>
				</div>		
				
				<div class="search-form-404">
				 <?php get_template_part('searchform'); ?>
				</div>
			
			</div>
			
			<?php
			
			// Page Sidebar
		
			if($layout != "no_sidebar") {
				get_sidebar();    
			}
			
			?>
		
		</div>
	
	</div>

</section>

<?php get_footer(); ?>