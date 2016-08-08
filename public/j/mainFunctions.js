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

	$('form').submit(function(){

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

	/*
	*
	* Funcion que retorna un elemento de tipo BS dropdown dado un simple arreglo
	*
	*/

});





