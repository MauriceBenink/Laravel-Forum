<?php

namespace App\Http\Controllers\forum;

use App\sub_topics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubTopicController extends Controller
{
    public function __construct(Request $request)
    {
        $par = $request->route()->parameters();
        $this->middleware("path.check:{$par['maintopic']}");
    }


    public function showSubTopics($maintopic){
        $subtopics = sub_topics::all()->where("upper_level_id",$maintopic);

        return view('forum/sub_topic')->with(['subtopics' => $subtopics]);
    }
}
