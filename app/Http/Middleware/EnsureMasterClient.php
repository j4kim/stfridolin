<?php

namespace App\Http\Middleware;

use App\Exceptions\NotMasterClientException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class EnsureMasterClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('X-Client-Id') !== Cache::get('master-client-id')) {
            throw new NotMasterClientException;
        }
        return $next($request);
    }
}
