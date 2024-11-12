<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'logapierrors' => \App\Http\Middleware\LogApiErrors::class,
        ]);

        // Middleware gruplarını manuel olarak tanımlayın
        $middleware->middlewareGroups = [
            'api' => [
                \Rakutentech\LaravelRequestDocs\LaravelRequestDocsMiddleware::class,
                // Diğer api grubu middleware'leri burada

            ],
            'web' => [
                // Web grubu için middleware'ler
            ],
        ];

        // Global middleware'leri burada ekleyebilirsiniz
        // $middleware->addGlobal(\App\Http\Middleware\YourGlobalMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        $exceptions->render(function (\Throwable $exception, Request $request) {
            if ($request->is('api/*')) {
                // return response()->json([
                //     'status' => 'false',
                //     'message' => $e->getMessage(),
                // ], 404);
                // Hata oluşursa burada logla
                $userId = auth('api')->check() ? auth('api')->user()->id : 'Guest';
                $requestUrl = $request->fullUrl();
                $requestData = $request->all();


                \Log::channel('custom_log')->error('API Error:', [
                    'user_id' => $userId,
                    'url' => $requestUrl,
                    'data' => $requestData,
                    'error' => $exception->getMessage(),
                    // 'trace' => $exception->getTraceAsString(),
                ]);
            }
        });
    })->create();
