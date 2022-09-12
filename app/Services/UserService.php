<?php

namespace App\Services;

use App\Http\Requests\ResetPasswordTokenRequest;
use App\Repositories\UserRepository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserService
{
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function createUser($data)
    {
        return $this->userRepo->create($data);
    }

    public function deleteUser(int $id)
    {
        return $this->userRepo->deleteById($id);
    }

    public function getUserByEmail(string $email)
    {
        return $this->userRepo->getByEmail($email);
    }

    public function updateUser(int $id, array $data)
    {
        $user = $this->userRepo->updateById($id, $data);
        if ($user) {
            return $this->getUserById($user->id);
        }
        return false;
    }

    public function getUserById(int $id)
    {
        return $this->userRepo->getById($id);
    }

    public function getAllUsers()
    {
        return $this->userRepo->getAll();
    }

    public function resetPassword(ResetPasswordTokenRequest $request)
    {
        return Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                $user->save();
            }
        );
    }

}
