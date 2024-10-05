<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $isAdmin = session('user')->roles[0]->name === 'admin' ? true : false;
        $user = User::with('roles', 'permissions')->where('uid', Auth::user()->uid)->first();
        $isAdmin = $user->roles[0]->name == 'admin' || $user->roles[0]->name == 'bxssUser'  ? true : false;
        if (!$isAdmin) {
            return abort(403);
        }
        return $next($request);
    }
}
