<?php
	require_once 'assets/php/header.php';
?>


<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-10">
			<div class="card rounder-0 mt-3 border-dark">
				<div class="card-header border-dark">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<a href="#profile" class="nav-link active font-weight-bold" data-toggle="tab">Perfil</a>
						</li>
						<li class="nav-item">
							<a href="#editProfile" class="nav-link font-weight-bold" data-toggle="tab">Editar Perfil</a>
						</li>
						<li class="nav-item">
							<a href="#changePass" class="nav-link font-weight-bold" data-toggle="tab">Cambiar contraseña</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane container active" id="profile">
							<div class="card-deck">
								<div class="card border-dark">
									<div class="card-header bg-dark text-light text-center lead">USER ID <?= $cid; ?></div>
									<div class="card-body">
										<p class="card-text p-2 m-3 rounder" style="border: 1px solid #0275d8;">
											<strong>Nombre : </strong><?= $nombreCompleto; ?>
										</p>
										<p class="card-text p-2 m-3 rounder" style="border: 1px solid #0275d8;">
											<strong>Apellidos : </strong><?= $capellidos; ?>
										</p>
										<p class="card-text p-2 m-3 rounder" style="border: 1px solid #0275d8;">
											<strong>Area en que labora : </strong><?= $cnombreArea; ?>
										</p>
										<p class="card-text p-2 m-3 rounder" style="border: 1px solid #0275d8;">
											<strong>Correo Electronico : </strong><?= $ccorreo; ?>
										</p>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="card border-dark align-self-center">
									<div class="card-header bg-dark text-light text-center lead">Foto de perfil</div>
									<?php if( !$cfoto ): ?>
										<img src="assets/img/MaleAvatar.png" class="img-thumbnail img-fluid" width="408px">
									<?php else: ?>
										<img src="<?= 'assets/php/'.$cfoto; ?>" class="img-thumbnail img-fluid" width="408px">
									<?php endif; ?>
								</div>								
							</div>
							<!--  -->

							<!--  -->
						</div>
						<!--  -->
						<div class="tab-pane container fade" id="editProfile">
							<div class="card-deck">
								<div class="card border-dark align-self-center">
									<?php if( !$cfoto ): ?>
										<img src="assets/img/MaleAvatar.png" class="img-thumbnail img-fluid" width="408px">
									<?php else: ?>
										<img src="<?= 'assets/php/'.$cfoto; ?>" class="img-thumbnail img-fluid" width="408px">
									<?php endif; ?>
								</div>
								<div class="card border-dark">

									<form action="#" method="post" class="px-3 mt-2" enctype="multipart/form-data" id="profile-update-form">
										<input type="hidden" name="oldimage" value="<?= $cfoto; ?>">
										<div class="form-group m-0">
											<label for="profilePhoto" class="m-1">Cargar imagen de perfil</label>
											<input type="file" name="image" id="profilePhoto">
										</div>

										<div class="form-group mt-2">
											<input type="submit" name="editar_perfil" value="Subir Foto" class="btn btn-outline-success btn-block" id="subirFotoBtn">
										</div>

									</form>
								</div>
							</div>
						</div>
						<!--  -->
						<div class="tab-pane container fade" id="changePass">
							<div class="card-deck">
								<div class="card border-dark">
									<div class="card-header bg-dark text-white text-center lead">Cambiar Contraseña</div>
									<form action="#" method="post" class="px-3 mt-2" id="change-pass-form">
										<div class="form-group">
											<label for="curpass">Ingresa tu contraseña actual</label>
											<input type="password" name="curpass" placeholder="Contraseña Actual" class="form-control form-control-lg" id="curpass" required minlength="5">
										</div>

										<div class="form-group">
											<label for="newpass">Nueva contraseña</label>
											<input type="password" name="newpass" placeholder="Nueva Contraseña" class="form-control form-control-lg" id="newpass" required minlength="5">
										</div>

										<div class="form-group">
											<label for="cnewpass">Confirmar contraseña</label>
											<input type="password" name="cnewpass" placeholder="Confirmar Contraseña" class="form-control form-control-lg" id="cnewpass" required minlength="5">
										</div>

										<div class="form-group">
											<input type="submit" name="changepass" value="Cambiar contraseña" class="btn btn-outline-success btn-block btn-lg" id="changePassBtn">
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--  -->
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="row mt-5">
	<div class="col-lg-12">
		<div class="alert alert-dark mt-5">
			<p class="text-center text-uppercase"><strong>recuerda esta es la version 1.0</strong></p>
			<p class="text-center text-uppercase"><strong>contactanos para buscar adaptarnos a tu sistema</strong></p>
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



		//Cambiar contraseña
		$('#changePassBtn').click(function(e){
			if( $('#change-pass-form')[0].checkValidity() ){
				e.preventDefault();
				$('#changePassBtn').val('Cambiando contraseña............');
				if( $('#newpass').val() != $('#cnewpass').val() ){
					Swal.fire('Error', 'Las contraseña no coinciden favor de verificar', 'error')
				}else{
					$.ajax({
						url : 'assets/php/procesos.php',
						method : 'post',
						data : $('#change-pass-form').serialize()+'&action=ChangePassword',
						success:function(response){
							// console.log(response);
							alerta = JSON.parse(response)
							Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
							$('#changePassBtn').val('Cambiar contraseña');
							$('#change-pass-form')[0].reset();
						}
					});
				}
			}
		});

		//subir foto de perfil
		$('#profile-update-form').submit(function(e){
			e.preventDefault();
			$.ajax({
				url : 'assets/php/procesos.php',
				method: 'post',
				processData : false,
				contentType : false,
				cache : false,
				data : new FormData(this),
				success:function(response){
					location.reload();
				}
			});
		});

	});

</script>