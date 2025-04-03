<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_successfully_got_user_data(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'surname', 'email', 'created_at', 'updated_at', 'roles']);
    }

    public function test_failed_to_get_user_data_when_not_logged(): void
    {
        $response = $this->get('/api/user');
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }
}
