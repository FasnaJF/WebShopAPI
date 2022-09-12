<?php

namespace Tests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

trait StubUser
{
    protected User $user;

    public function createStubUser(array $data = [])
    {
        $password = Hash::make('password');
        $user = User::factory()->create([
            'password' => $password,
            'job_title' => 'Teacher',
            'phone' => '000',
            'registered_since' => Carbon::now()
        ]);
        return $this->user = $user;
    }
}
