<?php
	include_once "assets/php/admin-header.php";
?>

<div class="row">
	<div class="col-lg-12">
		<div class="card my-2 border-dark">
			<div class="card-header bg-dark text-white"><h4 class="m-0">Total de mensajes para el administrador</h4></div>
			<div class="card-body">
				<div class="table-responsive" id="mostrarFeedbacks">
					<p class="text-center text-secondary lead">Cargando mensajes...........</p>
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


<div class="modal fade" id="showReplayModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Responder mensaje</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="#" method="post" class="px-3" id="feedback-replay-form">
					<div class="form-group">
						<textarea name="mensaje" id="mensaje" class="form-control" rows="6" placeholder="Escribe tu respuesta al mensaje enviado" required></textarea>
					</div>
					<div class="form-group">
						<input type="submit" name="submit" value="Enviar Respuesta" class="btn btn-outline-success btn-block" id="feedbackreplyBtn">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


		<!-- Footer area -->
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

		mostrarFeedbacks();

		//mostrar los feedbacks
		function mostrarFeedbacks(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : {  action : 'mostrarFeedbacks' },
				success:function(response){
					$('#mostrarFeedbacks').html(response);
					$('table').DataTable({
						order : [0, 'desc']
					});
				}
			});
		}


		var uid;
		var fid;
		$('body').on('click','.replyFeedbackIcon',function(e){
			uid = $(this).attr('id');
			fid = $(this).attr('fid');
			//mandar respuesta por ajax
			$('#feedbackreplyBtn').click(function(e){
				if( $('#feedback-replay-form')[0].checkValidity() ){
					e.preventDefault();
					let mensaje = $('#mensaje').val();
					$('#feedbackreplyBtn').val('Enviando respuesta.........');
					$.ajax({
						url : 'assets/php/admin-action.php',
						method : 'post',
						data : { uid : uid, mensaje : mensaje, fid : fid },
						success :function(response){
		  					alerta = JSON.parse(response);
		  					Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
		  					$('#feedbackreplyBtn').val('Enviar Respuesta');
		  					$('#feedback-replay-form')[0].reset();
		  					$('#showReplayModal').modal('hide');
							mostrarFeedbacks();
						}
					});
				}
			});
		});


	});
	

</script>