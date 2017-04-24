<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class rank
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $rankreq)
    {
        if(is_null(Auth::user())){
            $this->notallowed('login',['returnError' => 'Sorry you have to login first']);
        }

        if(Auth::user()->level < $rankreq){
            $this->notallowed('forum',['returnError' => 'You do not have the required permission to do this']);
        }


        return $next($request);
    }

    private function notallowed($redirect,$with = null){
        if(url()->current() == "http://localhost:8888/laravel-filemanager"){
            dd("sorry you do not have the permission to do this");
        }else{
            return redirect($redirect)->with($with);
        }
    }
}
