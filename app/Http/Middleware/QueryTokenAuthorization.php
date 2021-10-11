<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class QueryTokenAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(hash_equals(csrf_token(),$request->token ?? '')) {
            return $next($request);
        }
       
        return redirect($request->redirect_uri ?? route('admin.home'))->withMessage("Failed to verify token.");
    }
}
