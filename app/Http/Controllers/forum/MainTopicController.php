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
        $maintopic = main_topics::all();

        return view('forum/main_topic')->with(['maintopics' => $maintopic]);
    }

    public function showNewMainTopics(){
        return view('forum/new/maintopics');
    }

    public function makeNewMainTopic(Request $request){

        $request['user_id'] = Auth::user()->id;

        $this->NewMainTopicValidator($request->all())->validate();

        $send =[
            'user_id' => $request->user_id,
            'name' => $request->title,
            'description' => $request->description,
            'user_level_req_vieuw' => $request->cansee,
            'user_level_req_edit' => 8
        ];

        Auth::user()->mainTopics()->save(new main_topics($send));

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
