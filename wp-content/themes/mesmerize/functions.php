<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */

/* =========== INÍCIO: FUNÇÕES DECLARADAS =============== */

function getMediaEstrelas($idCurso, $numAvaliacoes) {
    global $wpdb;

    if($numAvaliacoes != 0) {
        $query = "SELECT SUM(A.RECOMENDACAO_NPS) ".
                  "FROM avaliacao A ".
                  "WHERE A.ID_CURSO = '{$idCurso}' ";

        $soma = $wpdb->get_var($query);
        $media = $soma/$numAvaliacoes;
        return $media;
    }

    return 0;
}


function getNivelBySlug($nivel) {
    global $wpdb;

    $query = "SELECT A.DESCR as nomeNivel ".
              "FROM nivel A ".
              "WHERE A.DESCR = '{$nivel}' ";

    return $wpdb->get_var($query);
}

function getEscolaBySlug($escola) {
global $wpdb;

    $query = "SELECT A.DESCR as nomeEscola ".
              "FROM escola A ".
              "WHERE A.DESCR = '{$escola}' ";

    return $wpdb->get_var($query);
}


function getAvaliacoesCurso($id_curso) {
    global $wpdb;

    $query = "SELECT A.COMENTARIO as comentario, A.RECOMENDACAO_NPS as recomendacao, A.ID_USUARIO as id_usuario, A.DATA_HORA as data_hora ".
              "FROM avaliacao A ".
              "WHERE A.ID_CURSO = '{$id_curso}' ".
              "ORDER BY A.DATA_HORA ASC ";

    return $wpdb->get_results($query);
}

function getIdUltimoPost() {
    global $wpdb;

    $query = "SELECT A.ID ".
              "FROM wp_posts A, wp_postmeta B ".
              "WHERE A.POST_TYPE = 'nf_sub' ". 
              "AND A.POST_DATE = (SELECT MAX(C.POST_DATE) FROM WP_POSTS C) ".
              "AND A.ID = B.POST_ID ".
              "GROUP BY A.ID";

    return $wpdb->get_var($query);
}

function montaArrayAvaliacoes($post_id) {

    $avaliacoesArray = array('QUALIDADE_PROFESSORES' => '', 'AULAS_PRATICAS' => '', 'ESTAGIO_PROJETOS' => '', 'CUSTO_BENEFICIO' => '', 'ESTRUTURA' => '', 'LABORATORIO_TECNOLOGIA' => '', 'SEGURANCA' => '', 'ATENDIMENTO' => '', 'RECOMENDACAO_NPS' => '', 'COMENTARIO' => '', 'ID_USUARIO' => '', 'ID_CURSO' => '');

    foreach ($avaliacoesArray as $key => $value) {
        switch ($key) {
          case 'QUALIDADE_PROFESSORES':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_29");
            break;
          case 'AULAS_PRATICAS':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_30");
            break;
          case 'ESTAGIO_PROJETOS':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_32");
            break;
          case 'CUSTO_BENEFICIO':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_33");
            break;
          case 'ESTRUTURA':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_35");
            break;
          case 'LABORATORIO_TECNOLOGIA':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_36");
            break;
          case 'SEGURANCA':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_37");
            break;
          case 'ATENDIMENTO':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_39");
            break;
          case 'RECOMENDACAO_NPS':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_21");
            break;
          case 'COMENTARIO':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_77");
            break;
          case 'ID_USUARIO':
          $avaliacoesArray[$key] = (string) um_profile_id();
            break;
          case 'ID_CURSO':
          $avaliacoesArray[$key] = getAvaliacao($post_id, "_field_76");
            break;

          default:
            break;
        }
    }

    return $avaliacoesArray;
}

function getAvaliacao($postId, $field) {
    global $wpdb;

    $result = $wpdb->get_var("SELECT A.META_VALUE FROM wp_postmeta A WHERE A.POST_ID = {$postId} AND A.META_KEY = '{$field}' ");
    return $result;
}

function calculaAvaliacoes($idCurso, $nomeColuna) {
    global $wpdb;

    $soma = $wpdb->get_var($wpdb->prepare(
    "SELECT SUM({$nomeColuna}) as soma " .
    "FROM avaliacao A " .
    "WHERE A.ID_CURSO = '%s' ", $idCurso));

    $num_avaliacoes = getNumAvaliacoes($idCurso);
    if($num_avaliacoes != 0) {
        return ($soma/$num_avaliacoes);
    } else {
        return $soma;
    }
}

function getNumAvaliacoes($param) {
    global $wpdb;

    $contagem = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) as contagem " .
    "FROM avaliacao A " .
    "WHERE A.ID_CURSO = '%s' ", $param));

    return $contagem;
}

function getCourseById($param) {
    global $wpdb;

    $cursos = $wpdb->get_results($wpdb->prepare(
    "SELECT A.ID_CURSO as id_curso, C.ID_CAMPUS as id_campus " .
    "FROM curso A, campus_curso B, campus C " .
    "WHERE A.ID_CURSO = '%s' " .
    "AND A.ID_CURSO = B.ID_CURSO " .
    "AND B.ID_CAMPUS = C.ID_CAMPUS ", $param));

    return $cursos;
}

function getCoursesBySearchParam($param) {
    global $wpdb;

    $cursos = $wpdb->get_results("SELECT A.ID_CURSO as id_curso, C.ID_CAMPUS as id_campus " .
    "FROM curso A, campus_curso B, campus C " .
    "WHERE A.DESCR LIKE '%$param%' " .
    "AND A.ID_CURSO = B.ID_CURSO " .
    "AND B.ID_CAMPUS = C.ID_CAMPUS ");

    return $cursos;
}

function getCoursesByNivelAndEscola($parent, $slug) {

    global $wpdb;

    $cursos = $wpdb->get_results(
    "SELECT A.ID_CURSO as id_curso, C.ID_CAMPUS as id_campus " .
    "FROM curso A, campus_curso B, campus C, escola D, nivel E " .
    "WHERE A.ID_CURSO = B.ID_CURSO " .
    "AND B.ID_CAMPUS = C.ID_CAMPUS " .
    "AND A.ID_ESCOLA = D.ID_ESCOLA " .
    "AND D.SLUG = '{$slug}' " .
    "AND A.ID_NIVEL = E.ID_NIVEL " .
    "AND E.SLUG = '{$parent}' "); 

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

function getNomeCurso($idCurso) {

    global $wpdb;

    $query = "SELECT DESCR ".
             "FROM curso A ".
             "WHERE A.ID_CURSO = {$idCurso} ";

    return $wpdb->get_var($query);

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
        "FROM campus A ".
        "WHERE A.ID_CAMPUS = {$idCampus} ");

    return $result;
}

function getInfoCursoById($idCurso, $nomeColuna) {
    global $wpdb;
    $result = "";

    $result = $wpdb->get_var(
        "SELECT {$nomeColuna} ".
        "FROM curso A ".
        "WHERE A.ID_CURSO = {$idCurso} ");

    return $result;
}

function getNomeCursoById($idCurso) {
    global $wpdb;
    $result = "";

    $result = $wpdb->get_var($wpdb->prepare(
        "SELECT DESCR ".
        "FROM curso A ".
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
        "FROM campus_financiamento A ".
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