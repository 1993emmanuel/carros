<?php
	require_once 'assets/php/admin-header.php';
?>


<div class="row mt-3">
	<div class="col-lg-12">
		<div class="card border-dark">
			<div class="card-header bg-dark d-flex justify-content-between">
				<span class="text-light lead align-self-center">Todos los empleados de la empresa</span>
				<a href="#" class="btn btn-outline-info" data-toggle="modal" data-target="#agregarEmpleado">
					<i class="fas fa-plus-circle fa-lg"></i>&nbsp;Agregar Empleado
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive" id="Allempleados">
					<p class="text-center lead mt-3">Cargando empleados........</p>
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

		<!-- Footer area -->
			</div>
		</div>
	</div>




<div class="modal fade" id="agregarEmpleado">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h4 class="modal-title text-light">Agregar nuevo empleado</h4>
				<button type="button" class="close text-light" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="#" id="add-empleado-form" class="px-3">
					<div class="row">
						<div class="col-lg-12">
							<h3 class="text-center lead">Datos Personales</h3>
							<hr>
							<div class="form-group">
								<label for="name">Nombre</label>
								<input type="text" name="name" id="name" class="form-control form-control-lg">
							</div>
							<div class="form-group">
								<label for="apellido">Apellidos</label>
								<input type="text" name="apellido" id="apellido" class="form-control form-control-lg">
							</div>
						</div>
					</div>
					<hr>
					<div class="row mt-3">
						<div class="col-lg-12">
							<h3 class="text-center lead">Datos del Usuario</h3>
							<hr>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="email">Correo</label>
								<input type="email" name="email" id="email" class="form-control form-control-lg">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="user">Usuario</label>
								<input type="text" name="user" id="user" class="form-control form-control-lg">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="password">Clave</label>
								<input type="password" name="password" id="password" class="form-control form-control-lg">
							</div>
						</div>
					</div>
					<hr>
					<div class="row mt-2">
						<div class="col-lg-12">
							<h3 class="text-center lead">Area en que trabaja</h3>
							<hr>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Seleccione un area</label>
								<select id="areas" name="areas" class="form-control form-control-lg">
								</select>
							</div>
							<div class="form-group">
								<input type="submit" name="add_user" value="Agregar Usuario" class="btn btn-outline-success btn-block" id="agregarEmpleadoBtn">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="editarEmpleado">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h4 class="modal-title text-light">Editar empleado</h4>
				<button type="button" class="close text-light" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="#" method="post" id="edit-empleado-form" class="px-3">
					<input type="hidden" name="id" id="id">
					<div class="row">
						<div class="col-lg-12">
							<h3 class="text-center lead">Datos Personales</h3>
							<hr>
							<div class="form-group">
								<label for="name">Nombre</label>
								<input type="text" name="nameEdit" id="nameEdit" class="form-control form-control-lg">
							</div>
							<div class="form-group">
								<label for="apellido">Apellidos</label>
								<input type="text" name="apellidoEdit" id="apellidoEdit" class="form-control form-control-lg">
							</div>
						</div>
					</div>
					<hr>
					<div class="row mt-2">
						<div class="col-lg-12">
							<h3 class="text-center lead">Area en que trabaja</h3>
							<hr>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Seleccione un area</label>
								<select id="areasEdit" name="areasEdit" class="form-control form-control-lg">
								</select>
							</div>
							<div class="form-group">
								<input type="submit" name="edit_user" value="Editar Usuario" class="btn btn-outline-success btn-block" id="editarEmpleadoBtn">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="editarEmpleadoAccesos">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h4 class="modal-title text-light">Editar empleado</h4>
				<button type="button" class="close text-light" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="#" method="post" id="edit-empleado-accesos-form" class="px-3">
					<input type="hidden" name="idAceso" id="idAceso">
					<h3 class="text-center lead">Datos del Usuario</h3>
					<hr>
					<div class="form-group">
						<label for="email">Correo</label>
						<input type="email" name="emailEdit" id="emailEdit" class="form-control form-control-lg" disabled>
					</div>
					<div class="form-group">
						<label for="user">Usuario</label>
						<input type="text" name="userEdit" id="userEdit" class="form-control form-control-lg" disabled>
					</div>
					<div class="form-group">
						<label for="password">Clave</label>
						<input type="password" name="passwordEdit" id="passwordEdit" class="form-control form-control-lg">
						<strong class="text-uppercase">*la clave del usuario sera cambiada.</strong>
					</div>
					<div class="form-group">
						<input type="submit" name="actualizar_clave" id="actualizar_claveBtn" class="btn btn-outline-success btn-block">
					</div>
				</form>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){

		generarSelected();

		function generarSelected(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : {  action : 'selectedAreas' },
				success:function(response){
					$('#areas').html(response);
					$('#areasEdit').html(response);
				}
			});
		}

		$('#agregarEmpleadoBtn').click(function(e){
			if( $('#add-empleado-form')[0].checkValidity() ){
				e.preventDefault();
				$('#agregarEmpleadoBtn').val('Agregando Espere porfavor...........');
				$.ajax({
					url : 'assets/php/admin-action.php',
					method : 'post',
					data : $('#add-empleado-form').serialize()+'&action=agregarEmpleado',
					success : function(response){
						$('#agregarEmpleadoBtn').val('Agregar Usuario');
						alerta = JSON.parse(response);
						Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
						$('#add-empleado-form')[0].reset();
						$('#agregarEmpleado').modal('hide');
						TraerEmpleados();
					}
				});
			}
		});

		TraerEmpleados();

		function TraerEmpleados(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : {action : 'allUsuario'},
				success : function(response){
					$('#Allempleados').html(response);
					$('table').DataTable({
						order : [0, 'desc']
					});
				}
			});
		}


		//Traer Datos
		$('body').on('click','.userEditDetailsIcon',function(e){
			e.preventDefault();
			Editarusuario_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : {  Editarusuario_id : Editarusuario_id },
				success:function(response){
					valores = JSON.parse(response);
					$('#id').val(valores.id);
					$('#nameEdit').val(valores.nombre);
					$('#apellidoEdit').val(valores.apellidos);
					$('#areasEdit').val(valores.AreaID);
				}
			});
		});

		//Editar el usuario
		$('#editarEmpleadoBtn').click(function(e){
			if( $('#edit-empleado-form')[0].checkValidity() ){
				e.preventDefault();
				$.ajax({
					url : 'assets/php/admin-action.php',
					method : 'post',
					data : $('#edit-empleado-form').serialize()+'&action=EditarEmpleado',
					success:function(response){
						alerta = JSON.parse(response);
						Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
						$('#add-empleado-form')[0].reset();
						$('#editarEmpleado').modal('hide');
						TraerEmpleados();
					}
				});
			}
		});


		$('body').on('click','.userEditCuentaIcon',function(e){
			e.preventDefault();
			EditarClaves_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data: { EditarClaves_id : EditarClaves_id },
				success:function(response){
					valores = JSON.parse(response);
					$('#idAceso').val(valores.id);
					$('#emailEdit').val(valores.correo);
					$('#userEdit').val(valores.username);
				}
			});
		})

		//Editar Contraseña
		$('#actualizar_claveBtn').click(function(e){
			if( $('#edit-empleado-accesos-form')[0].checkValidity() ){
				e.preventDefault();
				$.ajax({
					url : 'assets/php/admin-action.php',
					method : 'post',
					data : $('#edit-empleado-accesos-form').serialize()+'&action=EditarClave',
					success:function(response){
						alerta = JSON.parse(response);
						Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
						$('#edit-empleado-accesos-form')[0].reset();
						$('#editarEmpleadoAccesos').modal('hide');
						TraerEmpleados();
					}
				});
			}
		});

		//Eliminar los usuarios
		$('body').on('click','.userDeleteDetailsIcon',function(e){
			e.preventDefault();
			eliminarUsuario_id = $(this).attr('id');
			Swal.fire({
		  		title: '¿Estas seguro?',
		  		text: "Seguro que deseas eliminar este usuario del sistema",
		  		type: 'warning',
		  		showCancelButton: true,
		  		confirmButtonColor: '#3085d6',
		  		cancelButtonColor: '#d33',
		  		confirmButtonText: 'Si, Eliminar usuario'
			}).then((result) => {
		  		if (result.value) {

		  			$.ajax({
		  				url : 'assets/php/admin-action.php',
		  				method : 'post',
		  				data: { eliminarUsuario_id, eliminarUsuario_id },
		  				success:function(response){
		  					alerta = JSON.parse(response);
		  					Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
				    		TraerEmpleados();
		  				}
		  			});
		  		}
			});
		});


	});

</script>