<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class EnsureCartToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasCookie('cart_token')) {
            $cartToken = Str::uuid()->toString();
            cookie()->queue('cart_token', $cartToken, 60 * 24 * 30);
        }

        return $next($request);
    }
}
