<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')

	Chequeo rapido

@stop

@section('content')

	<h1>
		Chequeo rapido
	</h1>
		
	@if(isset($charge) && isset($merchant))
	
		@if($charge['isChecked'] == 1)
			
			{{ Own::printHtmlFeedback('Codigo ya verificado', 'bg-info') }}

		@endif
		
		<div class="row">
			
			<div class="col-xs-10">
				
				<legend>Datos</legend>

			</div>

			<div class="col-xs-2 text-right">
				
				<!-- Single button -->
				<div class="btn-group">
					
					<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					 <span class="caret"></span>
					</button>
					
					<ul class="dropdown-menu dropdown-menu-right">
						
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li><a href="#">Separated link</a></li>

					</ul>

				</div>

			</div>
			
		</div>

		

		<div class="row">
			
			<div class="col-sm-4">

				<table class="table table-bordered table-condensed table-striped table-hover">

					<tr>
						<td><b>Fecha</b></td>
						<td>{{  $charge['created_at'] }}</td>
					</tr>

					<tr>
						<td><b>Id </b></td>
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
						<td><b>Folio</b></td>
						<td>{{  str_pad($charge['id'], 6, "0", STR_PAD_LEFT) }}</td>
					</tr>

					<tr>
						<td><b> Giro </b></td>
						<td> {{ $charge['trading'] }} </td>
					</tr>

					<tr>
						<td><b> Zona </b></td>
						<td> {{ $charge['zone'] }} </td>
					</tr>

					<tr>
						<td><b> Metros </b></td>
						<td> {{ $charge['wideLength'] }} </td>
					</tr>

					<tr>
						<td><b> Chequeado </b></td>
						<td> {{ Own::boolToString($charge['trading']) }}</td>
					</tr>

				</table>

			</div>

		</div>

		<br>

		<legend>
			Observaciones
		</legend>

		<p>
			{{ $charge['notes'] }}
		</p>

	@else



	@endif

	<div class="row">
		
		<div class="col-xs-12">
			
			

		</div>

	</div>

@stop
