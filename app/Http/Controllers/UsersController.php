<?

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\User;

use App\Privilege;

use Hash;

use DB;
	
	/**
	* 
	*/
	class UsersController extends Controller
	{

		/**
		*
		* Funcion que dispara la funcion para mostrar los usuarios sin parametros
		* @return view users
		*
		*/

		public function displayGetUsers(){

			return $this->displayUsers('', '');

		}


		/**
		*
		* Funcion que muestra los usuarios
		* @return view users
		*
		*/

		public function displayUsers($message, $class){

			$query = "SELECT 
				id as '+Id',
			    lastName as 'A. Paterno',
			    secondName as 'A. Materno',
			    names as 'Nombre(s)',
			    birthDate as 'F. Nacimiento',
			    email as 'E-Mail',
			    phone as 'Telefono',
			    whatsapp as 'Whatsapp',
			    curp as 'Curp',
			    street as 'Calle',
			    created_at as 'F. Creacion'
			FROM users
			WHERE deleted_at IS NULL;";

			$menus = Own::createMenusArray();

			$users = Own::queryToArray($query);

			$data = array(

				'users' => $users,
				'message' => $message,
				'class' => $class,
				'menus' => $menus

			);

			return view('users', $data);


		}
		
		public function addUser(Request $request){

	        $inputs = $request->toArray();

	        $user = new User;

	        $user->names = $inputs['names'];
	        $user->lastName = $inputs['lastName'];
	        $user->secondName = $inputs['secondName'];
	        $user->birthDate = $inputs['birthDate'];
	        $user->gender = $inputs['gender'];
	        $user->password = Hash::make($inputs['password']);
	        $user->email = $inputs['email'];
	        $user->phone = $inputs['phone'];
	        $user->whatsapp = (isset($inputs['whatsapp'])) ? 1 : 0;
	        $user->curp = $inputs['curp'];
	        $user->street = $inputs['street'];
	        $user->gmap = $inputs['gmap'];

	        $message = '';
	        $class = '';

	       	try{

				$status = $user->save();							//Se guarda el Usuario

				if($status == 1){

					$message = 'Usuario agregado con exito!';
					$class = 'alert-success';

					$privileges = array();							//Coleccion deprivilegios

			        foreach ($inputs as $key => $value) {			//Se separan los privilegios del menu con el id del usuario

			        	if(Own::contains($key, "menu", false)){		//Se aplica un candado para verificar que sea una entrada de un menu
			        		
			        		$idMenu = -1;							//Se crean las variables con valores no deseados
				        	$state = -1;
				        	$type = "";
				        	
				        	if(Own::contains($key, "menuRead", false)){ 		//Lectura
				        		
				        		$idMenu = str_replace("menuRead", "", $key);

				        		$state = $value;

				        		$type = "read";

				        	} else if(Own::contains($key, "menuWrite", false)){	//Escritura

				        		$idMenu = str_replace("menuWrite", "", $key);

				        		$state = $value;

				        		$type = "write";

				        	}

				        	$found = false; 									//Bandera para evitar repetidos

				        	foreach($privileges as &$privilege){

				        		if($privilege['idMenu'] == $idMenu){    		//Ya se encuentra menu en el arreglo

				        			$privilege[$type] = $state; 				//Se agrega la propiedad de lectura/escritura

				        			$found = true;								//Se cambia el estado de la bandera
				        			
				        			break;

				        		}

				        	}

				        	if($found == false 
				        		&& $idMenu != -1 && $state != -1				//Verificamos si es un nuevo menu y que esten asignados los valores
				        	){

				        		$newPrivilege = array(							//Se crea el privilegio
				        			'idUser' => $user->id,
				        			'idMenu' => $idMenu,
				        			$type => $state,
			        			); 

			        			array_push($privileges, $newPrivilege);	//Se anexa al arreglo

				        	}


			        	}

			        }

			        foreach ($privileges as &$privilegesArray) {			//Se insertan los privilegios en la tabla
			        	
			        	$priv = Privilege::firstOrNew(
			        		[
				        		'idUser' => $privilegesArray['idUser'],
				        		'idMenu' => $privilegesArray['idMenu']
			        		]
		        		);

		        		$priv->read = $privilegesArray['read'];
		        		$priv->write = $privilegesArray['write'];

		        		$priv->save();

			        }


				}

			} catch(\Illuminate\Database\QueryException $e){

				$message = 'Entrada duplicada';
				$class = 'alert-danger';

			}

	        
			return $this->displayUsers($message, $class);

	    }

	    /**
	    *
	    * Funcion para extraer los datos del usuario para su modificacion
	    * @param Request peticion
	    * @return view updateUser
	    */

	    public function updateUser(Request $request){

	    	$inputs = $request->toArray();

	    	$id = $inputs['id'];

	    	$user = User::find($id);

	    	$data = array(
	    		'user' => $user
    		);

    		return view('editUser', $data);

	    }

	    /**
	    *
	    * Funcion para editar el usuario en la base con los nuevos datos
	    * @param Request peticion
	    * @return view updateUser
	    *
	    */
	    public function updateUserData(Request $request){

	    	$inputs = $request->toArray();

	    	$user = User::find($inputs['id']);

	    	$user->names = $inputs['names'];
	        $user->lastName = $inputs['lastName'];
	        $user->secondName = $inputs['secondName'];
	        $user->birthDate = $inputs['birthDate'];
	        $user->gender = $inputs['gender'];
	        // $user->password = Hash::make($inputs['password']);
	        $user->email = $inputs['email'];
	        $user->phone = $inputs['phone'];
	        $user->whatsapp = (isset($inputs['whatsapp'])) ? 1 : 0;
	        $user->curp = $inputs['curp'];
	        $user->street = $inputs['street'];
	        $user->gmap = $inputs['gmap'];

        	try{

				$status = $user->save();

				if($status == 1){

					$message = 'Usuario actualizado con exito!';
					$class = 'alert-success';

				}

			} catch(\Illuminate\Database\QueryException $e){

				$message = '<b>Error en la actualizacion</b><br>Favor de verificar los datos';
				$class = 'alert-danger';

			}

			return $this->displayUsers($message, $class);

	    }

	    /**
	    *
	    * Funcion que elimnia un usuario dado el id
	    * @param Request request
	    * @return view users
	    *
	    */

	    public function deleteUser(Request $request){

	    	$inputs = $request->toArray();

	    	$user = User::find($inputs['id']);

	    	$message = '';
	    	$class = '';

	    	if(isset($user)){

		    	$status = $user->delete();													//Se elimina el usuario

		    	$privilegesDeleted = Privilege::where('idUser', $inputs['id'])->delete(); 	//Se eliminan los privilegios

		    	if($status == 1){

		    		$message = 'Usuario eliminado!';
		    		$class = 'bg-info';

		    	} else {

		    		$message = 'Error, favor de intentar mas tarde!';
		    		$class = 'bg-danger';

		    	}

	    	}

	    	return $this->displayUsers($message, $class);

	    }

	    public function showUserMenu(){

	    	$user = User::find(15);

	    	// $user->go();

	    	// Own::d($user);

	    	// Own::d(Auth::user());

	    }

	}

?>