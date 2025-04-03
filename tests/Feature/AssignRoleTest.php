<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignRoleTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    /**
     * A basic feature test example.
     */
    public function test_assign_role_when_user_is_manager(): void
    {
        $user = User::factory()->create();
        $user->assignRole('manager');
        $user2 = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/user/' . $user2->email . '/assign-role', [
                    'role' => 'moderator'
                ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseHas('model_has_roles', ['model_id' => $user2->id]);
    }

    public function test_cannot_assign_role_when_user_is_moderator(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $user->assignRole('moderator');
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/user/' . $user2->email . '/assign-role', [
                    'role' => 'moderator'
                ]);
        $response->assertStatus(403);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseMissing('model_has_roles', ['model_id' => $user2->id]);
    }

    public function test_assign_not_existing_role(): void
    {
        $user = User::factory()->create();
        $user->assignRole('manager');
        $user2 = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/user/' . $user2->email . '/assign-role', [
                    'role' => 'not_existing_role'
                ]);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'status', 'errors']);
        $this->assertDatabaseMissing('model_has_roles', ['model_id' => $user2->id]);
    }
}
