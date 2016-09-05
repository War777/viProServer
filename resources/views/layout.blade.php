<!DOCTYPE html>

<html lang="en">
<head>
	
	<link rel="stylesheet" href="{{ asset('public/c/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('public/c/mainStyles.css') }}">
	
	<link rel="stylesheet" href="{{ asset('public/c/datepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('public/c/simple-sideBar.css') }}">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta charset="UTF-8">

	<title> @yield('title', 'Delegaci&oacute;n Villa Progreso') </title>

</head>

<?
	
	use App\Own\Own;

?>

<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		
		<div class="container">
			
			<!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id="side-toggler" class="navbar-brand" href="#">ViPro</a>
		    </div>

		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

		    	<div class="nav navbar-nav">

			    	<!-- <li>
			    		<a href="#">
			    			Seccion 1
			    		</a>
			    	</li>

			    	<li class="dropdown">

						<a href="#" data-toggle="dropdown"> 

							<b class="glyphicon glyphicon-asterisk"></b>Seccion 2 <small>Small</small>

							<span class="caret"></span>

						</a>

						<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
							<li class="dropdown-submenu">
								<a tabindex="-1" href="#">Level 1</a>
								<ul class="dropdown-menu">
									<li><a href="#">Sub Level 11 </a></li>
									<li><a href="#">Sub Level 12 </a></li>
								</ul>
							</li>
						</ul>

					</li> -->

		    	</div>

		    	<ul class="nav navbar-nav navbar-right">
		    		
		    		<!-- <li class="dropdown">
		    			<a href="#" class="screen">
		    				Start
		    			</a>
		    		</li> -->

					<li class="dropdown">
			    		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			    			{{ Auth::user()->names }}
			    			<span class="caret"></span>
			    		</a>
			    		<ul class="dropdown-menu">
			    			<!-- <li>
			    				<a href="profile">Perfil</a>
			    			</li> -->
			    			<li>
			    				<a href="logout">Cerrar sesi&oacute;n</a>
			    			</li>
			    		</ul>
			    	</li>

			    </ul>

		    </div>

		</div>

	</nav>
	
	<div class="" id="wrapper">

		<div id="sidebar-wrapper" class="bg">

			<ul id="sidebar-nav" class="sidebar-nav">
                
                <? echo Request::session()->get('menuHtml'); ?>

            </ul>

		</div>
		
		<div id="page-content-wrapper" class="">
			
			<div class="container">

				<h1>
					@yield('h1')
				</h1>

				@yield('content')

			</div>

		</div>
	</div>
	
	<!-- Menu contextual para las tablas -->
	<div id="" class="dropdown clearfix tableMenu">
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
			<li><a class="updateAnchor" tabindex="-1" href="#">Editar</a></li>
			<li><a class="deleteAnchor" tabindex="-1" href="#">Eliminar</a></li>
			<li><a target="_blank" class="specialAnchor" tabindex="-1" href="#"></a></li>
		</ul>
	</div>


</body>
</html>

<script src="{{ asset('public/j/jquery-3.0.0.js') }}"></script>
<script src="{{ asset('public/j/bootstrap.js') }}"></script>
<script src="{{ asset('public/j/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('public/j/mainFunctions.js') }}"></script>

@yield('script')