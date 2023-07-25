<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $instance = $request->route('instance');

        if ($instance->id !== $request->user()->instances->contains($instance)) {
            abort(403);
        }

        return $next($request);
    }
}
