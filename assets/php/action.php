<?php

	session_start();

	require_once 'auth.php';
	$user = new Auth();

	/**
		el archivo action solo sirve para el modulo de index que es el de iniciar sesion.
	**/

	if( isset($_POST['action']) && $_POST['action'] === 'IniciarSesion' ){
		$email = $user->__Limpiar_inputs($_POST['email']);
		$password = $user->__Limpiar_inputs($_POST['password']);
		if( $email == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'El email es requerido!!!', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $password == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'La contraseña es requerida!!!!', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}

		$loggedInUser = $user->iniciarSesion($email);

		if($loggedInUser != null ){
			if( password_verify($password, $loggedInUser['password']) ){
				echo 'login';
				$_SESSION['user'] = $email;
			}else{
				$mensaje = ['titulo'=>'Error','mensaje'=>'Contraseña incorrecta', 'tipo'=>'error'];
				echo json_encode($mensaje);
				die();
			}
		}else{
			$mensaje = ['titulo'=>'Error','mensaje'=>'usuario no valido contacta al administrador', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}


	}

?>