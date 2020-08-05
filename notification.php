<?php
	include_once 'assets/php/header.php';
?>


<div class="container">
	<div class="row justify-content-center my-2">
		<div class="col-lg-6 mt-4" id="AllNotificaciones"></div>
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
		
		mostrarMisNotificacione();

		function mostrarMisNotificacione(){
			$.ajax({
				url : 'assets/php/procesos.php',
				method : 'post',
				data : { action : 'misnotificaciones' },
				success : function( response ){
					$('#AllNotificaciones').html(response);
				}
			});
		}


		$('body').on('click','.close',function(e){
			e.preventDefault();
			notificacion_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/procesos.php',
				method : 'post',
				data : {  notificacion_id : notificacion_id },
				success:function(response){
					mostrarMisNotificacione();
				}
			});
		});

	});
</script>