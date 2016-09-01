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
	
	<div>

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#withReceipt" aria-controls="withReceipt" role="tab" data-toggle="tab">Con recibo</a></li>
		<li role="presentation"><a href="#withoutReceipt" aria-controls="withoutReceipt" role="tab" data-toggle="tab">Sin recibo</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		
		<div role="tabpanel" class="tab-pane active" id="withReceipt">
			<br>
			<form action="addMerchantWithReceipt" method="post" class="validate">

				{{ csrf_field() }}

				<div class="row">
					
					<div class="col-sm-4">
						
						<legend>Datos del titular</legend>

						<input type="text" name="firstName" class="form-control" placeholder="Apellido paterno" required  value="">

						<input type="text" name="lastName" class="form-control" placeholder="Apellido materno" required  value="">

						<input type="text" name="names" class="form-control" placeholder="Nombre(s)" required value="">

						<input type="text" name="phone" class="form-control numeric" placeholder="Telefono" required value="">

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

		</div>
		
		<div role="tabpanel" class="tab-pane" id="withoutReceipt">
			<br>
			<form action="">
				
				<div class="row">
					
					<div class="col-sm-4">
						
						<legend>Datos del titular</legend>

						<input type="text" name="firstName" class="form-control" placeholder="Apellido paterno" required  value="">

						<input type="text" name="lastName" class="form-control" placeholder="Apellido materno" required  value="">

						<input type="text" name="names" class="form-control" placeholder="Nombre(s)" required value="">

						<input type="text" name="phone" class="form-control numeric" placeholder="Telefono" required value="">

						{{ Own::arrayToDropdown('Local', 'isLocal', $localValues) }}
						<br>
						{{ Own::arrayToDropdown('Giro', 'idTrading', $tradingsValues) }}
						<br>
						{{ Own::arrayToDropdown('Zona', 'idZone', $zonesValues) }}
						<br>
						{{ Own::arrayToDropdown('Ingreso', 'incomeType', $incomeValues) }}

					</div>

					<div class="col-sm-4">
						
						<legend>Recibo 2016</legend>

						<input type="text" id="worFrontLength" name="frontLength" class="form-control numeric worChargeInput" placeholder="Metros de frente" required value="">

						<input type="text" id="worWideLength" name="wideLength" class="form-control numeric worChargeInput" placeholder="Metros de largo" required value="">

						<input type="text" id="worSpotLightsOral" name="lightsOral" class="form-control numeric worChargeInput" placeholder="Focos" required value="">

						<input type="hidden" id="lightCharge" name="lightCharge" value="{{ $lightCharge }}">

						<input type="hidden" id="currentIncrease" name="currentIncrease" value="{{ $currentIncrease }}">

						<br>

						<button type="submit" class="btn btn-primary pull-right">
							<i class="glyphicon glyphicon-plus"></i> Agregar
						</button>

					</div>

				</div>


			</form>

		</div>

	</div>

	</div>

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

					var lastCharge = parseInt($('#lastCharge').val());
					var lastMeters = parseInt($('#lastMeters').val());
					var lastMeterCharge = Math.ceil(lastCharge / lastMeters);

					$('#lastMeterChargeLabel').html('<b>Costo por metro: </b> $ ' + lastMeterCharge + ".00");
					$('#lastMeterCharge').val(lastMeterCharge);

					var frontLength = parseInt($('#frontLength').val());
					var wideLength = parseInt($('#wideLength').val());
					var spotLightsOral = parseInt($('#spotLightsOral').val());
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

			$('.worChargeInput').keyup(function(){

				var frontLength = $('#worFrontLength').val();
				var wideLength = $('#worWideLength').val();
				var spotLightsOral = $('#worSpotLightsOral').val();
				
				var lightCharge = $('#lightCharge').val();
				var currentIncrease = $('#currentIncrease').val();

				var isLocal = $('input[name="isLocal"]');
				// var idTrading = $('input[name=idTrading]').val();
				// var idZone = $('input[name=idZone]').val();

				if(

					frontLength != '' &&
					wideLength != '' &&
					spotLightsOral != '' &&
					
					lightCharge != '' &&
					currentIncrease != ''
					
					// isLocal != '' && 
					// idTrading != '' && 
					// idZone != ''

					){

					// $.ajax({
					// 	async : true,
					// 	data : {
					// 		'isLocal' : isLocal,
					// 		'idTrading' : idTrading,
					// 		'idZone' : idZone
					// 	},
					// 	url : 'getAjaxRate',
					// 	type : 'post',
					// 	dataType : 'json',
					// 	success : function(data){
					// 		alert('hecho');
					// 	}, 
					// 	error: function(error){
					// 		console.log(error);
					// 	}
					// });

				}

			});
		});

	</script>

@stop