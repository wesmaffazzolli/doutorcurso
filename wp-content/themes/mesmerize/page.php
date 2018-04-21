<?php mesmerize_get_header();?>

<div class="page-content">
  <div class="<?php mesmerize_page_content_wrapper_class(); ?>">
   <?php
      	while ( have_posts() ) : the_post();
        	get_template_part( 'template-parts/content', 'page' );
      	endwhile;

		/* is it a page */
		if( is_page() ) { 
			global $post;
		    
		    /* Get an array of Ancestors and Parents if they exist */
			$parents = get_post_ancestors( $post->ID );
		    /* Get the top Level page->ID count base 1, array base 0 so -1 */ 
			$id = ($parents) ? $parents[count($parents)-1]: $post->ID;
			/* Get the parent and set the $class with the page slug (post_name) */
		    $parent = get_post($id);
			$class = $parent->post_name;
			// echo $class;

	      	// Get the queried object and sanitize it
			$current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
			// Get the page slug
			$slug = $current_page->post_name;
			// echo $slug;

	    	/*global $post;
	    	$post_slug=$post->post_name;
	    	echo $post_slug;*/

	    	



		}



     ?>
  </div>
</div>

<?php get_footer(); ?>