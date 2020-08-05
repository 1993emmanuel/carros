<?php
	require_once "assets/php/admin-header.php";
?>

<div class="row mt-3">
	<div class="col-lg-12">
		<div class="card border-dark">
			<div class="card-header bg-dark d-flex justify-content-between">
				<span class="text-light lead align-self-center">Todas al áreas de la empresa</span>
				<a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#agregarArea">
					<i class="fas fa-plus-circle fa-lg"></i>&nbsp;Agregar Area
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive" id="AllAreas">
					<p class="text-center lead mt-5">Cargando Areas...............</p>
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




<div class="modal fade" id="agregarArea">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h4 class="modal-title text-light">Agregar un area nueva</h4>
				<button type="button" class="close text-light" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="#" method="post" id="add-area-form" class="px-3">
					<div class="form-group">
						<input type="text" name="area" class="form-control form-control-lg" placeholder="Ingrese el nombre del area" required>
					</div>
					<div class="form-group">
						<input type="submit" name="addArea" id="addAreaBtn" class="btn btn-outline-success btn-block btn-lg" value="Agregar Area">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="showAreaEditModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h4 class="modal-title text-light">Editar Area</h4>
				<button type="button" class="close text-light" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="#" method="post" id="edit-area-form" class="px-3">
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<input type="text" name="areaEdit" class="form-control form-control-lg" required id="areaEdit">
					</div>
					<div class="form-control">
						<input type="submit" name="editArea" id="editAreaBtn" class="btn btn-outline-info btn-block btn-lg" value="Editar Area">
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

		mostrarAreas();

		//mostrar todos las areas de la empresa
		function mostrarAreas(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : { action : 'mostrarAreas' },
				success:function(response){
					$('#AllAreas').html(response)
					$('table').DataTable({
						order: [0,'desc']
					});
				}
			})
		}

		//evento para agregar una nueva area
		$('#addAreaBtn').click(function(e){
			if( $('#add-area-form')[0].checkValidity() ){
				e.preventDefault();
				$('#addAreaBtn').val('Guardando area........');
				$.ajax({
					url : 'assets/php/admin-action.php',
					method : 'post',
					data : $('#add-area-form').serialize()+'&action=agregarArea',
					success:function(response){
						$('#addAreaBtn').val('Agregar Area');
						$('#add-area-form')[0].reset();
						$('#agregarArea').modal('hide');
						// console.log(response);
						alerta = JSON.parse(response);
						Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
					}
				});
				mostrarAreas();
			}
		});

		//traer los datos para el editar el modal
		$('body').on('click','.areaDetailsIcon',function(e){
			e.preventDefault();
			edit_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : {  edit_id : edit_id },
				success:function(response){
					datos = JSON.parse(response)
					$('#id').val(datos.id);
					$('#areaEdit').val(datos.area);
				}
			});
		});

		//Editar el area
		$('#editAreaBtn').click(function(e){
			if( $('#edit-area-form')[0].checkValidity() ){
				e.preventDefault();
				$('#editAreaBtn').val('Editando.........');
				$.ajax({
					url : 'assets/php/admin-action.php',
					method : 'post',
					data :  $('#edit-area-form').serialize()+'&action=EditArea',
					success:function(response){
						alerta = JSON.parse(response)
						Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
						$('#edit-area-form')[0].reset();
						$('#showAreaEditModal').modal('hide');
						$('#editAreaBtn').val('Editar Area');
						mostrarAreas();
					}
				});
			}

		});

		//eliminar un area
		$('body').on('click','.deleteAreaIcon',function(e){
			e.preventDefault();
			delete_area = $(this).attr('id');
			Swal.fire({
				title : '¿Deseas eliminar el area?',
				text : 'El area sera eliminada del sistema',
				type : 'warning',
				showCancelButton : true,
		  		showCancelButton: true,
		  		confirmButtonColor: '#3085d6',
		  		cancelButtonColor: '#d33',
		  		confirmButtonText: 'Si, borrar area'
			}).then((result)=>{
				if(result){
					$.ajax({
						url : 'assets/php/admin-action.php',
						method : 'post',
						data : {  delete_area : delete_area },
						success : function(response){
							alerta = JSON.parse(response)
							Swal.fire(alerta.titulo,alerta.mensaje,alerta.tipo);
							mostrarAreas();
						}
					});
				}
			});
		});

	});


</script>