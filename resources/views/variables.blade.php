<?
	use App\Own\Own;
?>

@extends('layout')

@section('title')
	
	Variables

@stop

@section('content')

	<h1>
		Variables
	</h1>

	{{ Own::printHtmlFeedback($message, $class) }}

	<div class="row">
		
		<div class="col-sm-4 col-sm-offset-4 text-center">
			
			<legend>
				Agregar
			</legend>

			<form action="addVariable" method="post">
				
				{{ csrf_field() }}

				<input type="text" name="name" class="form-control" placeholder="Nombre" required>
				<br>
				<input type="text" name="value" class="form-control" placeholder="Valor" required>
				<br>
				<input type="reset" class="btn btn-danger" value="Cancelar">

				<input type="submit" class="btn btn-primary" value="Agregar">

			</form>

		</div>

	</div>

	<br>

	<div class="row">
		
		@if(count($variables) > 0)
			
			<div class="table-responsive">
					
					<table class="table table-bordered table-striped table-hover table-condensed">

						<thead>

							<td>Id</td>
							<td>Nombre</td>
							<td>Valor</td>
							<td>F. Creacion</td>
							<td>U. Modificaci&oacute;n</td>
							<td>F. Eliminaci&oacute;n</td>

						</thead>

						<tbody>
							
							@foreach($variables as $variable)
								
								<tr>
									
									<td> {{ $variable['id'] }} </td>
									<td> {{ $variable['name'] }} </td>
									<td> {{ $variable['value'] }} </td>
									<td> {{ $variable['created_at'] }} </td>
									<td> {{ $variable['updated_at'] }} </td>
									<td> {{ $variable['deleted_at'] }} </td>

								</tr>

							@endforeach
							
						</tbody>

					</table>

				</div>

		@else
			
			<h3>
				
				No hay variables agregadas

			</h3>

		@endif

	</div>

@stop