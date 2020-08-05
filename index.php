<?php
	session_start();
	if( isset($_SESSION['user']) ){
		header('location:home.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>RESERVA DE VEHICULOS || Emmanuel</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/index.css">
</head>
<body>

<div class="container">
	<div class="row justify-content-center wrapper" id="login-box">
		<div class="col-lg-10 my-auto">
			<div class="card-group myShadow">
				<div class="card rounder-left p-4" style="flex-grow: 1.4;">
					<h1 class="text-center font-weight-bold text-primary">Iniciar Sesion</h1>
					<hr>
					
					<form action="#" method="post" id="login-form" class="px-3">
						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="far fa-envelope fa-lg"></i>
								</span>
							</div>
							<input type="email" name="email" id="email" class="form-control rounder-0" placeholder="Ingresa tu correo electronico" required>
						</div>
						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="fas fa-key fa-lg"></i>
								</span>
							</div>
							<input type="password" name="password" id="password" class="form-control rounder-0" placeholder="Ingresa tu contraseña" required>
						</div>
						<div class="form-group">
							<input type="submit" name="Iniciar Sesion" id="login-btn" class="btn btn-primary btn-lg btn-block myBtn">
						</div>
					</form>

				</div>

<!-- 				<div class="card justify-content-center rounder-right myColor p-4">
					<h1 class="text-center font-weight-bold text-white">Hola amigo!!</h1>
					<hr class="my-3 bg-light myHr">
					<p class="text-center font-weight-bold text-light lead">si no tienes una cuenta puedes crear una dando clic sobre el boton</p>
					<button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" id="register-link">Crear Cuenta</button>
				</div> -->

			</div>
		</div>
	</div>

	
<!-- 	<div class="row justify-content-center wrapper" id="register-box" style="display: none;">
		<div class="col-lg-10 my-auto">
			<div class="card-group myShadow">
				<div class="card justify-content-center rounder-right myColor p-4">
					<h1 class="text-center font-weight-bold text-white">Bienvenido!!!!</h1>
					<hr class="my-3 bg-light myHr">
					<p class="text-center font-weight-bold text-light lead">Para reservar un vehiculo es necesario iniciar sesion</p>
					<button class="btn btn-outline-light btn-lg align-self-center font-weight-bold mt-4 myLinkBtn" id="login-link">
						Iniciar Sesion
					</button>
				</div>
				<div class="card rounder-right p-4" style="flex-grow: 1.4;">
					<h1 class="text-center font-weight-bold text-primary">Crear cuenta</h1>
					<hr class="my-3">
					<form action="#" method="post" class="px-3" id="register-box">
						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="far fa-user fa-lg"></i>
								</span>
							</div>
							<input type="text" name="name" id="name" class="form-control rounder-0" placeholder="Nombre Completo" required >
						</div>

						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="far fa-envelope fa-lg"></i>
								</span>
							</div>
							<input type="email" name="email" id="remail" class="form-control rounder-0" placeholder="Correo Electronico" required >
						</div>

						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="fas fa-key fa-lg"></i>
								</span>
							</div>
							<input type="password" name="password" id="rpassword" class="form-control rounder-0" placeholder="Contraseña" required minlength="5">
						</div>

						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="fas fa-key fa-lg"></i>
								</span>
							</div>
							<input type="password" name="rpassword" id="cpassword" class="form-control rounder-0" placeholder="Confirmar Contraseña" required minlength="5">
						</div>

						<div class="form-group">
							<input type="submit" value="Registrar" id="register-btn" class="btn btn-primary btn-lg btn-block myBtn">
						</div>

					</form>
				</div>
			</div>
		</div>
	</div> -->

</div>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>


<script type="text/javascript">
	
	$(document).ready(function(){
		// $("#register-link").click(function(){
		// 	$("#login-box").hide();
		// 	$("#register-box").show();
		// });
		// $("#login-link").click(function(){
		// 	$("#login-box").show();
		// 	$("#register-box").hide();
		// });

		$('#login-btn').click(function(e){
			if( $('#login-form')[0].checkValidity() ){
				e.preventDefault();
				$.ajax({
					url : 'assets/php/action.php',
					method : 'post',
					data : $('#login-form').serialize()+'&action=IniciarSesion',
					success:function(response){
						if(response==='login'){
							window.location = 'home.php';
						}else{
							alerta = JSON.parse(response);
							Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
						}
					}
				});
			}
		});

	});
	

</script>

</body>
</html>