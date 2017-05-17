<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class validate extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('showValidationForm');
        $this->middleware('account.status')->only('showValidationForm');
    }

    protected $redirectTo = '/login';



    public function showValidationForm($token = null){
        if(!is_null(Auth::user())){
            switch(Auth::user()->account_status){

                case 2: return view('auth.passReset');
                break;

            }
        }

        if($token == null) {
            return view("auth.confirm");
        }else {
            if ($this->checkhash(['hash'=>$token])) {
                switch (Auth::user()->account_status) {
                    case 1:
                        return $this->myValidateAccAtivate();
                        break;
                }
            }
        }
        return redirect()->route('validation/password');
    }

    public function showResetPassword($token = null){
        if(is_null($token)){
            return view('auth.passReset');
        }else{
            return view('auth.passReset')->with(['hash' => $token]);
        }
    }

    public function showResetUsername($token = null){
        if(is_null($token)){
            return view('auth.usernameReset');
        }else{
            return view('auth.usernameReset')->with(['hash' => $token]);
        }
    }


    public function myValidate(Request $request){

        if($this->checkhash($request->all())){
            switch (Auth::user()->account_status){
                case 1:
                    return $this->myValidateAccAtivate();
                    break;
            }
        }
    }

    public function ResetPassword(Request $request){

        $this->resetPassValidator($request->all())->validate();

        $user = User::where('hashcode',$request->hash)->get()->first();

        $user->password = bcrypt($request->password);
        $user->account_status = 0;
        $user->hashcode = null;
        $user->save();

        return redirect('login');
    }

    public function ResetUsername(Request $request){

        $this->resetUsernameValidator($request->all())->validate();

        $user = User::where('hashcode',$request->hash)->get()->first();

        $user->login_name = customEncrypt($request->login_name);
        $user->account_status = 0;
        $user->hashcode = null;
        $user->save();

        return redirect('login');
    }

    private function checkhash($token){
        $this->Hashvalidator($token)->validate();

        if($token['hash'] == Auth::user()->hashcode){
            return true;
        }else{
            return false;
        }
    }

    private function myValidateAccAtivate()
    {
        $this->resetStatus(Auth::user()->id);
        return view('confirm.acc');
    }

    private function resetStatus($id){
        $user = User::find($id);
        $user->account_status = 0;
        $user->hashcode = null;
        $user->level = validation_level();
        $user->save();
    }

    protected function Hashvalidator(array $data)
    {
        $id = Auth::user()->id;

        return Validator::make($data, [
            'hash' => "required|min:32|max:32|exists:users,hashcode,id,$id",
            'password' => 'required|min:6|confirmed',
        ]);
    }

    private function resetPassValidator(array $data){
        return Validator::make($data, [
            'hash' => "required|min:32|max:32|exists:users,hashcode",
            'password' => 'required|min:6|confirmed',
        ]);
    }

    private function resetUsernameValidator(array $data){
        return Validator::make($data, [
            'hash' => "required|min:32|max:32|exists:users,hashcode",
            'login_name' => 'required|'.login_req(),
        ]);
    }

}
