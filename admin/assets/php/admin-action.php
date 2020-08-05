<?php
	
	/**
		Requerimos admin-db para tener las funciones que nos permiten
		interactuar con la base de datos.
	**/

	require_once "admin-db.php";
	$admin = new Admin();
	session_start();

	//validamos action de login
	if( isset($_POST['action']) && $_POST['action'] === 'adminLogin' ){
		$username = $admin->__Limpiar_inputs($_POST['username']);
		$password = $admin->__Limpiar_inputs($_POST['password']);
		//validar si estan vacios
		if( $username == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'El campo de usuario es requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $password == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'El campo de contraseña es requerida', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}

		$hpassword = sha1($password);
		$loggedInAdmin = $admin->adminLogin($username,$hpassword);
		if( $loggedInAdmin !=null ){
			echo 'admin_login';
			$_SESSION['username'] = $username;
		}else{
			$mensaje = ['titulo'=>'Error','mensaje'=>'Usuario y/o Password Incorrectos', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
	}


	/**
		funciones de admin-areas
	**/
	if( isset($_POST['action']) && $_POST['action'] === 'mostrarAreas' ){
		$salida = '';
		$datos = $admin->allAreas();
		if($datos){
			$salida.='
				<table class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th>#</th>
							<th>Area</th>
							<th>Estatus</th>
							<th>Creada</th>
							<th>Editada</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>';
			foreach( $datos as $dato ){
				if($dato['estatus'] == 1){ $estado = "Area Activa"; }else{ $estado = 'Area Cerrada'; }
				$salida.='
					<tr>
						<td>'.$dato['id'].'</td>
						<td>'.$dato['area'].'</td>
						<td>'.$estado.'</td>
						<td>'.$dato['created_at'].'</td>
						<td>'.$dato['edited_at'].'</td>
						<td>
							<a href="#" id="'.$dato['id'].'" title="Editar" class="text-info areaDetailsIcon" data-toggle="modal" data-target="#showAreaEditModal">
								<i class="fas fa-edit fa-lg"></i>&nbsp;&nbsp;
							</a>
							<a href="#" id="'.$dato['id'].'" title="Eliminar Area" class="text-danger deleteAreaIcon">
								<i class="fas fa-trash-alt fa-lg"></i>&nbsp;&nbsp;
							</a>
						</td>
					</tr>
				';
			}
			$salida.='</tbody></table>';
			echo $salida;
		}else{
			echo '<h3 class="text-center lead text-secondary">Sin Areas registradas!!!</h3>';
		}
	}

	//agregar un area
	if( isset($_POST['action']) && $_POST['action'] === 'agregarArea' ){
		$area = $admin->__Limpiar_inputs($_POST['area']);
		if($area == ''){
			$mensaje = ['titulo'=>'Error','mensaje'=>'El area es un campo requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$admin->agregarArea($area);
			$mensaje = ['titulo'=>'Area Guardada','mensaje'=>'El area fue guardada correctamente', 'tipo'=>'success'];
			echo json_encode($mensaje);
			die();
		}
	}

	//mostrar datos del area
	if( isset($_POST['edit_id']) ){
		$edit_id = $admin->__Limpiar_inputs($_POST['edit_id']);
		if($edit_id==''){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Error al traer la informacion', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$informacion = $admin->traerArea($edit_id);
			echo json_encode($informacion);
			die();
		}
	}

	//editar el area
	if( isset($_POST['action']) && $_POST['action'] === 'EditArea' ){
		$areaEdit = $admin->__Limpiar_inputs($_POST['areaEdit']);
		$id = $admin->__Limpiar_inputs($_POST['id']);
		if($areaEdit == ''){
			$mensaje = ['titulo'=>'Error','mensaje'=>'El area es requerida para editarla', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $id == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Por el momento no podemos actualizar el area', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		$admin->EditarArea($areaEdit,$id);
		$mensaje = ['titulo'=>'Correcto','mensaje'=>'Area editada correctamente', 'tipo'=>'success'];
		echo json_encode($mensaje);
		die();
	}

	//eliminar Area
	if( isset($_POST['delete_area']) ){
		$delete_area = $admin->__Limpiar_inputs($_POST['delete_area']);
		if( $delete_area == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'lo sentimos por el momento no podemos realizar la operacion', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$admin->EliminarArea($delete_area,0);
			$mensaje = ['titulo'=>'Correcto','mensaje'=>'area eliminada correctamente', 'tipo'=>'success'];
			echo json_encode($mensaje);
			die();
		}
	}

	/**
		funciones para admin-users.php
	**/
	//funcion para mostrar las areas en un selected
	if( isset($_POST['action']) && $_POST['action'] === 'selectedAreas' ){
		$salida = '';
		$datos = $admin->allAreas();
		if( $datos ){
			$salida.='<option value="" disabled>Elige un area</option>';
			foreach($datos as $dato){
				$salida.='<option value="'.$dato['id'].'">'.$dato['area'].'</option>';
			}
			echo $salida;
		}else{
			echo '<h3 class="text-center">Contacta a soporte tecnico!!!!</h3>';
		}
	}

	//funcion para agregar empleado
	if( isset($_POST['action']) && $_POST['action'] === 'agregarEmpleado' ){
		$name = $admin->__Limpiar_inputs($_POST['name']);
		$apellido = $admin->__Limpiar_inputs($_POST['apellido']);
		$email = $admin->__Limpiar_inputs($_POST['email']);
		$user = $admin->__Limpiar_inputs($_POST['user']);
		$password = $admin->__Limpiar_inputs($_POST['password']);
		$areas = $admin->__Limpiar_inputs($_POST['areas']);
		//validaciones a vacio
		if($name == ''){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el nombre es un campo requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if($apellido == ''){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el apellido es un campo requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();			
		}
		if( $email == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el email es un campo requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $user == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el usuario es un campo requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $password == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el password es un campo requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $areas == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el area es un campo obligatorio', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}

		if( $admin->CorreoUsuarioExiste($email) ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el correo ya existe!', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $admin->UsernameExiste($user) ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el usuario ya existe!', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		$hpassword = password_hash($password, PASSWORD_DEFAULT);
		$admin->AgregarEmpleado($areas, $name, $apellido, $email, $user, $hpassword);
		$mensaje = ['titulo'=>'Correcto','mensaje'=>'usuario Agregado Correctamente', 'tipo'=>'success'];
		echo json_encode($mensaje);
		die();
	}

	//traer todos los usuarios activos
	if( isset($_POST['action']) && $_POST['action'] === 'allUsuario' ){
		$salida = '';
		$datos = $admin->AllEmpleados();
		if($datos){
			$salida.='
				<table class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th>#</th>
							<th>Area</th>
							<th>Nombre</th>
							<th>Apellidos</th>
							<th>Correo</th>
							<th>Nombre de Usuario</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>';
			foreach($datos as $dato){
				$salida.='
					<tr>
						<td>'.$dato['id'].'</td>
						<td>'.$dato['area'].'</td>
						<td>'.$dato['nombre'].'</td>
						<td>'.$dato['apellidos'].'</td>
						<td>'.$dato['correo'].'</td>
						<td>'.$dato['username'].'</td>
						<td>
							<a href="#" id="'.$dato['id'].'" title="Editar Usuario" class="text-primary userEditDetailsIcon" data-toggle="modal" data-target="#editarEmpleado">
								<i class="fas fa-edit fa-lg"></i>
							</a>
							<a href="#" id="'.$dato['id'].'" title="Editar Cuenta" class="text-warning userEditCuentaIcon" data-toggle="modal" data-target="#editarEmpleadoAccesos">
								<i class="fas fa-user-lock fa-lg"></i>
							</a>
							<a href="#" id="'.$dato['id'].'" title="Eliminar Usuario" class="text-danger userDeleteDetailsIcon">
								<i class="fas fa-trash-alt fa-lg"></i>
							</a>
						</td>
					</tr>';
			}
			$salida.='</tbody></table>';
			echo $salida;
		}else{
			echo '<h3>No hay empleados registrados en el sistema!!!</h3>';
		}
	}

	//traer datos del ussuario
	if( isset($_POST['Editarusuario_id']) ){
		$id = $admin->__Limpiar_inputs($_POST['Editarusuario_id']);
		if($id == ''){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Ocurrio un error inesperado contacta al admin', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$data = $admin->mostrarEmpleado($id);
			echo json_encode($data);
			die();
		}

	}

	//editar el usuario
	if( isset($_POST['action']) && $_POST['action'] === 'EditarEmpleado' ){
		$id = $admin->__Limpiar_inputs($_POST['id']);
		$name = $admin->__Limpiar_inputs($_POST['nameEdit']);
		$apellidos = $admin->__Limpiar_inputs($_POST['apellidoEdit']);
		$idarea = $admin->__Limpiar_inputs($_POST['areasEdit']);
		if( $id == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Ocurrio un error al momento de actualizar llamar a soporte', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if($name == ''){
			$mensaje = ['titulo'=>'Error','mensaje'=>'El campo nombre es requerido para editar', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $apellidos == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'El apellido es un campo requerido para editar', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $idarea == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'el area es un campo requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		$admin->ActualizarEmpleado($id,$name,$apellidos,$idarea);
		$mensaje = ['titulo'=>'Correcto!','mensaje'=>'el usuario fue editado correctamente', 'tipo'=>'success'];
		echo json_encode($mensaje);
		die();
	}

	//cambiar contraseña
	if( isset($_POST['EditarClaves_id']) ){
		$id = $admin->__Limpiar_inputs($_POST['EditarClaves_id']);
		if( $id == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Ocurrio un error inesperado contacta al admin', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$data = $admin->mostrarEmpleado($id);
			echo json_encode($data);
			die();
		}
	}

	if( isset($_POST['action']) && $_POST['action'] === 'EditarClave' ){
		$id = $admin->__Limpiar_inputs($_POST['idAceso']);
		$password = $admin->__Limpiar_inputs($_POST['passwordEdit']);
		if( $id == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Ocurrio un error inesperado contacta al admin', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $password == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Es necesaria la contraseña!!!!', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		$hpassword = password_hash($password, PASSWORD_DEFAULT);
		$admin->ActualizarContra($id,$hpassword);
		$mensaje = ['titulo'=>'Correcto!!','mensaje'=>'Contraseña reseteada correctamente', 'tipo'=>'success'];
		echo json_encode($mensaje);
		die();
	}

	//Eliminar usuario del sistema
	if( isset($_POST['eliminarUsuario_id']) ){
		$id = $admin->__Limpiar_inputs($_POST['eliminarUsuario_id']);
		if( $id == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Error al eliminar el usuario contacta al administrador', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$admin->EliminarUsuarioSistema($id, 0);
			$mensaje = ['titulo'=>'Correcto','mensaje'=>'Usuario eliminado del sistema correctamente', 'tipo'=>'success'];
			echo json_encode($mensaje);
			die();
		}
	}

	/**
		admin-userDelete.php todas las validaciones
	**/
	if( isset($_POST['action']) && $_POST['action'] === 'mostrarEliminados' ){
		$salida = '';
		$datos = $admin->mostrarEmpleadoEliminado();
		if( $datos ){
			$salida.='
				<table class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th>#</th>
							<th>Nombre</th>
							<th>Apellidos</th>
							<th>Correo</th>
							<th>Nombre de Usuario</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>';
			foreach($datos as $dato){
				$salida.='
					<tr>
						<td>'.$dato['id'].'</td>
						<td>'.$dato['nombre'].'</td>
						<td>'.$dato['apellidos'].'</td>
						<td>'.$dato['correo'].'</td>
						<td>'.$dato['username'].'</td>
						<td>
							<a href="#" id="'.$dato['id'].'" title="Restaurar Usuario" class="text-white restoreUserIcon badge badge-dark p-2">
								Restaurar
							</a>
						</td>
					</tr>';
			}
			$salida.='</tbody></table>';
			echo $salida;
		}else{
			echo '<h3 class="text-center text-secondary lead">No hay usuarios eliminados en el sistema</h3>';
		}
	}

	//restaurar usuario eliminado
	if( isset($_POST['restaurarUser_id']) ){
		$id = $admin->__Limpiar_inputs($_POST['restaurarUser_id']);
		if($id == ''){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Error al restaurar usuario contacta al administrador', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$admin->EliminarUsuarioSistema($id,1);
			$mensaje = ['titulo'=>'Correcto','mensaje'=>'usuario restaurado al sistema', 'tipo'=>'success'];
			echo json_encode($mensaje);
			die();
		}
	}

	/**
		admin-userDelete.php
	**/

	//mostrar areas eliminadas del sistema
	if( isset($_POST['action']) && $_POST['action'] === 'areasEliminadas' ){
		$salida='';
		$datos = $admin->mostrarAreasEliminadas();
		if( $datos ){
			$salida.='
				<table class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th>#</th>
							<th>Area</th>
							<th>Estatus</th>
							<th>Creada</th>
							<th>Editada</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>';
			foreach( $datos as $dato ){
				if($dato['estatus'] == 1){ $estado = "Area Activa"; }else{ $estado = 'Area Cerrada'; }
				$salida.='
					<tr>
						<td>'.$dato['id'].'</td>
						<td>'.$dato['area'].'</td>
						<td>'.$estado.'</td>
						<td>'.$dato['created_at'].'</td>
						<td>'.$dato['edited_at'].'</td>
						<td>
							<a href="#" id="'.$dato['id'].'" title="Restaurar Area" class="text-white restoreAreaIcon badge badge-dark p-2">
								Restaurar
							</a>
						</td>
					</tr>
				';
			}
			$salida.='</tbody></table>';
			echo $salida;
		}else{
			echo '<h3 class="text-center text-secondary lead">No hay areas eliminadas en el sistema</h3>';
		}
	}

	//reacivar area eliminada
	if( isset($_POST['restaurarArea_id']) ){
		$id = $admin->__Limpiar_inputs($_POST['restaurarArea_id']);
		if( $id == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Oops error al restaurar contacta al administrador', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$admin->EliminarArea($id,1);
			$mensaje = ['titulo'=>'Correcto','mensaje'=>'Area restaurada correctamente', 'tipo'=>'success'];
			echo json_encode($mensaje);
			die();
		}
	}

	/********
		Seccion de Feedbacks
	*********/
	if ( isset($_POST['action']) && $_POST['action'] === 'mostrarFeedbacks' ){
		$salida = '';
		$datos = $admin->allFeedback();
		if( $datos ){
			$salida = '
				<table class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th>ID</th>
							<th>titulo</th>
							<th>mensaje</th>
							<th>correo</th>
							<th>area</th>
							<th>enviado</th>
							<th>action</th>
						</tr>
					</thead>
					<tbody>';
			foreach( $datos as $dato ){
				$salida.='
					<tr>
						<td>'.$dato['id'].'</td>
						<td>'.$dato['titulo_mensaje'].'</td>
						<td>'.$dato['mensaje_admin'].'</td>
						<td>'.$dato['correo'].'</td>
						<td>'.$dato['area'].'</td>
						<td>'.$dato['creado'].'</td>
						<td>
							<a href="#" fid="'.$dato['id'].'" id="'.$dato['uid'].'" title="Reply" class="text-primary replyFeedbackIcon" data-toggle="modal" data-target="#showReplayModal">
								<i class="fas fa-reply fa-lg"></i>
							</a>
						</td>
					</tr>
				';
			}
			$salida.='</tbody></table>';
			echo $salida;
		}else{
			echo '<h3 class="text-center text-secondary lead">no hay mensajes para el administrador!!!!!</h3>';
		}
	}

	if( isset($_POST['mensaje']) ){
		$uid = $admin->__Limpiar_inputs($_POST['uid']);
		$fid = $admin->__Limpiar_inputs($_POST['fid']);
		$mensaje = $admin->__Limpiar_inputs($_POST['mensaje']);
		if( $uid == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Oops error al responder contacta al administrador', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $fid == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'Oops error al responder mensaje contacta al administrador', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}
		if( $mensaje == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'mensaje es un campo requerido', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}

		$admin->enviarUsuario($uid, $mensaje);
		$admin->feedbackReply($fid);
		$mensaje = ['titulo'=>'Correcto','mensaje'=>'mensaje enviado correctamente', 'tipo'=>'success'];
		echo json_encode($mensaje);
		die();
	}


	/**
		admin-notificaciones
	**/
	if( isset($_POST['action']) && $_POST['action'] === 'adminNotification' ){
		$salida = '';
		$adminNotificaciones = $admin->adminNotifications();
		if( $adminNotificaciones ){
			foreach( $adminNotificaciones as $adminNotificacion ){
				$salida.='
					<div class="alert alert-dark" role="alert">
						<button type="button" id="'.$adminNotificacion['id'].'" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="alert-heading">New Notification</h4>
						<p class="mb-0 lead">'.$adminNotificacion['message'].' by '.$adminNotificacion['nombre'].' </p>
						<hr class="my-2">
						<p class="mb-0 float-left"><b>User E-mail: </b>'.$adminNotificacion['correo'].'</p>
						<p class="mb-0 float-right">'.$admin->tiempoAtras($adminNotificacion['created_at']).'</p>
						<div class="clearfix"></div>
					</div>';
			}
			echo $salida;
		}else{
			echo '<h3 class="text-center text-secondary lead">No hay notificaciones por el momento</h3>';
		}
	}

	if( isset($_POST['adminNotificacion_id']) ){
		$id = $admin->__Limpiar_inputs($_POST['adminNotificacion_id']);
		if( $id == '' ){
			$mensaje = ['titulo'=>'Error','mensaje'=>'error al eliminar notificacion contacte administrador', 'tipo'=>'error'];
			echo json_encode($mensaje);
			die();
		}else{
			$admin->notificacionesEstatusAdmin($id);
			$mensaje = ['titulo'=>'Correcto','mensaje'=>'notificacion eliminada', 'tipo'=>'success'];
			echo json_encode($mensaje);
			die();
		}
	}


?>