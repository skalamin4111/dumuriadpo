<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_login_returns_standard_response(): void
    {
        User::create([
            'name' => 'API Admin',
            'email' => 'api@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $this->postJson('/api/auth/login', ['email' => 'api@example.com', 'password' => 'password'])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['token']]);
    }
}
