<?php

namespace App\Http\Controllers\profile;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\class_link_table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class specialPermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showSpecialPerm($user = null){

        $user = !is_null($user) ?
            User::where('display_name',$user)->get()->first() :
            User::where('id',Auth::user()->id)->get()->first();

        $perms = class_link_table::where('user_id',$user->id)->orderBy('user_group_id')->orderBy('content_group_id')->get()->all();
        foreach($perms as $perm){

            if(!is_null($perm->user_group_id)){
                $perm->user_group = $perm->user_group_id;
                $perm->user_group_id = class_link_table::where('user_group_id',$perm->user_group_id)->orderBy('content_group_id')->get()->all();

                foreach($perm->user_group_id as $group) {

                    if (!is_null($group->content_group_id)) {
                        $group->content_group = $group->content_group_id;
                        $group->content_group_id = class_link_table::where('content_group_id', $group->content_group_id)->get()->all();
                    }

                }
            }

            if(!is_null($perm->content_group_id)){
                $perm->content_group = $perm->content_group_id;
                $perm->content_group_id = class_link_table::where('user_content_id',$perm->content_group_id)->get()->all();
            }
        }

        return view('specialperm/profile')->with([
            'perms' => $perms,
            'user' => $user
        ]);

        //return and get data for special permissions user and process these for the view
    }

    public function showUserGroup($name){
        //collect group info
    }

    public function showContentGroup($name){
        //collect content group info
    }

    public function deleteSpecialPerm(Request $request){
        if(Auth::user()->level >= profileEditLevel()){
            class_link_table::destroy($request->delete/2);
            return Redirect::back();
        }
        $tables = class_link_table::where('id',$request->delete/2)->where('user_id',Auth::user()->id)->get()->first();

        if(!is_null($tables)){
            class_link_table::destroy($request->delete/2);
            return Redirect::back();
        }

    }
}
