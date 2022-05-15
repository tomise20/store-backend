<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->headers->get('X-API-TOKEN');
        if(!$token || $token !== "store-api-b8b6eac03dcd96753c77c1cb13914cb5e5766185")  {
            return response('Missing api token!', Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
