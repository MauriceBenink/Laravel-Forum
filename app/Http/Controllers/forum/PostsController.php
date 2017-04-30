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
        $this->middleware("create.perm:2,{$par['maintopic']},{$par['subtopic']}", ['only' => ['showNewPost', 'makeNewPost','editPost']]);
        if(isset($par['post'])) {
            $this->middleware("create.perm:2,{$par['maintopic']},{$par['subtopic']},{$par['post']}", ['only' => ['showEditPost', 'makeEditPost']]);
        }
    }

    public function showPosts($maintopic,$subtopics){
        $posts = posts::where('upper_level_id',$subtopics)->orderBy('created_at','desc')->get();

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

    public function showEditPost($maintopic,$subtopic,$post){

        $post = posts::all()->where('id', $post)->first();

        if(user_edit_permission($post)) {
            return view('forum/edit/posts')->with([
                'maintopic' => $maintopic,
                'subtopic' => $subtopic,
                'post' => $post,
            ]);
        }
        return redirect('forum')->with('returnError',noPermError());
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
            'user_level_req_edit' => min_mod_level(),
        ];

        Auth::user()->posts()->save(new posts($send));

        return redirect("forum/$maintopic/$subtopic");
    }

    public function makeEditPost(Request $request,$maintopic,$subtopic,$post){
        if($request->rating == 'on'){
            $request['rating'] = true;
        }else{
            $request['rating'] = false;
        }

        $this->EditPostValidator($request->all())->validate();

        $post = posts::find($post);
        if(user_edit_permission($post)){
            $post->name = $request->title;
            $post->description = $request->description;
            $post->content = $request->contentt;
            $post->user_level_req_vieuw = $request->cansee;
            if(Auth::user()->level >= min_mod_level()) {
                if (isset($request->author)) {
                    $post->user_id = $request->author;
                }
                if(isset($request->upper)){
                    $post->upper_level_id = $request->upper;
                }
                if(isset($request->canedit)){
                    $post->user_level_req_edit = $request->canedit;
                }
                if($request->rating){
                    $post->rating = 0;
                }
                if(isset($request->priority)){
                    $post->priority = $request->priority;
                }
            }

            $post->save();

            $this->specialperm($post, $request->specialperm0, $request->specialperm1);

            return redirect("forum/$maintopic/$subtopic");
        }
        return redirect('forum')->with('returnError',noPermError());
    }

    public function editPosts(Request $request,$maintopic,$subtopic){

        switch($request->type){

            case "edit":
                return redirect("forum/$maintopic/$subtopic/$request->id/edit");
                break;

            case "remove":
                return $this->removePost($request->id);
                break;
            case "ban":
                return $this->banPost($request->id,$request->reason);
                break;

            default :
                return redirect('forum')->with('returnError',noPermError());
        }
    }

    private function banPost($id,$reason){
        $post = posts::find($id);

        $post->banned_by = Auth::user()->id;
        $post->banned_reason = $reason;

        if( $this->BanValidator([
            "banned_by" =>$post->banned_by,
            "banned_reason" => $post->banned_reason
        ])->fails()){
            return redirect("forum")->with('returnError','Failed to ban comment');
        }

        $post->save();

        return redirect(url()->current());
    }

    private function removePost($id){

        posts::killme(posts::find($id));

        return redirect(url()->current());
    }

    private function EditPostValidator(array $data)
    {
        return Validator::make($data, [
            'author' => "exists:users,id|integer",
            'description' => "required|min:10|max:200",
            'title' => "required|min:10|max:50",
            'contentt' =>"required|min:5|max:3000",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
            'canedit' =>"integer|max:".Auth::user()->level."|min:".min_mod_level(),
            'priority' => "required|integer|max:9|min:0",
            'rating' => "boolean",
            'upper' => "integer|exists:posts,id"
        ]);
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
