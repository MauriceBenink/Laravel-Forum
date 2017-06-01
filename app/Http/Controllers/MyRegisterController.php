<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\User;
use App\profile;
use App\level;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Mail\mailer;

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


    public function register(Request $request)
    {
        if(function_exists('customEncrypt')){
            $request['login_name'] = customEncrypt($request['login_name']);
            $request['login_name_confirmation'] = customEncrypt($request['login_name_confirmation']);
        }else{
            $request['login_name'] = md5($request['login_name']);
            $request['login_name_confirmation'] = md5($request['login_name_confirmation']);
        }


        $this->validator($request->all())->validate();

        if(User::count()!=0){
            event(new Registered($user = $this->create($request->all())));
        }else{
            event(new Registered($user = $this->firstcreate($request->all())));
        }

        $this->guard()->login($user);


        $pro = new profile;
        $pro->user_id = $user->id;
        $pro->save();

        mailer::registration(User::find($user->id));



        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'display_name' => 'required|'.display_req(),
            'login_name' => 'required|'.login_req(),
            'email' => 'required|'.email_req(),
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

    protected function firstcreate(array $data){

        $user = new User();
        $user->display_name = $data['display_name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->login_name = $data['login_name'];
        $user->hashcode = md5(uniqid(rand(), true));
        $user->level = 99;
        $user->save();

        $level = new level();
        $level->level = 99;
        $level->name = 'owner';
        $level->is_staff = 1;
        $level->save();

        $level = new level();
        $level->level = 1;
        $level->name = 'Brand New User';
        $level->is_staff = 0;
        $level->save();

        $level = new level();
        $level->level = 2;
        $level->name = 'New User';
        $level->is_staff = 0;
        $level->save();

        return User::where('display_name',$data['display_name'])->get()->first();
    }


}
