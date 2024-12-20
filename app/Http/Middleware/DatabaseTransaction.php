<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DatabaseTransaction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        DB::beginTransaction();
        try {
            $response = $next($request);
            DB::commit();

            return $response;
        } catch (Throwable $e) {
            Log::error('Rollback:' . $e);
            DB::rollBack();
            throw $e;
        }
    }
}
