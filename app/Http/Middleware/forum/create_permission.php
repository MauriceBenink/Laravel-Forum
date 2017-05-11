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

        switch ($type) {
            case 1:
                $post = posts::find($post)->get()->first();
                if($post->user_id != Auth::user()->id) {
                    if($this->check($post)){
                        return $this->no_perm();
                    }
                }

            case 2:
                $subtopic = sub_topics::find($subtopic)->get()->first();
                if($subtopic->user_id != Auth::user()->id) {
                    if($this->check($subtopic)){
                        return $this->no_perm();
                    }
                }

            case 3:
                $maintopic = main_topics::find($maintopic)->get()->first();
                    if($this->check($maintopic)){
                        return $this->no_perm();
                    }
        }

        return $next($request);
    }

    private function check($object){
            if (!newItem(class_basename($object))) {
                $perm = specialPermission($object);
                if (empty($perm)) {
                    return true;
                }
                if ($perm[0]->permission == 0) {
                    return true;
                }
            }
            return false;
    }

    private function no_perm()
    {
            return redirect('forum')->with('returnError', 'You do not have the permission to preform this action !');
    }
}
