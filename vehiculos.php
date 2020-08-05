<?php
	require_once "assets/php/header.php";
?>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card border-dark my-2">
				<div class="card-header bg-dark text-white">
					<h4 class="m-0">Total de vehiculos sin reservar</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive" id="freeVehiculos">
						<p class="text-center align-self-center lead">Cargando los vehiculos.........</p>
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


<div class="modal fade" id="ventanaReservar">
	<div class="modal-dialog modal-dialog-centered mw-100 w-50">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="nombreVehiculo"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<h4 class="text-center lead">Datos de la reserva</h4>
				<form action="#" class="px-3" id="reservar-carro-form">
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<label for="nombre">Nombre del vehiculo</label>
						<input type="text" name="nombre" id="nombre" class="form-control form-control-lg" disabled>
					</div>
					<div class="form-group">
						<label for="marca">Marca</label>
						<input type="text" name="marca" id="marca" class="form-control form-control-lg" disabled>
					</div>
					<div class="form-group">
						<label for="modelo">Modelo</label>
						<input type="text" name="modelo" id="modelo" class="form-control form-control-lg" disabled>
					</div>
					<div class="form-group">
						<label for="placas">Placas</label>
						<input type="text" name="placas" id="placas" class="form-control form-control-lg" disabled>
					</div>
					<div class="form-group">
						<label for="dateReserva">Día de inicio</label>
						<input type="date" name="dateReserva" id="dateReserva" class="form-control form-control-lg">
					</div>
					<div class="form-group">
						<label for="dateReservaFinal">Día Final</label>
						<input type="date" name="dateReservaFinal" id="dateReservaFinal" class="form-control form-control-lg">
					</div>
					<div class="form-control">
						<input type="submit" name="apartar_carro" id="ReservarBtn" class="btn btn-outline-success btn-block" value="Reservar Carro">
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


<script type="text/javascript">
	$(document).ready(function(){

		sinReservar();

		//funcion para mostrar todos los vehiculos sin reservar
		function sinReservar(){
			$.ajax({
				url : 'assets/php/procesos.php',
				method : 'post',
				data : { action : 'sinReservar' },
				success : function(response){
					$('#freeVehiculos').html(response);
					$('Table').DataTable({
						order : [0 , 'desc']
					});
				}
			});
		}

		$('body').on('click','.eventReservarIcon',function(e){
			reservarCarrro_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/procesos.php',
				method : 'post',
				data : { reservarCarrro_id : reservarCarrro_id },
				success:function(response){
					datos = JSON.parse(response);
					$('#id').val(datos.id);
					$('#nombre').val(datos.nombre_vehiculo);
					$('#marca').val(datos.marca);
					$('#modelo').val(datos.modelo);
					$('#placas').val(datos.placas);
				}
			});
		});


		$('#ReservarBtn').click(function(e){
			if( $('#reservar-carro-form')[0].checkValidity() ){
				e.preventDefault();
				$.ajax({
					url : 'assets/php/procesos.php',
					method : 'post',
					data : $('#reservar-carro-form').serialize()+'&action=ReservarVehiculo',
					success : function(response){
						alerta = JSON.parse(response);
						Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
						$('#ventanaReservar').modal('hide');
						$('#reservar-carro-form')[0].reset();
						sinReservar();
					}
				});
			}
		});

	});
</script>

</body>
</html>