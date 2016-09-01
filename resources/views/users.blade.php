<?
	
	use App\Own\Own;
	
?>

@extends('layout')

@section('title')
	Agregar usuario
@stop

@section('content')

	<h1>Usuarios</h1>

	@if(isset($message) && isset($class))
		
		{{ Own::printHtmlFeedback($message, $class) }}
	
	@endif


	<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
		
		<div class="modal-dialog" role="document">
			
			<div class="modal-content">
				
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				
					<h4 class="modal-title">Datos del usuario</h4>

				</div>


				<div class="modal-body">

					<form action="addUser" method="post">
						
						<div class="row">
							<div class="col-sm-4">
								<input type="text" class="form-control" name="names" placeholder="Nombre(s)" value="Oscar Jesus">
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="lastName" placeholder="Apellido paterno" value="Resendiz">
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="secondName" placeholder="Apellido materno" value="Mendoza">
							</div>
						</div>

						<div class="row">

							<div class="col-xs-4">
								
								<div class="input-append date" id="dp3" data-date="" data-date-format="dd-mm-yy">
									
									<div class="input-group">

										<input type="text" class="form-control" name="birthDate"  value="" placeholder="aaaa-mm-dd">

										<span class="input-group-addon" id="basic-addon2">

											<span class="add-on">

												<i class="glyphicon glyphicon-calendar"></i>
											
											</span>
										
										</span>
									
									</div>

								</div>

							</div>

							<div class="col-xs-4">
								
								<input type="text" class="form-control" name="curp" placeholder="Curp" value="REMO911120HQTSNS00">

							</div>

							<div class="col-xs-4">

								<input type="email" class="form-control" name="email" placeholder="E-mail" value="oscarResendizUaq@gmail.com">
								
							</div>
							
						</div>

						<div class="row">
							<div class="col-xs-4">
								<input type="password" class="form-control" name="password" placeholder="Password" value="yaniviendo">
							</div>
							<div class="col-xs-4">
								<input type="password" class="form-control" name="" placeholder="Confirmar password" value="yaniviendo">
							</div>
							<div class="col-xs-4">
								<input type="text" class="form-control" name="phone" placeholder="Telefono" value="4411218973">
							</div>
						</div>

						<div class="row">
							<div class="col-xs-4">
								<input type="radio" name="gender" value="M" checked> Masculino
								<input type="radio" name="gender" value="F"> Femenino
							</div>
							<div class="col-xs-4">
								<input type="checkbox" name="whatsapp" checked> Whatsapp
							</div>
							<div class="col-xs-4">
								<input type="text" class="form-control" name="street" placeholder="Calle" value="Villahermosa">
							</div>
						</div>

						<input type="text" class="form-control" name="gmap" placeholder="Mapa" value=" - ">

						<br>

						<legend>Privilegios</legend>

						<table class="table table-condensed table-bordered">

							@foreach($menus as $menu)
								
									<? echo Own::menuToHtml($menu) ?>
								
							@endforeach

						</table>

						<br>

						<input type="reset" class="btn btn-danger" value="Cancelar">	

						<input type="submit" class="btn btn-primary" value="Agregar">				
						

						{{ csrf_field() }}
						


					</form>

				</div>

				<div class="modal-footer">
					
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
					<button type="button" class="btn btn-primary">Save changes</button>
				
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

	<div class="row">
		
		<div class="col-sm-12">
			
			<? echo Own::arrayToTable($users, 'updateUser', 'deleteUser', ['route' => '', 'glyphicon' => '', 'label' => '']); ?>

		</div>

	</div>

	<!-- {{ Own::d(Auth::user()) }} -->

@stop

@section('script')
	<script>

		
	</script>
@stop