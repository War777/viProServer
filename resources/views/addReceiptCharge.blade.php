<?
	
	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Agregar cargo

@stop

@section('content')
	
	<h1>
		Agregar cargo
	</h1>
	
	<form action="addReceiptCharge" method="post" class="validate">

		{{ csrf_field() }}

		<div class="row">
			
			<div class="col-sm-4">

				<legend>Datos del comerciante</legend>
				
				<table class="table table-bordered table-condensed table-striped table-hover">
					
					<tr>
						<td><b>Id</b></td>
						<td>{{ $merchant->id }}</td>
					</tr>

					<tr>
						<td><b>Nombre</b></td>
						<td>{{ $merchant->getFullName() }}</td>
					</tr>

					<tr>
						<td><b>Es local</b></td>
						<td>{{ Own::boolToString($merchant->isLocal) }}</td>
					</tr>

					<tr>
						<td><b>Telefono</b></td>
						<td>{{ $merchant->phone }}</td>
					</tr>

					<tr>
						<td><b>Tipo de ingreso</b></td>
						<td>{{ $merchant->incomeType }}</td>
					</tr>

				</table>
				
				<input type="hidden" name="idMerchant" value="{{ $merchant->id }}">
	
				<input type="hidden" name="isLocal" value="{{ $merchant->isLocal }}">
				
				<input type="hidden" name="idTrading" value="{{ $merchant->idTrading }}">
				

			</div>
			
			<div class="col-sm-4">
				<legend>
					Recibo 2015
				</legend>

				<input type="text" id="lastMeters" name="lastMeters" class="form-control numeric chargeInput" placeholder="Metros" required value="">

				<input type="text" id="lastCharge" name="lastMetersCharge" class="form-control numeric chargeInput" placeholder="Costo" required value="">

				<input type="text" id="lastCharge" name="lastLightCharge" class="form-control numeric chargeInput" placeholder="Costo CFE" required value="">

				<h4 class="pull-right">
					<input type="hidden" id="lastMeterCharge" name="lastMeterCharge">
					<div id="lastMeterChargeLabel">
						
					</div>
				</h4>
				<textarea name="notes" class="form-control" cols="20" rows="4" placeholder="Notas"></textarea>

			</div>

			<div class="col-sm-4">
				
				<legend>
					Recibo 2016
				</legend>

				{{ Own::arrayToDropdown('Giro', 'idTrading', $tradingsValues) }}

				<br>				

				{{ Own::arrayToDropdown('Zona', 'idZone', $zonesValues) }}

				<br>

				<input type="text" id="frontLength" name="frontLength" class="form-control numeric chargeInput" placeholder="Metros de frente" required value="">

				<input type="text" id="wideLength" name="wideLength" class="form-control numeric chargeInput" placeholder="Metros de largo" required value="">

				<input type="text" id="spotLightsOral" name="lightsOral" class="form-control numeric chargeInput" placeholder="Focos" required value="">

				<input type="hidden" id="lightCost" name="lightCharge" value="{{ $lightCharge }}">

				<input type="hidden" id="currentIncrease" name="currentIncrease" value="{{ $currentIncrease }}">
					
				<table class="table table-bordered">
					<tr>
						<td><b>Costo metros</b></td>
						
						<td align="right">
							<div id="metersChargeLabel">
								
							</div>
						</td>
					</tr>
					<tr>
						<td><b>Costo cfe</b></td>
						
						<td align="right">
							<div id="lightChargeLabel">
								
							</div>
						</td>
					</tr>
					<tr>
						<td><b>Costo total</b></td>
						
						<td align="right">
							<div id="totalChargeLabel">
								
							</div>
						</td>
					</tr>
				
				</table>
				
				<br>

				<button type="submit" class="btn btn-primary pull-right">
					<i class="glyphicon glyphicon-plus"></i> Agregar
				</button>

			</div>

		</div>
	
	</form>

@stop

@section('script')
	
	<script>
		
		$(document).ready(function(){

			$('.chargeInput').keyup(function(){

				if(
					$('#lastCharge').val() != '' && $('#lastCharge').val() != '0' &&
					$('#lastMeters').val() != '' && $('#lastMeters').val() != '0' &&

					$('#frontLength').val() != '' && $('#frontLength').val() != '0' &&
					$('#wideLength').val() != '' && $('#wideLength').val() != '0' &&
					$('#spotLightsOral').val() != '' && $('#spotLightsOral').val() != '0' &&
					$('#perLightCost').val() != '' && $('#perLightCost').val() != '0'

				){

					var lastCharge = parseFloat($('#lastCharge').val());
					var lastMeters = parseFloat($('#lastMeters').val());
					var lastMeterCharge = Math.ceil(lastCharge / lastMeters);

					console.log('gogogogo');

					$('#lastMeterChargeLabel').html('<b>Costo por metro: </b> $ ' + lastMeterCharge + ".00");
					$('#lastMeterCharge').val(lastMeterCharge);

					var frontLength = parseInt($('#frontLength').val());
					var wideLength = parseInt($('#wideLength').val());

					var spotLightsOral = $('#spotLightsOral').val() != '0' ? parseInt($('#spotLightsOral').val()) : 0;
					var lightCost = parseInt($('#lightCost').val());
					var currentIncrease = parseInt($('#currentIncrease').val());

					var metersCharge = (lastMeterCharge + currentIncrease) * wideLength;
					var lightCharge = spotLightsOral * lightCost;
					var totalCharge = metersCharge + lightCharge;

					$('#metersChargeLabel').html('$ ' + metersCharge + ".00");
					$('#lightChargeLabel').html('$ ' + lightCharge + ".00");
					$('#totalChargeLabel').html('$ ' + totalCharge + ".00");

				}
				
			});

		});

	</script>

@stop