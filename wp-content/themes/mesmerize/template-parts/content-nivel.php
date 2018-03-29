    <?php $wpdb->show_errors = TRUE;
    $wpdb->suppress_errors = FALSE; 
    ?>

    <div class="container">        

        <?php 
        global $wpdb;
        $param = $_GET['s'];

        $cursos = $wpdb->get_results($wpdb->prepare(
        "SELECT a.igc AS instituicao_nota, a.descr AS instituicao_nome, a.descrshort, b.descr AS campus_nome, b.endereco, b.bairro, c.descr AS cidade_nome, d.uf, f.descr AS curso_nome, f.duracao, f.diploma, f.dupla_diplomacao, f.intercambio, f.enade, f.cc, f.cpc AS curso_nota, g.descr AS nivel, i.descr AS titulo, k.descr AS modalidade " .
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
            <div class="card border-dark mb-3" style="padding: 0px 0px;">
                <div class="card-header">
                    <h3><?php echo $curso->curso_nome?></h3>
                </div>
                <div class="container">
                    <div class="card-block">
                        <div class="row espacamento-instituicao-endereco">
                            <div class="col-sm-6">
                                <h4 class=""><?php echo $curso->instituicao_nome. " - ".$curso->sigla; ?></h4>
                            </div>
                            <div class="col-sm-6">                        
                                <p class="text-secondary instituicao-endereco">
                                    <i class="material-icons icone-local">location_on</i>
                                    <?php echo $curso->endereco." - ".$curso->bairro." - ".$curso->cidade_nome." - ".$curso->uf?>
                                </p>
                            </div>
                        </div>
                    
                        <div class="row">
                                <div class="col-sm-6">
                                    <div class="row espacamento-notas">
                                        <div class="col-6">
                                            <p>Nota do Curso:</p>
                                        </div>
                                        <div class="col-6 align-items-center">
                                            <?php if(!empty($curso->curso_nota)) { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo $curso->curso_nota;?></span></p>    
                                            <?php } else { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center espacamento-notas">
                                        <div class="col-6">
                                            <p>Nota da Instituição:</p>
                                        </div>
                                        <div class="col-6">
                                            <?php if(!empty($curso->instituicao_nota)) { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo $curso->instituicao_nota;?></span></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-primary config-badge"><?php echo "-";?></span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row espacamento-detalhes-curso">
                                        <div class="col-6">
                                            <p>Formação:</p>
                                        </div>
                                        <div class="col-6">
                                            <?php if(!empty($curso->nivel)) { ?>
                                                <p class="marcacao-padrao"><?php echo $curso->nivel;?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row espacamento-detalhes-curso">
                                        <div class="col-6">
                                            <p>Titulação:</p>
                                        </div>
                                        <div class="col-6">
                                             <?php if(!empty($curso->titulo)) { ?>
                                                <p class="marcacao-padrao"><?php echo $curso->titulo;?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row espacamento-detalhes-curso">
                                        <div class="col-6">
                                            <p>Modalidade:</p>
                                        </div>
                                        <div class="col-6">
                                            <?php if(!empty($curso->modalidade)) { ?>
                                                <p class="marcacao-padrao"><?php echo $curso->modalidade;?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                     <div class="row espacamento-detalhes-curso">
                                        <div class="col-6">
                                            <p>Duração:</p>
                                        </div>
                                        <div class="col-6">
                                            <?php if(!empty($curso->duracao)) { ?>
                                                <p class="marcacao-padrao"><?php echo $curso->duracao." Semestres";?></p>
                                            <?php } else { ?>
                                                <p class="marcacao-padrao"><?php echo "-";?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="row card-footer "> <!-- linha principal -->
                            <div class="col-sm-6"> <!-- coluna informações e coluna do botão tenho interesse -->
                                <div class="row"> <!-- linha das informações do curso -->
                                    <div class="col-md-6"> <!-- coluna 1 infos curso -->
                                        <div class="row espacamento-detalhes-extras">
                                            <?php if(!empty($curso->dupla_diplomacao)) { ?>
                                            <div class="col-4 text-right">
                                                <p><i class="material-icons existe">done</i></p>        
                                            </div>
                                            <div class="col-8">
                                                <p>Dupla Diplomação</p>
                                            </div>
                                            <?php } else { ?>
                                            <div class="col-4 text-right">
                                                <p><i class="material-icons n-existe">clear</i></p>        
                                            </div>
                                            <div class="col-8">
                                                <p>Dupla Diplomação</p>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row espacamento-detalhes-extras">
                                            <?php if(!empty($curso->diploma)) { ?>
                                            <div class="col-4 text-right">
                                                <p><i class="material-icons existe">done</i></p>        
                                            </div>
                                            <div class="col-8">
                                                <p>Diploma</p>
                                            </div>
                                            <?php } else { ?>
                                            <div class="col-4 text-right">
                                                <p><i class="material-icons n-existe">clear</i></p>        
                                            </div>
                                            <div class="col-8">
                                                <p>Diploma</p>
                                            </div>
                                            <?php } ?>
                                        </div>
                                   </div>
                                </div> 
                            </div>

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-6"> <!-- coluna 2 infos curso -->
                                        <div class="row espacamento-detalhes-extras">
                                            <?php if(!empty($curso->intercambio)) { ?>
                                            <div class="col-4 text-right">
                                                <p><i class="material-icons existe">done</i></p>        
                                            </div>
                                            <div class="col-8">
                                                <p>Intercâmbio</p>
                                            </div>
                                            <?php } else { ?>
                                            <div class="col-4 text-right">
                                                <p><i class="material-icons n-existe">clear</i></p>        
                                            </div>
                                            <div class="col-8">
                                                <p>Intercâmbio</p>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row espacamento-detalhes-extras">
                                            <?php if(!empty($curso->certificado)) { ?>
                                            <div class="col-4 text-right">
                                                <p><i class="material-icons existe">done</i></p>        
                                            </div>
                                            <div class="col-8">
                                                <p>Certificado</p>
                                            </div>
                                            <?php } else { ?>
                                            <div class="col-4 text-right">
                                                <p><i class="material-icons n-existe">clear</i></p>        
                                            </div>
                                            <div class="col-8">
                                                <p>Certificado</p>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                            <div class="col-12">
                                <div class="row no-gutter alinhamento">
                                    <div class="col-12">
                                        <a href="#" class="btn btn-success fluid-size">TENHO INTERESSE</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <?php } ?>
    </div>
</div>