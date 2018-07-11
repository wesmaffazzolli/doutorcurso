<?php mesmerize_get_header(); ?>

<div class="page-content">
  <div class="<?php mesmerize_page_content_wrapper_class(); ?>">

   <?php
      the_content(); 
        
      /*if(isset($_COOKIE['user_location'])) {
        header("Location: ".$_COOKIE['user_location']);
      } else {
        header("Location: http://localhost");
      }*/
    /*} else {
      header("Location: ".$_COOKIE['user_location']);
    }*/
    ?>

  </div>
</div>

<?php get_footer(); ?>