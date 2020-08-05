<?php
	session_start();
	if( ! isset($_SESSION['username']) ){
		header('location:index.php');
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<?php
		$title = basename($_SERVER['PHP_SELF'],'.php');
		$title = explode('-', $title);
		$title = ucfirst($title[1]);
	?>
	<title> <?= $title; ?> | Admin Panel </title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#open-nav').click(function(){
				$('.admin-nav').toggleClass('animate');
			});
		});
	</script>

	<style type="text/css">
		.admin-nav{
			width: 220px;
			min-height: 100vh;
			overflow: hidden;
			background-color: #343a40;
			transition: 0.3s all ease-in-out;
		}
		.admin-link{
			background-color: #343a40;
		}
		.admin-link:hover, .nav-active{
			background-color: #212529;
			text-decoration: none;
		}
		.animate{
			width: 0;
			transition: 0.3s all ease-in-out;
		}
	</style>
</head>
<body>
	
	<div class="container-fluid">
		<div class="row">
			<div class="admin-nav p-0">
				<h4 class="text-light text-center p-2">Admin Panel</h4>
				
				<div class="list-group list-group-flush">
					<a href="admin-dashboard.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) ) == 'admin-dashboard.php' ? "nav-active" : "" ?>">
						<i class="fas fa-chart-pie"></i>&nbsp;&nbsp;Escritorio
					</a>

					<a href="admin-users.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) ) == 'admin-users.php' ? "nav-active" : "" ?>">
						<i class="fas fa-user-friends"></i>&nbsp;&nbsp;Usuarios
					</a>

					<a href="admin-areas.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) ) == 'admin-areas.php' ? "nav-active" : "" ?>">
						<i class="fas fa-clipboard-list"></i>&nbsp;&nbsp;Áreas
					</a>

					<a href="admin-areasEliminadas.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) ) == 'admin-areasEliminadas.php' ? "nav-active" : "" ?>">
						<i class="fas fa-backspace"></i>&nbsp;&nbsp;Áreas Eliminadas
					</a>

					<a href="admin-userDelete.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) ) == 'admin-userDelete.php' ? "nav-active" : "" ?>">
						<i class="fas fa-user-slash"></i>&nbsp;&nbsp;Usuarios Eliminados
					</a>

					<a href="admin-feedback.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) ) == 'admin-feedback.php' ? "nav-active" : "" ?>">
						<i class="fas fa-comment"></i>&nbsp;&nbsp;Feedback
					</a>

					<a href="admin-notification.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) ) == 'admin-notification.php' ? "nav-active" : "" ?>">
						<i class="fas fa-bell "></i>&nbsp;&nbsp;Notificaciones&nbsp;<span id="checkNotification"></span>
					</a>

<!-- 					<a href="assets/php/admin-action.php?export=excel" class="list-group-item text-light admin-link">
						<i class="fas fa-table"></i>&nbsp;&nbsp;Export Usuarios
					</a> -->

<!-- 					<a href="" class="list-group-item text-light admin-link">
						<i class="fas fa-id-card"></i>&nbsp;&nbsp;Profiles
					</a> -->

<!-- 					<a href="" class="list-group-item text-light admin-link">
						<i class="fas fa-cog"></i>&nbsp;&nbsp;Settings
					</a> -->

				</div>
			</div>

			<div class="col">
				<div class="row">
					<div class="col-lg-12 bg-primary pt-2 justify-content-between d-flex">
						<a href="#" class="text-white" id="open-nav">
							<h3><i class="fas fa-bars"></i></h3>
						</a>
						<h4 class="text-light"><?= $title; ?></h4>
						<a href="assets/php/logout.php" class="text-light mt-1"><i class="fas fa-sign-out-alt"></i>&nbsp;Cerrar Sesion</a>
					</div>
				</div>