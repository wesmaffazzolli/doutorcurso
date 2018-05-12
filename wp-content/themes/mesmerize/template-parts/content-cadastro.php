<div id="post-<?php the_ID();?>" <?php post_class(); ?>>
  <div>
   <?php 
	
	the_content(); 

	/*add_filter( 'um_submit_form_data', 'my_submit_form_data', 10, 2 );
	function my_submit_form_data( $data ) {

		foreach( $ as $key => $value ){
			if ( strstr( $key, $this->form_suffix ) ) {
				$a_key = str_replace( $this->form_suffix, '', $key );
				$form[ $a_key ] = $value;
				unset( $form[ $key ] );
			}
		}

		global $wpdb;
		$table = $wpdb->prefix.'usuario';
$data = array('column1' => 'data one', 'column2' => 123);
$format = array('%s','%d');
$wpdb->insert($table,$data,$format);
$my_id = $wpdb->insert_id;

	return $data;
	}*/	

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
