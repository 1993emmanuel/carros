<?php
	require_once "assets/php/admin-header.php";
?>

<div class="row mt-3">
	<div class="col-lg-12">
		<div class="card border-dark">
			<div class="card-header text-light lead text-center bg-dark"><h3>Areas eliminadas</h3></div>
			<div class="card-body">
				<div class="table-responsive" id="allAreasEliminadas">
					<p class="text-center lead">Cargando Areas Eliminadas..........</p>
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




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

		areasEliminadas();

		//traer todas las areas eliminadas
		function areasEliminadas(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method: 'post',
				data : { action : 'areasEliminadas' },
				success:function(response){
					$('#allAreasEliminadas').html(response);
					$('table').DataTable({
						order : [0 , 'desc']
					});
				}
			});
		}

		//restaurar un area eliminada
		$('body').on('click','.restoreAreaIcon',function(e){
			restaurarArea_id = $(this).attr('id');
			e.preventDefault();
			Swal.fire({
				title : '¿Estas seguro?',
				text : 'Estas seguro de activar esta area',
				type : 'warning',
				showCancelButton : true,
				confirmButtonColor : '#3085d6',
				cancelButtonColor : '#d33',
				confirmButtonText : 'Si, Activar area'
			}).then((result)=>{
				if(result){
					$.ajax({
						url : 'assets/php/admin-action.php',
						method : 'post',
						data : {  restaurarArea_id : restaurarArea_id },
						success : function(response){
		  					alerta = JSON.parse(response);
		  					Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
							areasEliminadas();
						}
					});
				}
			});

		});

	});
</script>