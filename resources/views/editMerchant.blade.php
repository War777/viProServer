<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Agregar comerciante

@stop

@section('content')
	
	<h1>
		Editar comerciante
	</h1>

	<form action="updateMerchant" method="post" class="validate">
		
		{{ csrf_field() }}

		<div class="row">
			
			<div class="col-sm-4">

				<input type="text" name="firstName" class="form-control" placeholder="Apellido paterno" required  value="{{ $merchant->firstName }}">

				<input type="text" name="lastName" class="form-control" placeholder="Apellido materno" required  value="{{ $merchant->lastName }}">

				<input type="text" name="names" class="form-control" placeholder="Nombre(s)" required value="{{ $merchant->names }}">

				<input type="hidden" name="phone" class="form-control numeric" placeholder="Telefono" required value="{{ $merchant->phone }}">

				{{ Own::arrayToDropdown('Local', 'isLocal', $localValues) }}
				<br>
				{{ Own::arrayToDropdown('Giro', 'idTrading', $tradingsValues) }}
				<br>
				{{ Own::arrayToDropdown('Ingreso', 'incomeType', $incomeValues) }}

				<div class="row">

					<div class="col-sm-12 text-right">

						<a href="merchants" class="btn btn-danger">

							<i class="glyphicon glyphicon-remove"></i> Cancelar

						</a>

						<button type="submit" id="submitButton" class="btn btn-primary">

							<i class="glyphicon glyphicon-ok"></i> Actualizar

						</button>

					</div>

				</div>	

			</div>

	</form>

@stop
