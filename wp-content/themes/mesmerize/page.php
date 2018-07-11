<?php get_header("custom");//mesmerize_get_header(); ?>

<div class="page-content">
  <div class="<?php mesmerize_page_content_wrapper_class(); ?>">
   <?php
	/* is it a page */
	if(is_page()) {
		
		$slug = getPostSlug();
		$parent = getPostParent();

		//echo $parent;
		// echo $slug;

		if($parent == 'graduacao' || $parent == 'pos-graducao' || $parent == 'mestrado' || $parent == 'doutorado') { 

			while ( have_posts() ) : the_post();
		  		get_template_part( 'template-parts/content', 'searchbycourse' );
			endwhile;

		} else if($parent == 'login') {

			while ( have_posts() ) : the_post();
		  		get_template_part( 'template-parts/content', 'login' );
			endwhile;

		} else {
	
			while ( have_posts() ) : the_post();
		  		get_template_part( 'template-parts/content', 'page' );
			endwhile;

		}
    } ?> <!-- Is page if statement -->
  </div>
</div>

<?php get_footer(); ?>