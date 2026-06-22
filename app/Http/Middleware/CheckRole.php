<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole {
    public function handle(Request $request, Closure $next, string ...$roles): Response {
        if (!$request->user()) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
            }
            return redirect('/login');
        }

        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized. Insufficient role.'], 403);
        }
        abort(403, 'Unauthorized.');
    }
}
