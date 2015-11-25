<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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
//    protected $auth;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {  
        //cuando esta autenticado solo tiene esas rutas
        $this->middleware('guest', ['except' => ['getLogout','getRegister','postRegister']]);///verifica rol de usuario en getRegister
//        $this->middleware('guest', ['except' => 'getLogout']);
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
            'name'      => 'required|max:255',
            'usuario'   => 'required|max:15|unique:users',
            'password'  => 'required|confirmed|min:6',
            'fono'      => 'required|max:15'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//        ]);
        $user = new User([
            'name' => strtoUpper($data['name']),
            'user' => strtoUpper($data['user']),  
            'fono' => strtoUpper($data['fono']),
            'password' => bcrypt($data['password']),
        ]);
        $user->rol= 'usuario';
        $user->save();
        return $user;
    }
    
    
    public function loginPath()
    {
        return route('login');
    }
    
    public function redirectPath()
    {
        return route('home');
    }
    
    protected function getFailedLoginMessage()//mensaje si hay error en login
    {
        return trans('validation.login');
    }
}
