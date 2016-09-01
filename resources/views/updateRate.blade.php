<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Tarifas

@stop

@section('content')

	<h1>
		Actualizar tarifa
	</h1>
	
	<div class="row">
		
		<div class="col-sm-12">
			
			<form action="updateRate" method="post">

				{{ csrf_field() }}

					<div class="row">
						
						<div class="col-sm-4 col-sm-offset-4">
							
							<h4> {{ $rate['trading'] }} </h4>

							<input type="hidden" name="idTrading" value="{{ $rate['idTrading'] }}">

							<h4> {{ $rate['zone'] }} </h4>

							<input type="hidden" name="idZone" value="{{ $rate['idZone'] }}">

							<h4> {{ Own::boolToString($rate['isLocal'])  }} </h4>

							<input type="hidden" name="isLocal" value="{{ $rate['isLocal'] }}">

							<input type="text" name="meterCharge" class="form-control numeric" placeholder="Tarifa" required value="{{ $rate['meterCharge'] }}">

							<textarea name="comments" class="form-control" lenght="100" placeholder="Comentarios">{{ $rate['comments'] }}</textarea>

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

					</div>

				</div>

			</form>

		</div>

	</div>		

@stop