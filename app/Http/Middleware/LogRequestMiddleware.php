<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $log = sprintf(
            "[%s] %s %s\nPayload: %s\n\n",
            now()->toDateTimeString(),
            $request->method(),
            $request->fullUrl(),
            json_encode($request->all(), JSON_UNESCAPED_SLASHES)
        );

        \Log::channel('requestlog')->info($log);

        return $next($request);
    }
}
