<?
	
	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Tarifas

@stop

@section('content')

	<h1>
		Tarifas
	</h1>

	{{ Own::printHtmlFeedback($message, $class) }}

	@if(count($tradings) > 0 && count($zones) > 0)
		
		<div class="row">
			
			<div class="col-sm-offset-4 col-sm-4">
				
				<legend>
				
					Agregar

				</legend>

				<form action="addRate" method="post">

					{{ csrf_field() }}
					
					{{ Own::arrayToDropdown('Giro', 'idTrading', $tradings) }}

					<br>

					{{ Own::arrayToDropdown('Zona', 'idZone', $zones) }}

					<br>

					{{ Own::arrayToDropdown('Local', 'isLocal', $localValues) }}

					<br>

					<input type="text" name="baseRate" class="form-control numeric" placeholder="Tarifa base" required>

					<br>

					<input type="text" name="perMeterRate" class="form-control numeric" placeholder="Tarifa por metro" required>	

					<br>
					
					<textarea name="comments" class="form-control" lenght="100" placeholder="Comentarios" required></textarea>
					
					<br>

					<input type="reset" value="Cancelar" class="btn btn-danger"> <input type="submit" value="Agregar" class="btn btn-primary">	

					<br>
					<br>		

				</form>

			</div>

		</div>

	@else

		<legend>
			
			Favor de agregar Giros y Zonas comerciales antes de agregar una tarifa.

		</legend>

	@endif

	<div class="row">
		
		<div class="col-sm-12">
			
			@if(count($rates) > 0)

				<div class="table-responsive">
					
					<table class="table table-bordered table-striped table-hover table-condensed">

						<thead>

							<td>Giro</td>
							<td>Zona</td>
							<td>Es local</td>
							<td>Tarifa base</td>
							<td>Tarifa por metro</td>
							<td>F. Creacion</td>
							<td>U. Modificaci&oacute;n</td>
							<td>F. Eliminaci&oacute;n</td>

						</thead>

						<tbody>
							
							@foreach($rates as $rate)
								
								<tr>
									
									<td> {{ $rate['trading'] }} </td>
									<td> {{ $rate['zone'] }} </td>
									<td> {{ Own::boolToString($rate['isLocal']) }} </td>
									<td> {{ $rate['baseRate'] }} </td>
									<td> {{ $rate['perMeterRate'] }} </td>
									<td> {{ $rate['created_at'] }} </td>
									<td> {{ $rate['updated_at'] }} </td>
									<td> {{ $rate['deleted_at'] }} </td>

								</tr>

							@endforeach
							
						</tbody>

					</table>

				</div>

			@else

				<h3>Sin tarifas agregadas</h3>

			@endif

		</div>

	</div>


@stop