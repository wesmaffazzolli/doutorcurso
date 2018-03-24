<?php 

//mesmerize_get_header();
get_header('nivel'); 

?>

<div class="page-content">
  <div class="<?php mesmerize_page_content_wrapper_class(); ?>">
   <?php

   	global $post; 

   	$post_slug=$post->post_name; 
   	$post_data = get_post($post->post_parent);
	$parent_slug = $post_data->post_name;

	if($parent_slug == "posgraduacao" || $parent_slug == "graduacao") {
		get_template_part( 'template-parts/content', 'nivel' );
	} else if($parent_slug == "curso") {
		get_template_part( 'template-parts/content', 'curso' );
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}

      /*while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/content', 'page' );
      endwhile;*/
     ?>
  </div>
</div>

<?php get_footer(); ?>