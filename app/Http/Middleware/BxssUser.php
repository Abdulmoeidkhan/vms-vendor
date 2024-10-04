<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BxssUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::with('roles', 'permissions')->where('uid', Auth::user()->uid)->first();
        $isBxss = $user->roles[0]->name == 'bxssUser' ? true : false;
        if (!$isBxss) {
            return abort(403);
        }
        return $next($request);
    }
}
