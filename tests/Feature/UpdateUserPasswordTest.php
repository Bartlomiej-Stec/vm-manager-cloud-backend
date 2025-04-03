<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserPasswordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_update_password_success(): void
    {
        $oldPassword = 'password1';
        $user = User::factory()->create(
            ['password' => Hash::make($oldPassword)]
        );
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patch('/api/user/password', [
                    'old_password' => $oldPassword,
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'status']);
        $user = $user->fresh();
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_failed_to_update_password_when_old_password_is_wrong(): void
    {
        $oldPassword = 'password1';
        $user = User::factory()->create(
            ['password' => Hash::make($oldPassword)]
        );
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patch('/api/user/password', [
                    'old_password' => 'wrong_password',
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ]);
        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
    }

    public function test_failed_to_update_when_password_not_match(): void
    {
        $oldPassword = 'password1';
        $user = User::factory()->create(
            ['password' => Hash::make($oldPassword)]
        );
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patch('/api/user/password', [
                    'old_password' => $oldPassword,
                    'password' => 'password',
                    'password_confirmation' => 'password1',
                ]);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
    }
}
