<?php

namespace App\Http\Controllers;

use App\class_link_table;
use App\User;
use App\main_topics;
use App\sub_topics;
use App\Posts;
use App\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('level:'.min_mod_level());
    }

    public function showPanel(){
        return view("panel/main");
    }

    public function showUsers(){
        return view("panel/users")->with([
            'users' => User::orderBy('level','DESC')->get()->all()
        ]);
    }

    public function showUserGroups(){
        return view("panel/Groups")->with([
            'type' => 'User',
            'groups' => class_link_table::whereNotNull('group_name')->whereNotNull('user_group_id')->get()->all(),
        ]);
    }

    public function showBanned(){
        return view('panel/banned')->with([
            'holder' => [
                main_topics::whereNotNull('banned_by')->get()->all(),
                sub_topics::whereNotNull('banned_by')->get()->all(),
                posts::whereNotNull('banned_by')->get()->all(),
                comments::whereNotNull('banned_by')->get()->all(),
            ]
        ]);
    }

    public function showContentGroups(){
        return view("panel/Groups")->with([
            'type' => 'Content',
            'groups' => class_link_table::whereNotNull('group_name')->whereNotNull('content_group_id')->get()->all(),
        ]);
    }

    public function editUsers(Request $request){
        $holder = Validator::make([
            'subject' => $request->user,
            'reason' => $request->reason,
            'unban' => $request->unban
        ],[
            'subject' => "exists:Users,display_name",
            'reason' => "nullable|required_if:unban,null|min:4"
        ]);

        if(!$holder->fails()) {
            if (!is_null($request->reason)) {
                $user = User::where('display_name', $request->user)->get()->first();
                if (Auth::user()->level > $user->level) {
                    $user->banned_by = Auth::user()->id;
                    $user->banned_reason = $request->reason;
                    $user->save();
                    return redirect("adminPanel/Users");
                }
                return redirect("adminPanel/Users")->with('returnError', 'You cannot ban someone in a higher position!');
            }
            if (!is_null($request->unban)) {
                $user = User::where('display_name', $request->user)->get()->first();
                return $this->unban($user);
            }
        }
        return redirect("adminPanel/Users")->with('returnError','Invalid input!');

    }

    public function unbanPost(Request $request){
        if(!is_null($request->comments)){
            $item = comments::where('id',$request->comments)->get()->first();
        }
        elseif(!is_null($request->posts)){
            $item = posts::where('id',$request->posts)->get()->first();
        }
        elseif(!is_null($request->sub_topics)){
            $item = sub_topics::where('id',$request->sub_topics)->get()->first();
        }
        elseif(!is_null($request->main_topics)){
            $item = main_topics::where('id',$request->main_topics)->get()->first();
        }
        else{
            return redirect(url('adminPanel/bannedPosts'))->with('returnError','Wrong input!');
        }

        return $this->unban($item);
    }

    private function unban($object){
        $banner = User::find($object->banned_by)->get()->first();
        if (Auth::user()->level >= $banner->level) {
            $object->banned_by = null;
            $object->banned_reason = null;
            $object->save();
            return redirect(url()->current());
        }
        return redirect(url()->current())->with('returnError', 'You cannot unban someone banned by someone with a higher position');
    }
}
