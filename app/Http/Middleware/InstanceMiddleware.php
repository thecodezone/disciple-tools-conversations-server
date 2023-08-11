<?php

namespace App\Http\Middleware;

use App\Models\Instance;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $channel = $request->route('channel');
        $service = $request->route('service');
        $instance = $request->route('instance');

        if ($instance) {
            $instance = Instance::find($instance);
        }

        if (! $channel && ! $service && ! $instance) {
            abort(404);
        }

        //Get the instance from the service
        if (! $instance && ! $service && $channel) {
            $service = $channel->service;
        }

        if (! $instance && $service) {
            $instance = $service->instance;
        }

        if (! $instance) {
            abort(404);
        }

        if (! $request->user()->instances->contains($instance)) {
            abort(403);
        }

        return $next($request);
    }
}
