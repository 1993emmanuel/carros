<?php
	include_once 'assets/php/admin-header.php';
?>

<div class="row mt-5 justify-content-center">
	<div class="col-lg-6 mt-4" id="todasmisnotifiaciones"></div>
</div>

<div class="row mt-5">
	<div class="col-lg-12">
		<div class="alert alert-dark mt-5">
			<p class="text-center text-uppercase"><strong>recuerda esta es la version 1.0</strong></p>
			<p class="text-center text-uppercase"><strong>contactanos para buscar adaptarnos a tu sistema</strong></p>
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

		todasmisNotificaciones();

		function todasmisNotificaciones(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : {  action : 'adminNotification' },
				success:function(response){
					$('#todasmisnotifiaciones').html(response);
				}
			})
		}

		$('body').on('click','.close',function(e){
			adminNotificacion_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : { adminNotificacion_id : adminNotificacion_id },
				success:function(response){
					todasmisNotificaciones();
  					alerta = JSON.parse(response);
  					Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
				}
			});
		});


	});
</script>