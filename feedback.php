<?php
	require_once 'assets/php/header.php';
?>


<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-8 mt-3">
			<div class="card border-dark">
				<div class="card-header lead text-center bg-dark text-white">Enviar mensaje al administrador</div>
				<div class="card-body">
					<form action="#" method="post" class="px-4" id="feedback-form">
						<div class="form-group">
							<input type="text" name="tituloMensaje" placeholder="ingresa el titulo de tu mensaje" class="form-control form-control-lg rounder-0" required>
						</div>
						<div class="form-group">
							<textarea name="feedback" class="form-control-lg form-control rounder-0" placeholder="Escribe tu mensaje aquí........." rows="8" required></textarea>
						</div>
						<div class="form-group">
							<input type="submit" name="enviarMensaje" id="feedbackBtn" value="Enviar Mensaje" class="btn btn-outline-success btn-block btn-lg rounder-0">
						</div>
					</form>
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
		$('#feedbackBtn').click(function(e){
			if( $('#feedback-form')[0].checkValidity() ){
				e.preventDefault();
				$.ajax({
					url : 'assets/php/procesos.php',
					method : 'post',
					data : $('#feedback-form').serialize()+'&action=AdminMensaje',
					success:function(response){
						alerta = JSON.parse(response);
						Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
						$('#feedback-form')[0].reset();
					}
				});
			}
		});
	});
</script>