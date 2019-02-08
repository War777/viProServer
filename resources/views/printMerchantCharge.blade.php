<?
	
	use App\Own\Own;

?>

<head>
	<link rel="icon" href="{{ asset('public/i/villaIcon.jpg') }}">
</head>

<style>

	html {
		
		font-family: sans-serif;

	}

	
h4 {
  font-family: inherit;
  font-weight: 500;
  line-height: 1.1;
  color: inherit;
  font-size: 30px;
  margin: 0px;
}

	.bg {
		background: rgba(0, 0, 0, 0.1);
	}

	.container{
	
		

	}
	
	p {

		font-size: 10px;

	}

	table {
	  border-spacing: 0;
	  border-collapse: collapse;
	}
	
	.table {
	  width: 100%;
	  max-width: 100%;
	  /*margin-bottom: 20px;*/
	  font-size: 12px;
	  padding-left: 0px;

	}

	.table-bordered {
	  border: 1px solid #ddd;
	}
	.table-bordered > thead > tr > th,
	.table-bordered > tbody > tr > th,
	.table-bordered > tfoot > tr > th,
	.table-bordered > thead > tr > td,
	.table-bordered > tbody > tr > td,
	.table-bordered > tfoot > tr > td {
	  border: 1px solid #ddd;
	}
	.table-bordered > thead > tr > th,
	.table-bordered > thead > tr > td {
	  border-bottom-width: 2px;
	}

	.table-condensed > thead > tr > th,
	.table-condensed > tbody > tr > th,
	.table-condensed > tfoot > tr > th,
	.table-condensed > thead > tr > td,
	.table-condensed > tbody > tr > td,
	.table-condensed > tfoot > tr > td {
	  padding-left: 5px;
	  padding-top: 2px;
	  padding-bottom: 2px;
	  /*padding-bottom: 2px;*/
	}

	hr {

	  margin-top: 10px;
	  margin-bottom: 10px;
	  border: 0;
	  border-top: 1px solid #eee;

	}
</style>

<center>

<legend>
	Fiestas patronales San Miguel Villa Progreso {{ Date('Y') }}
</legend>

</center>

<p>

	Folio: {{ str_pad($charge->id, 6, "0", STR_PAD_LEFT) }}

</p>

<table class="table table-bordered">
	<tr>
		<td>
			<b>Fecha</b>
		</td>
		<td align="">
			{{ $charge->created_at }}
		</td>
		
		<td><b>Largo</b></td>
		<td align="right">{{ $charge->wideLength }} m</td>
	</tr>
	<tr>
		<td><b>Nombre</b></td>
		<td>{{ $merchant->getFullName() }}</td>

		<td><b>Frente</b></td>
		<td align="right">{{ $charge->frontLength }} m</td>

	
	</tr>
	<tr>
		<td><b>Telefono</b></td>
		<td>{{ $merchant->phone }}</td>
		
		<td align="right"></td>
		<td><b></b></td>
	
	</tr>
	<tr>
		<td><b>Origen</b></td>
		<td>{{ $merchant->isLocal == 1 ? 'Local' : 'Externo' }}</td>

		
		<td><b>Tarifa por metro</b></td>
		<td align="right">$ 
			{{
				number_format(
					$charge->meterCharge,
					2 
				) 
			}}
		</td>
	
	</tr>
	<tr>
		<td><b>Giro</b></td>
		<td>{{ $trading }}</td>

		<td><b>Tarifa de luz</b></td>
		<td align="right">$
			{{ 
				number_format(
					$charge->lightsCharge,
					2 
				)	
			}}
		</td>
		
	</tr>
	<tr>
		<td><b>Zona</b></td>
		<td>{{ $zone }}</td>
		<td><b>Total</b></td>
		<td align="right">$
			{{ 
				number_format(
					$charge->totalCharge,
					2 
				)	
			}}
		</td>
	
	</tr>
	
