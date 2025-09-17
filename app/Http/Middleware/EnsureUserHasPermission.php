<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $currentRoute = $request->route()->getName();
        $user = $request->user();

        if (!$user) {
            abort(403, 'You are not allowed to access this page');
        }

        $role = Role::where('name', $user->role)->first();

        if (!$role) {
            abort(403, 'You are not allowed to access this page');
        }

        $allowedPages = json_decode($role->allowed_pages, true) ?? [];

        if (in_array('*', $allowedPages)) {
            return $next($request);
        }

        if (!in_array($currentRoute, $allowedPages)) {
            abort(403, 'You are not allowed to access this page');
        }

        return $next($request);
    }


}
