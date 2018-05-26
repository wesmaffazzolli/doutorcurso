<?php mesmerize_get_header(); ?>

<div class="page-content">
  <div class="<?php mesmerize_page_content_wrapper_class(); ?>">

   <?php
        the_content(); 
    
    ?>

  </div>
</div>

<?php get_footer(); ?>