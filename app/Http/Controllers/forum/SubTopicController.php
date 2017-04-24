<?php

namespace App\Http\Controllers\forum;

use App\sub_topics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SubTopicController extends Controller
{
    public function __construct(Request $request)
    {
        $par = $request->route()->parameters();
        $this->middleware("path.check:{$par['maintopic']}");
        $this->middleware("create.perm:3,{$par['maintopic']}", ['only' => ['showNewSubTopic', 'makeNewSubTopic']]);
    }


    public function showSubTopics($maintopic){
        $subtopics = sub_topics::all()->where("upper_level_id",$maintopic);

        return view('forum/sub_topic')->with(['subtopics' => $subtopics]);
    }

    public function showNewSubTopic($maintopic){

        return view('forum/new/subtopics')->with([
            'maintopic' => $maintopic
        ]);
    }

    public function makeNewSubTopic(Request $request,$maintopic){

        $request['user_id'] = Auth::user()->id;

        $this->SubTopicValidator($request->all())->validate();

        $send =[
            'user_id' => $request->user_id,
            'name' => $request->title,
            'description' => $request->description,
            'upper_level_id' => $maintopic,
            'user_level_req_vieuw' => $request->cansee,
            'user_level_req_edit' => 6,
        ];

        Auth::user()->subTopics()->save(new sub_topics($send));

        return redirect("forum/{$maintopic}");
    }

    protected function SubTopicValidator(array $data)
    {
        return Validator::make($data, [
            'title' => "required|min:10|max:50",
            'description' => "required|min:10|max:500",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
            'user_id' => "exists:users,id",
        ]);
    }
}
