<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTaskTest extends TestCase
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
    public function test_task_successfully_deleted_by_author(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $task = Task::factory()->create([
            'created_by' => $user->id
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/task/'.$task->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_task_not_deleted_when_user_not_author_and_no_moderator(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $task = Task::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/task/'.$task->id);
        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseCount('tasks', 1);
    }

    public function test_task_deleted_when_user_is_moderator(): void
    {
        $user = User::factory()->create();
        $user->assignRole('moderator');
        $token = JWTAuth::fromUser($user);
        $task = Task::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/task/'.$task->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    
}
