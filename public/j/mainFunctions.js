/*
* Funciones Javascript propias de la aplicacion
*/

//Esperamos a que el documento este listo
$(document).ready(function(){

	/**
	*
	* Funcion que se encarga de actualizar la seleccion de las listas
	*
	*/
	$('.dropDownOption').click(function(){

		$(this).closest('.dropdown')
			.find('.dropDownLabel')
			.text(
				$(this).text()
			);

		$(this).closest('.dropdown')
			.find('.dropDownValue')
			.val(
				$(this).attr('id')
			);

	});

	/**
	*
	* Funcion que evalua las opciones de las listas para asegurar que contengan un valor
	*
	*/

	$('form.validate').submit(function(){

		var formData = $(this).serializeArray();

		var flag = true;

		$(formData).each(function(index, field){

			if(field.value == ''){ 

				flag = false;

			}

		});

		if(flag == false){

			a('Favor de llenar todos los campos');
		
			return false;

		}

	});



	/*
	* Funcion para mandar a consola cualquier objeto/variable
	*/
	function l(object){
		console.log(object);
	}

	/**
	*
	* Funcion para mandar una simple alerta
	*
	*/

	function a(message){

		alert(message);

	}

	/*
	* Funcionalidad para mostrar u ocultar el menu lateral
	* 'layout.blade.php'
	*/
	$("#side-toggler").click(function(e) {
	    e.preventDefault();
	    $("#wrapper").toggleClass("toggled");
	});

	/*
	*
	* Funcion para permitir solo valores numericos en las entradas de texto con la clase numerica 
	*
	*/
    $('body').delegate('.numeric', 'keypress', function(evento){
			
		var texto = $(this).val();
		var longitud = texto.length;

		var key = window.Event ? evento.which : eevento.keyCode

		if(key == 46){
			var existePunto = false;
			for(var i = 0; i < longitud; i++){
				if(texto.charAt(i) == '.'){
					existePunto = true;
				}
			}

			if(existePunto == true){
				return false;
			}

		} else if(key == 45){

			if(longitud > 0){
				return false;
			}


		} else{

			return (key >= 48 && key <= 57)

		}
		
	});

    /**
    *
    * Funcion para inicializar el datepicker
    *
    */

	$('#dp3').datepicker({
		'format' : 'yyyy-mm-dd'
	});

	/**
	*
	* Funcion para aparecer el menu contextual de las tablas
	*
	*/

	var $contextMenu = $(".tableMenu");
  
	$(".editable").on("contextmenu", "tr.tableRow", function(e) {

		$contextMenu.css({
			display: "block",
			left: e.pageX,
			top: e.pageY
		});

		var id = $(this).attr('id');

		var updateRoute = $(this).closest('table').attr('updateRoute');
		var deleteRoute = $(this).closest('table').attr('deleteRoute');
		var specialRoute = $(this).closest('table').attr('specialRoute');
		var specialRouteLabel = $(this).closest('table').attr('specialRouteLabel');

		

		if(updateRoute != ''){

			$contextMenu.find('.updateAnchor').attr('href', updateRoute + '?id=' + id);	

		} else {

			$contextMenu.find('.updateAnchor').remove();

		}

		$contextMenu.find('.deleteAnchor').attr('href', deleteRoute + '?id=' + id);

		if(specialRoute == ''){

			$contextMenu.find('.specialAnchor').remove();

		} else {

			$contextMenu.find('.specialAnchor').attr('href', specialRoute + '?id=' + id);
			$contextMenu.find('.specialAnchor').text(specialRouteLabel);

		}

		return false;

	});

	$('body').on('click', function(){			//Perdida del foco del menu
		$contextMenu.hide();
	});

	$('html').on('click', function(){			//Perdida del foco del menu
		$contextMenu.hide();
	});

	//Funcion para el estado de los menus
	
	$('.menuReadCheck').change(function(){ //Lectura

		var id = $(this).attr('id');

		var state = $(this).is(':checked');

		var value = state == true ? 1 : 0;

		$('#menuRead' + id).val(value);

	});

	$('.menuWriteCheck').change(function(){ //Escritura

		var id = $(this).attr('id');

		var state = $(this).is(':checked');

		var value = state == true ? 1 : 0;

		$('#menuWrite' + id).val(value);

	});

	/**
	*
	* Funcion para validar los eventos de eliminacion
	*
	*/

	$('.deleteAnchor').click(function(){

		var response = confirm("Esta seguro que desea eliminar este registro?");
		
		if (response == false) {

			return false;

		}

	});

});





