<?php

namespace App\Http\Middleware\forum;

use App\comments;
use App\main_topics;
use App\posts;
use App\sub_topics;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class exists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $redirectTo = '/forum';

    public function handle($request, Closure $next,$maintopic = null,  $subtopic = null, $post = null, $comment =null)
    {

        $stuff['subb'] = null;
        $stuff['postt'] = null;

        if($maintopic != null){
            $stuff['main'] = $maintopic;
            $check['main'] = (main_topics::all()->where('id',$maintopic)->first());
            $type = "MainTopic";
        }
        if($subtopic != null){
            $stuff['sub'] = $subtopic;
            $stuff['subb'] = $subtopic;
            $check['sub'] = (sub_topics::all()->where('id',$subtopic)->first());
            $type = "SubTopic";
        }
        if($post != null){
            $stuff['post'] = $post;
            $stuff['postt'] = $post;
            $check['post'] = (posts::all()->where('id',$post)->first());
            $type = "Post";
        }
        if($comment != null){
            $stuff['comment'] = $comment;
            $check['comment'] = (comments::all()->where('id',$comment)->first());
            $type = "comment";
        }

        if($this->validator($stuff)->fails()){
            return redirect('forum')->with('returnError', "This $type doesnt exist");
        }

        switch($this->check($check)){
            case 1:
                return redirect('forum')->with('returnError', "This $type is no longer available");
            case 2:
                return redirect('forum')->with('returnError', "You do not have the permission to vieuw this $type");
        };


        return $next($request);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'main' => 'exists:main_topics,id',
            'sub' => "exists:sub_topics,id,upper_level_id,{$data['main']}",
            'post' => "exists:posts,id,upper_level_id,{$data['subb']}",
            'comment' =>"exists:comments,id,upper_level_id,{$data['postt']}"
        ]);
    }

    protected function check($objects){
        foreach($objects as $object) {

            if(!is_null($object->banned_by)){
                return 1;
            }

            if (is_null(Auth::user())) {
                if ($object->user_level_req_vieuw != 0) {
                    return 2;
                }
            } else {
                if (!(Auth::user()->level >= $object->user_level_req_vieuw)) {
                    if(empty(SpecialPermission($object))){
                        return 2;
                    }
                }
            }
        }
    }
}
