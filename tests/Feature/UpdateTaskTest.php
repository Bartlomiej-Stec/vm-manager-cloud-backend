<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_task_successfully_updated(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $task = Task::factory()->create([
            'created_by' => $user->id
        ]);
        $taskData = [
            'title' => 'Title',
            'content' => 'Content',
            'level' => 'easy',
            'input' => '16;17;18',
            'code' => 'return $a + 1;',
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('/api/task/'.$task->id, $taskData);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_failed_to_update_task_when_not_author(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $task = Task::factory()->create();
        $taskData = [
            'title' => 'Title',
            'content' => 'Content',
            'level' => 'easy',
            'input' => '16;17;18',
            'code' => 'return $a + 1;',
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('/api/task/'.$task->id, $taskData);
        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
    }

    public function test_failed_to_update_task_when_not_logged(): void
    {
        $task = Task::factory()->create();
        $taskData = [
            'title' => 'Title',
            'content' => 'Content',
            'level' => 'easy',
            'input' => '16;17;18',
            'code' => 'return $a + 1;',
        ];
        $response = $this->put('/api/task/'.$task->id, $taskData);
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }
}
