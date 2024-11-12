<?php

namespace App\Http\Controllers\Api\v1;

use App\Core\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthController\v1\LoginRequest;
use App\Http\Requests\Api\AuthController\v1\RegisterRequest;
use App\Services\v1\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponse;
    // public AuthService $authService;

    public function __construct(private AuthService $authService) {}

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request)
    {
        \DB::beginTransaction();
        try {
            $response = $this->authService->register(
                name: $request->name,
                email: $request->email,
                password: $request->password
            );
            \DB::commit();
            return $this->httpResponse($response);
        } catch (\Throwable $th) {
            \DB::rollBack();
        }
    }

    public function login(LoginRequest $request)
    {
        $response = $this->authService->login(
            email: $request->email,
            password: $request->password
        );
        return $this->httpResponse($response);
    }
}
