<?php get_header("custom");?>

<div class="page-content">
  
    <div class="container">        

        <?php 
        global $wpdb;

        if(isset($_GET['c_id']) && isset($_GET['cmp_id'])) {
            $paramIdCurso = $_GET['c_id'];
            $paramIdCampus = $_GET['cmp_id'];
            $cursos = getCourseById($paramIdCurso, $paramIdCampus);
            $avaliacoes = getAvaliacoesCurso($paramIdCurso, $paramIdCampus);
            setcookie("user_location", get_permalink()."?c_id=".$paramIdCurso."&cmp_id=".$paramIdCampus, time()+3600, "/", "www.doutorcurso.com.br");
        } else {
            get_template_part( 'template-parts/content', 'none' );
        }

        foreach($cursos as $curso) { ?>

        <div class="row titulo-geral">
            <div class="col-lg-10">
                <h2><?php echo getNomeCurso($curso->id_curso); ?></h2>
                <h5><?php echo getInfoTableById("instituicao", "DESCR", getInfoTableById("campus", "ID_INSTITUICAO", $curso->id_campus, true), true). " - ".getInfoTableById("instituicao", "DESCRSHORT", getInfoTableById("campus", "ID_INSTITUICAO", $curso->id_campus, true), true); ?></h5>
                <p class="text-secondary instituicao-endereco">
                    <i class="material-icons icone-local">location_on</i>
                    <?php echo getInfoTableById("campus", "ENDERECO", $curso->id_campus, true)
                    ." - ".
                    getInfoTableById("campus", "BAIRRO", $curso->id_campus, true)
                    ." - ".
                    getInfoTableById("cidade", "DESCR", getInfoTableById("campus", "ID_CIDADE", $curso->id_campus, true), false)
                    ." - ".
                    getInfoTableById("estado", "UF", getInfoTableById("cidade", "ID_ESTADO", getInfoTableById("campus", "ID_CIDADE", $curso->id_campus, true), false), false); ?>
                </p>
            </div>
            <div class="col-lg-2">
                <a href="querosabermais/?c_id=<?php echo $curso->id_curso; ?>" class="btn btn-success fluid-size">QUERO SABER MAIS</a>
            </div>
        </div>

        <!-- ROW 1 -->

        <div class="row">
            <div class="card border-dark mb-3" style="padding: 0px 0px;">
                <div class="card-header">
                    <h4>Visão Geral</h4>
                </div>
                <div class="container">
                    <div class="card-block">                    
                        <div class="row">

                                <div class="col-12 col-md-4">
                                    <div class="row espacamento-visao-geral">
                                        <div class="col-6 col-md-6">
                                            <p>Formação:</p>
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <?php if(!empty(getInfoTableById("nivel", "DESCR", getInfoTableById("curso", "ID_NIVEL", $curso->id_curso, true), false))) { ?>
                                                <p class="marcacao-padrao"><?php echo getInfoTableById("nivel", "DESCR", getInfoTableById("curso", "ID_NIVEL", $curso->id_curso, true), false); ?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row espacamento-visao-geral">
                                        <div class="col-6 col-md-6">
                                            <p>Titulação:</p>
                                        </div>
                                        <div class="col-6 col-md-6">
                                             <?php $titulacao = getInfoTableById("titulo", "DESCR", getInfoTableByIdNn("curso_titulo", "ID_TITULO", "ID_CURSO", $curso->id_curso), false);
                                             if(!empty($titulacao)) { ?>
                                                <p class="marcacao-padrao"><?php echo $titulacao;?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row espacamento-visao-geral">
                                        <div class="col-6 col-md-6">
                                            <p>Modalidade:</p>
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <?php $modalidade = getInfoTableById("modalidade", "DESCR", getInfoTableByIdNn("curso_modalidade", "ID_MODALIDADE", "ID_CURSO", $curso->id_curso), false);  
                                            if(!empty($modalidade)) { ?>
                                                <p class="marcacao-padrao"><?php echo $modalidade;?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                     <div class="row espacamento-visao-geral espacamento-fundo">
                                        <div class="col-6 col-md-6">
                                            <p>Duração:</p>
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <?php $duracao = getInfoTableById("curso", "DURACAO", $curso->id_curso, true);
                                            if(!empty($duracao)) { ?>
                                                <p class="marcacao-padrao"><?php echo $duracao." Semestres";?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-md-4">
                                    <div class="row espacamento-notas-visao-geral">
                                        <div class="col-6 col-md-7">
                                            <p>Financiamento:</p>
                                        </div>
                                        <div class="col-6 col-md-5">
                                            <?php if(isFinancimento($curso->id_campus)) { ?>
                                                <p><span class="badge badge-primary config-badge-curso"><?php echo "SIM";?></span></p>    
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge-curso"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas-visao-geral">
                                        <div class="col-6 col-md-7">
                                            <p>Diploma:</p>
                                        </div>
                                        <div class="col-6 col-md-5">
                                            <?php if(existeStatusTabelaColunaPorId("curso", "DIPLOMA", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge-curso"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge-curso"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas-visao-geral">
                                        <div class="col-6 col-md-7">
                                            <p>Certificado:</p>
                                        </div>
                                        <div class="col-6 col-md-5">
                                            <?php if(existeStatusTabelaColunaPorId("curso", "CERTIFICADO", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge-curso"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge-curso"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas-visao-geral">
                                        <div class="col-6 col-md-7">
                                            <p>Estacionamento:</p>
                                        </div>
                                        <div class="col-6 col-md-5">
                                            <?php if(existeStatusTabelaColunaPorId("campus", "ESTACIONAMENTO", "S", $curso->id_campus)) { ?>
                                                <p><span class="badge badge-primary config-badge-curso"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge-curso"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-12 col-md-4">
                                    <div class="row espacamento-notas-visao-geral">
                                        <div class="col-6 col-md-8"">
                                            <p>Intercâmbio:</p>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <?php if(existeStatusTabelaColunaPorId("curso", "INTERCAMBIO", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge-curso"><?php echo "SIM";?></span></p>    
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge-curso"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas-visao-geral">
                                        <div class="col-6 col-md-8">
                                            <p>Módulo Internacional:</p>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <?php if(existeStatusTabelaColunaPorId("curso", "MODULO_INTERNACIONAL", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge-curso"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge-curso"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas-visao-geral espacamento-fundo">
                                        <div class="col-6 col-md-8">
                                            <p>Dupla Diplomação:</p>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <?php if(existeStatusTabelaColunaPorId("curso", "DUPLA_DIPLOMACAO", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge-curso"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge-curso"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- ROW 2 NOTA MEC -->

        <div class="row">
            <div class="card border-dark mb-3" style="padding: 0px 0px;">
                <div class="card-header">
                    <h4 class="titulo-grande">Nota MEC</h4>
                </div>
                <div class="container">
                    <div class="card-block">                        
                        <div class="row espacamento-notas-visao-geral">
                            <div class="col-6 col-md-4">
                                <p>Nota Curso (CPC):</p>
                            </div>
                            <div class="col-6 col-md-8">
                                <?php if(!empty(getInfoTableById("curso", "CPC", $curso->id_curso, true))) { ?>
                                    <p><span class="badge badge-primary config-badge-curso"><?php echo getInfoTableById("curso", "CPC", $curso->id_curso, true);?></span></p>    
                                <?php } else { ?>
                                    <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                <?php } ?>
                            </div>                        
                        </div>
                        <div class="row espacamento-notas-visao-geral espacamento-fundo">
                            <div class="col-6 col-md-4">
                                <p>Nota Instituição de ensino (IGC):</p>
                            </div>
                            <div class="col-6 col-md-8">
                                <?php if(!empty(getInfoTableById("instituicao", "IGC", getInfoTableById("campus", "ID_INSTITUICAO", $curso->id_campus, true), true))) { ?>
                                    <p><span class="badge badge-primary config-badge-curso"><?php echo getInfoTableById("instituicao", "IGC", getInfoTableById("campus", "ID_INSTITUICAO", $curso->id_campus, true), true); ?></span></p>
                                <?php } else { ?>
                                    <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                <?php } ?>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- ROW 3 AVALIAÇÕES -->

        <div class="row">
            <div class="card border-dark mb-3" style="padding: 0px 0px;">
                <div class="card-header">
                    <h4>Avaliações</h4>
                </div>
                <div class="container">
                    <div class="card-block">                        
                        <div class="row titulo-indice">
                            <div class="col-12">
                                <?php $num_avaliacoes = getNumAvaliacoes($curso->id_curso, $curso->id_campus); 
                                $media_estrelas = getMediaEstrelas($curso->id_curso, $curso->id_campus, $num_avaliacoes); ?>
                                <h4 class="titulo-avaliacoes">Índice de recomendação dos alunos:</h4>

                                <?php 

                                //Código que preenche as estrelas
                                for($i = 1; $i <= $media_estrelas; $i++) {
                                    echo "<span class=\"fa fa-star checked estrelas\" style=\"color: orange;\"></span>";
                                }

                                for($j = $media_estrelas; $j < 5; $j++) {
                                    echo "<span class=\"fa fa-star estrelas\" style=\"color: black;\"></span>";   
                                }

                                ?>

                                <?php echo "<span class='badge badge-light num-avaliacoes'>$num_avaliacoes Avaliações</span>"; ?>
                                <?php //echo "Média das estrelas é: $media_estrelas"; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="espacamento-titulos-avaliacoes">Curso</h4>
                                <div class="row espacamento-notas-visao-geral">
                                    <div class="col-8 col-md-8">
                                        <p>Capacitação dos Professores:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php $nota_qualidade_professores = calculaAvaliacoes($curso->id_curso, $curso->id_campus, "QUALIDADE_PROFESSORES"); ?>
                                        <?php if(!empty($nota_qualidade_professores)) { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo number_format((float)$nota_qualidade_professores, 1, '.', ''); ?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row espacamento-notas-visao-geral">
                                    <div class="col-8 col-md-8">
                                        <p>Aulas Práticas:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php $nota_aulas_praticas = calculaAvaliacoes($curso->id_curso, $curso->id_campus, "AULAS_PRATICAS"); ?>
                                        <?php if(!empty($nota_aulas_praticas)) { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo number_format((float)$nota_aulas_praticas, 1, '.', ''); ?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row espacamento-notas-visao-geral">
                                    <div class="col-8 col-md-8">
                                        <p>Apoio para Projetos e/ou Estágios:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php $nota_estagio_projetos = calculaAvaliacoes($curso->id_curso, $curso->id_campus, "ESTAGIO_PROJETOS"); ?>
                                        <?php if(!empty($nota_estagio_projetos)) { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo number_format((float)$nota_estagio_projetos, 1, '.', '');?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row espacamento-notas-visao-geral espacamento-fundo">
                                    <div class="col-8 col-md-8">
                                        <p>Relação de Custos vs. Benefícios:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php $nota_custos_beneficios = calculaAvaliacoes($curso->id_curso, $curso->id_campus, "CUSTO_BENEFICIO"); ?>
                                        <?php if(!empty($nota_custos_beneficios)) { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo number_format((float)$nota_custos_beneficios, 1, '.', '');?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="espacamento-titulos-avaliacoes">Instituição de Ensino</h4>
                                <div class="row espacamento-notas-visao-geral">
                                    <div class="col-8 col-md-8">
                                        <p>Estrutura (salas de aula, biblioteca, wi-fi, etc):</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php $nota_estrutura = calculaAvaliacoes($curso->id_curso, $curso->id_campus, "ESTRUTURA"); ?>
                                        <?php if(!empty($nota_estrutura)) { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo number_format((float)$nota_estrutura, 1, '.', ''); ?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row espacamento-notas-visao-geral">
                                    <div class="col-8 col-md-8">
                                        <p>Qualidade dos Laboratórios e Tecnologia:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php $nota_laboratorios_tecnologia = calculaAvaliacoes($curso->id_curso, $curso->id_campus, "LABORATORIO_TECNOLOGIA"); ?>
                                        <?php if(!empty($nota_laboratorios_tecnologia)) { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo number_format((float)$nota_laboratorios_tecnologia, 1, '.', '');?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row espacamento-notas-visao-geral">
                                    <div class="col-8 col-md-8">
                                        <p>Nível de Segurança para o Aluno:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php $nota_seguranca_aluno = calculaAvaliacoes($curso->id_curso, $curso->id_campus, "SEGURANCA"); ?>
                                        <?php if(!empty($nota_seguranca_aluno)) { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo number_format((float)$nota_seguranca_aluno, 1, '.', ''); ?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row espacamento-notas-visao-geral espacamento-fundo">
                                    <div class="col-8 col-md-8">
                                        <p>Qualidade de Atendimento ao Aluno:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php $nota_qualidade_atendimento_aluno = calculaAvaliacoes($curso->id_curso, $curso->id_campus, "ATENDIMENTO"); ?>
                                        <?php if(!empty($nota_qualidade_atendimento_aluno)) { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo number_format((float)$nota_qualidade_atendimento_aluno, 1, '.', ''); ?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge-curso"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row card-footer "> <!-- linha principal -->
                        <div class="col-12">
                            <div class="row no-gutter alinhamento">
                                <div class="col-12">
                                    <a href="avaliar?c_id=<?php echo $curso->id_curso; ?>&cmp_id=<?php echo $curso->id_campus; ?>" class="btn btn-success fluid-size">AVALIAR CURSO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h4 class="titulo-secao-comentarios">Comentários e Avaliações</h4>
            <div class="col-sm-12">

                <?php

                $num_avaliacoes = getNumAvaliacoes($curso->id_curso, $curso->id_campus);

                //echo $num_avaliacoes;

                if($num_avaliacoes != "0") {

                foreach ($avaliacoes as $avaliacao) { 

                    um_fetch_user($avaliacao->id_usuario);

                ?>

                <div class="panel panel-white post panel-shadow espacamento-box-comentario">
                    <div class="post-heading">
                        <div class="pull-left image">
                            <img src="/wp-content/themes/mesmerize/img/mascote.png" class="img-circle avatar" alt="user profile image">
                        </div>
                        <div class="pull-left meta">
                            <div class="title h5">
                                <b><?php echo um_user('display_name'); ?></b>                                
                                <?php for($i = 1; $i <= $avaliacao->recomendacao; $i++) { ?> 
                                    <span class="fa fa-star checked" style="color: orange;"></span>
                                <?php } ?>
                                <?php for($k = $avaliacao->recomendacao; $k < 5; $k++) { ?> 
                                    <span class="fa fa-star" style="color: black;"></span>
                                <?php } ?>
                            </div>
                            <?php 
                                $date = new DateTime($avaliacao->data_hora);
                            ?>
                            <h6 class="text-muted time"><?php echo $date->format('d/m/Y H:i'); ?></h6>
                        </div>
                    </div> 
                    <div class="post-description"> 
                        <p><?php echo $avaliacao->comentario; ?></p>
                    </div>
                </div>

                <?php } } else {

                    echo "<h6 style='margin-top:20px;'>Ainda não há avaliações para este curso. <a href='/login'>Faça login e seja o primeiro!</a></h6>";

                } ?>

            </div>
        </div>


         <?php } ?>
    </div> <!-- container div -->
</div> <!-- page-content div -->

<?php get_footer(); ?>