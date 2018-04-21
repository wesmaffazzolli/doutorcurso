<?php get_header("curso");?>

<div class="page-content">
  
    <div class="container">        

        <?php 
        global $wpdb;
        $param = $_GET['s'];

        $cursos = $wpdb->get_results($wpdb->prepare(
        "SELECT a.igc AS instituicao_nota, a.descr AS instituicao_nome, a.descrshort, b.id_campus, b.descr AS campus_nome, b.endereco, b.bairro, c.descr AS cidade_nome, d.uf, f.ID_CURSO AS id_curso, f.descr AS curso_nome, f.duracao, f.diploma, f.dupla_diplomacao, f.intercambio, f.enade, f.cc, f.cpc AS curso_nota, g.descr AS nivel, i.descr AS titulo, k.descr AS modalidade " .
        "FROM instituicao a, campus b, cidade c, estado d, campus_curso e, curso f, nivel g, curso_titulo h, titulo i, curso_modalidade j, modalidade k " .
        "WHERE a.id_instituicao = b.id_instituicao " .
        "AND b.id_cidade = c.id_cidade " .
        "AND c.id_estado = d.id_estado " .
        "AND b.id_campus = e.id_campus " .
        "AND e.id_curso = f.id_curso " .
        "AND f.id_nivel = g.id_nivel " .
        "AND f.id_curso =  h.id_curso " .
        "AND h.id_titulo = i.id_titulo " .
        "AND f.id_curso = j.id_curso " .
        "AND j.id_modalidade = k.id_modalidade " .
        "AND f.status = 'A' " . 
        "AND f.descr LIKE '%%s%'", $param));

        foreach($cursos as $curso) { ?>

        <div class="row">
            <div class="col-sm-10">
                <h2 class="titulo-grande"><?php echo $curso->curso_nome?></h2>
                <h5 class=""><?php echo $curso->instituicao_nome. " - ".$curso->sigla; ?></h5>
                <p class="text-secondary instituicao-endereco">
                    <i class="material-icons icone-local">location_on</i>
                    <?php echo $curso->endereco." - ".$curso->bairro." - ".$curso->cidade_nome." - ".$curso->uf?>
                </p>
            </div>
            <div class="col-sm-2">
                <a href="curso?c_id=<?php echo $curso->id_curso; ?>" class="btn btn-success fluid-size">TENHO INTERESSE ></a>
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
                                    <div class="row espacamento-detalhes-curso">
                                        <div class="col-4 col-md-6">
                                            <p>Nível de Formação:</p>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <?php if(!empty($curso->nivel)) { ?>
                                                <p class="marcacao-padrao"><?php echo $curso->nivel;?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row espacamento-detalhes-curso">
                                        <div class="col-4 col-md-6">
                                            <p>Titulação:</p>
                                        </div>
                                        <div class="col-8 col-md-6">
                                             <?php if(!empty($curso->titulo)) { ?>
                                                <p class="marcacao-padrao"><?php echo $curso->titulo;?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row espacamento-detalhes-curso">
                                        <div class="col-4 col-md-6">
                                            <p>Modalidade:</p>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <?php if(!empty($curso->modalidade)) { ?>
                                                <p class="marcacao-padrao"><?php echo $curso->modalidade;?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                     <div class="row espacamento-detalhes-curso">
                                        <div class="col-4 col-md-6">
                                            <p>Duração:</p>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <?php if(!empty($curso->duracao)) { ?>
                                                <p class="marcacao-padrao"><?php echo $curso->duracao." Semestres";?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-md-4">
                                    <div class="row espacamento-notas">
                                        <div class="col-4 col-md-7">
                                            <p>Financiamento:</p>
                                        </div>
                                        <div class="col-8 col-md-5">
                                            <?php if(isFinancimento($curso->id_campus)) { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo "SIM";?></span></p>    
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas">
                                        <div class="col-4 col-md-7">
                                            <p>Diploma:</p>
                                        </div>
                                        <div class="col-8 col-md-5">
                                            <?php if(existeStatusTabelaColunaPorId("CURSO", "DIPLOMA", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas">
                                        <div class="col-4 col-md-7">
                                            <p>Certificado:</p>
                                        </div>
                                        <div class="col-8 col-md-5">
                                            <?php if(existeStatusTabelaColunaPorId("CURSO", "CERTIFICADO", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas">
                                        <div class="col-4 col-md-7">
                                            <p>Estacionamento:</p>
                                        </div>
                                        <div class="col-8 col-md-5">
                                            <?php if(existeStatusTabelaColunaPorId("CAMPUS", "ESTACIONAMENTO", "S", $curso->id_campus)) { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-12 col-md-4">
                                    <div class="row espacamento-notas">
                                        <div class="col-4 col-md-8" style="border: 1px solid red;">
                                            <p>Intercâmbio:</p>
                                        </div>
                                        <div class="col-8 col-md-4" style="border: 1px solid green">
                                            <?php if(existeStatusTabelaColunaPorId("CURSO", "INTERCAMBIO", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo "SIM";?></span></p>    
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas">
                                        <div class="col-4 col-md-8">
                                            <p>Módulo Internacional:</p>
                                        </div>
                                        <div class="col-8 col-md-4">
                                            <?php if(existeStatusTabelaColunaPorId("CURSO", "MODULO_INTERNACIONAL", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge label-secondary config-badge"><?php echo "NÃO";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas">
                                        <div class="col-4 col-md-8">
                                            <p>Dupla Diplomação:</p>
                                        </div>
                                        <div class="col-8 col-md-4">
                                            <?php if(existeStatusTabelaColunaPorId("CURSO", "DUPLA_DIPLOMACAO", "S", $curso->id_curso)) { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo "SIM";?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-secondary config-badge"><?php echo "NÃO";?></span></p>
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
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <p>Nota Curso (CPC):</p>
                            </div>
                            <div class="col-6 col-md-8">
                                <?php if(!empty($curso->curso_nota)) { ?>
                                    <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                <?php } else { ?>
                                    <p><span class="badge badge-secondary config-badge"><?php echo "-";?></span></p>
                                <?php } ?>
                            </div>                        
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <p>Nota Instituição de ensino (IGC):</p>
                            </div>
                            <div class="col-6 col-md-8">
                                <?php if(!empty($curso->instituicao_nota)) { ?>
                                    <p><span class="badge badge-primary config-badge"><?php echo $curso->instituicao_nota;?></span></p>
                                <?php } else { ?>
                                    <p><span class="badge badge-secondary config-badge"><?php echo "-";?></span></p>
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
                    <h4 class="titulo-grande">Avaliações</h4>
                </div>
                <div class="container">
                    <div class="card-block">                        
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Índice de recomendação dos alunos:</h4>
                                <span class="fa fa-star checked" style="color: orange;"></span>
                                <span class="fa fa-star checked" style="color: orange;"></span>
                                <span class="fa fa-star checked" style="color: orange;"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"> 500 Avaliações</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Curso</h4>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Qualidade e Nível de Formação dos Professores:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Aulas Práticas:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Atualização de Conteúdos Ensinados:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Apoio para Projetos e/ou Estágios:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Relação de Custos vs. Benefícios:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4>Instituição de Ensino</h4>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Estrutura (salas de aula, biblioteca, wi-fi, etc):</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Qualidade dos Laboratórios e Tecnologia:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Nível de Segurança para o Aluno:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Corpo Docente (coordenação e funcionários):</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <p>Qualidade de Atendimento ao Aluno:</p>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <?php if(!empty($curso->curso_nota)) { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                        <?php } else { ?>
                                            <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
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
                                    <a href="curso?c_id=<?php echo $curso->id_curso; ?>" class="btn btn-success fluid-size">AVALIE ></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card border-dark mb-3" style="padding: 0px 0px;">
                <div class="card-header">
                    <h4 class="titulo-grande">Comentários</h4>
                </div>
                <div class="container">
                    <div class="card-block">                        
                        <ul class="list-unstyled">
                          <li class="media">
                            <img class="mr-3" src="https://bowdaa.com/images/membersprofilepic/noprofilepicture.gif" alt="Generic placeholder image" style="width: 50px; height: 50px;">
                            <div class="media-body">
                              <h5 class="mt-0 mb-1">List-based media object</h5>
                              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                          </li>
                          <li class="media my-4">
                            <img class="mr-3" src="https://bowdaa.com/images/membersprofilepic/noprofilepicture.gif" alt="Generic placeholder image" style="width: 50px; height: 50px;">
                            <div class="media-body">
                              <h5 class="mt-0 mb-1">List-based media object</h5>
                              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                          </li>
                          <li class="media">
                            <img class="mr-3" src="https://bowdaa.com/images/membersprofilepic/noprofilepicture.gif" alt="Generic placeholder image" style="width: 50px; height: 50px;">
                            <div class="media-body">
                              <h5 class="mt-0 mb-1">List-based media object</h5>
                              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                          </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


         <?php } ?>
    </div> <!-- container div -->
</div> <!-- page-content div -->

<?php get_footer(); ?>