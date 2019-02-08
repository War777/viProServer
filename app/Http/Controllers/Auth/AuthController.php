<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Session;
use App\Own\Own;
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * @param  array  $data
     * @return User
     *
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
    *
    * Function to check a valid login
    * @param Request $request
    * @return view responseView
    *
    */

    public function checkLogin(Request $request){

        $inputs = $request->toArray();

        $remember = false;

        if(isset($inputs['remember'])){
            
            $remember = true;

        }


        $data = array(

            'email' => $inputs['email'],
            'password' => $inputs['password'],

        );

        if(Auth::attempt($data, $remember)){

            $menuArray = Auth::user()->getMenuArray(Auth::user()->id);                   //Obtenemos el menu de arreglo
            $menuHtml = Auth::user()->getMenuHtml($menuArray);

            $request->session()->put('menuHtml', $menuHtml);

            $query = "SELECT 
                m.id as '+id', 
                m.firstName as 'A. Paterno', 
                m.lastName as 'A. Materno', 
                m.names as 'Nombre(s)', 
                m.isLocal as '!Es local', 
                m.phone as 'Telefono .tr', 
                t.description as 'Giro',
                m.incomeType as 'Ingreso', 
                m.created_at as 'F. Creacion .tc'
            FROM merchants m
            JOIN tradings t
            ON m.idTrading = t.id
            WHERE m.deleted_at IS NULL;";

        $merchants = Own::queryToArray($query);

        $data = array(
            'merchants' => $merchants,
            'message' => "",
            'class' => ""
        );
            return view('merchants', $data);

        } else {

            $data = array(
                'message' => 'Contrase&ntilde;a y/o password invalidos',
                'class' => 'bg-danger',
                'email' => $inputs['email'],
            );

            return view('login', $data);

        }

    }

    /**
    *
    * Return just the login view
    * @return view login
    *
    */

    public function displayLogin(){

        return view('login');

    }

    /**
    *
    * We close the session
    * @return view login
    *
    */

    public function logout(){

        Session::forget('menuHtml');

        Auth::logout();

        return view('login', ['message' => 'Sesi&oacute;n cerrada con exito!', 'class' => 'bg-info']);

    }

}
