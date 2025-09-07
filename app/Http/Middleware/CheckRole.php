<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $user = auth()->user();
        
        // If checking for admin role
        if ($role === 'admin' && !$user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this admin area.');
        }
        
        // If checking for vet role, allow both vets and admins (admins can do vet things)
        if ($role === 'vet' && !$user->isVet() && !$user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this veterinarian area.');
        }
        
        // For other roles, check exact match
        if ($role !== 'admin' && $role !== 'vet' && $user->role !== $role) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}