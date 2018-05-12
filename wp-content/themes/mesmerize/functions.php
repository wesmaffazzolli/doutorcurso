<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */

/* =========== INÍCIO: FUNÇÕES DECLARADAS =============== */

function getNumAvaliacoes($param) {
    global $wpdb;

    $contagem = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) as contagem " .
    "FROM AVALIACAO A " .
    "WHERE A.ID_CURSO = '%s' ", $param));

    return $contagem;
}

function getCourseById($param) {
    global $wpdb;

    $cursos = $wpdb->get_results($wpdb->prepare(
    "SELECT A.ID_CURSO as id_curso, C.ID_CAMPUS as id_campus " .
    "FROM CURSO A, CAMPUS_CURSO B, CAMPUS C " .
    "WHERE A.ID_CURSO = '%s' " .
    "AND A.ID_CURSO = B.ID_CURSO " .
    "AND B.ID_CAMPUS = C.ID_CAMPUS ", $param));

    return $cursos;
}

function getCoursesBySearchParam($param) {
    global $wpdb;

    $cursos = $wpdb->get_results($wpdb->prepare(
    "SELECT A.ID_CURSO as id_curso, C.ID_CAMPUS as id_campus " .
    "FROM CURSO A, CAMPUS_CURSO B, CAMPUS C " .
    "WHERE A.DESCR LIKE '%%s%' " .
    "AND A.ID_CURSO = B.ID_CURSO " .
    "AND B.ID_CAMPUS = C.ID_CAMPUS ", $param));

    return $cursos;
}

function getCoursesByNivelAndEscola($parent, $slug) {

    global $wpdb;

    $cursos = $wpdb->get_results($wpdb->prepare(
    "SELECT A.ID_CURSO as id_curso, C.ID_CAMPUS as id_campus " .
    "FROM CURSO A, CAMPUS_CURSO B, CAMPUS C, ESCOLA D, NIVEL E " .
    "WHERE A.ID_CURSO = B.ID_CURSO " .
    "AND B.ID_CAMPUS = C.ID_CAMPUS " .
    "AND A.ID_ESCOLA = D.ID_ESCOLA " .
    "AND D.SLUG = '%s' " .
    "AND A.ID_NIVEL = E.ID_NIVEL " .
    "AND E.SLUG = '%s' ", array($slug, $parent))); 

    return $cursos;
}

function getInfoTableByIdNn($tabela, $nomeColuna, $nomeColunaComparacao, $id) {
    global $wpdb;
    $result = "";

    $query = "SELECT {$nomeColuna} ".
             "FROM {$tabela} A ".
             "WHERE A.{$nomeColunaComparacao} = {$id} ".
             "AND A.STATUS = 'A' ";

    $result = $wpdb->get_var($query);

    return $result;
}

function getInfoTableById($tabela, $nomeColuna, $id, $ativo) {
    global $wpdb;
    $result = "";
    if(empty($ativo)) {
        $ativo = false;
    }

    $query = "SELECT {$nomeColuna} ".
             "FROM {$tabela} A ".
             "WHERE A.ID_{$tabela} = {$id} ";

    $result = $wpdb->get_var($ativo == true ? $query."AND STATUS = 'A' " : $query);

    return $result;
}


function getInfoCampusById($idCampus, $nomeColuna) {
    global $wpdb;
    $result = "";

    $result = $wpdb->get_var(
        "SELECT {$nomeColuna} ".
        "FROM CAMPUS A ".
        "WHERE A.ID_CAMPUS = {$idCampus} ");

    return $result;
}

function getInfoCursoById($idCurso, $nomeColuna) {
    global $wpdb;
    $result = "";

    $result = $wpdb->get_var(
        "SELECT {$nomeColuna} ".
        "FROM CURSO A ".
        "WHERE A.ID_CURSO = {$idCurso} ");

    return $result;
}

function getNomeCursoById($idCurso) {
    global $wpdb;
    $result = "";

    $result = $wpdb->get_var($wpdb->prepare(
        "SELECT DESCR ".
        "FROM CURSO A ".
        "WHERE A.ID_CURSO = %s ", $idCurso));

    return $result;
}


function getPostParent() {
    global $post;

    /* Get an array of Ancestors and Parents if they exist */
    $parents = get_post_ancestors( $post->ID );
    /* Get the top Level page->ID count base 1, array base 0 so -1 */ 
    $id = ($parents) ? $parents[count($parents)-1]: $post->ID;
    /* Get the parent and set the $class with the page slug (post_name) */
    $parent = get_post($id);
    $post_parent = $parent->post_name;
    return $post_parent;
}

function getPostSlug() {
    // Get the queried object and sanitize it
    $current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
    // Get the page slug
    $slug = $current_page->post_name;

    /*global $post;
    $post_slug=$post->post_name;
    echo $post_slug;*/

    return $slug;
}


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