<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LoginController extends Controller
{
    //Funcion para mostrar el formulario de inicio de sesion
    public function showLogin(){

    	return view('login');

    }

    public function postLogin(){

    	return view('addUser');

    }
}
