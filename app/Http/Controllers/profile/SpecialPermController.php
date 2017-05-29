<?php

namespace App\Http\Controllers\profile;

use App\User;
use Illuminate\Support\Facades\Validator;
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
        $this->middleware("level:".profileEditLevel())->only(['addUserGroup','addContentGroup','deleteSpecialPerm','newGroup']);
    }

    public function showSpecialPerm($user = null){

        $user = !is_null($user) ?
            User::where('display_name',$user)->get()->first() :
            User::where('id',Auth::user()->id)->get()->first();

        $perms = class_link_table::where('user_id',$user->id)
            ->orderBy('user_group_id')
            ->orderBy('content_group_id')
            ->orderBy('main_topics_id','DESC')
            ->orderBy('sub_topics_id','DESC')
            ->orderBy('posts_id','DESC')
            ->orderBy('comments_id','DESC')
            ->get()->all();
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
                $perm->content_group_id = class_link_table::where('content_group_id',$perm->content_group_id)->get()->all();
            }
        }

        return view('specialperm/profile')->with([
            'perms' => $perms,
            'user' => $user
        ]);

        //return and get data for special permissions user and process these for the view
    }

    public function showUserGroup($name){

        $group = class_link_table::where('group_name',$name)->get()->first();
        if(is_null($group)){
            return redirect('forum')->with('returnError',"this User Group doesnt not exist");
        }
        if(is_null($group->user_group_id)){
            return redirect('forum')->with('returnError',"this User Group doesnt not exist");
        }

        $group = class_link_table::where('user_group_id',$group->user_group_id)
                                            ->orderBy('content_group_id',"ASC")
                                            ->orderBy('main_topics_id','DESC')
                                            ->orderBy('sub_topics_id','DESC')
                                            ->orderBy('posts_id','DESC')
                                            ->orderBy('comments_id','DESC')
                                            ->get()->all();
        $people = array();

        foreach($group as $solo){
            if(!is_null($solo->user_id)){
                $people[] = $solo;
            }
            if(!is_null($solo->content_group_id)){
                $solo->content_group = $solo->content_group_id;
                $solo->content_group_id = class_link_table::where('content_group_id',$solo->content_group_id)->get()->all();
            }
        }

        return view("specialperm/group")->with([
            'group' => $group,
            'people' => $people,
            'groupname' => $name
        ]);
    }

    public function showContentGroup($name){

        $group = class_link_table::where('group_name',$name)->get()->first();
        if(is_null($group)){
            return redirect('forum')->with('returnError',"this Content Group doesnt not exist");
        }
        if(is_null($group->content_group_id)){
            return redirect('forum')->with('returnError',"this Content Group doesnt not exist");
        }

        $group = class_link_table::where('content_group_id',$group->content_group_id)
                                            ->orderBy('main_topics_id','DESC')
                                            ->orderBy('sub_topics_id','DESC')
                                            ->orderBy('posts_id','DESC')
                                            ->orderBy('comments_id','DESC')
                                            ->get()->all();
        $people = array();

        foreach($group as $solo){
            if(!is_null($solo->user_id)){
                $people['direct'][] = $solo;
            }
            if(!is_null($solo->user_group_id)){
                $solo->user_group = $solo->user_group_id;
                $solo->user_group_id = class_link_table::where("user_group_id",$solo->user_group_id)->get()->all();
                foreach($solo->user_group_id as $usergroup){
                    if(!is_null($usergroup->user_id)){
                        $groupname = class_link_table::where('user_group_id',$solo->user_group_id)->whereNotNull('group_name')->get()->first();
                        $people["$groupname->group_name"][] = $usergroup;
                    }
                }
            }

        }
        return view("specialperm/content")->with([
            'group' => $group,
            'people' => $people,
            'groupname' => $name
        ]);
    }



    public function addUserGroup($name){
        $group = class_link_table::where('group_name',$name)->get()->first();
        if(is_null($group)){
            return redirect('forum')->with('returnError',"this User Group doesnt not exist");
        }
        if(is_null($group->user_group_id)){
            return redirect('forum')->with('returnError',"this User Group doesnt not exist");
        }

        $group = class_link_table::where('user_group_id',$group->user_group_id)
            ->orderBy('content_group_id',"ASC")
            ->orderBy('main_topics_id','DESC')
            ->orderBy('sub_topics_id','DESC')
            ->orderBy('posts_id','DESC')
            ->orderBy('comments_id','DESC')
            ->get()->all();

        return view('specialperm/add/group')->with([
            'name' =>$name,
            'group' => $group,
            'users' => User::whereNull('banned_by')->get()->all(),
            'content' => class_link_table::whereNotNull('content_group_id')->WhereNotNull('group_name')->get()->all()
        ]);


    }

    public function addContentGroup($name){
        $group = class_link_table::where('group_name',$name)->get()->first();
        if(is_null($group)){
            return redirect('forum')->with('returnError',"this Content Group doesnt not exist");
        }
        if(is_null($group->content_group_id)){
            return redirect('forum')->with('returnError',"this Content Group doesnt not exist");
        }

        $group = class_link_table::where('content_group_id',$group->content_group_id)
            ->orderBy('main_topics_id','DESC')
            ->orderBy('sub_topics_id','DESC')
            ->orderBy('posts_id','DESC')
            ->orderBy('comments_id','DESC')
            ->get()->all();

        return view('specialperm/add/content')->with([
            'name' =>$name,
            'content' => $group,
            'group' => class_link_table::whereNotNull('user_group_id')->WhereNotNull('group_name')->orderBy('group_name')->get()->first(),
            'users' => User::whereNull('banned_by')->get()->all(),
        ]);

    }

    public function newGroup(Request $request){

        Validator::make($request->all(),[
            'contentGroup' => 'unique:class_link_tables,group_name|required|min:5|max:25'
        ])->validate();

        $class = new class_link_table();
        switch(explode(' ',$request->newGroup)[2]){
            case "Content" :
                $class->content_group_id = class_link_table::orderBy('content_group_id','desc')->get()->first()->content_group_id+1;
                $return = "content/specialperm/$request->contentGroup";
                break;
            case "User" :
                $class->user_group_id = class_link_table::orderBy('user_group_id','desc')->get()->first()->user_group_id+1;
                $return = "group/specialperm/$request->contentGroup";
                break;
        }
        $class->group_name = $request->contentGroup;
        $class->save();

        return redirect($return);

    }

    public function editGroup(Request $request){

        if($request->type != 'content' && $request->type != 'user'){
            return redirect("forum")->with('returnError',"This Type does Not exists, please dont mess in the HTML");
        }

        $groupname = $request->groupname;

        if($request->groupname == class_link_table::where("{$request->type}_group_id",$request->info)->whereNotNull('group_name')->get()->first()->group_name){
            unset($request['groupname']);
        }

        Validator::make($request->all(),[
            'groupname' => 'unique:class_link_tables,group_name|min:5|max:25',
            'info' => "required|exists:class_link_tables,{$request->type}_group_id|integer",
        ])->validate();

        $class = class_link_table::where("{$request->type}_group_id",$request->info)->get();

        if(isset($request->groupname)){
            $change = class_link_table::find($class->where('group_name','<>',null)->first()->id);
            $change->group_name = $request->groupname;
            $change->save();
            $groupname = $change->groupname;
        }

        if(isset($request->add['user'])) {
            foreach ($request->add['user'] as $user) {
                if (is_null($class->where('user_id', $user)->first())) {
                    $new = new class_link_table();
                    $new->user_id = $user;
                    $request->type == 'user' ?
                        $new->user_group_id = $request->info :
                        $new->content_group_id = $request->info;
                    $new->save();
                }
            }
        }

        if(isset($request->add['content'])) {
            foreach ($request->add['content'] as $content) {
                if (is_null($class->where('content_group_id', '=', $content)->first())) {
                    $new = new class_link_table();
                    $new->content_group_id = $content;
                    $new->user_group_id = $request->info;
                    $new->save();
                }
            }
        }

        if(isset($request->add['group'])) {
            foreach ($request->add['group'] as $group) {
                if (is_null($class->where('user_group_id', '=', $group)->first())) {
                    $new = new class_link_table();
                    $new->content_group_id = $request->info;
                    $new->user_group_id = $group;
                    $new->save();
                }
            }
        }

        return $request->type == 'user'?
            redirect("group/specialperm/$groupname"):
            redirect("content/specialperm/$groupname");
    }

    public function deleteSpecialPerm(Request $request){

        if(isset($request->remove)&&!empty($request->remove)){
            $request->remove = explode('||',$request->remove);
            if(Auth::user()->level >= profileEditLevel()){
                switch($request->remove[0]){
                    case "group" :
                        class_link_table::killAll($request->remove[1], 'user_group_id');
                        break;
                    case "content" :
                        class_link_table::killAll($request->remove[1], 'content_group_id');
                        break;
                }
                return url('forum');
            }
        }

        if(Auth::user()->level >= profileEditLevel()){
            class_link_table::destroy($request->delete/2);
            return Redirect::back();
        }
        $tables = class_link_table::where('id',$request->delete/2)->where('user_id',Auth::user()->id)->get()->first();

        if(!is_null($tables)){
            class_link_table::destroy($request->delete/2);
            return Redirect::back();
        }

        return Redirect::back();
    }
}
