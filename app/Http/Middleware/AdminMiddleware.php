<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //echo $request->user()->email;
        $role = Role::findOrFail($request->user()->role_id);

        if($role->name == 'admin')
            return $next($request);
        else{
            //return response()->json('Invalid Token', 401);
            //return response()->json(['error' => 'Unauthenticated.'], 401);
            return response('Unauthorized Action', 403);
        }
    }
}
