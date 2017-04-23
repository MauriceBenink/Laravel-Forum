<?php

namespace App\Http\Controllers\forum;

use App\posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function __construct(Request $request)
    {
        $par = $request->route()->parameters();
        $this->middleware("path.check:{$par['maintopic']},{$par['subtopic']}");
    }

    public function showPosts($maintopic,$subtopics){
        $posts = posts::all()->where('upper_level_id',$subtopics);

        return view('forum/post')->with(['posts' => $posts,'maintopic' => $maintopic]);
    }

    public function showNewPost(){

    }
}
