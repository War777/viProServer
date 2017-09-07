<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Buscar por folio

@stop


@section('content')
	
	<h1>
		Buscar
	</h1>
	
	<hr>
	
	@if(isset($message) && isset($class))
		
		{{ Own::printHtmlFeedback($message, $class) }}

	@endif

	<div class="row">
		
		<div class="col-sm-4 col-sm-offset-4">
			
			<form action="searchByCharge" method="post">
				
				{{ csrf_field() }}

				<input type="text" name="id" class="form-control" placeholder="Folio" value="<? if(isset($id)){ echo $id; } ?>" >
				
				<button type="submit" class="btn btn-primary pull-right">
					<i class="glyphicon glyphicon-search"></i> Buscar
				</button>

			</form>

		</div>

	</div>

	@if(isset($charge))

		<div class="row">
			
			<div class="col-sm-12">

				<legend>
					Comerciante
				</legend>
				
				<table class="table-bordered table-condensed">
					
					<tr>
						<td>
							<b>Nombre: </b>
						</td>
						<td>
							{{ $merchant->getFullName() }}
						</td>
					</tr>

					<tr>
						<td>
							<b>Telefono: </b>
						</td>
						<td>
							{{ $merchant->phone }}
						</td>
					</tr>

					<tr>
						<td>
							<b>Es local: </b>
						</td>

						<td>
							{{ Own::boolToString($merchant->isLocal) }}
						</td>
					</tr>

				</table>

			</div>

		</div>

		<br>

		<div class="row">
		
			<div class="col-sm-12">
				
				<legend>
					Cargo
				</legend>

				<div class="table-responsive">
					
					<table class="table table-bordered table-condensed">

						<thead align="center" class="bg-info">
							<td>Folio</td>
							<td>Giro</td>
							<td>Zona</td>
							<td>A&ntilde;o</td>
							<td>Metros</td>
							<td>Costo</td>
							<td>Luz</td>
							<td>Cargo total</td>
							<td>Fecha</td>
						</thead>

						<tr>
							<td> {{ $charge->id }} </td>
							<td> {{ isset($trading->description) ? $trading->description : '' }} </td>
							<td> {{ isset($zone->description) ? $zone->description : '' }} </td>
							<td> {{ $charge->year }} </td>
							<td> {{ $charge->wideLength }} </td>
							<td> {{ $charge->meterCharge }} </td>
							<td> {{ $charge->lightsCharge }} </td>
							<td> {{ $charge->totalCharge }} </td>
							<td> {{ $charge->created_at }} </td>
						</tr>
						
					</table>

				</div>
				
				<br>
				
				<legend>
					Notas
				</legend>

				<p>
					{{ $charge->notes }}
				</p>

			</div>

		</div>	
		
		<legend>
			Recibo {{ Date('Y') }}
		</legend>

		<form action="addNewCharge" method="post" class="validate">

			{{ csrf_field() }}
			
			<input type="hidden" name="idMerchant" value="{{ $merchant->id }}">
		
			<input type="hidden" name="isLocal" value="{{ $merchant->isLocal }}">

			<div class="row">
				
				<div class="col-sm-12">

					{{ Own::arrayToDropdown('Giro', 'idTrading', $tradingsValues) }}

					<br>

					{{ Own::arrayToDropdown('Zona', 'idZone', $zonesValues) }}

					<br>
					
					<input type="hidden" id="worFrontLength" name="frontLength" class="form-control numeric worChargeInput" placeholder="Metros de frente" required value="3">

					<input type="text" id="worWideLength" name="wideLength" class="form-control numeric worChargeInput" placeholder="Metros de largo" required value="{{ $charge->wideLength }}">

					<input type="text" id="lightsOral" name="lightsOral" class="form-control numeric worChargeInput" placeholder="Focos" required value="5">

					<input type="hidden" id="lightCharge" name="lightCharge" value="{{ $lightCharge }}">
					
					<!-- Esta variable no se usa en esta rutina ni es evaluada por el archivo js para verificar el costo -->
					<input type="hidden" id="currentIncrease" name="currentIncrease" value="{{ $currentIncrease }}">

					<input type="hidden" id="meterCharge" name="meterCharge" value="{{ $charge->meterCharge}}">

					<textarea name="notes" class="form-control" id="" cols="10" rows="">Sin observaciones</textarea>

				</div>

			</div>

			<br>

			<table class="table table-bordered">
				<tr>
					<td><b>Tarifa por metro</b></td>
					
					<td align="right">
						<div id="meterChargeLabel">
							{{ $charge->meterCharge}}
						</div>
					</td>
				</tr>
				<tr>
					<td><b>Costo metros</b></td>
					
					<td align="right">
						<div id="metersChargeLabel">
							{{ $charge->meterCharge * $charge->wideLength}}
						</div>
					</td>
				</tr>
				<tr>
					<td><b>Costo cfe</b></td>
					
					<td align="right">
						<div id="lightsChargeLabel">
							{{ $charge->lightsCharge }}
						</div>
					</td>
				</tr>
				<tr>
					<td><b>Costo total</b></td>
					
					<td align="right">
						<div id="totalChargeLabel">
							{{ $charge->totalCharge }}
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

					<button type="submit" id="submitButton" class="btn btn-primary">

						<i class="glyphicon glyphicon-plus"></i> Agregar

					</button>

				</div>

			</div>

		</form>

	@endif

@stop

@section('script')

	<script src="{{ asset('public/j/verifyCharge.js') }}"></script>

@stop
