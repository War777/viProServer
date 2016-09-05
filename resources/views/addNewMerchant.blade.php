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

		<form action="addNewMerchant" method="post">
			
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
					
					<legend>Recibo 2016</legend>

					<input type="text" id="worFrontLength" name="frontLength" class="form-control numeric worChargeInput" placeholder="Metros de frente" required value="{{ isset($inputs['frontLength']) ? $inputs['frontLength'] : '' }}">

					<input type="text" id="worWideLength" name="wideLength" class="form-control numeric worChargeInput" placeholder="Metros de largo" required value="{{ isset($inputs['wideLength']) ? $inputs['wideLength'] : '' }}">

					<input type="text" id="lightsOral" name="lightsOral" class="form-control numeric worChargeInput" placeholder="Focos" required value="{{ isset($inputs['lightsOral']) ? $inputs['lightsOral'] : '' }}">

					<input type="hidden" id="lightCharge" name="lightCharge" value="{{ $lightCharge }}">

					<input type="hidden" id="currentIncrease" name="currentIncrease" value="{{ $currentIncrease }}">

					<input type="hidden" id="meterCharge" name="meterCharge" value="{{ isset($inputs['lastMeterCharge']) ? $inputs['lastMeterCharge'] : '' }}">

					<textarea name="notes" class="form-control" id="" cols="10" rows="">{{ isset($inputs['notes']) ? $inputs['notes'] : '' }}</textarea>

					<br>

					<table class="table table-bordered">
						<tr>
							<td><b>Tarifa por metro</b></td>
							
							<td align="right">
								<div id="meterChargeLabel">
									
								</div>
							</td>
						</tr>
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
								<div id="lightsChargeLabel">
									
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

					<div class="row">

						<div class="col-sm-12 text-right">

							<a href="merchants" class="btn btn-danger">

								<i class="glyphicon glyphicon-remove"></i> Cancelar

							</a>

							<button type="button" id="verifyButton" class="btn btn-info">

								<i class="glyphicon glyphicon-plus"></i> Verificar

							</button>

							<button type="submit" id="submitButton" class="btn btn-primary disabled">

								<i class="glyphicon glyphicon-plus"></i> Agregar

							</button>

						</div>

					</div>				

				</div>

			</div>


		</form>

		<div id="message">
		</div>

@stop

@section('script')
	
	<script>
		
		$(document).ready(function(){

			$('#verifyButton').click(function(){

				var token = $('input[name="_token"]').val();

				var frontLength = $('#worFrontLength').val();
				var wideLength = $('#worWideLength').val();
				var lightsOral = $('#lightsOral').val();
				
				var lightCharge = $('#lightCharge').val();
				var currentIncrease = $('#currentIncrease').val();

				var isLocal = $('input[name="isLocal"]').val();
				var idTrading = $('input[name=idTrading]').val();
				var idZone = $('input[name=idZone]').val();

				if(

					frontLength != '' &&
					wideLength != '' &&
					lightsOral != '' &&
					
					isLocal != '' && 
					idTrading != '' && 
					idZone != ''

					){

					$.ajax({
						async : true,
						data : {
							'_token' : token,
							'isLocal' : isLocal,
							'idTrading' : idTrading,
							'idZone' : idZone
						},
						url : 'getAjaxRate',
						type : 'post',
						dataType : 'json',
						success : function(response){
							
							if(response.rate[0] != null){

								var meterCharge = response.rate[0].meterCharge;

								$('input[name="meterCharge"]').val(meterCharge);

								var metersCharge = wideLength * meterCharge;
								var lightsCharge = lightCharge * lightsOral;
								var totalCharge = metersCharge + lightsCharge;

								$('#meterChargeLabel').html("$" + meterCharge + ".00");
								$('#metersChargeLabel').html("$" + metersCharge + ".00");
								$('#lightsChargeLabel').html("$" + lightsCharge + ".00");
								$('#totalChargeLabel').html("$" + totalCharge + ".00");

								$('#submitButton').removeClass('disabled');

							} else {

								alert('Tarifa no existente en la zona o con el origen del comerciante, favor de elegir otra zona u origen');
								$('#submitButton').addClass('disabled');
								
							}

						}, 
						error: function(error){
							$('#submitButton').addClass('disabled');
							$('#message').html(error.responseText);

						}
					});

				} else {

					alert('Favor de llenar todos los campos');
					$('#submitButton').addClass('disabled');

				}

			});
		});

	</script>

@stop