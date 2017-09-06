
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