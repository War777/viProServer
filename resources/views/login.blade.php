<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>

	<link rel="stylesheet" href="{{ asset('public/c/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('public/c/mainStyles.css') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
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
						Bienvenido fagget
					</h1>

				</center>
				

			</div>

		</div>
		
		<div class="row">

			<div class="col-sm-offset-4 col-sm-4 text-center">

				<form action="login" method="POST">

					{{ csrf_field() }}
					
					<input type="text" name="user" class="form-control" placeholder="Usuario" required>
					
					<br>

					<input type="password" name="password" class="form-control" placeholder="Contrase&ntilde;a" required>
					
					<br>

					<button type="reset" class="btn btn-danger"> Cancelar </button>

					<button type="submit" class="btn btn-primary"> Ingresar </button>

				</form>
				
			</div>

		</div>

	</div>
	
</body>
</html>