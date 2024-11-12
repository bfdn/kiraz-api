<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogApiErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
        try {
            return $next($request);
        } catch (\Laravel\Passport\Exceptions\OAuthServerException $e) {

            \Log::error($e);
            \Log::info("Request made by user ID: " . auth('api')->id());
            \Log::info("Request made to: " . $request->fullUrl());
            throw $e;
        }
        */


        try {
            // İsteği normal şekilde işleme
            return $next($request);
        } catch (\Throwable $exception) {

            // Hata oluşursa burada logla
            $userId = auth('api')->check() ? auth('api')->user()->id : 'Guest';
            $requestUrl = $request->fullUrl();
            $requestData = $request->all();


            \Log::channel('custom_log')->error('API Error:', [
                'user_id' => $userId,
                'url' => $requestUrl,
                'data' => $requestData,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            // Hata yanıtını döndür
            return response()->json(['message' => 'Bir hata oluştu.'], 500);
        }
    }
}
