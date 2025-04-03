<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_registered_successfully(): void
    {
        $user = [
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'example@example.com',
            'password' => 'Haslo1234567!',
            'password_confirmation' => 'Haslo1234567!',
        ];
        $response = $this->post('/api/register', $user);
        $response->assertJsonStructure(['token', 'status']);
        $response->assertStatus(201);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_user_registration_failed_when_invalid_password(): void
    {
        $user = [
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'example@example.com',
            'password' => 'Haslo12345',
            'password_confirmation' => 'Haslo1234567!',
        ];
        $response = $this->post('/api/register', $user);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'status', 'errors']);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_cannot_register_with_same_email(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/api/register', [
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => $user->email,
            'password' => 'Haslo1234567!',
            'password_confirmation' => 'Haslo1234567!',
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'status', 'errors']);
        $this->assertDatabaseCount('users', 1);
    }
}
