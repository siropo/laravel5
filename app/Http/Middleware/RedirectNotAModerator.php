<?php

namespace App\Http\Middleware;

use Closure;

class RedirectNotAModerator
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

        if (!$request->user()->isAModerator()) {
            return redirect('ads');
        }

        return $responce;
    }
}
