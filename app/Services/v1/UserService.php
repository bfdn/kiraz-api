<?php

namespace App\Services\v1;

use App\Core\ServiceResponse;
use App\Models\User;

class UserService
{
    // public User $users;

    public function __construct(public User $users) {}

    public function getLoginUser(): ServiceResponse
    {
        $user = auth('api')->user();
        return new ServiceResponse(true, 'User found', ['user' => $user], 200);
    }

    public function getById(int $id): ServiceResponse
    {
        $user = $this->users->find($id);
        if (!$user) {
            return new ServiceResponse(false, 'User not found', null, 404);
        }
        return new ServiceResponse(true, 'User found', ['user' => $user], 200);
    }
}
