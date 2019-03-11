<?php

namespace App\Http\Middleware;

use Closure;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;

class CheckWebmaster
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role_id > 3){

            Flash::error('The requested route is not available');
            return redirect()->route('transactions.index');

        }
        return $next($request);
    }
}
