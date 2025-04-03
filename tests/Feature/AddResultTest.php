<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Result;
use Junges\Kafka\Facades\Kafka;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddResultTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_successfully_add_answer(): void
    {
        Kafka::fake();
        $task = Task::factory()->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $code = 'print("Hello, World!")';
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/task/' . $task->id . '/answer', ['code' => $code]);
        $response->assertStatus(201);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseCount('results', 1);
        $this->assertDatabaseHas('results', ['task_id' => $task->id, 'user_id' => $user->id, 'code' => $code]);
        $this->assertDatabaseCount('internal_tokens', 1);
        Kafka::assertPublished();
    }

    public function test_cannot_send_answer_when_user_is_test_creator(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by' => $user->id]);
        $token = JWTAuth::fromUser($user);
        $code = 'print("Hello, World!")';
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/task/' . $task->id . '/answer', ['code' => $code]);
        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseCount('results', 0);
    }

    public function test_cannot_send_answer_if_already_completed(): void
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();
        Result::factory()->create(['task_id' => $task->id, 'user_id' => $user->id]);
        $token = JWTAuth::fromUser($user);
        $code = 'print("Hello, World!")';
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/task/' . $task->id . '/answer', ['code' => $code]);
        $response->assertStatus(400);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseCount('results', 1);
    }

    public function test_cannot_send_answer_if_task_not_found(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $code = 'print("Hello, World!")';
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/task/1/answer', ['code' => $code]);
        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseCount('results', 0);
    }

    public function test_cannot_send_answer_if_code_is_missing(): void
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/task/' . $task->id . '/answer');
        $response->assertStatus(422);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseCount('results', 0);
    }

    public function test_cannot_send_answer_if_not_logged(): void
    {
        $task = Task::factory()->create();
        $response = $this->post('/api/task/' . $task->id . '/answer', ['code' => 'jhjhj']);
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseCount('results', 0);
    }
}
