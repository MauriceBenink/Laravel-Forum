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
            return $this->notallowed('login',['returnError' => 'Sorry you have to login first']);
        }

        if(Auth::user()->level < $rankreq){
            return $this->notallowed('forum',['returnError' => 'You do not have the required permission to do this']);
        }


        return $next($request);
    }

    private function notallowed($redirect,$with = null){
            return redirect($redirect)->with($with);
    }
}
