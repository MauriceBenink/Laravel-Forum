<?php

namespace App\Http\Middleware\forum;

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

    public function handle($request, Closure $next,$maintopic = null,  $subtopic = null, $post = null)
    {
        $stuff['subb'] = null;
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
            $check['post'] = (posts::all()->where('id',$post)->first());
            $type = "Post";
        }

        if($this->validator($stuff)->fails()){
            return redirect('forum')->with('returnError', "This $type doesnt exist");
        }

        if($this->check($check)){
            return redirect('forum')->with('returnError', "You do not have the permission to vieuw this $type");
        };


        return $next($request);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'main' => 'exists:main_topics,id',
            'sub' => "exists:sub_topics,id,upper_level_id,{$data['main']}",
            'post' => "exists:posts,id,upper_level_id,{$data['subb']}"
        ]);
    }

    protected function check($objects){

        foreach($objects as $object) {

            if (is_null(Auth::user())) {
                if ($object->user_level_req_vieuw != 0) {
                    return true;
                }
            } else {
                if (!(Auth::user()->level >= $object->user_level_req_vieuw)) {
                    if(empty(SpecialPermission($object))){
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
