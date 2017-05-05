<?php

namespace App\Http\Middleware;

use Closure;

class RedirectNotAAdministrator
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
        $responce = $next($request);
        //$request->user();

        if (!$request->user()->isAAdministrator()) {
            return redirect('ads');
        }

        return $responce;
    }
}
