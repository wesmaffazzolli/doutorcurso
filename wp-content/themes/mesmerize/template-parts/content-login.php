<div id="post-<?php the_ID();?>" <?php post_class(); ?>>
  <div>
   <?php 
	
	the_content(); 

	if (is_ultimatemember()) {
		session_start();
		$_SESSION['id'] = um_profile_id();
		$_SESSION['username'] = um_user('display_name');
		$_SESSION['role'] = um_user('role_name');
		$_SESSION['time'] = time();
	}


	/* 

	Parâmetros de regisgtro:
	Nome: first_name
	Sobrenome: last_name
	Email: user_email
	Senha: user_password

	Parâmetros de login:
	Email: username
	Senha: user_password

	*/



?>

  </div>
