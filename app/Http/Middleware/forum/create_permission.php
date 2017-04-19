<?php

namespace App\Http\Middleware\forum;

use App\main_topics;
use App\posts;
use App\sub_topics;
use Closure;
use Illuminate\Support\Facades\Auth;

class create_permission
{
    /**
     * Handle an incoming request.
     *
     * @param   int $type 1 = comment 2 = post 3 = sub_topic 4 = main_topic
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type, $maintopic = null, $subtopic = null, $post = null)
    {
        if (is_null(Auth::user())) {
            return redirect('login')->with('returnError', 'You have to login first !');
        }
        if (Auth::user()->level < $type * 2) {
            return $this->no_perm();
        }

        switch ($type) {
            case 1:
                $post = posts::all()->where('id', $post);
                $this->check($post->first());

            case 2:
                $subtopic = sub_topics::all()->where('id', $subtopic);
                $this->check($subtopic->first());

            case 3:
                $maintopic = main_topics::all()->where('id',$maintopic);
                $this->check($maintopic->first());
        }

        return $next($request);
    }

    private function check($object){

        if($object->user_level_req_vieuw > Auth::user()->level){
            return $this->no_perm();
        }
    }

    private function no_perm()
    {
        return redirect('forum')->with('returnError', 'You do not have the permission to preform this action !');
    }
}
