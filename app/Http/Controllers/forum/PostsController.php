<?php

namespace App\Http\Controllers\forum;

use App\posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function __construct(Request $request)
    {
        $par = $request->route()->parameters();
        $this->middleware("path.check:{$par['maintopic']},{$par['subtopic']}");
        $this->middleware("create.perm:2,{$par['maintopic']},{$par['subtopic']}", ['only' => ['showNewPost', 'makeNewPost']]);
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

    public function makeNewPost(Request $request,$maintopic,$subtopic){

        $request['user_id'] = Auth::user()->id;

        $this->NewPostValidator($request->all())->validate();

        $send = [
            'name' => $request->title,
            'description' => $request->description,
            'content' => $request->contentt,
            'upper_level_id' => $subtopic,
            'user_level_req_vieuw' => $request->cansee,
            'user_level_req_edit' => 6,
        ];

        Auth::user()->posts()->save(new posts($send));

        return redirect("forum/$maintopic/$subtopic");
    }

    protected function NewPostValidator(array $data)
    {
        return Validator::make($data, [
            'title' => "required|min:10|max:50",
            'description' => "required|min:10|max:200",
            'contentt' =>"required|min:5|max:3000",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
            'user_id' => "exists:users,id",
        ]);
    }
}
