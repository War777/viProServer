<?

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\Zone;

use App\Rate;

use Hash;

use DB;
	
	/**
	* 
	*/
	class ZonesController extends Controller
	{

		//Funcion para agregar una zona
		public function addZone(Request $request){

	        $inputs = $request->toArray();

	        $zone = $this->firstOrNewZone($inputs);

			return $this->displayZones('Zona agregada con exito', 'bg-success');

	    }

	    //Funcion para mostrar las zonas en el documento
	    public function displayGetZones(){

			return $this->displayZones('', '');

	    }

	    /**
	    *
	    * Funcion para mostrar las zonas 
	    * @param String message
	    * @param String class
	    *
	    */

	   	public function displayZones($message, $class){

	   		$queryZones = "SELECT 
	   			id as '+id',
	   			description as 'Descripcion .tc',
	   			created_at as 'Creacion .tc',
	   			updated_at as 'U. Actualizacion .tc'
	   			FROM zones
	   			WHERE deleted_at is null;
   			";

	   		$zones = Own::queryToArray($queryZones);

	   		$data = array(

	   			'zones' => $zones,
	   			'message' => $message,
	   			'class' => $class

	   		);

	   		return view('zones', $data);

	   	}

	   	/**
	   	*
	   	* Funcion para crear o actualizar una zonas
	   	* @param Array
	   	*
	   	*/

	   	public function firstOrNewZone($attributes){

	   		$zone = Zone::withTrashed()->firstOrNew(['description' => $attributes['description']]);
	   		$zone->deleted_at = null;
	   		$zone->save();

	   		return $zone;

	   	}

	   	/**
	   	*
	   	* Funcion para eliminar una zona
	   	* @param Request
	   	* @return View
	   	*
	   	*/

	   	public function deleteZone(Request $request){

	   		$inputs = $request->toArray();			//Obtenemos las entradas

	   		$message = '';							//Declaramos los parametros
	   		$class = '';

	   		if(isset($inputs['id'])){				//Verificamos que exista un id

	   			$zone = Zone::find($inputs['id']);	//Ubicamos la zona

	   			if(isset($zone)){					//Verificamos que exista la zona

	   				$zone->delete();				//Eliminamos la zona

	   				Rate::where('idZone', $inputs['id'])->delete();	//Asi mismo eliminamos los cargos

	   				$message = 'Zona eliminada con exito!';	//Modificamos los parametros
	   				$class = 'bg-info';

	   			}

	   		}

	   		return $this->displayZones($message, $class);

	   	}

	   	/**
		*
		* Funcion para mostrar la plantilla de actualizacion
		* @param Request
		* @return View
		*
		*/

		public function displayUpdateBlade(Request $request){

			$inputs = $request->toArray();

			if(isset($inputs['id'])){

				$zone = Zone::find($inputs['id']);

				if(isset($zone)){

					return view('updateZone', ['zone' => $zone]);

				}

			} else {

				return $this->displayZones('', '');

			}

		}

	}

?>