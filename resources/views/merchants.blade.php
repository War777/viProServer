<?
	
	use App\Own\Own;

?>

@extends('layout')

@section('title')

	Comerciantes

@stop

{{ Own::printHtmlFeedback($message, $class) }}

@section('content')

	<style>
		input[type=file] {

			display: none;

		}
	</style>

	<h1>
		Comerciantes
	</h1>

	<div class="row">
		
		<div class="col-sm-4 col-sm-offset-4">
			
			<form action="addMerchant" method="post">
				
				{{ csrf_field() }}

				<input type="text" name="names" class="form-control" placeholder="Nombre(s)" required value="Oscar Jesus">
				<br>
				<input type="text" name="firstName" class="form-control" placeholder="Apellido paterno" required  value="Resendiz">
				<br>
				<input type="text" name="lastName" class="form-control" placeholder="Apellido materno" required  value="Mendoza">
				<br>
				{{ Own::arrayToDropdown('Local', 'isLocal', $localValues) }}
				<br>
				<input type="text" name="phone" class="form-control numeric" placeholder="Telefono" required value="4411218973">
				<br>
				{{ Own::arrayToDropdown('Giro', 'idTrading', $tradingsValues) }}
				<br>
				{{ Own::arrayToDropdown('Zona', 'idZone', $zonesValues) }}
				<br>
				{{ Own::arrayToDropdown('Ingreso', 'incomeType', $incomeValues) }}
				<br>
				<input type="text" name="wideLength" class="form-control numeric" placeholder="Metros de largo" required value="1">
				<br>
				<input type="text" name="frontLength" class="form-control numeric" placeholder="Metros de frente" required value="1">
				<br>
				<input type="text" name="spotLightsOral" class="form-control numeric" placeholder="Focos" required value="1">
				<br>
				<input type="text" name="spotLigthsReal" class="form-control numeric" placeholder="Focos reales" required value="1">
				<br>
				<label class="btn-file btn btn-info" id="inputLabel">
					Imagen...
				</label>
					<input class="inputFile" type="file" accept="image/*" capture="camera" id="input">
				<br>
				<br>
				<input type="reset" value="Cancelar" class="btn btn-danger">
				
				<input type="submit" value="Enviar" class="btn btn-primary">
				
	

			</form>

		</div>
		
	</div>
	
	<br>

	@if(count($merchants) > 0)
	
		<div class="row">
			
			<div class="col-sm-12">
				
				<div class="table-responsive">
							
					<table class="table table-bordered table-striped table-hover table-condensed">

						<thead class="bg-info" align="center">
							<td>Id</td>
							<td>Nombre(s)</td>
							<td>A. Paterno</td>
							<td>A. Materno</td>
							<td>C. Local</td>
							<td>Telefono</td>
							<td>G. Comercial</td>
							<td>Zona</td>
							<td>T. Ingreso</td>
							<td>M. Largo</td>
							<td>M. Frente</td>
							<td>Focos</td>
							<td>Focos Reales</td>
							<td>Tarifa Base</td>
							<td>Tarifa x Metro</td>
							<td>Tarifa x luz</td>
							<td>Total</td>
							<td>Verificado</td>
							<td>Puntuacion</td>

							<td>F. Creacion</td>
							<td>U. Modificaci&oacute;n</td>
							<td>F. Eliminaci&oacute;n</td>

							<td></td>

						</thead>

						<tbody>
							
							@foreach($merchants as $merchant)
								
								<tr>
									
									<td> {{ $merchant['id'] }} </td>
									<td> {{ $merchant['names'] }} </td>
									<td> {{ $merchant['firstName'] }} </td>
									<td> {{ $merchant['lastName'] }} </td>
									<td> {{ Own::boolToString($merchant['isLocal']) }} </td>
									<td> {{ $merchant['phone'] }} </td>
									<td> {{ $merchant['tradingDescription'] }} </td>
									<td> {{ $merchant['zoneDescription'] }} </td>
									<td> {{ $merchant['incomeType'] }} </td>
									<td> {{ $merchant['wideLength'] }} </td>
									<td> {{ $merchant['frontLength'] }} </td>
									<td> {{ $merchant['spotLightsOral'] }} </td>
									<td> {{ $merchant['spotLightsReal'] }} </td>
									<td> {{ $merchant['baseRate'] }} </td>
									<td> {{ $merchant['perMeterRate'] }} </td>
									<td> {{ $merchant['cfeMeterRate'] }} </td>
									<td> {{ $merchant['total'] }} </td>
									<td> {{ Own::boolToString($merchant['isChecked']) }} </td>
									<td> {{ $merchant['score'] }} </td>

									<td> {{ $merchant['created_at'] }} </td>
									<td> {{ $merchant['updated_at'] }} </td>
									<td> {{ $merchant['deleted_at'] }} </td>
									<td>
										<form action="printReceipt" method="post">
											{{ csrf_field() }}
											<input type="hidden" name="id" value="{{$merchant['id']}}">
											<button type="submit" class="btn btn-xs btn-default">
												<i class="glyphicon glyphicon-print"></i>
											</button>
										</form>
									</td>

								</tr>

							@endforeach
							
						</tbody>

					</table>

				</div>

			</div>

		</div>

	@else
	
		<h4>
			Sin comerciantes agregados
		</h4>

	@endif

@stop

@section('script')

	<script>

		$("input[type=file]").change(function (){
			var fileName = $(this).val().split('\\').pop();
			$('#inputLabel').text(fileName);
			// $(".filename").html(fileName);
		});

		$('.btn-info').click(function(){

			$('#input').click();

		});

	</script>

@stop
