<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class validate extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('account.status');
    }

    protected $redirectTo = '/login';



    public function showValidationForm($token = null){
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
        return redirect()->route('validation');
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
        $this->resetStatus();
        return view('confirm.acc');
    }


    protected function Hashvalidator(array $data)
    {
        $id = Auth::user()->id;

        return Validator::make($data, [
            'hash' => "required|min:32|max:32|exists:users,hashcode,id,$id",
        ]);
    }

    private function resetStatus(){
        DB::update("update users set level = 1, account_status = 0, hashcode = null where id = ".Auth::user()->id);
    }
}
