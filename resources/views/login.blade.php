<!DOCTYPE html>

<html lang="en">

	<head>

		<meta charset="UTF-8">
		<title>Inicio</title>

		<link rel="stylesheet" href="{{ asset('public/c/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('public/c/mainStyles.css') }}">
		<meta name="viewport" content="width=device-width, initial-scale=1">

	</head>

<?

	use App\Own\Own;

?>

	<body>

		<div class="container bg">
			
			<div class="row">
				
				<div class="col-sm-12 text-center">
					
					<br>
					<br>
					<br>
					<br>
					<br>
					
					<center>

						<h1>
							Bienvenido
						</h1>

					</center>
					

				</div>

			</div>
			
			<div class="row">

				<div class="col-sm-offset-4 col-sm-4">
					
					@if(isset($message) && isset($class))

						{{ Own::printHtmlFeedback($message, $class) }}

					@endif

					<form action="checkLogin" method="POST">

						{{ csrf_field() }}
						
						<input type="email" name="email" class="form-control" placeholder="Usuario" required value="{{ isset($email) === true ? $email : '' }}">
						
						<br>

						<input type="password" name="password" class="form-control" placeholder="Contrase&ntilde;a" required>
						
						<br>

						<input type="checkbox" name="remember"> Recordarme

						<br>

						<button type="submit" class="btn btn-primary pull-right"> Ingresar </button>

					</form>
					
				</div>

			</div>

		</div>
		
	</body>

</html>

<script src="{{ asset('public/j/jquery-3.0.0.js') }}"></script>
<script src="{{ asset('public/j/bootstrap.js') }}"></script>