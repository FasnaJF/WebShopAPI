<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Password;
use Tests\StubUser;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use StubUser;

    public function test_new_user_can_register()
    {
        $response = $this->post('/api/users/register', [
            'name' => 'Test user',
            'email' => 'test@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'phone' => '000-000-111',
            'job_title' => 'Doctor',
        ]);
        $response->assertStatus(200);
    }

    public function test_user_can_login()
    {
        $user = $this->createStubUser();
        $response = $this->post('/api/users/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticatedAs($user);
        $response->assertStatus(200);
    }

    public function test_user_can_request_forgot_password_token()
    {
        $user = $this->createStubUser();
        $response = $this->post('/api/users/forgot-password', [
            'email' => $user->email,
        ]);
        $response->assertStatus(200);
    }

    public function test_user_can_reset_password_with_token()
    {
        $user = $this->createStubUser();
        $token = Password::createToken($user);
        $response = $this->post('/api/users/reset-password', [
            'email' => $user->email,
            'token' => $token,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
        $response->assertStatus(200);
    }
}
