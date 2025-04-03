<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Result;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetOwnAnswerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_get_answer_when_test_completed(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        Result::factory()->create([
            'task_id' => $task->id,
            'user_id' => $user->id
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/task/' . $task->id . '/answer/my');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'code',
            'output',
            'is_correct',
            'mark',
        ]);
        $data = $response->json();
        $this->assertNotNull($data['code']);
    }

    public function test_cannot_get_answer_when_test_not_completed(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/task/' . $task->id . '/answer/my');
        $response->assertStatus(404);
    }
}
