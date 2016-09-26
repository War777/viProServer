<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')

	Chequeo rapido

@stop

@section('content')
	
	<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
	<link rel="stylesheet" href="{{ asset('public/c/bootstrap-image-gallery.css') }}">

	<h1>
		Chequeo rapido
	</h1>
		
	@if(isset($charge) && isset($merchant))
	
		@if($charge['isChecked'] == 1)
			
			{{ Own::printHtmlFeedback('Codigo ya verificado, favor de asegurar su autenticidad', 'bg-danger') }}

		@endif
		
		<div class="row">
			
			<div class="col-xs-12">
				
				<legend>Datos</legend>

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
			Evaluaci&oacute;n
		</legend>
		
		<form action="evaluateCharge" method="post">

			{{ csrf_field() }}

			<input type="hidden" name="id" value="{{ $charge['id'] }}" class="dropDownValue">

			<div class="row">

				<div class="col-xs-6">

					<div class="dropdown" style="display:inline;">

				<!-- Single button -->
						<div class="btn-group">
							
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<input type="hidden" name="score" class="dropDownValue" value="{{$charge['score']}}">
								<span class="dropDownLabel">{{$charge['score']}}</span>

							 <span class="caret"></span>
							</button>
							
							<ul class="dropdown-menu">
								
								<li><a id="5" href="#" class="dropDownOption">5</a></li>
								<li><a id="4" href="#" class="dropDownOption">4</a></li>
								<li><a id="3" href="#" class="dropDownOption">3</a></li>
								<li><a id="2" href="#" class="dropDownOption">2</a></li>
								<li><a id="1" href="#" class="dropDownOption">1</a></li>

							</ul>

						</div>

					</div>
					
				</div>

				<div class="col-xs-6 text-right">
					
					<button type="submit" class="btn btn-primary">
						
						<i class="glyphicon glyphicon-floppy-saved"></i>

					</button>
	
				</div>

			</div>

			<input type="hidden" name="key" value="{{ $charge['randomKey'] }}">

			<br>

			<textarea name="notes" class="form-control" id="" cols="30" rows="10">{{ $charge['notes'] }}</textarea>
			
		</form>

		</p>

		<hr>

		<style>

			input[type=file] {

				display: none;

			}
			
		</style>


		<div class="row">
	
			<div class="col-lg-12">

				<legend>
					Evidencias
				</legend>
				
				<form action="mapOutChargeByQr" method="post" enctype="multipart/form-data">
					
					{{ csrf_field() }}

					<input type="hidden" name="idCharge" value="{{ $charge['id'] }}">
					<input type="hidden" name="key" value="{{ $charge['randomKey'] }}">


					<div class="col-lg-12 text-right">

						<label class="btn-file btn btn-info" id="inputLabel">
							<i class="glyphicon glyphicon-camera"></i>
						</label>
						
						<button type="submit" id="submit" class="btn btn-primary disabled">
							
							<i class="glyphicon glyphicon-plus">
							</i>
							
						</button>

						<input name="map" class="inputFile" type="file" accept="image/*" capture="camera" id="input">

					</div>

				</form>

			</div>

		</div>

		<br>

		@if(count($maps) > 0)
			
					<div id="links">
			
			@foreach($maps as $map)
				
				<!-- <div class="row"> -->

						
						<div class="col-sm-2">
							
							<div class="thumbnail">
							      
								<div class="caption pull-right">

									<a href="removeMapByQr?id={{ $map['id'] }}&idCharge={{ $charge['id'] }}&key={{ $charge['randomKey'] }}" class="btn btn-danger btn-xs">

										<i class="glyphicon glyphicon-remove"></i>

									</a>

								</div>

								<a href="resources/maps/{{ $map['file'] }}" class="thumbnail" data-gallery>
								
									<img src="resources/maps/{{ $map['file'] }}" class="img-responsive">
									
								</a>

						    </div>

						</div>

				<!-- </div> -->
				
				<!-- <hr> -->
			
			@endforeach
					</div>

		<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
		<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="false">
		    <!-- The container for the modal slides -->
		    <div class="slides"></div>
		    <!-- Controls for the borderless lightbox -->
		    <h3 class="title"></h3>
		    <a class="prev">‹</a>
		    <a class="next">›</a>
		    <a class="close">×</a>
		    <a class="play-pause"></a>
		    <ol class="indicator"></ol>
		    <!-- The modal dialog, which will be used to wrap the lightbox content -->
		    <div class="modal fade">
		        <div class="modal-dialog modal-lg">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" aria-hidden="true">&times;</button>
		                    <h4 class="modal-title"></h4>
		                </div>
		                <div class="modal-body next"></div>
		                <div class="modal-footer">
		                    <button type="button" class="btn btn-default pull-left prev">
		                        <i class="glyphicon glyphicon-chevron-left"></i>
		                        Previous
		                    </button>
		                    <button type="button" class="btn btn-primary next">
		                        Next
		                        <i class="glyphicon glyphicon-chevron-right"></i>
		                    </button>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		@else
			
			<center>

				<h4>Sin evidencias</h4>

			</center>

		@endif

	@else

		{{ Own::printHtmlFeedback('Folio no existente', 'bg-danger') }}

	@endif

@stop

@section('script')

	<script>

		$("input[type=file]").change(function (){
			
			var fileName = $(this).val().split('\\').pop();
			
			$('#inputLabel').text(fileName);

			$('#submit').removeClass('disabled');
			
		});

		$('.btn-info').click(function(){

			$('#input').click();

		});

	</script>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Bootstrap JS is not required, but included for the responsive demo navigation and button states -->
	<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
	<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
	<script src="{{ asset('public/j/bootstrap-image-gallery.js') }}"></script>

@stop
