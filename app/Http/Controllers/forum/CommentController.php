<?php

namespace App\Http\Controllers\forum;

use App\class_link_table;
use App\comments;
use App\posts;
use Illuminate\Support\Facades\DB;
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
        $this->middleware("create.perm:1,{$par['maintopic']},{$par['subtopic']},{$par['post']}", ['only' => ['showNewComment', 'makeNewComment','editComment','showEditComment','makeEditComment']]);
    }

    public function showComments($maintopic,$subtopic,$post)
    {
        $comments = comments::where('upper_level_id', $post)->orderBy('created_at','desc')->get();
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

    public function showEditComment($mainpost,$subpost,$post,$id){
        $comment = comments::all()->where('id',$id)->first();

        if($this->checkComment($post,$comment)){
            $post = posts::all()->where('id', $post);
            return view('forum/edit/comments')->with([
                'maintopic' => $mainpost,
                'subtopic' => $subpost,
                'post' => $post,
                'comment' => $comment,
            ]);
        }

        return redirect('forum')->with('returnError',noPermError());
    }

    public function makeNewComment(Request $request,$mainpost,$subpost, $post)
    {
        if($request->title == null){
            unset($request['title']);
        }

        $request['user_id'] = Auth::user()->id;

        $this->NewCommentValidator($request->all())->validate();

        $send = [
            'name' => $request->title,
            'content' => $request->commentContent,
            'user_level_req_vieuw' => $request->cansee ,
            'upper_level_id' => $post,
            'user_id' => Auth::user()->id,
            'user_level_req_edit' => min_mod_level(),
        ];

        Auth::user()->comments()->save(new comments($send));

        return redirect("forum/$mainpost/$subpost/$post");
    }

    public function makeEditComment(Request $request,$maintopic,$subtopic,$post,$comment){
        if($request->rating == 'on'){
            $request['rating'] = true;
        }else{
            $request['rating'] = false;
        }

        if(is_null($request->title)){
            unset($request['title']);
        }

        $this->EditCommentValidator($request->all())->validate();

        $comment = comments::find($comment);

        if($this->checkComment($post,$comment)) {
            $comment->name = $request->title;
            $comment->content = $request->commentContent;
            $comment->user_level_req_vieuw = $request->cansee;

            if (Auth::user()->level >= min_mod_level()) {
                if (isset($request->author)) {
                    $comment->user_id = $request->author;
                }
                if (isset($request->upper)) {
                    $comment->upper_level_id = $request->upper;
                }
                if (isset($request->canedit)) {
                    $comment->user_level_req_edit = $request->canedit;
                }
                if ($request->rating) {
                    $comment->rating = 0;
                }
                if(isset($request->priority)){
                    $comment->priority = $request->priority;
                }
                $comment->save();

                $this->specialperm($comment, $request->specialperm0, $request->specialperm1);

                return redirect("forum/$maintopic/$subtopic/$post");
            }
        }
        return redirect('forum')->with('returnError',noPermError());
    }


    public function editComment(Request $request,$maintpost,$subpost,$post){

        switch($request->type){

            case "edit":
                return redirect("forum/$maintpost/$subpost/$post/$request->id/edit");
            break;

            case "remove":
                return $this->removeComment($post,$request->id);
                break;
            case "ban":
                return $this->banComment($request->id,$request->reason);
                break;

            default :
                return redirect('forum')->with('returnError',noPermError());
        }

    }


    protected function removeComment($post,$id)
    {
        $comment = comments::all()->where('id',$id)->first();
        if ($this->checkComment($post, $comment)) {

            comments::killme($comment);

            return redirect(url()->current());
        }

        return redirect('forum')->with('returnError', noPermError());
    }

    private function banComment($id,$reason){
        if(auth_level(min_mod_level())){

            $ban = comments::find($id);
            $ban->banned_by = Auth::user()->id;
            $ban->banned_reason = $reason;

            if( $this->BanValidator([
                "banned_by" =>$ban->banned_by,
                "banned_reason" => $ban->banned_reason
            ])->fails()){
                return redirect("forum")->with('returnError','Failed to ban comment');
            }

            $ban->save();

            return redirect(url()->current());
        }
    }


    private function checkComment($post,$comment){
        if(!is_null($comment)) {
            if (user_edit_permission($comment)) {
                if ($comment->up->id == $post) {
                    return true;
                }
            }
        }
        return false;
    }

    private function EditCommentValidator(array $data)
    {
        return Validator::make($data, [
            'author' => "exists:users,id|integer",
            'title' => "min:10|max:50",
            'commentContent' =>"required|min:5|max:3000",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
            'canedit' =>"integer|max:".Auth::user()->level."|min:".min_mod_level(),
            'priority' => "required|integer|max:9|min:0",
            'rating' => "boolean",
            'upper' => "integer|exists:posts,id"
        ]);
    }

    private function NewCommentValidator(array $data)
    {
        return Validator::make($data, [
            'title' => "min:10|max:50",
            'commentContent' =>"required|min:5|max:3000",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
            'user_id' => "exists:users,id",
        ]);
    }


}