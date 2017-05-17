<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Mail\mailer;

class ForgotController extends Controller
{

    use AuthenticatesUsers;


    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showForgotPass(){
        return view('auth/forgot/username');
    }

    public function showForgotUsername(){
        return view('auth/forgot/pass');
    }

    public function checkForgotPass(Request $request){

        $this->UsernameValidator($request->all())->validate();

        $user = User::where('email',$request->email)->get()->first();

        if(!empty($user)) {
            if ($user->login_name == customEncrypt($request->login_name)) {

                $user->hashcode = md5(uniqid(rand(), true));
                $user->account_status = '2';
                $user->save();

                mailer::forgotPass($user);

                return redirect('validate/password')->with('returnError','A email has been send to reset your Email adress');
            }
        }

        return view('auth/forgot/pass')->with('returnError','Wrong credentials, please try again');
    }

    public function checkForgotUsername(Request $request){

        $this->PasswordValidator($request->all())->validate();

        $user = User::where('email',$request->email)->get()->first();

        if(!empty($user)) {
            if ($this->guard()->validate(['login_name' => $user->login_name,'password' => $request->password])) {

                $user->hashcode = md5(uniqid(rand(), true));
                $user->account_status = '3';
                $user->save();

                mailer::forgotUsername($user);

                return redirect('validate/username')->with('returnError','A email has been send to reset your Email adress');
            }
        }

        return view('auth/forgot/username')->with('returnError','Wrong credentials, please try again');
    }

    private function UsernameValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|exists:Users,email',
            'login_name' => 'required'
        ]);
    }

    private function PasswordValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|exists:Users,email',
            'password' => 'required'
        ]);
    }
}
