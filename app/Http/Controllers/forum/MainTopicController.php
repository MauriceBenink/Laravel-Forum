<?php

namespace App\Http\Controllers\forum;

use App\main_topics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MainTopicController extends Controller
{

    public function __construct()
    {
        $this->middleware("create.perm:4",['only' => ['showNewMainTopics', 'makeNewMainTopic']]);
    }

    public function showMainTopics(){
        $maintopic = main_topics::orderBy('created_at','desc')->get();;

        return view('forum/main_topic')->with(['maintopics' => $maintopic]);
    }

    public function showNewMainTopics(){
        return view('forum/new/maintopics');
    }

    public function makeNewMainTopic(Request $request){

        $request['user_id'] = Auth::user()->id;

        $this->NewMainTopicValidator($request->all())->validate();

        $new = new main_topics;

        $new->name = $request->title;
        $new->description = $request->description;
        $new->user_level_req_vieuw = $request->cansee;
        $new->user_level_req_edit = maintopiclevel();

        $new -> save();

        return redirect("forum");
    }

    protected function NewMainTopicValidator(array $data)
    {
        return Validator::make($data, [
            'title' => "required|min:10|max:50",
            'description' => "required|min:10|max:500",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
            'user_id' => "exists:users,id",
        ]);
    }
}
