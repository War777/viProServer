<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	Menus
@stop

@section('h1')
	Menus
@stop

@section('content')

	{{ Own::printHtmlFeedback($message, $class) }}

	<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
		
		<div class="modal-dialog" role="document">
			
			<div class="modal-content">
				
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				
					<h4 class="modal-title">Agregar</h4>

				</div>

				<div class="modal-body">

					<form action="addMenu" method="post">
							
						<input type="text" class="form-control" name="name" placeholder="Nombre" value="">
						<br>
						<input type="text" class="form-control" name="target" placeholder="Objetivo" value="">
						<br>
						{{ Own::arrayToDropdown('Tiene sub menus', 'hasSubmenus', $subMenusValues) }}
						<br>
						{{ Own::arrayToDropdown('Menu padre', 'idParent', $parentsValues) }}				
						<br>
						{{ csrf_field() }}
						
						<input type="reset" class="btn btn-danger" data-dismiss="modal" value="Cancelar">	

						<input type="submit" class="btn btn-primary" value="Agregar">
					</form>

				</div>
			
			</div><!-- /.modal-content -->
		
		</div><!-- /.modal-dialog -->
	
	</div><!-- /.modal -->
	
	<br>

	<button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#myModal">
		<i class="glyphicon glyphicon-plus"></i>
	</button>

	<br>
	<br>

	<?
		echo Own::arrayToTable($menus, 'updateMenu', 'deleteMenu', '');
	?>

@stop