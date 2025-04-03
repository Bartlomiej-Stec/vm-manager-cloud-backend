<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_successfully_logged_out(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/logout');
        $response = $this->post('/api/logout');
        $response->assertJsonStructure(['message', 'status']);
    }

    public function test_failed_to_logout_when_not_logged(): void
    {
        $response = $this->post('/api/logout');
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }
}
