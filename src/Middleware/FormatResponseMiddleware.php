<?php

namespace Giatechindo\HypervelResponseFormatter\Middleware;

use Closure;
use Giatechindo\HypervelResponseFormatter\ResponseFormatter;

class FormatResponseMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Only format if response is not already formatted
        if (!is_array($response) || !isset($response['status'])) {
            $response = ResponseFormatter::success($response);
        }

        return $response;
    }
}