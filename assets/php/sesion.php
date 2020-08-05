<?php

	session_start();
	require_once 'auth.php';

	$cuser = new Auth();

	if( !isset($_SESSION['user']) ){
		header('location:index.php');
		die();
	}

	$ccorreo = $_SESSION['user'];

	$data = $cuser->datosInicioSesion($ccorreo);

	$cid = $data['id'];
	$cnombre = $data['nombre'];
	$capellidos = $data['apellidos'];
	$cnombreArea = $data['area'];
	$cpass = $data['password'];
	$cfoto = $data['foto'];
	$estado = $data['estatus'];
	$narea = $data['numeroArea'];
	// $carea = $data['idarea'];

	// $creado = $data['created_at'];

	// $registrdo = date('d M Y',strtotime($creado));

	$nombreCompleto = strtok($cnombre, " ");

?>