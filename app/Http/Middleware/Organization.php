<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Organization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isOrg = session()->get('user')->roles[0]->name === 'orgRep' ||session()->get('user')->roles[0]->name === 'admin' ? true : false;

        if (!$isOrg) {
            return abort(403);
        }

        return $next($request);
    }
}
