<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Own\Own;

class User extends Authenticatable
{

    use SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'names',
        'lastName',
        'secondName',
        'birthDate',
        'gender',
        'password',
        'email',
        'phone',
        'whatsapp',
        'curp',
        'street',
        'gmap'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];
    
    /**
    *
    * Agregamos funcionalidades propias al constructor 
    * 
    */

    public function __construct(array $attributes = array()){

        parent::__construct($attributes);
        // $this->go();

    }

    /**
    *
    * Funcion para crear la estructura del menu lateral
    * @return Array menus
    *
    */

    private function createMenusArray(){

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
    * Funcion para obtener un arreglo de menus dado un id
    * @param integer id
    * @return Array menuArray
    *
    */

    public function getMenuArray($id){

        $query = "select p.idMenu as 'id', m.name, m.hasSubmenus, m.target, m.idParent 
            from privileges p
            inner join menus m
            on p.idMenu = m.id
            and p.idUser = " . $id . "
            and p.read = 1;";

        $menus = Own::queryToArray($query);             //Obtenemos los menus base

        $parentMenus = array();                         //Obtenemos los padres en caso de existir

        foreach ($menus as $menu) {                     //Recorremos los menus
            
            $queryParentMenu = "select id, name, hasSubmenus, target
                from menus 
                where id = " . $menu['idParent'] . ";";
            
            $parentMenu = Own::queryToSingleArray($queryParentMenu);

            if(isset($parentMenu['id'])){               //Verificamos que no sea nulo

                $flag = false;

                foreach ($parentMenus as $parMen) {     //Verificamos que no este repetido
                    
                    if($parentMenu['id'] == $parMen['id']){

                        $flag = true;

                        break;

                    }

                }

                if($flag == false){                     //En dado caso de no estar repetido, se agrega el menu

                    array_push($parentMenus, $parentMenu);

                }
                
            }

        }

        foreach ($parentMenus as &$parentMenu) {        //Agregamos los menus a sus respectivos padres

            $parentMenu['subMenus'] = array();

            foreach($menus as &$menu){

                if($menu['idParent'] == $parentMenu['id']){

                    array_push($parentMenu['subMenus'], $menu);

                }

            }

        }

        foreach($menus as &$menu){

            if($menu['idParent'] == 0){

                $menu['subMenus'] = array();

                array_push($parentMenus, $menu);

            }

        }

        return $parentMenus;

    }

    /**
    *
    * Funcion para crear el menu del usuario en formato html
    * @param Array menuArray
    * @return String menuHtml
    *
    */

    public function getMenuHtml($menuArray){

        $menuHtml = "";                                 //Declaramos la variable para el mnenu

        foreach ($menuArray as $menu) {           //Recorremos los menus asociados al usuario
            
            if(count($menu['subMenus']) > 0){                       //Verificamos si el menu tiene sub menus

                //Asignamos la estructura html
                
                $menuHtml .= "<li>
                    <a data-toggle='collapse' data-parent='#menu-bar' aria-expanded='true' href='#" . $menu['target'] . "'>
                        " . $menu['name'] . "
                    </a>";
                

                $menuHtml .= "<ul id='" . $menu['target'] . "' class='panel-collapse collapse'>";

                foreach ($menu['subMenus'] as $subMenu) {
                    
                    $menuHtml .= "<li><a href='" . $subMenu['target'] . "'> " . $subMenu['name'] . " </a></li>";

                }
                
                $menuHtml .= "</ul>";

                $menuHtml .= "</li>";    

            } else {

                $menuHtml .= "<li> <a href='" . $menu['target'] . "'> " . $menu['name'] . " </a> </li>";

            }

        }

        return $menuHtml;

    }

}
