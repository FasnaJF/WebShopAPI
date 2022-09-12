<?php

namespace App\Repositories\UserRepository;

use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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

    public function create($attributes)
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $attributes['registered_since'] = Carbon::now();
        return parent::create($attributes);
    }
}
