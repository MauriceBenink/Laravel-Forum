<?php

namespace App\Http\Controllers;

use App\class_link_table;
use App\level;
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

    public function showUsers($rank = null){

        if(isset($_GET['options'])&&!empty($_GET['options'])){
            $rank = $_GET['options'];
        }

        if(is_null($rank)){
          $user = User::orderBy('level','DESC')->get()->all();
        }else{
            $user = User::where('level',level::where('name',$rank)->get()->first()->level)->orderBy('level','DESC')->get()->all();
        }

        return view("panel/users")->with([
            'users' => $user,
            'rank' => $rank,
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

    public function showLevels(){

        $level = level::max('level')==Auth::user()->level?level::orderBy('level')->get()->all():level::where('level','<',Auth::user()->level)->orderBy('level')->get()->all();

        return view("panel/levels")->with([
            'levels' => $level,
        ]);
    }

    public function editlevels(Request $request){

        $request['staff'] = $request->staff=='on'?true:false;

        if(isset($request->delete)){
            return $this->dellevel($request);
        }

        if(!isset($request->id)){
            return $this->addlevel($request);
        }
        return $this->editlevel($request);
    }

    private function dellevel($request){

        $level = level::where('id',$request->id)->get()->first();

        if(Auth::user()->level != level::max('level')) {
            if (Auth::user()->level <= $request->level) {
                return redirect('adminPanel/levels')->with('returnError', 'Cannot delete levels higher then you!');
            }
        }

        if($level->level == 1 || $level->level == 2){
            return redirect('adminPanel/levels')->with('returnError', 'Cannot delete levels 1 and 2');
        }

        if(User::where('level',$level->level)->count('level') != 0){
            return redirect('adminPanel/levels')->with('returnError', 'Cannot delete levels with people in it');
        }

        level::destroy($level->id);

        return redirect('adminPanel/levels');
    }

    private function editlevel($request){

        $level = level::where('id',$request->id)->get()->first();
        $levels = level::get();

        if($request->level == $level->level){
            $request['level'] = null;
        }

        Validator::make($request->all(),[
            'name' => 'required|min:2|max:50',
            'level' => 'nullable|integer|min:0|max:99|unique:levels,level',
            'staff' => 'required|boolean'
        ])->validate();

        if(is_null($request->level)){
            $request['level'] = $level->level;
        }

        if(($level->level == 1||$level->level == 2)&& $level->level != $request->level){
            return redirect('adminPanel/levels')->with('returnError', 'Cannot edit levels 1 and 2');
        }

        if(Auth::user()->level != $levels->max('level')) {
            if (Auth::user()->level <= $level->level) {
                return redirect('adminPanel/levels')->with('returnError', 'Cannot edit levels higher then you!');
            }
            if (Auth::user()->level <= $request->level) {
                return redirect('adminPanel/levels')->with('returnError', 'Cannot change level to higher then your own!');
            }
        }

        if($level->level != $request->level){
            User::where('level',$level->level)->update(['level' => $request->level]);
        }

        $level->level = $request->level;
        $level->name = $request->name;
        $level->is_staff = $request->staff?1:0;
        $level->save();

        return redirect('adminPanel/levels');
    }

    private function addlevel($request){

        Validator::make($request->all(),[
            'name' => 'required|min:2|max:50',
            'level' => 'required|integer|min:0|max:99|unique:levels,level',
            'staff' => 'required|boolean'
        ])->validate();

        if(Auth::user()->level != level::max('level')) {
            if (Auth::user()->level <= $request->level) {
                return redirect('adminPanel/levels')->with('returnError', 'Cannot make levels higher then you!');
            }
        }

        $level = new level();
        $level->name = $request->name;
        $level->level = $request->level;
        $level->is_staff = $request->staff?1:0;
        $level->save();

        return redirect('adminPanel/levels');
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
