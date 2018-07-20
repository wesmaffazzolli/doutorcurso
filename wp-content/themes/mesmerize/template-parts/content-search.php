<?php 

	$parent = getPostParent();
	$cursos = array();

	if(isset($_GET['s'])) {
		$param = $_GET['s'];
		$cursos = getCoursesBySearchParam($param);
	} else if($parent == 'graduacao' || $parent == 'pos-graducao' || $parent == 'mestrado' || $parent == 'doutorado') {
		$slug = getPostSlug();
		$cursos = getCoursesByNivelAndEscola($parent, $slug);
	}

	if(count($cursos) == 0) {
		get_template_part( 'template-parts/content', 'none' );
	} else { ?>

	<div class="alert alert-info" role="alert">
  		<?php if(count($cursos) > 1) {
  			echo "<h5>".count($cursos)." cursos encontrados para \"{$param}\"...</h5>"; 	
  		} else {
  			echo "<h5>".count($cursos)." curso encontrado para \"{$param}\"...</h5>";
  		}
  		
  		?>
	</div>

		<?php foreach($cursos as $curso) { ?>

	    <div class="row">
	        <div class="card border-dark mb-3" style="padding: 0px 0px;">
	            <div class="card-header">
	                <h3><?php echo getInfoTableById("curso", "DESCR", $curso->id_curso, false); ?></h3>
	            </div>
	            <div class="container">
	                <div class="card-block">
	                    <div class="row espacamento-instituicao-endereco">
	                        <div class="col-sm-6">
	                            <h4 class=""><?php echo getInfoTableById("instituicao", "DESCR", getInfoTableById("campus", "ID_INSTITUICAO", $curso->id_campus, true), true)
	                            . " - ".
	                            getInfoTableById("instituicao", "DESCRSHORT", getInfoTableById("campus", "ID_INSTITUICAO", $curso->id_campus, true), true); ?></h4>
	                        </div>
	                        <div class="col-sm-6">                        
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
	                    </div>
	                
	                    <div class="row">
	                            <div class="col-sm-6">
	                                <div class="row espacamento-notas">
	                                    <div class="col-6">
	                                        <p>Nota do Curso:</p>
	                                    </div>
	                                    <div class="col-6 align-items-center">
	                                        <?php if(!empty(getInfoTableById("curso", "CPC", $curso->id_curso, true))) { ?>
	                                            <p><span class="badge badge-primary config-badge"><?php echo getInfoTableById("curso", "CPC", $curso->id_curso, true);?></span></p>    
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
	                                        <?php if(!empty(getInfoTableById("instituicao", "IGC", getInfoTableById("campus", "ID_INSTITUICAO", $curso->id_campus, true), true))) { ?>
	                                            <p><span class="badge badge-primary config-badge"><?php echo getInfoTableById("instituicao", "IGC", getInfoTableById("campus", "ID_INSTITUICAO", $curso->id_campus, true), true); ?></span></p>
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
	                                        <?php if(!empty(getInfoTableById("nivel", "DESCR", getInfoTableById("curso", "ID_NIVEL", $curso->id_curso, true), false))) { ?>
	                                            <p class="marcacao-padrao"><?php echo getInfoTableById("nivel", "DESCR", getInfoTableById("curso", "ID_NIVEL", $curso->id_curso, true), false); ?></p>
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
	                                         <?php $titulacao = getInfoTableById("titulo", "DESCR", getInfoTableByIdNn("curso_titulo", "ID_TITULO", "ID_CURSO", $curso->id_curso), false);
	                                         if(!empty($titulacao)) { ?>
	                                            <p class="marcacao-padrao"><?php echo $titulacao;?></p>
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
	                                        <?php $modalidade = getInfoTableById("modalidade", "DESCR", getInfoTableByIdNn("curso_modalidade", "ID_MODALIDADE", "ID_CURSO", $curso->id_curso), false);  
	                                        if(!empty($modalidade)) { ?>
	                                            <p class="marcacao-padrao"><?php echo $modalidade;?></p>
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
	                                        <?php $duracao = getInfoTableById("curso", "DURACAO", $curso->id_curso, true);
	                                        if(!empty($duracao)) { ?>
	                                            <p class="marcacao-padrao"><?php echo $duracao." Semestres";?></p>
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
	                                        <?php $dupla_diplomacao = getInfoTableById("curso", "DUPLA_DIPLOMACAO", $curso->id_curso, true);
	                                        if(!empty($dupla_diplomacao)) { ?>
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
	                                        <?php $diploma = getInfoTableById("curso", "DIPLOMA", $curso->id_curso, true);
	                                        if(!empty($diploma)) { ?>
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
	                                        <?php $intercambio = getInfoTableById("curso", "INTERCAMBIO", $curso->id_curso, true);
	                                        if(!empty($intercambio)) { ?>
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
	                                        <?php $certificado = getInfoTableById("curso", "CERTIFICADO", $curso->id_curso, true);
	                                        if(!empty($certificado)) { ?>
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
	                                    <a href="curso?c_id=<?php echo $curso->id_curso; ?>" class="btn btn-success fluid-size">TENHO INTERESSE</a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	  <?php } ?> <!-- for each statement -->
  <?php } ?> <!-- if statement array length == 0 -->