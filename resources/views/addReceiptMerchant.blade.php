<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Agregar comerciante

@stop

@section('content')
	
	<h1>
		Agregar comerciante
	</h1>
	
	{{ Own::printHtmlFeedback($message, $class) }}

	<form action="addMerchantWithReceipt" method="post" class="validate">

		{{ csrf_field() }}

		<div class="row">
			
			<div class="col-sm-4">
				
				<legend>Datos del titular</legend>

				<input type="text" name="firstName" class="form-control" placeholder="Apellido paterno" required  value="{{ isset($inputs['firstName']) ? $inputs['firstName'] : '' }}">

				<input type="text" name="lastName" class="form-control" placeholder="Apellido materno" required  value="{{ isset($inputs['lastName']) ? $inputs['lastName'] : '' }}">

				<input type="text" name="names" class="form-control" placeholder="Nombre(s)" required value="{{ isset($inputs['names']) ? $inputs['names'] : '' }}">

				<input type="text" name="phone" class="form-control numeric" placeholder="Telefono" required value="{{ isset($inputs['phone']) ? $inputs['phone'] : '' }}">

				{{ Own::arrayToDropdown('Local', 'isLocal', $localValues) }}
				<br>
				{{ Own::arrayToDropdown('Giro', 'idTrading', $tradingsValues) }}
				<br>
				{{ Own::arrayToDropdown('Zona', 'idZone', $zonesValues) }}
				<br>
				{{ Own::arrayToDropdown('Ingreso', 'incomeType', $incomeValues) }}

			</div>
			
			<div class="col-sm-4">
				<legend>
					Recibo anterior
				</legend>

				<input type="text" id="lastMeters" name="lastMeters" class="form-control numeric chargeInput" placeholder="Metros" required value="{{ isset($inputs['lastMeters']) ? $inputs['lastMeters'] : '' }}">

				<input type="text" id="lastCharge" name="lastMetersCharge" class="form-control numeric chargeInput" placeholder="Costo" required value="{{ isset($inputs['lastMetersCharge']) ? $inputs['lastMetersCharge'] : '' }}">

				<input type="text" id="lastCharge" name="lastLightCharge" class="form-control numeric chargeInput" placeholder="Costo CFE" required value="{{ isset($inputs['lastLightCharge']) ? $inputs['lastLightCharge'] : '' }}">

				<h4 class="pull-right">
					<input type="hidden" id="lastMeterCharge" name="lastMeterCharge" value="{{ isset($inputs['lastMeterCharge']) ? $inputs['lastMeterCharge'] : '' }}">
					<div id="lastMeterChargeLabel" class="text-right">
						<?
							echo isset($inputs['lastMeterCharge']) ? '<b>Costo por metro: </b> $' . $inputs['lastMeterCharge'] . '.00' : '';
						?> 
						

					</div>
				</h4>
				<textarea name="notes" class="form-control" cols="20" rows="4" placeholder="Notas">{{ isset($inputs['notes']) ? $inputs['notes'] : '' }}</textarea>

			</div>

			<div class="col-sm-4">
				
				<legend>
					Recibo {{ Date('Y') }}
				</legend>

				<input type="text" id="frontLength" name="frontLength" class="form-control numeric chargeInput" placeholder="Metros de frente" required value="{{ isset($inputs['frontLength']) ? $inputs['frontLength'] : '' }}">

				<input type="text" id="wideLength" name="wideLength" class="form-control numeric chargeInput" placeholder="Metros de largo" required value="{{ isset($inputs['wideLength']) ? $inputs['wideLength'] : '' }}">

				<input type="text" id="spotLightsOral" name="lightsOral" class="form-control numeric chargeInput" placeholder="Focos" required value="{{ isset($inputs['lightsOral']) ? $inputs['lightsOral'] : '' }}">

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

					$('#lastMeterChargeLabel').html('<b>Costo por metro: </b> $ ' + lastMeterCharge + '.00');
					$('#lastMeterCharge').val(lastMeterCharge);

					var frontLength = parseInt($('#frontLength').val());
					var wideLength = parseInt($('#wideLength').val());
					var spotLightsOral = $('#spotLightsOral').val() != '0' ? parseInt($('#spotLightsOral').val()) : 0;
					var lightCost = parseInt($('#lightCost').val());
					var currentIncrease = parseInt($('#currentIncrease').val());

					var metersCharge = (lastMeterCharge + currentIncrease) * wideLength;
					var lightCharge = (spotLightsOral * lightCost);
					var totalCharge = metersCharge + lightCharge;

					$('#metersChargeLabel').html('$ ' + metersCharge + ".00");
					$('#lightChargeLabel').html('$ ' + lightCharge + ".00");
					$('#totalChargeLabel').html('$ ' + totalCharge + ".00");

				}
				
			});

		});

	</script>

@stop