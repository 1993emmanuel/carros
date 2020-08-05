<?php
	session_start();
	if( isset($_SESSION['username']) ){
		header('location:admin-dashboard.php');
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login | Admin</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
  	<style type="text/css">
  		html,body{	height: 100%;	}
  	</style>
</head>
<body class="bg-dark">


<div class="container h-100">
	<div class="row h-100 align-items-center justify-content-center">
		<div class="col-lg-5">
			<div class="card border-danger shadow-lg">
				<div class="card-header bg-danger">
					<h3 class="text-white m-0"><i class="fas fa-user-cog"></i>&nbsp;Panel Administrativo</h3>
				</div>
				<div class="card-body">
					<form action="" method="post" class="px-3" id="admin-login-form">
						<div class="form-group">
							<input type="text" name="username" class="form-control form-control-lg rounder-0" placeholder="Nombre de Usuario" required autofocus maxlength="35">
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control form-control-lg" placeholder="Ingresa la contraseña" required maxlength="100">
						</div>
						<div class="form-group">
							<input type="submit" name="admin-login" class="btn btn-outline-success btn-block btn-lg rounder-0" value="Iniciar Sesion" id="adminLoginBtn">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script type="text/javascript">
	$(document).ready(function(){
		 
		//peticion ajax para login admin
		$('#adminLoginBtn').click(function(e){
			if( $('#admin-login-form')[0].checkValidity() ){
				e.preventDefault();
				$(this).val('Espere Por Favor...........');
				$.ajax({
					url : 'assets/php/admin-action.php',
					method : 'post',
					data : $('#admin-login-form').serialize()+'&action=adminLogin',
					success: function(response){
						if( response === 'admin_login' ){
							window.location = 'admin-dashboard.php';
						}else{
							alerta = JSON.parse(response);
							Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo)
						}
						$('#adminLoginBtn').val('Iniciar Sesion');
					}
				});
			}
		});

	});
</script>
		

</body>
</html>
