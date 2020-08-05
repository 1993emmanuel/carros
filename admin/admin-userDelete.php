<?php
	require_once 'assets/php/admin-header.php';
?>


<div class="row mt-3">
	<div class="col-lg-12">
		<div class="card border-dark">
			<div class="card-header bg-dark"><h3 class="text-light text-center lead">Usuarios dados de baja del sistema</h3></div>
			<div class="card-body">
				<div class="table-responsive" id="usuariosEliminadosSistema">
					<p class="text-center lead">Cargando usuarios eliminados del sistema...........</p>
				</div>
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
		//funcion para mostrar todos los usuarios eliminados

		usuariosEliminados();

		function usuariosEliminados(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : {  action : 'mostrarEliminados' },
				success:function(response){
					$('#usuariosEliminadosSistema').html(response);
					$('table').DataTable({
						order : [0 ,'desc']
					});
				}
			});
		}

		//Alerta para resutaurar usuario
		$('body').on('click','.restoreUserIcon',function(e){
			restaurarUser_id = $(this).attr('id');
			e.preventDefault();
			Swal.fire({
		  		title: '¿Estas seguro?',
		  		text: "Deseas restaurar el usuario seleccionado",
		  		type: 'warning',
		  		showCancelButton: true,
		  		confirmButtonColor: '#3085d6',
		  		cancelButtonColor: '#d33',
		  		confirmButtonText: 'Si, Restaurar usuario'
			}).then((result) => {
		  		if (result.value) {

		  			$.ajax({
		  				url : 'assets/php/admin-action.php',
		  				method : 'post',
		  				data: { restaurarUser_id, restaurarUser_id },
		  				success:function(response){
		  					alerta = JSON.parse(response);
		  					Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
				    		usuariosEliminados();
		  				}
		  			});
		  		}
			});
		});


	});
</script>