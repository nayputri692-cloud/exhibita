<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pengganti requireRole() dari includes/auth.php:
 * - belum login            -> ke halaman login
 * - role tidak cocok       -> ke beranda (ADMIN selalu boleh)
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!in_array($user->role, $roles, true) && $user->role !== 'ADMIN') {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
