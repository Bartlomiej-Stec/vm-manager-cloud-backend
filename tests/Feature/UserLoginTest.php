<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_logged_successfully(): void
    {
        $password = 'Haslo1234567!';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => $password
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['token', 'status']);
    }

    public function test_user_login_failed_when_invalid_password(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'Haslo12345',
        ]);
        $response->assertStatus(400);
        $response->assertJsonStructure(['message', 'status']);
    }
}
