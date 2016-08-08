@extends('layout')

@section('title')
	Agregar usuario
@stop

@section('content')

	<h1>Agregar usuario</h1>

	<div class="row bg">

		<form action="addUser" method="post">
			
			<div class="col-sm-offset-4 col-sm-4">
				
				<input type="text" class="form-control" name="names" placeholder="Nombre(s)" value="Oscar Jesus">
				<br>
				<input type="text" class="form-control" name="lastName" placeholder="Apellido paterno" value="Resendiz">
				<br>
				<input type="text" class="form-control" name="secondName" placeholder="Apellido materno" value="Mendoza">
				<br>

				<div class="input-append date" id="dp3" data-date="" data-date-format="dd-mm-yy">
					
					<input type="text" class="" name="birthDate"  value="20-11-1991" placeholder="dd-mm-aaaa">
					
					<span class="add-on">
						<i class="glyphicon glyphicon-calendar"></i>
					</span>

				</div>
				<br>

				<input type="text" class="form-control" name="curp" placeholder="Curp" value="REMO911120HQTSNS00">
				
				<br>

				<input type="radio" name="gender" value="M" checked> Masculino

				<input type="radio" name="gender" value="F"> Femenino

				<br>
				
				<input type="email" class="form-control" name="email" placeholder="E-mail" value="oscarResendizUaq@gmail.com">
				<br>
				<input type="password" class="form-control" name="password" placeholder="Password" value="yaniviendo">
				<br>
				<input type="password" class="form-control" name="" placeholder="Confirmar password" value="yaniviendo">
				<br>
				<input type="text" class="form-control" name="phone" placeholder="Telefono" value="4411218973">
				
				<input type="checkbox" name="whatsapp" checked> Whatsapp
				
				<br>
				
				<br>
				<input type="text" class="form-control" name="street" placeholder="Calle" value="Villahermosa">
				<br>

				<input type="text" class="form-control" name="gmap" placeholder="Mapa" value=" - ">

				<br>

				<input type="reset" class="btn btn-lg btn-danger" value="Cancelar">	

				<input type="submit" class="btn btn-lg btn-primary" value="Agregar">				
				

				{{ csrf_field() }}
				

			</div>

		</form>

	</div>
@stop

@section('script')
	<script>
		$('#dp3').datepicker({
			'format' : 'yyyy-mm-dd'
		});
	</script>
@stop