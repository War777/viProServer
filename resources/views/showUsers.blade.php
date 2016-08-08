@extends('layout')

@section('title')
	
	Mostrar usuarios

@stop


@section('content')
	
	<h1>
		
		Usuarios registrados

	</h1>

	<div class="row">
		
		@if($users)
			
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-condensed">
					
					<thead class="bg-info" align="center">

						<td>Id</td>
						<td>Nombre</td>
						<td>A. Paterno</td>
						<td>A. Materno</td>
						<td>F. Nacimiento</td>
						<td>Genero</td>
						<td>Password</td>
						<td>E-mail</td>
						<td>Telefono</td>
						<td>Whatsapp</td>
						<td>Curp</td>
						<td>Calle</td>
						<td>Google Map</td>
						<td>Token activo</td>
						<td>F. Creacion</td>
						<td>U. Modificacion</td>
						<td>F. Eliminacion</td>
						<td></td>

					</thead>

					<tbody>				

						@foreach($users as $user)

							<tr>
								
								@foreach($user as $data)
									
									<td>
										{{ $data }}
									</td>

								@endforeach

								<td>
									
									<button class="btn btn-primary btn-xs">
										<i class="glyphicon glyphicon-edit"></i>
									</button>

									<button class="btn btn-danger btn-xs">
										<i class="glyphicon glyphicon-remove"></i>
									</button>

								</td>

							</tr>

						@endforeach


					</tbody>

				</table>
				
			</div>

		
		@else

			<legend>No existen usuarios</legend>

		@endif

	</div>

@stop
