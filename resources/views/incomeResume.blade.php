<!DOCTYPE html>

<html lang="en">

	<head>

		<meta charset="UTF-8">
		<title>Resumen de ingresos</title>

		<link rel="stylesheet" href="{{ asset('public/c/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('public/c/mainStyles.css') }}">
		<meta name="viewport" content="width=device-width, initial-scale=1">

	</head>

<?

	use App\Own\Own;

?>

	<body>

		<div class="container">
			
			<br>
			<h1>Resumen de ingresos Septiembre 2016</h1>

			<br>

			<div class="row">
				
				<div class="col-lg-3">
					<legend>Giro comercial</legend>
					<? echo Own::arrayToTable($tradingResume, '', '', ['route' => '', 'glyphicon' => '', 'label' => '']) ?>

				</div>

				<div class="col-lg-3">
					<legend>Zona</legend>
					<? echo Own::arrayToTable($zonesResume, '', '', ['route' => '', 'glyphicon' => '', 'label' => '']) ?>

				</div>

				<div class="col-lg-3">
					<legend>Origen</legend>
					<? echo Own::arrayToTable($localResume, '', '', ['route' => '', 'glyphicon' => '', 'label' => '']) ?>

				</div>

				<div class="col-lg-3">
					<legend>Dia</legend>
					<? echo Own::arrayToTable($dayResume, '', '', ['route' => '', 'glyphicon' => '', 'label' => '']) ?>
				</div>

			</div>

		</div>
		
	</body>

</html>

<script src="{{ asset('public/j/jquery-3.0.0.js') }}"></script>
<script src="{{ asset('public/j/bootstrap.js') }}"></script>