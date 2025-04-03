<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemoveUserRoleTest extends TestCase
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
    public function test_remove_role_when_user_is_manager(): void
    {
        $user = User::factory()->create();
        $user->assignRole('manager');
        $user2 = User::factory()->create();
        $moderatorRole = Role::findByName('moderator');
        $user2->assignRole($moderatorRole);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/user/' . $user2->email . '/role/moderator');
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseMissing('model_has_roles', ['model_id' => $user2->id]);
    }

    public function test_cannot_remove_role_when_user_is_moderator(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $moderatorRole = Role::findByName('moderator');
        $user->assignRole($moderatorRole);
        $user2->assignRole($moderatorRole);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/user/' . $user2->email . '/role/moderator');
        $response->assertStatus(403);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseHas('model_has_roles', ['model_id' => $user->id]);
    }

    public function test_remove_not_existing_role(): void
    {
        $user = User::factory()->create();
        $user->assignRole('manager');
        $user2 = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/user/' . $user2->email . '/role/notexist');
        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
    }
}
