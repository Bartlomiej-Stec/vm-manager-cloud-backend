<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Result;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteAnswerTest extends TestCase
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
    public function test_remove_answer_when_user_is_moderator(): void
    {
        $task = Task::factory()->create(['output' => 'correct']);
        $result = Result::factory()->create(['task_id' => $task->id, 'output' => null]);
        $user = User::factory()->create();
        $user->assignRole('moderator');
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/answer/' . $result->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseCount('results', 0);
    }

    public function test_cannot_remove_answer_when_has_no_permissions(): void
    {
        $task = Task::factory()->create(['output' => 'correct']);
        $result = Result::factory()->create(['task_id' => $task->id, 'output' => null]);
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/answer/' . $result->id);
        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseCount('results', 1);
    }
}
