<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    public function create(array $data): User
    {
        return User::create($data);
    }
}