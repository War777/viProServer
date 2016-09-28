<? use App\Own\Own; ?>

@extends('layout')

@section('title')
	
	Mapear espacio


@stop

@section('content')
	
	<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
	<link rel="stylesheet" href="{{ asset('public/c/bootstrap-image-gallery.css') }}">

	<h1>
		Mapear espacio
	</h1>

	@if(isset($message) && isset($class))

		{{ Own::printHtmlFeedback($message, $class) }}

	@endif

	<div class="row">
		
		<div class="col-sm-4 col-sm-offset-4">
			
			<br>

			<form action="displayChargeToMap" method="post">
				
				{{ csrf_field() }}
	
				<input type="number" name="id" placeholder="Folio" class="form-control">
				
				<div class="col-sm-12 text-right">
					
					<a href="merchants" class="btn btn-danger">
						<i class="glyphicon glyphicon-remove">
						</i>
						
					</a>

					<button type="submit" class="btn btn-primary">
						<i class="glyphicon glyphicon-search">
						</i>
						
					</button>

				</div>


			</form>

		</div>

	</div>

	@if(isset($charge))
		
		<br>
		
		<legend>Datos</legend>

		<div class="row">
			
			<div class="col-xs-4">

				<table class="table table-bordered table-condensed table-striped table-hover">

					<tr>
						<td><b>Fecha</b></td>
						<td>{{  $charge->created_at }}</td>
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
						<td>{{  str_pad($charge->id, 6, "0", STR_PAD_LEFT) }}</td>
					</tr>

					<tr>
						<td><b>Giro</b></td>
						<td align="center">${{ $charge->totalCharge }}.00</td>
					</tr>

					<tr>
						<td><b>Largo</b></td>
						<td align="center">{{ $charge->wideLength }}</td>
					</tr>

					<tr>
						<td><b>Frente</b></td>
						<td align="center">{{ $charge->frontLength }}</td>
					</tr>

					<tr>
						<td><b>Focos</b></td>
						<td align="center">{{ $charge->lightsOral }}</td>
					</tr>

					<tr>
						<td><b> Tarifa </b></td>
						<td align="center"> ${{ $charge['meterCharge'] }}.00</td>
					</tr>
					
					<tr>
						<td><b> Tarifa </b></td>
						<td align="center"> ${{ $charge['lightsCharge'] }}.00</td>
					</tr> 

					<tr>
						<td><b> Cargo </b></td>
						<td align="center"> ${{ $charge['totalCharge'] }}.00</td>
					</tr>

					<tr>
						<td><b> Evaluar </b></td>
						<td align="center"> 
							<a href="quickCheck?key={{$charge['randomKey']}}">
								ver
							</a>
						</td>
					</tr>

				</table>
				<br>
				

			</div>

		</div>
		
		<legend>Notas</legend>

		<p>
			{{ $charge['notes'] }}
		</p>

		<br>
		
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
				
				<form action="mapOutCharge" method="post" enctype="multipart/form-data">
					
					{{ csrf_field() }}

					<input type="hidden" name="idCharge" value="{{ $charge->id }}">

					<div class="col-lg-12 text-right">

						<label class="btn-file btn btn-info" id="inputLabel">
							Imagen...
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

									<a href="removeMap?id={{ $map['id'] }}&idCharge={{ $charge->id }}" class="btn btn-danger btn-xs">

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

		@else
			
			<center>

				<h4>Sin evidencias</h4>

			</center>

		@endif

	@endif

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
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
	<script src="{{ asset('public/j/bootstrap-image-gallery.js') }}"></script>

@stop
