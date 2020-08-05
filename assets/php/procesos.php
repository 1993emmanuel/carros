<?php

	/*
		Archivo que se encarga de validar y ser el intermedio antes de hacer las acciones
		con la base de datos
	*/
	// require_once 'auth.php';
	// $cuser = new Auth();
	include_once 'sesion.php';

	/**
		vamos a mostrar todos los vehiculos sin reservar
	**/
	if( isset($_POST['action']) && $_POST['action'] === 'sinReservar' ){
		$salida = '';
		$datos = $cuser->vehiculosSinReservar();
		if($datos){
			$salida.='
				<table class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th>#</th>
							<th>Nombre del vehiculo</th>
							<th>Marca</th>
							<th>Estado</th>
							<th>Apartado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
			';
			foreach($datos as $dato){
				if( $dato['estatus'] == 1 ){ $estatus = "Operando"; } else{ $estatus = 'Descontinuado'; }
				if( $dato['apartado'] == 1 ){ $apartado = "Ocupado"; } else{ $apartado = 'libre'; }
				$salida.='
					<tr>
						<td>'.$dato['id'].'</td>
						<td>'.$dato['nombre_vehiculo'].'</td>
						<td>'.$dato['marca'].'</td>
						<td>'.$estatus.'</td>
						<td>'.$apartado.'</td>
						<td>
							<a href="#" id="'.$dato['id'].'" title="Reservar Vehiculo" class="text-dark eventReservarIcon" data-toggle="modal" data-target="#ventanaReservar">
								<i class="fas fa-reply fa-lg"></i>
							</a>
						</td>
					</tr>
				';
			}
			$salida.='</tbody></table>';
			echo $salida;
		}else{
			echo '<h3>No hay vehiculos disponibles para reservar!!!</h3>';
		}
	}


	//datos del vehiculo
	if( isset($_POST['reservarCarrro_id']) ){
		$id = $cuser->__Limpiar_inputs($_POST['reservarCarrro_id']);
		if( $id == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Error al traer la informacion intente mas tarde', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$informacion = $cuser->traerDatosVehiculo($id);
			echo json_encode($informacion,JSON_UNESCAPED_UNICODE);
			die();
		}
	}

	//Reservar vehiculo
	if( isset($_POST['action']) && $_POST['action'] === 'ReservarVehiculo' ){
		$idCarro = $cuser->__Limpiar_inputs($_POST['id']);
		$horaInicial  = $cuser->__Limpiar_inputs($_POST['dateReserva']);
		$horaFinal = $cuser->__Limpiar_inputs($_POST['dateReservaFinal']);
		if( $idCarro == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Error al realizar la reserva', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $horaInicial == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'La hora de inicio es necesaria', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $horaFinal == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'La hora final es necesaria', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}

		$reserva = $cuser->reservaPendiente($cid);
		if( $reserva != null ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'ya posees un auto reservado lo sentimos', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$cuser->reservarVehiculo( $idCarro, $cid, $narea, $horaInicial, $horaFinal );
			$cuser->apartarVehiculo( $idCarro,1);
			$cuser->notifiacion($cid, 'admin' , 'el usuario registro un vehiculo');
			$mensaje = ['titulo'=>'Correcto','mensaje'=>'Vehiculo registrado Correctamente', 'tipo'=>'success'];
			echo json_encode($mensaje);
			die();
		}


	}



	/**
		seccion de profile.php
	**/
	if( isset($_POST['action']) && $_POST['action'] === 'ChangePassword' ){
		$contrasenaAcutal = $cuser->__Limpiar_inputs($_POST['curpass']);
		$nuevaContrasena = $cuser->__Limpiar_inputs($_POST['newpass']);
		$repetirContrasena = $cuser->__Limpiar_inputs($_POST['cnewpass']);

		if( $contrasenaAcutal == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Ingresar la contraseña actual es requerido!!!', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $nuevaContrasena == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Ingresar la nueva contraseña es requerda!!', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $repetirContrasena == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Repetir la nueva cotnraseña es requerido!!!!', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}

		if( $nuevaContrasena != $repetirContrasena ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Error las contraseñas no coinciden verifique por favor', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			if( password_verify($contrasenaAcutal, $cpass) ){
				$hpassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
				$cuser->cambiarContrasena($hpassword ,$cid);
				$cuser->notifiacion($cid, 'admin' , 'el usuario cambio su contraseña');
				$mensaje = ['titulo'=>'Correcto','mensaje'=>'Contraseña Cambiada Correctamente', 'tipo'=>'success'];
				echo json_encode($mensaje);
				die();
			}else{
				$mensaje = ['titulo'=>'Error','mensaje'=>'la contraseña actual es incorrecta!!!!!!!', 'tipo'=>'error'];
				echo json_encode($mensaje);
				die();
			}
		}
	}

	//subir foto nueva al perfil
	if( isset($_FILES['image']) ){
		$oldImage = $_POST['oldimage'];
		$folder = 'uploads/';

		//si llegan a subir una foto hay que moverla a folder
		if( isset($_FILES['image']['name']) && $_FILES['image']['name'] != "" ){
			$newImage = $folder.$_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'], $newImage);
			if( $oldImage != null ){
				unlink($oldImage);
			}
		}else{
			$newImage = $oldImage;
		}
		$cuser->subirFoto($newImage,$cid);
		$cuser->notifiacion($cid, 'admin' , 'el usuario cambio su foto de perfil');
	}


	/**
		Seccion para home.php
	**/
	if (isset($_POST['miRenta'])){
		$informaiconVehiculo = $cuser->miRenta($cid);
		echo json_encode($informaiconVehiculo);
		die();
	}


	/****
		Seccion de feedback.php
	****/

	//enviar mensaje al admin
	if( isset($_POST['action']) && $_POST['action'] === 'AdminMensaje' ){
		$tituloMensaje = $cuser->__Limpiar_inputs($_POST['tituloMensaje']);
		$feedback = $cuser->__Limpiar_inputs($_POST['feedback']);
		if( $tituloMensaje == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el titulo del mensaje es requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if ($feedback == '') {
			$mensaje = ['titulo'=>'Error','mensaje'=>'el mensaje es un campo requerido!!', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		$cuser->feedback($cid,$tituloMensaje,$feedback);
		$cuser->notifiacion($cid, 'admin' , 'el usuario mando un mensaje al administrador');
		$mensaje = ['titulo'=>'Correcto','mensaje'=>'mensaje enviado al administrador Correctamente', 'tipo'=>'success'];
		echo json_encode($mensaje);
		die();
	}


	/****
		seccion de notificaciones.php
	***/
	if( isset($_POST['action']) && $_POST['action'] === 'misnotificaciones' ){
		$notificaciones = $cuser->mostrarTodasMisNotificaciones($cid);
		$salida = '';
		if( $notificaciones ){
			foreach( $notificaciones as $notificacion ){
				$salida.='
					<div class="alert alert-danger" role="alert">
						<button type="button" id="'.$notificacion['id'].'" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="alert-heading">Nueva notificacion</h4>
						<p class="mb-0 lead">'.$notificacion['message'].'</p>
						<hr class="my-2">
						<p class="mb-0 float-left">Respuesta del Admin</p>
						<p class="mb-0 float-right">'.$cuser->tiempoAtras($notificacion['created_at']).'</p>
						<div class="clearfix"></div>
					</div>
				';
			}
			echo $salida;
		}else{
			echo '<h3 class="text-center text-secondary lead">no hay notificaciones por el momento</h3>';
		}
	}


	if( isset($_POST['notificacion_id']) ){
		$id = $cuser->__Limpiar_inputs($_POST['notificacion_id']);
		if( $id=='' ){
			$mensaje = ['titulo'=>'Correcto','mensaje'=>'error al eliminar notificacion contacta al administrador', 'tipo'=>'error'];
			echo json_encode($mensaje);
		}else{
			$cuser->eliminarAdministrador($id);
		}
	}

?>