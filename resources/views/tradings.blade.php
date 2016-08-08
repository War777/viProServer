@extends('layout')

@section('title')
	
	Giros

@stop


@section('content')

	<h1>
		Giros comerciales
	</h1>
	
	@if(isset($message))
		
		<div class="alert {{ $class }} alert-dismissible" role="alert">

			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			<strong>

				{{ $message }}
				
			</strong> 

		</div>
		
	@endif


	<div class="row">
		
		<div class="col-sm-offset-4 col-sm-4 text-center">
			
			<legend>
				Agregar
			</legend>

			<form action="addTrading" method="post">
				
				<input type="text" name="description" class="form-control" placeholder="Giro">

				<br>

				<input type="reset" value="Cancelar" class="btn btn-danger">

				<input type="submit" value="Agregar" class="btn btn-primary">
				
				{{ csrf_field() }}

			</form>

		</div>

	</div>

	<div class="row">
		
		<div class="col-sm-12">
			
			@if(count($tradings) > 0)
					
				<table class="table table-bordered table-striped table-hover table-condensed">

					<thead>
						<td>Id</td>
						<td>Descripci&oacute;n</td>
						<td>F. Creacion</td>
						<td>U. Modificaci&oacute;n</td>
						<td>F. Eliminaci&oacute;n</td>
					</thead>

					<tbody>
						
						@foreach($tradings as $trading)
							
							<tr>
								
								<td> {{ $trading['id'] }} </td>
								<td> {{ $trading['description'] }} </td>
								<td> {{ $trading['created_at'] }} </td>
								<td> {{ $trading['updated_at'] }} </td>
								<td> {{ $trading['deleted_at'] }} </td>

							</tr>

						@endforeach
						
					</tbody>

				</table>

			@else

				<h3>Sin giros comerciales</h3>

			@endif

		</div>

	</div>

@stop