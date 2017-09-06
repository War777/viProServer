<?

	namespace App\Own;
	use Illuminate\Http\Request;
	use DB;

	/**
	* 
	*/
	class VariablesController
	{
		
		/**
		*
		* Funcion para extraer los giros comerciales
		*
		*/
		public static function getTradingsArray(){

			$queryTradings = "select r.idTrading as 'value', t.description as 'label'
				from rates r
				inner join tradings t
				on r.idTrading = t.id
				and r.deleted_at is null
				group by r.idTrading, t.description;";

			$tradingsValues = Own::queryToArray($queryTradings);

			return $tradingsValues;

		}

		/**
		*
		* Funcion para extraer las zonas
		*
		*/
		public static function getZonesArray(){

			$queryZones = "select r.idZone as 'value', z.description as 'label'
				from rates r
				inner join zones z
				on r.idZone= z.id
				and r.deleted_at is null
				group by r.idZone, z.description;";


			$zonesValues = Own::queryToArray($queryZones);

			return $zonesValues;

		}

		/**
		*
		* Funcion para regresar los valores del tipo de entrada
		* @return Array
		*
		*/

		public static function getLightCharge(){

			$queryLightCost = "select value
				from variables
				where name = 'perLightCost';";

			$lightCharge = Own::queryToData($queryLightCost);

			return $lightCharge;

		}

		/**
		*
		* Funcion para regresar el incremento de tarifa
		* @return Array
		*
		*/

		public static function getCurrentIncrease(){

			$queryCurrentIncrease = "select value
				from variables
				where name = 'currentIncrease';";

			$currentIncrease = Own::queryToData($queryCurrentIncrease);

			return $currentIncrease;

		}		

	}

?>