</table>
<br>
<table border="1">
	<tr>
		<td align="center">
			<img src="{{ $qrUrl }}/resources/qrcodes/{{ $charge['randomKey'] . '.png' }}" alt="">
		</td>
		<td style="padding: 20px;">
			
			<center>
				<b>Terminos y condiciones</b>
			</center>

			<p>
				- Favor de cortar el código Qr por el margen negro<br>
				- Favor de tener <b>SIEMPRE</b> visible el código Qr. <br>
				- La instalacion de puestos se podra hacer a partir del dia Sabado anterior al dia de inauguracion a las 10:00 horas<br>
				- La desinstalacion de puestos se debera realizar el dia Martes posterior a la clausura para habilitar la vialidad<br>
				- Queda estrictamente prohibida la re-venta de lugares.<br>
				- Favor de quitar cuerdas durante las procesiones de la imagen de San Miguel Arcángel, aquellas que obstruyan el paso tendrán que ser cortadas en el momento. <br>
				- Queda prohibido el ambulantaje con carretillas/carritos/etc. que corran el riesgo de obstruir la vialidad<br>
				<b>
					- Para conservar el lugar para las fiestas del a&ntilde;o siguiente sera necesario enviar un mensaje de texto al numero celular 4411218973 agregando el numero de folio dentro del mensaje la primera semana de Mayo del a&ntilde;o siguiente como pre-registro.
				<br>
					He leído completamente y acepto términos y condiciones anteriormente descritos.
				</b>
				<br>
				<br>

				<hr style="margin-left:40px; margin-right:40px; color:black;">
				<center>
					Firma
				</center>

			</p>
		</td>
	</tr>
</table>

<hr>

<center>
<br>
</center>

<p>

	Folio: {{ str_pad($charge->id, 6, "0", STR_PAD_LEFT) }}

</p>

<table class="table table-bordered">
	<tr>
		<td>
			<b>Fecha</b>
		</td>
		<td align="center">
			{{ $charge->created_at }}
		</td>
		
		<td><b>Largo</b></td>
		<td align="right">{{ $charge->wideLength }} m</td>
	</tr>
	<tr>
		<td><b>Nombre</b></td>
		<td>{{ $merchant->getFullName() }}</td>

		<td><b>Frente</b></td>
		<td align="right">{{ $charge->frontLength }} m</td>

	
	</tr>
	<tr>
		<td><b>Telefono</b></td>
		<td>{{ $merchant->phone }}</td>
		
		<td align="right"></td>
		<td><b></b></td>
	
	</tr>
	<tr>
		<td><b>Origen</b></td>
		<td>{{ $merchant->isLocal == 1 ? 'Local' : 'Externo' }}</td>

		
		<td><b>Tarifa por metro</b></td>
		<td align="right">$ 
			{{
				number_format(
					$charge->meterCharge,
					2 
				) 
			}}
		</td>

		

	
	</tr>
	<tr>
		<td><b>Giro</b></td>
		<td>{{ $trading }}</td>

		<td><b>Tarifa de luz</b></td>
		<td align="right">$
			{{ 
				number_format(
					$charge->lightsCharge,
					2 
				)	
			}}
		</td>
		




	</tr>
	<tr>
		<td><b>Zona</b></td>
		<td>{{ $zone }}</td>
		<td><b>Total</b></td>
		<td align="right">$ {{ number_format($charge->totalCharge, 2)}}</td>
	</tr>
	
</table>
<br>
<table border="1">
	<tr>
		<td align="center">
			<img src="{{ $qrUrl }}/resources/qrcodes/{{ $charge['randomKey'] . '.png' }}" alt="">
		</td>
		<td style="padding: 20px;">
			
			<center>
				<b>Terminos y condiciones</b>
			</center>

			<p>
				- Favor de cortar el código Qr por el margen negro<br>
				- Favor de tener <b>SIEMPRE</b> visible el código Qr. <br>
				- La instalacion de puestos se podra hacer a partir del dia Sabado anterior al dia de inauguracion a las 10:00 horas<br>
				- La desinstalacion de puestos se debera realizar el dia Martes posterior a la clausura para habilitar la vialidad<br>
				- Queda estrictamente prohibida la re-venta de lugares.<br>
				- Favor de quitar cuerdas durante las procesiones de la imagen de San Miguel Arcángel, aquellas que obstruyan el paso tendrán que ser cortadas en el momento. <br>
				- Queda prohibido el ambulantaje con carretillas/carritos/etc. que corran el riesgo de obstruir la vialidad<br>
				<b>
					- Para conservar el lugar para las fiestas del a&ntilde;o siguiente sera necesario enviar un mensaje de texto al numero celular 4411218973 agregando el numero de folio dentro del mensaje la primera semana de Mayo del a&ntilde;o siguiente como pre-registro.

					<br>
					
					He leído completamente y acepto términos y condiciones anteriormente descritos.
				</b>
				<br>
				<br>

				<hr style="margin-left:40px; margin-right:40px; color:black;">
				<center>
					Firma
				</center>

			</p>
		</td>
	</tr>
</table>