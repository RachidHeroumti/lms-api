<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized: No authenticated user.'], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json(['error' => 'Forbidden: You do not have the right role.'], 403);
        }

        $request->merge(['user' => $user]);

        return $next($request);
    }
}
