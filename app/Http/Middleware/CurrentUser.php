<?php

namespace App\Http\Middleware;

use Closure;

class CurrentUser
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route();
        $params = $route->parameters();


        if(array_key_exists('profile', $params))
        {
            $username = $params['profile'];
        }

        if (auth()->user()->username != $username)
        {
            return Redirect()->home();
        }
        return $next($request);
    }
}
