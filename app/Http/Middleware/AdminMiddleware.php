<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->header('id');

        if (!$user) {
            return response('User  not found in the request header', 400);
        }

        $user = User::find($user);

        if (!$user) {
            return response('User not found', 404);
        }

        if ($user->role == 'admin' ) {
            return $next($request);
           
        }
        return response('Unauthorized', 403);
        
    }
}
