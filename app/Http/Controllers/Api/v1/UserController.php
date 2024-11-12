<?php

namespace App\Http\Controllers\Api\v1;

use App\Core\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthController\v1\LoginRequest;
use App\Http\Requests\Api\AuthController\v1\RegisterRequest;
use App\Services\v1\AuthService;
use App\Services\v1\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HttpResponse;
    // public AuthService $authService;

    public function __construct(private UserService $userService) {}

    public function getLoginUser(Request $request)
    {
        $response = $this->userService->getLoginUser();
        return $this->httpResponse($response);
    }
}
