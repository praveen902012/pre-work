<?php
namespace Redlof\Core\RedlofSDK\Middleware;

use Closure;

class RedlofAuth
{
    public function handle($request, Closure $next)
    {
        if ($request->REDLOF_PROJECT_KEY !== env('REDLOF_PROJECT_KEY')) {
            return response('You are not authorised', 401);
        }

        $response = $next($request);

        return $response;
    }
}
