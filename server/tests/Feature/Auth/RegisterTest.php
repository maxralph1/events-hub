<?php

namespace Tests\Feature\Auth;

// use Illuminate\Foundation\Testing\WithFaker;
// use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'username' => 'johndoe1',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['access_token']);

        $this->assertDatabaseHas('users', [
            'username' => 'johndoe1',
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_cannot_register_with_passwords_unmatched(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'username' => 'johndoe1',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong_password',
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('users', [
            'username' => 'johndoe1',
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_cannot_register_with_missing_fields(): void
    {
        $response1 = $this->postJson('/api/v1/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong_password',
        ]);

        $response2 = $this->postJson('/api/v1/register', [
            'username' => 'johndoe1',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong_password',
        ]);

        $response3 = $this->postJson('/api/v1/register', [
            'username' => 'johndoe1',
            'name' => 'John Doe',
            'password' => 'password',
            'password_confirmation' => 'wrong_password',
        ]);

        $response4 = $this->postJson('/api/v1/register', [
            'username' => 'johndoe1',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password_confirmation' => 'wrong_password',
        ]);

        $response5 = $this->postJson('/api/v1/register', [
            'username' => 'johndoe1',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response1->assertStatus(422);
        $response2->assertStatus(422);
        $response3->assertStatus(422);
        $response4->assertStatus(422);
        $response5->assertStatus(422);

        $this->assertDatabaseMissing('users', [
            'username' => 'johndoe1',
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}
