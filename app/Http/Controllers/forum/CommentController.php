<?php

namespace App\Http\Controllers\forum;

use App\comments;
use App\posts;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class CommentController extends Controller
{
    protected $redirectTo = '/forum';

    public function __construct(Request $request)
    {
        $par = $request->route()->parameters();
        $this->middleware("path.check:{$par['maintopic']},{$par['subtopic']},{$par['post']}");
        $this->middleware("create.perm:1,{$par['maintopic']},{$par['subtopic']},{$par['post']}", ['only' => ['showNewComment', 'makeNewComment']]);
    }

    public function showComments($maintopic,$subtopic,$post)
    {
        $comments = comments::all()->where('upper_level_id', $post);
        return view('forum/comments')->with([
            'comments' => $comments,
            'post' => $post,
            "maintopic" => $maintopic,
            'subtopic' => $subtopic,
        ]);
    }

    public function showNewComment($maintopic, $subtopic, $post)
    {
        $showpost = posts::all()->where('id', $post);
        return view('forum/new/comments')->with([
            'maintopic' => $maintopic,
            'subtopic' => $subtopic,
            'post' => $post,
            'showpost' => $showpost,
        ]);
    }

    public function makeNewComment(Request $request,$mainpost,$subpost, $post)
    {
        if($request->title == null){
            unset($request['title']);
        }

        $this->CommentValidator($request->all())->validate();

        $send = [
            'name' => $request->title,
            'content' => $request->commentContent,
            'user_level_req_vieuw' => $request->cansee ,
            'upper_level_id' => $post,
            'user_id' => Auth::user()->id,
            'user_level_req_edit' => 6,
        ];

        Auth::user()->comments()->save(new comments($send));

        return redirect("forum/$mainpost/$subpost/$post");
    }


    protected function CommentValidator(array $data)
    {
        return Validator::make($data, [
            'title' => "min:10|max:50",
            'commentContent' =>"required|min:5|max:3000",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
        ]);
    }


}