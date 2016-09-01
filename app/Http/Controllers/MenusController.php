<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\Menu;

//Clase controladora para los menus
class MenusController extends Controller
{

	/**
	*
	* Funcion para la llamada inicial a los menos
	* @return view menus
	*
	*/

	public function displayGetMenus(){

		return $this->displayMenus('', '');

	}


	/**
	*
	* Funcion para mostrar los menos
	* @param string message
	* @param string class
	* @return view menus
	*
	*/

	public function displayMenus($message, $class){

		$menus = Own::queryToArray(
			"SELECT 
				id as '-id',
				name, 
				target,
				hasSubmenus as '!Tiene Sub menus',
				idParent
			FROM menus
			WHERE deleted_at IS NULL;"
		);

		$parentsValues = Own::queryToArray(
			"SELECT 
				id as 'value',
				name as 'label'
			FROM menus
			WHERE deleted_at IS NULL
			AND hasSubMenus = 1;"
		);


		$subMenusValues = array(

			['value' => '1', 'label' => 'Si'],
			['value' => '0', 'label' => 'No'],

		);

		$data = array(

			'menus' => $menus,
			'message' => $message,
			'class' => $class,
			'subMenusValues' => $subMenusValues,
			'parentsValues' => $parentsValues

		);

		return view('menus', $data);

	}

	/**
	*
	* Funcion para agregar un menu
	* @param Request request
	* @return view menus
	*/

	public function addMenu(Request $request){

        $inputs = $request->toArray();

        $idParent = '';

        if(isset($inputs['idParent'])){

			$idParent = $inputs['idParent'];	        	

        }

        $menu = new Menu;

        $menu->name = $inputs['name'];
        $menu->target = $inputs['target'];
        $menu->hasSubmenus = $inputs['hasSubmenus'];
        $menu->idParent = $idParent;
        
        $message = '';
        $class = '';

       	try{

			$status = $menu->save();

			if($status == 1){

				$message = 'Menu agregado con exito!';
				$class = 'alert-success';

			}

		} catch(\Illuminate\Database\QueryException $e){

			$message = 'Entrada duplicada';
			$class = 'alert-danger';

		}

		return $this->displayMenus($message, $class);

    }

  	/**
    *
    * Funcion que elimnia un usuario dado el id
    * @param Request request
    * @return view menus
    *
    */

    public function deleteMenu(Request $request){

    	$inputs = $request->toArray();

    	$menu = Menu::find($inputs['id']);

    	$message = '';
    	$class = '';

    	$status = $menu->delete();

    	if($status == 1){

    		$message = 'Menu eliminado!';
    		$class = 'bg-info';

    	} else {

    		$message = 'Error, favor de intentar mas tarde!';
    		$class = 'bg-danger';

    	}

    	return $this->displayMenus($message, $class);

    }

}
