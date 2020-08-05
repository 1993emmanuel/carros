<?php

	/*
		Funcion Equivalente a auth para la conexion de la base de datos
	*/
	require_once 'config.php';

	class Admin extends Database{

		/*
			Funcion para iniciar sesion en la base de datos
		*/
		public function adminLogin($username, $password){
			$sql = "SELECT username, clave FROM administradores WHERE username=:username AND clave=:password";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute( ['username'=>$username, 'password'=>$password] );
			$datos = $stmt->fetch(PDO::FETCH_ASSOC);
			return $datos;
		}

		/*
			Funciones para la seccion de admin-Areas.php
		*/

		//funcion para traer todas las areas de la base de datos
			public function allAreas(){
				$sql = "SELECT * FROM areas WHERE estatus = 1";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $data;
			}

		//agregar una nueva Area
			public function agregarArea($area){
				$sql = "INSERT INTO areas(area) VALUES(:area)";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['area'=>$area]);
				return true;
			}

		//Traer informacion del area seleccionada
			public function traerArea($id){
				$sql = "SELECT * FROM areas WHERE id = :id AND estatus = 1";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['id'=>$id]);
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				return $data; 
			}

		//funcion para editar el area seleccionada
			public function EditarArea($area,$id){
				$sql = "UPDATE areas SET area =:area WHERE estatus = 1 AND id =:id";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['area'=>$area, 'id'=>$id]);
				return true;
			}

		//funciton para eliminar un area seleccionada
			public function EliminarArea($id,$val){
				$sql = "UPDATE areas SET estatus=$val WHERE id =:id";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['id'=>$id]);
				return true;
			}

		/**
			funciones para la seccion de empleados
		**/

		//funcion para agregar empleado en db
			public function AgregarEmpleado($area, $name, $apellidos, $correo, $usuario, $password){
				$sql = "INSERT INTO usuarios(idarea,nombre,apellidos,correo,username,password) VALUES(:area, :name, :apellidos, :correo, :username, :password)";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['area'=>$area, 'name'=>$name, 'apellidos'=>$apellidos, 'correo'=>$correo, 'username'=>$usuario, 'password'=>$password]);
				return true;
			}

		//validar que el correo ya exista
			public function CorreoUsuarioExiste($correo){
				$sql = "SELECT correo FROM usuarios WHERE correo=:correo AND estatus = 1";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['correo'=>$correo]);
				$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
				return $resultado;
			}

		//validar que el username no se repita
			public function UsernameExiste($usuario){
				$sql = "SELECT username FROM usuarios WHERE username=:username AND estatus = 1 ";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['username'=>$usuario]);
				$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
				return $resultado;
			}

		//traer todos los empleados
			public function AllEmpleados(){
				$sql = "SELECT usuarios.id,area, nombre, apellidos, correo , username, password
						FROM usuarios INNER JOIN areas ON areas.id = usuarios.idarea WHERE usuarios.estatus =1";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $registros;
			}

		//traer datos de un usuario
			public function mostrarEmpleado($id){
				$sql = "SELECT usuarios.id, areas.id as AreaID, nombre, apellidos, correo , username, password
						FROM usuarios INNER JOIN areas ON areas.id = usuarios.idarea WHERE usuarios.estatus =1 AND usuarios.id =:id ";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['id'=>$id]);
				$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
				return $resultado;
			}

		//actualizar empleado
			public function ActualizarEmpleado($id,$nombre,$apellidos,$idarea){
				$sql = "UPDATE usuarios SET  nombre=:nombre, apellidos=:apellidos, idarea=:idarea WHERE id=:id";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['nombre'=>$nombre, 'apellidos'=>$apellidos, 'idarea'=>$idarea,'id'=>$id]);
				return true;
			}

		//Actualizar contraseña
			public function ActualizarContra($id,$password){
				$sql = "UPDATE usuarios SET  password=:password WHERE id=:id";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['password'=>$password, 'id'=>$id]);
				return true;
			}

		//Eliminar usuario del sistema
			public function EliminarUsuarioSistema($id, $val){
				$sql = "UPDATE usuarios SET estatus = $val WHERE id=:id";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['id'=>$id]);
				return true;
			}

		/**
			funciones para adminuserDelete.php
		**/

		//mostrar usuarios eliminados
			public function mostrarEmpleadoEliminado(){
				$sql = "SELECT * FROM usuarios WHERE estatus = 0";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$empleadosEliminados = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $empleadosEliminados;
			}

		/**
			mostrar areas eliminadas del sistema
		**/
		public function mostrarAreasEliminadas(){
			$sql = "SELECT * FROM areas WHERE estatus=0";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}

		/****
			mostrar todos los feedback pagina admin-feedback
		***/
		public function allFeedback(){
			$sql = "SELECT feedback.id,uid,titulo_mensaje,mensaje_admin,replied, nombre,apellidos, area, correo ,feedback.created_at as creado
					FROM feedback inner join usuarios on uid = usuarios.id inner join areas on idarea = areas.id WHERE replied != 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $feedbacks;
		}

		//enviar al usuario
		public function enviarUsuario($uid, $mensaje){
			$sql = "INSERT INTO notificaciones(uid,type,message) VALUES(:uid,'user',:message)";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([ 'uid'=>$uid, 'message'=>$mensaje ]);
			return true;
		}

		//cambiar el valor del feedback
		public function feedbackReply( $fid ){
			$sql = "UPDATE feedback SET replied=1 WHERE id =:fid";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['fid'=>$fid]);
			return true;
		}

		/**
			admin-notification.php
		**/
		public function adminNotifications(){
			$sql = "SELECT  notificaciones.id, message, notificaciones.created_at, nombre, apellidos, correo FROM notificaciones
					inner join usuarios on uid = usuarios.id WHERE type = 'admin' AND notificaciones.estatus=1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$adminNotificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $adminNotificaciones;
		}

		public function notificacionesEstatusAdmin($id){
			$sql = "UPDATE notificaciones SET estatus=0 WHERE id = :id";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			return true;
		}

	}
?>