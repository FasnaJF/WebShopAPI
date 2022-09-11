<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;


class UserController extends BaseController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $userDetails = $request->validated();
        $user = $this->userService->createUser($userDetails);
        if ($user) {
            $token = $user->createToken('token')->plainTextToken;
            return $this->sendResponse(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer'],
                'User register successfully.');
        }
        return $this->sendError('User Registration failed', '', 500);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Unauthorized', 'Invalid Credentials', 401);
        }

        $user = $this->userService->getUserByEmail($request['email']);
        if ($user) {
            $token = $user->createToken('token')->plainTextToken;
            return $this->sendResponse(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer'],
                'Login was successful');
        }
        return $this->sendError('User Login failed', '', 500);
    }

    public function logout(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        $token->delete();
        return $this->sendResponse('Success',
            'You have successfully logged out and the token was successfully deleted');
    }

}
