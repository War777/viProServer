<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	Cargos
@stop

@section('content')
	
	<h1>
		Usuario
	</h1>
	
	{{ Own::printHtmlFeedback($message, $class) }}

	<div class="row">
		
		<div class="col-xs-4">

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

		</div>

	</div>
	
	<br>

	<h4>
		Cargos
	</h4>
	
	<div class="row">
		
		<div class="col-sm-12 text-right">
				
			<a href="addReceiptCharge?idMerchant={{ $merchant->id }}&idTrading={{ $merchant->idTrading }}&isLocal={{ $merchant->isLocal }}" class="btn btn-primary btn-xs">
				<i class="glyphicon glyphicon-plus"></i> Con recibo
			</a>

				
			<a href="addNewCharge?idMerchant={{ $merchant->id }}&idTrading={{ $merchant->idTrading }}&isLocal={{ $merchant->isLocal }}" class="btn btn-primary btn-xs">
				<i class="glyphicon glyphicon-plus"></i> Nuevo
			</a>

			

		</div>
	</div>
	<br>
	<div class="row">

		<div class="col-sm-12">
			
			<? echo Own::arrayToTable($charges, 'updateCharge', 'deleteCharge', ['route' => 'printMerchantCharge', 'glyphicon' => 'glyphicon-print', 'label' => 'Imprimir']); ?>
			
		</div>

	</div>

	
@stop