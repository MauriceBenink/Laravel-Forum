<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Container\Container;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function index(){
        return view('auth/login');
    }

    public function username(){
        return 'login_name';
    }


    public function login(Request $request)
    {
        $name = $request['login_name'];

        if(function_exists('customEncrypt')){
            $request['login_name'] = customEncrypt($request['login_name']);
        }else{
            $request['login_name'] = md5($request['login_name']);
        }

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $request['login_name'] = $name;

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        $request['login_name'] = $name;

        return $this->sendFailedLoginResponse($request);


    }

    function old($key = null, $default = null)
    {
        return app('request')->old($key, $default);
    }


    protected function authenticated(Request $request, $user)
    {
        if (Auth::attempt($request->only($this->username(),'password')))
        {
            Auth::loginUsingId($user->ID);
            return redirect()->intended('home');
        }
    }


}
