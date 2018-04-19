<?php 

$post = $wp_query->post;
get_header(); 

$layout = engage_page_layout();
$general_layout = engage_general_layout( $layout );
$sidebar_width = engage_sidebar_width();
$page_width = engage_page_width();
$container_class = engage_container_class( $page_width );

?>

<section class="section-page <?php echo esc_attr( $general_layout ); ?> page-layout-<?php echo esc_attr( $layout ); ?> sidebar-width-<?php echo esc_attr( $sidebar_width ); ?> page-width-<?php echo esc_attr( $page_width ); ?>"<?php engage_page_content_styles(); ?>>
	
	<div class="container<?php echo esc_attr( $container_class ); ?>">
	
		<div class="row main-row">
		
			<div id="page-content" class="page-content">
		
			<?php
			
			// Page Content Loop
			
			if ( have_posts() ) : while ( have_posts() ) : the_post(); 
			        
				the_content(); 
				
				wp_link_pages();
            
            getPrevNext();
            
			endwhile; endif; 
                
            // Comments 
	
            if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
                echo '<div class="page-comments post-comments"><div class="container' . esc_attr( $container_class ) . '">';
                comments_template();
                echo '</div></div>';
            }
			
			?>
			
			</div>
			
			<?php
			
			// Page Sidebar
		
			if ( $layout != "no_sidebar" ) {
				get_sidebar();    
			}
			
			?>
		
		</div>
	
	</div>

</section>

<?php get_footer();

/**
 * Display the previous next links if the category is a testimonial
 * 
 * Since pages don't work with the normal prev/next links that work with posts,
 * we need to get all the pages and search for the prev/next to the current page
 */
function getPrevNext(){
   $categoryData = get_the_category(get_the_ID());
   if(count($categoryData) > 0) {
      $category = $categoryData[0]->name;
      if(0 === strcmp($category, 'Testimonial')) {

         $pagelist = get_pages('sort_column=menu_order&sort_order=asc');
         $pages = array();
         foreach ($pagelist as $page) {
            $pages[] += $page->ID;
         }

         $current = array_search(get_the_ID(), $pages);
         $prevID = $pages[$current-1];
         if(!empty($prevID)) {
            $categoryData = get_the_category($prevID);
            if(count($categoryData) > 0) {
               $prevCategory = $categoryData[0]->name;
               if(0 !== strcmp($category, $prevCategory)) {
                  $prevID = null;
               }
            } else {
               $prevID = null;
            }
         }
         $nextID = $pages[$current+1];
         if(!empty($nextID)) {
            $categoryData = get_the_category($nextID);
            if(count($categoryData) > 0) {
               $nextCategory = $categoryData[0]->name;
               if(0 !== strcmp($category, $nextCategory)) {
                  $nextID = null;
               }
            } else {
               $nextID = null;
            }
         }

         echo '<div class="navigation">';

         if (!empty($prevID)) {
            echo '<div class="alignleft">';
            echo '<a href="';
            echo get_permalink($prevID);
            echo '"';
            echo 'title="View tesitmonial for ';
            echo get_the_title($prevID); 
            echo'">&laquo; View testimonial for ' . get_the_title($prevID) . '</a>';
            echo "</div>";
         }
         if (!empty($nextID)) {
            echo '<div class="alignright">';
            echo '<a href="';
            echo get_permalink($nextID);
            echo '"';
            echo 'title="View tesitmonial for ';
            echo get_the_title($nextID); 
            echo'">View tesitmonial for ' . get_the_title($nextID) . ' &raquo;</a>';
            echo "</div>";		
         }

      }
   }
}