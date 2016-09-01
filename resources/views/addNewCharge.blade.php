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

		<form action="addNewCharge" method="post">
			
			{{ csrf_field() }}

			<div class="row">
				
				<div class="col-sm-4">
					
					<legend>Datos del titular</legend>

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

						<tr>
							<td><b>Giro</b></td>
							<td>{{ $tradingDescription }}</td>
						</tr>

					</table>

					<input type="hidden" name="idMerchant" value="{{ $merchant->id }}">
		
					<input type="hidden" name="isLocal" value="{{ $merchant->isLocal }}">
					
					<input type="hidden" name="idTrading" value="{{ $merchant->idTrading }}">

					

				</div>

				<div class="col-sm-4">
					
					<legend>Recibo 2016</legend>

					{{ Own::arrayToDropdown('Zona', 'idZone', $zonesValues) }}

					<br>

					<input type="text" id="worFrontLength" name="frontLength" class="form-control numeric worChargeInput" placeholder="Metros de frente" required value="">

					<input type="text" id="worWideLength" name="wideLength" class="form-control numeric worChargeInput" placeholder="Metros de largo" required value="">

					<input type="text" id="lightsOral" name="lightsOral" class="form-control numeric worChargeInput" placeholder="Focos" required value="">

					<input type="hidden" id="lightCharge" name="lightCharge" value="{{ $lightCharge }}">

					<input type="hidden" id="currentIncrease" name="currentIncrease" value="{{ $currentIncrease }}">

					<input type="hidden" id="meterCharge" name="meterCharge">

					<textarea name="notes" class="form-control" id="" cols="10" rows=""></textarea>

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