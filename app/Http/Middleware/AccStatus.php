<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AccStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$status = true)
    {

        if($status === true){
            if(Auth::user()->account_status == 0) {
                return redirect()->intended();
            }
        }else{
            if(Auth::user()->account_status != 0) {
                return redirect('validate');
            }
        }

        return $next($request);
    }
}
