<?
	
	use App\Own\Own;

?>

@extends('layout')

@section('title')

	Comerciantes

@stop



@section('content')
		

	<style>

		input[type=file] {

			display: none;

		}
		
	</style>

	<h1>
		Comerciantes
	</h1>

	{{ Own::printHtmlFeedback($message, $class) }}

<!-- 	<div class="row">
		
		<div class="col-sm-4 col-sm-offset-4">
			
			<form action="addMerchant" method="post">
				
				{{ csrf_field() }}

				<input type="text" name="names" class="form-control" placeholder="Nombre(s)" required value="">
				<br>
				<input type="text" name="firstName" class="form-control" placeholder="Apellido paterno" required  value="">
				<br>
				<input type="text" name="lastName" class="form-control" placeholder="Apellido materno" required  value="">
				<br>
				
				<br>
				<input type="text" name="phone" class="form-control numeric" placeholder="Telefono" required value="">
				<br>
				
				<br>
				<input type="text" name="wideLength" class="form-control numeric" placeholder="Metros de largo" required value="">
				<br>
				<input type="text" name="frontLength" class="form-control numeric" placeholder="Metros de frente" required value="">
				<br>
				<input type="text" name="spotLightsOral" class="form-control numeric" placeholder="Focos" required value="">
				<br>
				<input type="text" name="spotLigthsReal" class="form-control numeric" placeholder="Focos reales" required value="">
				<br>
				<label class="btn-file btn btn-info" id="inputLabel">
					Imagen...
				</label>
					<input class="inputFile" type="file" accept="image/*" capture="camera" id="input">
				<br>
				<br>
				<input type="reset" value="Cancelar" class="btn btn-danger">
				
				<input type="submit" value="Enviar" class="btn btn-primary">

			</form>

		</div>
		
	</div> -->
	
	<br>

	<div class="row">
		
		<div class="col-sm-12 text-right">
			
			<a href="addReceiptMerchant" class="btn btn-xs btn-primary">
				<i class="glyphicon glyphicon-plus"></i>
				Con recibo
			</a>

			<a href="addNewMerchant" class="btn btn-xs btn-primary">
				<i class="glyphicon glyphicon-plus"></i>
				Nuevo
			</a>

		</div>

	</div>
	
	<br>
	
	<? echo Own::arrayToTable($merchants, 'updateMerchant', 'deleteMerchant', ['route' => 'displayMerchantCharges', 'glyphicon' => 'glyphicon-usd', 'label' => 'Cargos']); ?>

@stop

@section('script')

	<script>

		$("input[type=file]").change(function (){
			var fileName = $(this).val().split('\\').pop();
			$('#inputLabel').text(fileName);
			// $(".filename").html(fileName);
		});

		$('.btn-info').click(function(){

			$('#input').click();

		});

	</script>

@stop
