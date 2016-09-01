<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	
	Zonas

@stop

@section('content')
	
	<h1>Zonas</h1>
	
	{{ Own::printHtmlFeedback($message, $class) }}


	<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
		
		<div class="modal-dialog" role="document">
			
			<div class="modal-content">
				
				<form action="addZone" method="post">

					<div class="modal-body">
							
						<h4 class="modal-title">Zona</h4>

						<hr>
						
						{{ csrf_field() }}

						<input type="text" name="description" class="form-control" placeholder="Descripci&oacute;n" required>
							
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

	<? 
		echo Own::arrayToTable($zones, '', 'deleteZone', ['route'=>'','glyphicon'=>'','label'=>'']); 
	?>

@stop