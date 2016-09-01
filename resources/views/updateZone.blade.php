<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Actualizar zona

@stop

@section('content')

	<h1>
		Actualizar zona
	</h1>
	
	<div class="row">
		
		<div class="col-sm-12">
			
			<form action="updateZone" method="post">

				{{ csrf_field() }}

					<div class="row">
						
						<div class="col-sm-4 col-sm-offset-4">

							<input type="text" name="description" class="form-control" placeholder="Tarifa" required value="{{ $zone['description'] }}">

							<div class="row">
								
								<div class="col-sm-12 text-right">
									
									<button type="button" class="btn btn-danger" data-dismiss="modal">
										<i class="glyphicon glyphicon-remove"></i>
										Cancelar
									</button>

									<button type="submit" value="Agregar" class="btn btn-primary">
										<i class="glyphicon glyphicon-plus"></i>
										Agregar
									</button>

								</div>

							</div>

						</div>

					</div>

				</div>

			</form>

		</div>

	</div>		

@stop