<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Check if user has one of the allowed roles
        // We assume User model has relation 'role' which has 'role_name'
        if ($user->role) {
            $userRole = strtolower($user->role->role_name);
            $allowedRoles = array_map('strtolower', $roles);

            if (in_array($userRole, $allowedRoles)) {
                return $next($request);
            }
        }

        // Redirect if unauthorized
        // If Pegawai tries to access Admin page, redirect to Dashboard
        if ($user->role && $user->role->role_name == 'Pegawai') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
