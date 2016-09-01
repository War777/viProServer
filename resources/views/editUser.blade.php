<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Editar usuario

@stop

@section('content')
	
	<h1>Editar usuario</h1>
	
	<div class="row">
		
		<div class="bg col-sm-4 col-sm-offset-4">

			<form action="updateUserData" method="post">

				<input type="hidden" name="id" value="{{ $user->id }}">
							
				<input type="text" class="form-control" name="names" placeholder="Nombre(s)" value="{{ $user->names }}">
				<br>
				<input type="text" class="form-control" name="lastName" placeholder="Apellido paterno" value="{{ $user->lastName }}">
				<br>
				<input type="text" class="form-control" name="secondName" placeholder="Apellido materno" value="{{ $user->secondName }}">
				<br>

				<div class="input-append date" id="dp3" data-date="" data-date-format="dd-mm-yy">
					
					<input type="text" class="" name="birthDate"  value="{{ $user->birthDate }}" placeholder="dd-mm-aaaa">
					
					<span class="add-on">
						<i class="glyphicon glyphicon-calendar"></i>
					</span>

				</div>
				<br>

				<input type="text" class="form-control" name="curp" placeholder="Curp" value="{{ $user->curp }}">
				
				<br>

				<input type="radio" name="gender" value="M" checked> Masculino

				<input type="radio" name="gender" value="F"> Femenino

				<br>
				
				<input type="email" class="form-control" name="email" placeholder="E-mail" value="{{ $user->email }}">
				<br>
				<input type="text" class="form-control" name="phone" placeholder="Telefono" value="{{ $user->phone }}">
				
				<input type="checkbox" name="whatsapp" checked> Whatsapp
				
				<br>
				
				<br>
				<input type="text" class="form-control" name="street" placeholder="Calle" value="{{ $user->street }}">
				<br>

				<input type="text" class="form-control" name="gmap" placeholder="Mapa" value="{{ $user->gmap }}">

				<br>


				<input type="submit" class="btn btn-primary pull-right" value="Actualizar"> <input type="reset" class="btn btn-danger pull-right" value="Cancelar">	
				

				{{ csrf_field() }}
			
			</form>
			
		</div>

	</div>

					


@stop