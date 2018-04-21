<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */

/* =========== INÍCIO: FUNÇÕES DECLARADAS =============== */

function isFinancimento($idCampus) {
    global $wpdb;

    $num_financiamento = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) ".
        "FROM CAMPUS_FINANCIAMENTO A ".
        "WHERE A.ID_CAMPUS = %s ", $idCampus));
    if(empty($num_financiamento)) {
        return false;
    } else {
        return true;
    } 
        
}

/* Descrição: descobre o status da coluna de uma tabela

@params:
    $tabela: nome da tabela
    $coluna: nome da coluna  
    $status: status da coluna
    $id: id filtro

@return (boolean): 
    retorna verdadeiro se o status da coluna especificada para a tabela for igual ao que está no banco de dados senão retorna falso. 

*/

function existeStatusTabelaColunaPorId($tabela, $coluna, $status, $id) {
    global $wpdb;

    $result = $wpdb->get_var($wpdb->prepare(
        "SELECT {$coluna} ".
        "FROM {$tabela} A ".
        "WHERE A.ID_{$tabela} = %s ", $id));
    if($result == $status) {
        return true;
    } else {
        return false;
    }
}


/* =========== FIM: FUNÇÕES DECLARADAS =============== */





if ( ! defined('MESMERIZE_THEME_REQUIRED_PHP_VERSION')) {
    define('MESMERIZE_THEME_REQUIRED_PHP_VERSION', '5.3.0');
}

add_action('after_switch_theme', 'mesmerize_check_php_version');

/* Funções customizadas */
function get_my_custom_searchform() {
    include "searchform_custom.php";
}


function mesmerize_check_php_version()
{
    // Compare versions.
    if (version_compare(phpversion(), MESMERIZE_THEME_REQUIRED_PHP_VERSION, '<')) :
        // Theme not activated info message.
        add_action('admin_notices', 'mesmerize_php_version_notice');


        // Switch back to previous theme.
        switch_theme(get_option('theme_switched'));

        return false;
    endif;
}

function mesmerize_php_version_notice()
{
    ?>
    <div class="notice notice-alt notice-error notice-large">
        <h4><?php _e('Mesmerize theme activation failed!', 'mesmerize'); ?></h4>
        <p>
            <?php _e('You need to update your PHP version to use the <strong>Mesmerize</strong>.', 'mesmerize'); ?> <br/>
            <?php _e('Current php version is:', 'mesmerize') ?> <strong>
                <?php echo phpversion(); ?></strong>, <?php _e('and the minimum required version is ', 'mesmerize') ?>
            <strong><?php echo MESMERIZE_THEME_REQUIRED_PHP_VERSION; ?></strong>
        </p>
    </div>
    <?php
}

if (version_compare(phpversion(), MESMERIZE_THEME_REQUIRED_PHP_VERSION, '>=')) {
    require_once get_template_directory() . "/inc/functions.php";

     

    do_action("mesmerize_customize_register_options");
}