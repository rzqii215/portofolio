<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureMahasiswa
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return redirect()->route('login');
        }

        if ($user->hasAnyRole(['admin', 'super_admin'])) {
            return redirect('/admin');
        }

        if (! $user->hasRole('mahasiswa')) {
            abort(403);
        }

        return $next($request);
    }
}