<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\InternalToken;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddTaskOutputTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_task_output_updated_successfully(): void
    {
        $task = Task::factory()->create(['output' => null]);
        $internalToken = InternalToken::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $internalToken->token,
        ])->patch('/api/task/' . $task->id, [
                    'output' => '16;17;18',
                ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseHas('tasks', ['output' => '16;17;18']);
        $this->assertDatabaseMissing('internal_tokens', ['token' => $internalToken->token]);
        $this->assertDatabaseHas('tasks', ['output' => '16;17;18']);
    }

    public function test_failed_to_update_task_output_with_missing_token(): void
    {
        $task = Task::factory()->create(['output' => null]);
        $response = $this->patch('/api/task/' . $task->id, [
            'output' => '16;17;18',
        ]);
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('tasks', ['output' => '16;17;18']);
    }

    public function test_failed_to_update_task_output_with_invalid_token(): void
    {
        $task = Task::factory()->create(['output' => null]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid_token',
        ])->patch('/api/task/' . $task->id, [
                    'output' => '16;17;18',
                ]);
        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('tasks', ['output' => '16;17;18']);
    }

    public function test_failed_to_update_task_output_with_expired_token(): void
    {
        $internalToken = InternalToken::factory()->create([
            'created_at' => now()->subMinutes(config('internal_api.expiration_time') + 1),
        ]);
        $task = Task::factory()->create(['output' => null]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $internalToken->token,
        ])->patch('/api/task/' . $task->id, [
                    'output' => '16;17;18',
                ]);
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('tasks', ['output' => '16;17;18']);
    }
}
