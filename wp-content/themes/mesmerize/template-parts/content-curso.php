<?php 

if(isset($_GET['c_id'])) {
	$id_curso = $_GET['c_id'];
	echo "Esta é a página do curso: ".$id_curso.".";
}

?>