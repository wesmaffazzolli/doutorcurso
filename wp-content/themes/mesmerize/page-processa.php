<?php mesmerize_get_header(); ?>

<div class="page-content">

  <?php 

    global $wpdb;

    $latest_post_id = getIdUltimoPost();

    $arrayAvaliacoes = montaArrayAvaliacoes($latest_post_id);

    //echo $wpdb->last_error;

    if($wpdb->insert('avaliacao', $arrayAvaliacoes) != false) {
      if(isset($_COOKIE['user_location'])) {
        header("Location: ".$_COOKIE['user_location']);
      } else {
        header("Location: http://www.doutorcurso.com.br");
      }
    } else {
      header("Location: ".$_COOKIE['user_location']);
    }

  ?>

</div>

<?php get_footer(); ?>