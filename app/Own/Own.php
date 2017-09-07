<?

namespace App\Own;
use Illuminate\Http\Request;
use DB;

	/**
	* Funciones propias, por ello el nombre Own
	*/
	class Own 
	{

		/**
		*
		* Funcion que retorna un elemento de tipo dropdown dado un arreglo de datos
		* @param Array values
		* @return String dropdown
		*
		*/

		public static function arrayToDropdown($title, $inputName, $values){
			
			if(count($values)){

				echo ''
?>
				<div class="dropdown">

					<input type="hidden" name="<? echo $inputName ?>" class="dropDownValue" value="" >

					<button class="btn btn-default dropdown-toggle" type="button" id="dropDownMenu<?echo $title?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						
						<span class="dropDownLabel"><? echo $title ?> ... </span>
						
						<span class="caret"></span>

					</button>

					<ul class="dropdown-menu" aria-labelledby="dropDownMenu<?echo $title?>">
	<?
					foreach ($values as $value) {
	?>
						<li> <a href="#" class="dropDownOption" id="<? echo $value['value'] ?>"> <? echo $value['label'] ?> </a> </li>
	<?
					}
	?>
					</ul>

				</div>
<?			
			}

		}


		/**
		*
		* Function para crear un mensaje de retroalimentacion y una clase de formato
		* @param String message
		* @param Strin class
		* @return String htmlFeedBack
		*
		*/

		public static function printHtmlFeedback($message, $class){

			if($message != '' && $class != ''){

				echo ''

?>
				<div class="alert <? echo $class ?> alert-dismissible" role="alert">

					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					<strong>

						<? echo $message ?>
						
					</strong>

				</div>
<?			
			}

		}

		/**
		*
		* Funcion que regresa un booleano en formato de texto dado el dato
		* @param boolean data
		* @return String textBoolean
		*
		*/
		public static function boolToString($boolean){

			$textBoolean = "";

			if($boolean == 1){

				$textBoolean = "Si";

			} else {

				$textBoolean = "No";

			}

			return $textBoolean;

		}

		//Funcion para verificar si el servidor es local (desarrollo) o en produccion.
		public static function isLocal(){
			
			$isLocal = false;	//Bandera que indica el tipo de servidor

			if(Own::contains(Request::capture()->server()['SERVER_NAME'], "localhost", false) == true){
				$isLocal = true;	
			}

			return $isLocal;

		} 

		public static function getQrUrl(){

			$qrUrl = '';

			if(Own::isLocal() == true){

				$qrUrl = 'c:/xampp/htdocs/laravel';

			} else {

				$qrUrl = '/var/www/html';

			}

			return $qrUrl;

		}

		//Funcion que convierte un array a una tabla bootstrap
		public static function arrayToTable($array, $updateFunction, $deleteFunction, $specialRoute){

			if($array){

				$table = "";

				$tableHeaders = "<thead class='bg-info'>";

				$tableBody = "";

				$firstRow = true;

				$id = -1;						//Variable para almacenar tempralmente el id

				//Recorremos los registros
				foreach ($array as $row) {

					$tableRow = "<tr class='tableRow'>";

					$firstCell = true;

					//Recorremos las columnas
					foreach ($row as $header => $value) {	

						$cellClasses = "";
						
						if(Own::contains($header, "+", false) == true){ 	//Es id autoincrementable

							$cellClasses = " text-right";
							$header = str_replace("+", "", $header);
							if($firstCell == true){ $tableRow = str_replace(">", " id='" . $value . "'>", $tableRow); }
								$header = str_replace("-", "", $header);

							$id = $value;

							$value = str_pad($value, 4, "0", STR_PAD_LEFT);

						} else if(Own::contains($header, "#", false) == true){	//Es numerico
							
							$decimals = substr_count($header, "#");
							$cellClasses = " text-right";
							$value = number_format($value, ($decimals-1));
							$header = str_replace("#", "", $header);

						} else if(Own::contains($header, "\$", false) == true){	//Es moneda
							
							$decimals = substr_count($header, "\$");
							$cellClasses = " text-right";
							$value = number_format($value, ($decimals-1));

							$value = "<div class='pull-left'>$</div><div class='pull-right'>" . $value . "</div>"; //Agregamos el formato de moneda

							$header = str_replace("\$", "", $header);

						} else if(Own::contains($header, "%", false) == true){ //Es tiempo

							$decimals = substr_count($header, "%");
							$cellClasses = " text-right";
							$header = str_replace("%", "", $header);

						} else if(Own::contains($header, "!", false) == true){ //Es booleano

							$cellClasses = " text-center";
							$value = Own::boolToString($value);
							$header = str_replace("!", "", $header);

						}

						if(Own::contains($header, ".tc", false) == true){		//Verificamos las clases adicionales

							$header = str_replace(".tc", "", $header);
							$cellClasses .= " text-center";

						} else if(Own::contains($header, ".tr", false) == true){

							$header = str_replace(".tr", "", $header);
							$cellClasses .= " text-right";

						}

						if($firstRow == true){

							$tableHeaders.= "<td class='text-center'>" . ucfirst($header) . "</td>";

						}

						$tableRow .= "<td class='" . $cellClasses . "'>" . $value . "</td>";
						
					}

					$tableHiddenHeaders = 0;

					$tableRow .= "<td class='visible-xs visible-sm'>";

					if($updateFunction != ''){			//Verificamos si existe la ruta de actualizacion

						$tableRow .= "<a href='" . $updateFunction . "?id=" . $id . "' class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-pencil'></i></a>";						

						$tableHiddenHeaders++;

					}

					if($specialRoute['route'] != ''){			//Verificamos si existe la ruta de eliminacion

						$tableRow .= "<a href='" . $specialRoute['route'] . "?id=" . $id . "' class='btn btn-xs btn-info'><i class='glyphicon " . $specialRoute['glyphicon'] . "'></i></a>";

						$tableHiddenHeaders++;						

					}

					if($deleteFunction != ''){			//Verificamos si existe la ruta de eliminacion

						$tableRow .= "<a href='" . $deleteFunction . "?id=" . $id . "' class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i></a>";
						$tableHiddenHeaders++;								

					}

					$tableRow .= "</td>";

					$tableRow .= "</tr>";

					$tableBody .= $tableRow;

					$firstRow = false;
					
				}

				if($tableHiddenHeaders > 0){ 			//Verificamos que el encabezado contenga botones ocultos

					$tableHeaders .= "<td class='visible-xs visible-sm'></td>";
					
				}

				$tableHeaders .= "</thead>";

				$table = "<div class='table-responsive'>"
							. "<table class='table table-bordered table-hover table-condensed editable table-striped' updateRoute='" . $updateFunction . "' deleteRoute='" . $deleteFunction . "' specialRoute='" . $specialRoute['route'] . "' specialRouteLabel='" . $specialRoute['label'] . "' >" 
								. $tableHeaders
								. $tableBody 
							. "</table>"
						. "</div>";

				return $table;

			} else {

				return "<br><br><br><center><h4>Sin Datos</h4></center>";

			}

		}

		//Funcion para correr una serie de queries dados por un array
		public static function runQueries($queries){

			$results = array();

			foreach ($queries as $description => $query) {
				$result = Own::runQuery($description, $query);
				array_push($results, $result);
			}

			return $results;

		}

		//Funcion para ejecutar un simple query
		public static function runQuery($description, $query){

			$result = array();				//Arreglo informativo

			$start = Own::getCurrentTime();	//Hora de inicio

			// $rows = DB::statement($query);
			$rows = DB::affectingStatement($query);	//Registros afectados
			
			$finish = Own::getCurrentTime();	//Hora de termino

			//Agregamos la informacion
			$result['Descripcion'] = $description;	
			$result['#Filas'] = $rows;
			$result['%Tiempo'] = Own::getRunTime($start, $finish);
			$result['Query'] = $query;
			
			return $result;

		}

		//Funcion para obtener la hora actual
		public static function getCurrentTime(){
			$time = Date('h') . ":" . Date('i') . ":" . Date('s');
			return $time;
		}


		/*
		* Funcion para tener un tiempo de ejecucion dados dos
		* tiempos creados por la funcion getCurrentTime
		*/
		public static function getRunTime($start, $finish){

			//Construimos el tiempo transcurrido
			$interval = strtotime($finish) - strtotime($start);

			$minutes = floor( ($interval - (0 * 3600)) / 60 );
			$seconds = $interval - ( 0 * 3600 ) - ( $minutes * 60 );

			if($minutes < 10){
				$minutes = "0" . $minutes;
			}
			if($seconds < 10){
				$seconds = "0" . $seconds;
			}

			$time = $minutes . "m" . ":" . $seconds . "s";

			return $time;

		}

		//Funcion que evalua si un string contiene otro string
		public static function contains($where, $find, $caseSensitive){

			$flag = false;

			if($caseSensitive == true){

				if(strpos($where, $find) !== false){

					$flag = true;

				}

			} else {

				if(stripos($where, $find) !== false){

					$flag = true;

				}

			}

			return $flag;

		}

		//Funcion para mandar un echo mas simple con una linea de separacion
		public static function e($message){

			echo "<hr>" . $message;

		}

		//Funcion para hacer un var_dump con formato html
		public static function d($object){

			echo "<hr> <pre> " . print_r($object, true) . " </pre>";

		}

		//Funcion que inserta los registros de un archivo *.cvs a la base de datos
		public static function loadCsvToDb($table, $file, $periodExists){

			$isLocal = Own::isLocal();				//Verificamos el tipo de servidor

			$path = "/var/www/html/kvm/uploadedFiles/php/files/";	//Ruta del directorio de archivos
			
			if($isLocal){							//Si el servidor es local cambiamos la ruta

				$path = "C:/xampp/htdocs/kvm/uploadedFiles/php/files/";

			}

			$response = array();

			$deleteQuery = "TRUNCATE " . $table . ";";
		
			DB::connection()->getpdo()->exec($deleteQuery);

			$query = "load data local
					infile '" . $path . $file . "'
					into table " . $table . "
					fields terminated by ','
					lines terminated by '\n'
					ignore 1 lines";

			$response['insertedRows'] = DB::connection()->getpdo()->exec($query);
			// $affectedRows = DB::connection()->getpdo()->exec($query);

			Own::logEvent($table);

			return $response;
			
		}

		//Funcion para extraer los datos del grid
		public static function getGridData($query){

			$query = "SELECT * from sto_mac limit 10;";

			$records = DB::select($query);

			if(count($records) > 0){

				Own::d($records);

				// $columns = array();
				// $items = array();

				// $firstRecord = true;

				// foreach ($records as $record) {
					
				// 	foreach ($record as $field => $value) {

				// 		if($firstRecord == true){

				// 			array_push($columns, $field);

				// 		}

				// 		$record[$field] = utf8_encode($record[$field]);

				// 	}

				// 	array_push($items, $record);

				// 	$firstRecord = false;

				// }

				// $response = array(
				// 	'columns' => $columns,
				// 	'items' => $items
				// );

			} else {

				echo "No data";

			}

		}

		/*
		* Funcion para correr el metodo de un controlador
		* Recibe los siguiente parametros
		* array() Parametros
		* String Controlador@metodo
		* 
		* Devuelve un array con la informacion de retroalimentacion
		*/

		public static function runStringController($controllerString, $parameters){

			$controllerData = explode('@', $controllerString);
					
			$app = app();

			$controller = $app->make($controllerData[0]);

			return $controller->callAction($controllerData[1], $parameters);

		}

		/*
		*
		*/

		public static function arrayToModelForm($formData){

			$form = '<div class="input-group-sm">';

			$form .= Form::open(
				array(
					'url' => 'ajaxForm',
					'controller' => $formData['controller']
				)
			);

			foreach ($formData['inputs'] as $input) {
				
				switch($input['type']){

					case 'text':
						
						$attributes = array(
							'id' => $input['name'],
							'placeholder' => $input['placeholder'],
							'class' => 'form-control',
						);

						if($input['required'] == true){

							$attributes['required'] = 'required';

						}	
						
						$form .= Form::text(
							$input['name'],
							null, 
							$attributes
						);

					break;

					case 'select': 

						$form .= '<select>';

							foreach ($input['values'] as $option) {
								$form .= '<option value="' . $option['value'] . '">';
									$form .= $option['text'];
								$form .= '</option>';
							}
						
						$form .= '</select>';

						$form .= '<br /><br />';

					break;

					case 'numeric':

						$attributes = array(
							'id' => $input['name'],
							'placeholder' => $input['placeholder'],
							'class' => 'form-control numeric',
						);

						if($input['required'] == true){

							$attributes['required'] = 'required';

						}	
						
						$form .= Form::text(
							$input['name'],
							null, 
							$attributes
						);

					break;

				}

			}
			
			$form .= '<div class="row">';

				$form .= '<div class="col-sm-12 text-right">';

					$form .= Form::reset('Reset', array('class' => 'btn btn-primary btn-xs'));

					$form .= ' ';

					$form .= Form::button('Add', array('class' => 'ajaxForm btn btn-primary btn-xs'));

				$form .= '</div>';

			$form .= '</div>';
			
			
			$form .= '';


			$form .= Form::close();

			$form .= "</div>";

			return $form;

		}

		/*
		* Funcion que convierte un conjunto registros de clase estandar a un arreglo asociativo
		* @param [stdClass] stdRecords
		* @return Array records
		*/
		public static function stdRecordsToArray($stdRecords){

			$records = array();							//Declaramos el arreglo

			foreach ($stdRecords as $stdRecord) {		//Recorremos los registros
				
				$record = get_object_vars($stdRecord);	//Transformamos el registro de clase estandar a un arreglo asociativo

				array_push($records, $record);			//Agregamos el registro a la coleccion

			}

			return $records;							//Devolvemos la coleccion

		}

		/**
		* Funcion que devuelve un arreglo con datos dada una consulta en formato MySql
		* @param String $query
		* @return Array $records
		*/

		public static function queryToArray($query){

			$records = Own::stdRecordsToArray(
				DB::select($query)
			);

			return $records;

		}

		/*
		* ================================================
		* Fin de la funcion queryToArray();
		* ================================================
		*/

		/*
		* Funcion que devuelve un dato unico desde la base dado un query
		* @param String query
		* @return String data
		*/

		public static function queryToData($query){

			$data = "";

			$records = Own::stdRecordsToArray(
				DB::select($query)
			);
			
			foreach ($records as $record) {

				foreach ($record as $value) {

					$data = $value;
					
					break;

				}
				
				break;
			
			}

			return $data;

		}

		/**
		*
		* Funcion para crear un arreglo de menus
		* @return array menus
		*
		*/

		static function createMenusArray(){

	        $query = "select id, name, hasSubmenus, target, idParent
	            from menus
	            where deleted_at is null;";

	        $menus = Own::queryToArray($query);

	        $parentMenus = array();

	        foreach ($menus as $menu) {
	            
	            if($menu['hasSubmenus'] == 1){ //Verificamos si tiene submenus para agregarlos

	                $structuredMenu = array(

	                    'id' => $menu['id'],
	                    'name' => $menu['name'],
	                    'target' => $menu['target'],
	                    'subMenus' => array()

	                );

	                foreach($menus as $tempMenu){

	                    if($tempMenu['idParent'] == $menu['id']){

	                        $subMenu = array(

	                            'id' => $tempMenu['id'],
	                            'name' => $tempMenu['name'],
	                            'target' => $tempMenu['target']

	                        );

	                        array_push($structuredMenu['subMenus'], $subMenu);

	                    }   

	                }

	                array_push($parentMenus, $structuredMenu);

	            } else {                    //Si no tiene submenus se agrega directamente

	                if($menu['idParent'] == '0' || isset($menu['idParent']) == false){ //Verificamos que no tenga nodo padre para no repetir el menu

	                    $structuredMenu = array(

	                        'id' => $menu['id'],
	                        'name' => $menu['name'],
	                        'target' => $menu['target'],
	                        'subMenus' => array()

	                    );

	                    array_push($parentMenus, $structuredMenu);

	                }


	            }

	        }

	        return $parentMenus;

	    }

	    /**
	    *
	    * Funcion para convertir un menu a formato html para privilegios
	    * @param Array menu
	    * @return strin htmlMenu
	    *
	    */

	    static function menuToHtml($menu){

	    	$htmlMenu = "";

	    	if(count($menu['subMenus']) > 0){		//Verificamos si tiene submenus

	    		$htmlMenu .= "";

	    		$subMenusTable = ""
	    				. "<tr> <td colspan='3'>" . $menu['name'] . "</td>"
	    				. ""
	    				. ""
	    				. ""
	    				. ""
	    				. ""
	    				. "";

	    		foreach ($menu['subMenus'] as $subMenu) {
	    			
	    			$row = "<tr>"
	    				
		    				. "<td>" . $subMenu['name'] . "</td>"
		    				
		    				. "<td class='text-center'> <input type='hidden' value='1' id='menuRead" . $subMenu['id'] . "' name='menuRead" . $subMenu['id'] . "'> <input type='checkbox' id='" . $subMenu['id'] . "' class='menuReadCheck' checked> Lectura </td>"

		    				. "<td class='text-center'> <input type='hidden' value='1' id='menuWrite" . $subMenu['id'] . "' name='menuWrite" . $subMenu['id'] . "'> <input type='checkbox' id='" . $subMenu['id'] . "' class='menuWriteCheck' checked> Escritura </td>"
		    				
	    				. "</tr>";

	    			$subMenusTable .= $row;

	    		}

	    		$htmlMenu .= $subMenusTable;

	    	} else {								//Si no tiene agregamos como un menu padre

	    		$htmlMenu .= ""
	    				. "<tr> <td>" . $menu['name'] . "</td>"
	    				. "<td class='text-center'> <input type='hidden' value='1' id='menuRead" . $menu['id'] . "' name='menuRead" . $menu['id'] . "'> <input type='checkbox' id='" . $menu['id'] . "' class='menuReadCheck' checked> Lectura </td>"
	    				. "<td class='text-center'> <input type='hidden' value='1' id='menuWrite" . $menu['id'] . "' name='menuWrite" . $menu['id'] . "'> <input type='checkbox' id='" . $menu['id'] . "' class='menuWriteCheck' checked> Escritura </td>"
	    				. "</tr>";

	    	}

	    	return $htmlMenu;

	    }

		/*
		* Funcion que registra la modificacion de una tabla
		* @param String table
		*/

		public static function logEvent($table){

			$records = array();

			$record = array(
				'usu' => Auth::user()->user,
				'tab' => $table,
				'dat' => date('Y-m-d H:i:s')
			);

			array_push($records, $record);

			DB::table('kvm_eve')->insert($records);

		}

		public static function queryToSingleArray($query){

			$records = Own::queryToArray($query);

			$data = array();

			foreach ($records as $record) {
				
				foreach ($record as $index => $value) {
					
					$data[$index] = $value;

				}

				break;

			}

			return $data;

		}

		public static function  startsWith($haystack, $needle) {
		    // search backwards starting from haystack length characters from the end
		    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
		}
		
		public static function endsWith($haystack, $needle) {
		    // search forward starting from end minus needle length characters
		    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
		}


		/**
		*
		* Funcion para obtener los datos para graficar dado un query
		* @param String title
		* @param String query
		* @return Array serie
		*
		*/

		public static function getChartSerie($query){

			$serie = array();

			$dataResume = Own::queryToArray($query);

			$dataSeries = array();

			foreach ($dataResume as $data) {

				$serie = array(
					'name' => $data['name'],
					'data' => [
						$data['data']
					]
				);

				array_push($dataSeries, $serie);

			}

			return $dataSeries;

		}

		/**
		*
		* Funcion que genera los datos para las graficas
		*
		*
		*/

		public static function getIncomeSeries(){

			$queryZones = "select z.description as 'name', sum(c.totalCharge) as data
				from charges c
				join zones z
				on c.idZone = z.id
				and c.year = '2016'
				group by z.description
				order by data";

			$queryLocal = "SELECT 
					case m.isLocal when m.isLocal = 2 THEN 'Externo' ELSE 'Local' end as 'name', 
					sum(c.totalCharge) as 'data'
				from charges c
				join merchants m
				on c.idMerchant = m.id
				and c.year = '2016'
				group by m.isLocal
				order by 'data'";

			$queryDay = "SELECT concat(day(created_at), '-', month(created_at))  as name, sum(totalCharge) as 'data'
				FROM charges
				where year = '2016'
				group by name
				order by created_at;";

				$queryTradings = "SELECT t.description as name, sum(c.totalCharge) as data
				from charges c
				join merchants m
				join tradings t
				on c.idMerchant = m.id
				and m.idTrading = t.id
				and c.year = '2016'
				group by t.description
				order by data";

			$incomeSeries = array(

				'zones' => Own::getChartSerie($queryZones),
				'isLocal' => Own::getChartSerie($queryLocal),
				'day' => Own::getChartSerie($queryDay),
				'tradings' => Own::getChartSerie($queryTradings)

			);

			return $incomeSeries;

		}


	}

?>