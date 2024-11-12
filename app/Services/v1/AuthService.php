<?php

namespace App\Services\v1;

use App\Core\ServiceResponse;
use App\Models\User;

class AuthService
{
    // public User $users;

    public function __construct(public User $users) {}

    public function register(string $name, string $email, string $password): ServiceResponse
    {
        $user = $this->users->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        return new ServiceResponse(true, 'User created successfully', ['user' => $user], 200);
    }

    public function login(string $email, string $password): ServiceResponse
    {
        $user = $this->users->where('email', $email)->first();
        if (!$user) {
            return new ServiceResponse(false, 'Mail and password do not match', null, 401);
        }

        if (!password_verify($password, $user->password)) {
            return new ServiceResponse(false, 'Mail and password do not match', null, 401);
        }

        // $token = $user->createToken('authToken')->plainTextToken;
        $token = $user->createToken('authToken')->accessToken;

        return new ServiceResponse(true, 'Login successful', ['token' => $token, 'user' => $user], 200);
    }


    // public function login(string $email, string $password): ServiceResponse
    // {
    //     $userService = app()->make(IUserService::class);

    //     $user = $userService->getByEmail($email);
    //     if ($user->isSuccess()) {
    //         $user = $user->getData();
    //         if (!password_verify($password, $user->password)) {
    //             return new ServiceResponse(false, 'Mail and password do not match', null, 401);
    //         }
    //         $token = $user->createToken('authToken')->plainTextToken;
    //         return new ServiceResponse(true, 'Login successful', ['token' => $token, 'user' => $user], 200);
    //     }
    //     return new ServiceResponse(false, 'Mail and password do not match', null, 401);
    // }
}
