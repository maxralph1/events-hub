<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            abort(401);
        }

        // if ($role === 'super-admin|admin') {
        //     $roles = explode('|', $role);

        //     if (!auth()->user()->role()->where('title', [$roles[0] || $roles[1]])->exists()) {
        //         abort(403);
        //     }

        //     // if (!auth()->user()->role()->where('title', ($roles[0] || $roles[1]))->exists()) {
        //     //     abort(403);
        //     // }

        //     // if (!auth()->user()->role()->where('title', $roles[0])->exists() || !auth()->user()->role()->where('title', $roles[1])->exists()) {
        //     //     abort(403);
        //     // }
        // } else {
        //     if (!auth()->user()->role()->where('title', $role)->exists()) {
        //         abort(403);
        //     }
        // }

        if (!auth()->user()->role()->where('title', $role)->exists()) {
            abort(403);
        }

        return $next($request);
    }
}
