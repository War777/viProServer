<!DOCTYPE html>

<html lang="en">
<head>
	
	<link rel="stylesheet" href="{{ asset('public/c/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('public/c/mainStyles.css') }}">
	
	<link rel="stylesheet" href="{{ asset('public/c/datepicker.css') }}">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta charset="UTF-8">

	<title> @yield('title', 'Delegaci&oacute;n Villa Progreso') </title>

</head>

<body>
	
	<div class="container">
		<br>
		 
		@yield('content')

	</div>

</body>
</html>

<script src="{{ asset('public/j/jquery-3.0.0.js') }}"></script>
<script src="{{ asset('public/j/bootstrap.js') }}"></script>
<script src="{{ asset('public/j/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('public/j/mainFunctions.js') }}"></script>

@yield('script')