<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the API key from the request header
        $apiKey = $request->header('x-api-key');

        if (!$apiKey) {
            return $this->errorResponse(4001, 'API key is missing. Please provide an API key.', Response::HTTP_UNAUTHORIZED);
        }

        // Find the API key in the database
        $validApiKey = ApiKey::where('key', $apiKey)->where('is_active', true)->first();

        if (!$validApiKey) {
            return $this->errorResponse(4002, 'Invalid or inactive API key.', Response::HTTP_UNAUTHORIZED);
        }

        // Perform rate limiting
        $key = 'api_limit_' . $validApiKey->id;
        $maxAttempts = 5; // Maximum number of requests allowed
        $decayMinutes = 0.5; // Time period (in minutes) for rate limiting (30 seconds)

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return $this->errorResponse(4003, 'Too many requests. Please try again later.', Response::HTTP_TOO_MANY_REQUESTS);
        }

        // Increment the number of attempts
        RateLimiter::hit($key, $decayMinutes);

        // Continue with the request
        return $next($request);
    }


    /**
     * Generate error response.
     *
     * @param int $code
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorResponse(int $code, string $message, int $statusCode): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ], $statusCode);
    }
}
