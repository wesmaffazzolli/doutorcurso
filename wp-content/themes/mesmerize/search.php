<?php /* Template name: Custom Search */   
    get_header('custom'); 
?>

    <?php $wpdb->show_errors = TRUE;
    $wpdb->suppress_errors = FALSE; 
    ?>

    <div class="container-fluid config-base-barra-pesquisa">
        <div class="row">
            <div class="col-12">
                <form role="search" method="get" class="config-form-barra-pesquisa" action="<?php esc_url( home_url( '/search' ) )?>">
                    <!--<input type="search" class="config-direct-barra-pesquisa" value="<?php get_search_query() ?>" name="s" />-->
                    <input type="search" class="config-direct-barra-pesquisa" value="<?php get_search_query() ?>" name="s" />
                    <button type="button" class="config-botao-barra-pesquisa">Pesquisar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">        

        <?php 

        if(isset($_GET['s'])) { ?>

            <?php get_template_part( 'template-parts/content', 'search' ); ?>

        <?php } else { ?>

            <?php get_template_part( 'template-parts/content', 'none' ); ?>        

        <?php } ?>

    </div>
</div>

<?php get_footer(); ?>