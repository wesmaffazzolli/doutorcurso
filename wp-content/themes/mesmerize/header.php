<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/wp-content/themes/mesmerize/estilo.css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118968219-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-118968219-1');
    </script>
    
</head>

<body <?php body_class(); ?>>

<div  id="page-top" class="header-top">
	<?php mesmerize_print_header_top_bar(); ?>
	<?php mesmerize_get_navigation(); ?>
</div>

<div id="page" class="site">
    <div class="header-wrapper">
        <div <?php echo mesmerize_header_background_atts(); ?>>
            <?php do_action( 'mesmerize_before_header_background' ); ?>
			<?php mesmerize_print_video_container(); ?>
            <?php mesmerize_print_inner_pages_header_content(); ?>
            <?php mesmerize_print_header_separator(); ?>
        </div>
    </div>