<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class MyRegisterController extends Controller
{

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected $redirectTo = '/';


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view("auth.register");
    }



    protected function validator(array $data)
    {
        return Validator::make($data, [
            'display_name' => 'required|min:7|max:50|unique:users',
            'login_name' => 'required|min:7|max:255|confirmed|unique:users',
            'email' => 'required|email|max:255|unique:users|confirmed',
            'password' => 'required|min:6|confirmed',
            'hashcode' => 'empty',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'display_name' => $data['display_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'login_name' => $data['login_name'],
            'hashcode' => md5(uniqid(rand(), true)),
        ]);
    }


}
