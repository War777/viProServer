<?
	
	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Tarifas

@stop

@section('content')

	<h1>
		Tarifas
	</h1>

	{{ Own::printHtmlFeedback($message, $class) }}

	@if(count($tradings) > 0 && count($zones) > 0)


		<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
		
			<div class="modal-dialog" role="document">
				
				<div class="modal-content">
					
					<form action="addRate" method="post">

						{{ csrf_field() }}

						<div class="modal-body">
								
							<h4 class="modal-title">Tarifa</h4>

							<hr>

							<div class="row">
								
								<div class="col-sm-3">
									{{ Own::arrayToDropdown('Giro', 'idTrading', $tradings) }}
								</div>

								<div class="col-sm-3">
									{{ Own::arrayToDropdown('Zona', 'idZone', $zones) }}
								</div>

								<div class="col-sm-3">
									{{ Own::arrayToDropdown('Local', 'isLocal', $localValues) }}
								</div>

								<div class="col-sm-3">
									<input type="text" name="meterCharge" class="form-control numeric" placeholder="Tarifa" required>	
								</div>

							</div>

							<br>
							
							<textarea name="comments" class="form-control" lenght="100" placeholder="Comentarios" required></textarea>
								
							<div class="row">
								
								<div class="col-sm-12 text-right">
									
									<button type="button" class="btn btn-danger" data-dismiss="modal">
										<i class="glyphicon glyphicon-remove"></i>
										Cancelar
									</button>

									<button type="submit" value="Agregar" class="btn btn-primary">
										<i class="glyphicon glyphicon-plus"></i>
										Agregar
									</button>

								</div>

							</div>

						</div>

					</form>
				
				</div><!-- /.modal-content -->
			
			</div><!-- /.modal-dialog -->
		
		</div><!-- /.modal -->

		<button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#myModal">
			<i class="glyphicon glyphicon-plus"></i>
		</button>

		<br>
		<br>

	@else

		<legend>
			
			Favor de agregar Giros y Zonas comerciales antes de agregar una tarifa.

		</legend>

	@endif

	<? echo Own::arrayToTable($rates, 'updateRate', 'deleteRate', ['route' => '', 'glyphicon' => '', 'label' => 'label']); ?>


@stop