<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearanceRateLimiting
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->limiter = app(RateLimiter::class);

        // Rate limit clearance application submission - 1 per hour per user
        if ($request->routeIs('dashboard.clearance.submit')) {
            $key = 'clearance:submit:' . auth()->id();
            if ($this->limiter->tooManyAttempts($key, 1, 60)) { // 1 attempt per 60 minutes
                return response()->json([
                    'message' => 'Umecheleza. Tafadhali jaribu tena baada ya dakika ' . $this->limiter->availableIn($key),
                    'retry_after' => $this->limiter->availableIn($key),
                ], 429);
            }
            $this->limiter->hit($key);
        }

        // Rate limit clearance review (approval/denial) - 10 per minute per officer
        if ($request->routeIs('dashboard.applications.review')) {
            $key = 'clearance:review:' . auth()->id();
            if ($this->limiter->tooManyAttempts($key, 10, 1)) { // 10 attempts per 1 minute
                return response()->json([
                    'message' => 'Umecheleza sana na maombi. Tafadhali subiri.',
                    'retry_after' => $this->limiter->availableIn($key),
                ], 429);
            }
            $this->limiter->hit($key);
        }

        // Rate limit support ticket creation - 5 per day per user
        if ($request->routeIs('dashboard.support.store')) {
            $key = 'support:create:' . auth()->id() . ':' . today()->toDateString();
            if ($this->limiter->tooManyAttempts($key, 5, 24 * 60)) { // 5 per day
                return response()->json([
                    'message' => 'Umecheleza maombi ya msaada. Tafadhali jaribu tena kesho.',
                    'retry_after' => $this->limiter->availableIn($key),
                ], 429);
            }
            $this->limiter->hit($key);
        }

        // Rate limit clearance view/fetch - 30 per minute per user
        if ($request->routeIs('dashboard.clearance.index', 'dashboard.applications.index', 'api.clearance.*')) {
            $key = 'clearance:view:' . auth()->id();
            if ($this->limiter->tooManyAttempts($key, 30, 1)) { // 30 per minute
                return response()->json([
                    'message' => 'Umecheleza maombi. Tafadhali subiri.',
                    'retry_after' => $this->limiter->availableIn($key),
                ], 429);
            }
            $this->limiter->hit($key);
        }

        return $next($request);
    }
}
