<?php

	/**
		Este archivo contiene todos los querys en modo de funcion para que asi se puedan 
		realizar las operaciones en la base de datos.
	**/

	require_once 'config.php';

	class Auth extends Database{


		/*
			funciones para iniciar sesion y validaciones de cuenta...
		*/

		//iniciar sesion
			public function iniciarSesion($correo){
				$sql = "SELECT correo, password FROM usuarios WHERE correo=:correo AND estatus=1";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['correo'=>$correo]);
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				return $row;
			}

		//Datos del inicio de sesion
			public function datosInicioSesion($correo){
				// $sql = "SELECT * FROM usuarios WHERE correo = :correo AND estatus=1";
				$sql = "SELECT usuarios.id,areas.id as numeroArea ,area, nombre, apellidos, correo, username, password, usuarios.estatus, foto,password FROM usuarios INNER JOIN areas ON idarea = areas.id WHERE correo=:correo AND usuarios.estatus=1";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['correo'=>$correo]);
				$datos = $stmt->fetch(PDO::FETCH_ASSOC);
				return $datos;
			}

		/*
			Funcion para mostrar todos los vehiculos sin reservar del sistema.
		*/
		public function vehiculosSinReservar(){
			$sql = "SELECT * FROM vehiculos WHERE estatus = 1 AND apartado = 0";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//traer datos del vehiculo
		public function traerDatosVehiculo($id){
			$sql = "SELECT * FROM vehiculos WHERE estatus = 1 AND id =:id AND apartado = 0";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}
		
		//reservar el vehiculo
		public function reservarVehiculo( $idvehiculo, $iduser, $idarea, $fechaInicio, $fechaFinal ){
			$sql = "INSERT INTO renta(idvehiculo, iduser, idarea, fecha_inicio, fecha_final) VALUES( :idvehiculo, :iduser, :idarea, :fecha_inicio, :fecha_final )";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['idvehiculo'=>$idvehiculo, 'iduser'=>$iduser, 'idarea'=>$idarea , 'fecha_inicio'=>$fechaInicio, 'fecha_final'=>$fechaFinal ]);
			return true;
		}

		//reserva pendiente
		public function reservaPendiente( $iduser ){
			$sql = "SELECT * FROM renta WHERE idrenta = :idrenta AND estado_renta = 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['idrenta'=>$iduser]);
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//apartar vehiculo
		public function apartarVehiculo( $id, $val ){
			$sql = "UPDATE vehiculos SET apartado=$val WHERE id=:id AND estatus = 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			return true;
		}


		/**
			Secion de profile.php
		**/

		//funcion para cambiar las contraseñas del usuario
		public function cambiarContrasena($password ,$id){
			$sql = "UPDATE usuarios SET password=:password WHERE id=:id AND estatus = 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['password'=>$password, 'id'=>$id]);
			return true;
		}

		public function subirFoto($foto,$id){
			$sql = "UPDATE usuarios SET foto=:foto WHERE id =:id AND estatus = 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['foto'=>$foto, 'id'=>$id]);
			return true;
		}


		/**
			pagina home.php
		**/
		public function miRenta($id){
			$sql = "SELECT placas,modelo,marca,fecha_inicio, fecha_final, nombre_vehiculo FROM renta inner join vehiculos On idvehiculo = id 
					WHERE iduser=:id";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		/***
			pagina de feedback
		**/
		public function feedback($uid,$titulo,$mensaje){
			$sql = "INSERT INTO feedback(uid,titulo_mensaje,mensaje_admin) VALUES(:uid, :titulo_mensaje, :mensaje_admin)";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['uid'=>$uid, 'titulo_mensaje'=>$titulo, 'mensaje_admin'=>$mensaje]);
			return true;
		}


		/***
			mostrar todas las notificaciones
		****/
		public function mostrarTodasMisNotificaciones($id){
			$sql = "SELECT * FROM notificaciones WHERE uid =:uid AND type = 'user' AND estatus = 1 ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['uid'=>$id]);
			$todas = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $todas;
		}

		public function eliminarAdministrador($id){
			$sql = "UPDATE notificaciones SET estatus=0 WHERE id=:id AND type='user'";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			return true;
		}

		/**
			agregar las notificaciones
		**/
		public function notifiacion($uid, $type , $mensaje){
			$sql = "INSERT INTO notificaciones(uid, type, message) VALUES(:uid, :type, :message)";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['uid'=>$uid, 'type'=>$type,'message'=>$mensaje]);
			return true;
		}

	}


?>