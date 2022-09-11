<?php

namespace App\Repositories\UserRepository;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

}
