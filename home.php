<?php
	require_once 'assets/php/header.php';
?>



<div class="container">
	<div class="row mt-3">
		<div class="col-lg-8 border-dark">
			<div class="card bg-dark">
				<div class="card-header text-white lead text-center">
					<h3 class="text-center text-uppercase" id="nombreCarro"></h3>
				</div>
				<div class="card-body text-white lead text-center">
					<img src="assets/img/urban-proyecto.jpg" class="img-fluid img-thumbnail">
				</div>
			</div>
		</div>
		<div class="col-lg-4 border-dark">
			<div class="card bg-secondary text-white">
				<div class="card-header text-white text-center"><h4 class="text-center">Descripcion del vehiculo</h4></div>
				<div class="card-body">
					<p class="lead text-center">
						Este sera el vehiculo de renta que tomara los dias de inicio selecionados con anterioridad
					</p>
					<hr>
					<p id="placas" class="text-uppercase"></p>
					<p id="modelo" class="text-uppercase"></p>
					<p id="marca" class="text-uppercase"></p>
					<hr>
						<strong>DATOS DE LA RENTA</strong>
					<hr>
					<p id="fechaInicio" class="text-uppercase"></p>
					<p id="fechaFinal" class="text-uppercase"></p>
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

			//traer informacion de la renta del vehiculo

			informacionRenta();

			function informacionRenta(){
				$.ajax({
					url : 'assets/php/procesos.php',
					method : 'post',
					data : {  miRenta : 'miRenta' },
					success:function(response){
						data = JSON.parse(response);
						$('#placas').html('<strong>PLACAS : </strong>'+data.placas);
						$('#modelo').html('<strong>MODELO : </strong>'+data.modelo);
						$('#marca').html('<strong>MARCA : </strong>'+data.marca);
						$('#fechaInicio').html('<strong>Fecha de Incio : </strong>'+data.fecha_inicio);
						$('#fechaFinal').html('<strong>Fecha Final : </strong>'+data.fecha_final);
						$('#nombreCarro').html('<strong>NOMBRE DEL VEHICULO : </strong>'+data.nombre_vehiculo);
					}
				});
			}


		});
	</script>


</body>
</html>