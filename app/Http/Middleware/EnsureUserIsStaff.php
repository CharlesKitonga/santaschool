<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsStaff
{
    /**
     * Allow only dashboard roles (admin, manager) past this point.
     * Plain "user" accounts are bounced back to the public site.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isStaff()) {
            if ($request->expectsJson()) {
                abort(403, 'This area is restricted to staff accounts.');
            }

            return redirect('/');
        }

        return $next($request);
    }
}
