<?
	
	use App\Own\Own;

?>

<table border="0">
	<tr>
		<td>
			Fecha:
		</td>
		<td align="center">
			{{ $merchant['created_at'] }}
		</td>
		<td rowspan="13">
			<img src="c:/xampp/htdocs/laravel/resources/qrcodes/{{ $merchant['randomKey'] . '.svg' }}" alt="">
		</td>
	</tr>
	<tr>
		<td>Nombre:</td>
		<td>{{ $merchant['firstName'] . ' ' . $merchant['lastName'] . ' ' . $merchant['names'] }}</td>
	</tr>
	<tr>
		<td>Telefono:</td>
		<td>{{ $merchant['phone'] }}</td>
	</tr>
	<tr>
		<td>Origen:</td>
		<td>{{ $merchant['isLocal'] == 1 ? 'Local' : 'Externo' }}</td>
	</tr>
	<tr>
		<td>Giro:</td>
		<td>{{ $merchant['tradingDescription'] }}</td>
	</tr>
	<tr>
		<td>Zona:</td>
		<td>{{ $merchant['zoneDescription'] }}</td>
	</tr>
	<tr>
		<td>Largo:</td>
		<td align="right">{{ $merchant['wideLength'] }} m</td>
	</tr>

	<tr>
		<td>Frente:</td>
		<td align="right">{{ $merchant['frontLength'] }} m</td>
	</tr>
	<tr>
		<td>Focos</td>
		<td align="right">{{ $merchant['spotLightsOral'] }}</td>
	</tr>
	<tr>
		<td>Tarifa base</td>
		<td align="right">$ {{ 
			number_format(
				$merchant['baseRate'],
				2  
			)
		}}</td>
	</tr>
	<tr>
		<td>Tarifa por metro</td>
		<td align="right">$ 
			{{
				number_format(
					$merchant['perMeterRate'],
					2 
				) 
			}}
		</td>
	</tr>
	<tr>
		<td>Tarifa luz por metro</td>
		<td align="right">$
			{{ 
				number_format(
					$merchant['cfeMeterRate'],
					2 
				)	
			}}
		</td>
	</tr>
	<tr>
		<td>Total</td>
		<td align="right">$
			{{ 
				number_format(
					$merchant['total'],
					2 
				)	
			}}
		</td>
	</tr>

</table>

<hr>

<table border="0">
	<tr>
		<td>
			Fecha:
		</td>
		<td align="center">
			{{ $merchant['created_at'] }}
		</td>
		<td rowspan="15">
			<img src="c:/xampp/htdocs/laravel/resources/qrcodes/{{ $merchant['randomKey'] . '.svg' }}" alt="">
		</td>
	</tr>
	<tr>
		<td>Nombre:</td>
		<td>{{ $merchant['firstName'] . ' ' . $merchant['lastName'] . ' ' . $merchant['names'] }}</td>
	</tr>
	<tr>
		<td>Telefono:</td>
		<td>{{ $merchant['phone'] }}</td>
	</tr>
	<tr>
		<td>Origen:</td>
		<td>{{ $merchant['isLocal'] == 1 ? 'Local' : 'Externo' }}</td>
	</tr>
	<tr>
		<td>Giro:</td>
		<td>{{ $merchant['tradingDescription'] }}</td>
	</tr>
	<tr>
		<td>Zona:</td>
		<td>{{ $merchant['zoneDescription'] }}</td>
	</tr>
	<tr>
		<td>Largo:</td>
		<td align="right">{{ $merchant['wideLength'] }} m</td>
	</tr>

	<tr>
		<td>Frente:</td>
		<td align="right">{{ $merchant['frontLength'] }} m</td>
	</tr>
	<tr>
		<td>Focos</td>
		<td align="right">{{ $merchant['spotLightsOral'] }}</td>
	</tr>
	<tr>
		<td>Tarifa base</td>
		<td align="right">$ {{ 
			number_format(
				$merchant['baseRate'],
				2  
			)
		}}</td>
	</tr>
	<tr>
		<td>Tarifa por metro</td>
		<td align="right">$ 
			{{
				number_format(
					$merchant['perMeterRate'],
					2 
				) 
			}}
		</td>
	</tr>
	<tr>
		<td>Tarifa luz por metro</td>
		<td align="right">$
			{{ 
				number_format(
					$merchant['cfeMeterRate'],
					2 
				)	
			}}
		</td>
	</tr>
	<tr>
		<td>Total</td>
		<td align="right">$
			{{ 
				number_format(
					$merchant['total'],
					2 
				)	
			}}
		</td>
	</tr>

</table>