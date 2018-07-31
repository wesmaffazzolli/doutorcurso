<form id="customSearchForm" role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">

    <label>

        <!--<span class="screen-reader-text"><?php //_ex('Search for:', 'label', 'mesmerize'); ?></span>-->

        <input type="search" class="search-field" placeholder="<?php esc_attr_e('Search &hellip;', 'mesmerize'); ?>" value="<?php echo get_search_query(); ?>" name="s" maxlength="50"/>

    </label>

    <button type="submit" class="btn btn-primary botao-pesquisa-main"><i class="fas fa-search"></i> Pesquisar</button>

</form>

