<?php

namespace App\Core;

trait HttpResponse
{
    // public function httpResponse(bool $isSuccess, string $message, mixed $data, int $statusCode)
    // {
    //     if (!$message) {
    //         return response()->json(['message' => 'Message is required'], 500);
    //     }

    //     return response()->json([
    //         'isSuccess' => $isSuccess,
    //         'data' => $data,
    //         'message' => $message
    //     ], $statusCode);
    // }

    public function httpResponse(ServiceResponse $serviceResponse): \Illuminate\Http\JsonResponse
    {
        if (!$serviceResponse->getMessage()) {
            return response()->json(['message' => 'Message is required'], 500);
        }

        return response()->json([
            'status' => $serviceResponse->isSuccess(),
            'message' => $serviceResponse->getMessage(),
            'data' => $serviceResponse->getData()
        ], $serviceResponse->getStatusCode());
    }
}
