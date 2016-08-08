<?

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\Zone;

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

	        $zone = new Zone;

	        $zone->description = $inputs['description'];

	        $status = $zone->save();

	        $message = '';

	        if($status != 1){

	        	$message = 'Zona agregada con exito';

	        } else {

	        	$message = 'Error';

	        }

	        $zones = Own::queryToArray('select * from zones;');

			return view('zones', ['zones' => $zones]);

	    }

	    //Funcion para mostrar las zonas en el documento
	    public function displayZones(){

	    	$zones = Own::queryToArray('select * from zones;');
			// Own::d($zones);
			return view('zones', ['zones' => $zones]);

	    }

	}

?>