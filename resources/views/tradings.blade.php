<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Giros

@stop


@section('content')

	<h1>
		Giros comerciales
	</h1>
	
	{{ Own::printHtmlFeedback($message, $class) }}

	<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
		
		<div class="modal-dialog" role="document">
			
			<div class="modal-content">
				
				<form action="addTrading" method="post">

					{{ csrf_field() }}
				
					<div class="modal-body">
							
						<h4>Giro</h4>

						<hr>
						
						<input type="text" name="description" class="form-control" placeholder="Giro">
						
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

	<br>


	<button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#myModal">
		<i class="glyphicon glyphicon-plus"></i>
	</button>

	<br>
	<br>

	<? echo Own::arrayToTable($tradings, '', 'deleteTrading', ['route' => '', 'glyphicon' => '', 'label' => '']); ?>

	

@stop