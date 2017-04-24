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
        $this->middleware("create.perm:3,{$par['maintopic']},{$par['subtopic']}", ['only' => ['showNewPost', 'makeNewPost']]);
    }

    public function showPosts($maintopic,$subtopics){
        $posts = posts::all()->where('upper_level_id',$subtopics);

        return view('forum/post')->with(['posts' => $posts,'maintopic' => $maintopic]);
    }

    public function showNewPost($maintopic, $subtopic){
        $posts = posts::all()->where('upper_level_id',$subtopic);

        return view('forum/new/posts')->with([
            'maintopic' => $maintopic,
            'subtopic' => $subtopic,
            'posts' => $posts,
        ]);
    }
}
