<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_token_with_valid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/v1/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'role_id']);
    }

    public function test_login_returns_error_with_invalid_credentials(): void
    {
        $response = $this->post('/api/v1/login', [
            'username' => 'user',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
    }
}
