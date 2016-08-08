@extends('layout')

@section('title')
	
	Zonas

@stop

@section('content')
	
	<h1>Zonas</h1>

	<div class="row">
		
		<div class="col-sm-offset-4 col-sm-4 text-center">
			
			<form action="addZone" method="post">
				
				{{ csrf_field() }}

				<input type="text" name="description" class="form-control" placeholder="Descripci&oacute;n" required>
				<br>
				<input type="reset" value="Cancelar" class="btn btn-danger">

				<input type="submit" value="Agregar" class="btn btn-primary">

			</form>

		</div>
		
	</div>

		<div class="row">
			
			<br>

			<div class="col-sm-12">
				
				@if(count($zones) > 0)
					
					<table class="table table-bordered table-striped table-hover table-condensed">

						<thead>
							<td>Id</td>
							<td>Descripci&oacute;n</td>
							<td>F. Creacion</td>
							<td>U. Modificaci&oacute;n</td>
							<td>F. Eliminaci&oacute;n</td>
						</thead>

						<tbody>
							
							@foreach($zones as $zone)
								
								<tr>
									
									<td> {{ $zone['id'] }} </td>
									<td> {{ $zone['description'] }} </td>
									<td> {{ $zone['created_at'] }} </td>
									<td> {{ $zone['updated_at'] }} </td>
									<td> {{ $zone['deleted_at'] }} </td>

								</tr>

							@endforeach
							
						</tbody>

					</table>
	
				@else

					<h3>Sin zonas</h3>

				@endif

				

			</div>

		</div>

	</div>

@stop