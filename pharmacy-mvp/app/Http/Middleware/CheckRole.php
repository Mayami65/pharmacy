<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($role === 'manager' && !$user->isManager()) {
            abort(403, 'Access denied. Manager role required.');
        }

        if ($role === 'pharmacist' && !$user->isPharmacist()) {
            abort(403, 'Access denied. Pharmacist role required.');
        }

        return $next($request);
    }
}
