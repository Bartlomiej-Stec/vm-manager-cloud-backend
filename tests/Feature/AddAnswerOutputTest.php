<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Result;
use App\Models\InternalToken;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAnswerOutputTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_update_answer_correct_output(): void
    {
        $task = Task::factory()->create(['output' => 'correct']);
        $result = Result::factory()->create(['task_id' => $task->id, 'output' => null]);
        $internalToken = InternalToken::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $internalToken->token,
        ])->patch('/api/answer/' . $result->id, [
                    'output' => 'correct',
                ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseMissing('internal_tokens', ['token' => $internalToken->token]);
        $this->assertDatabaseHas('results', ['output' => 'correct', 'is_correct' => true]);
    }

    public function test_update_answer_with_incorrect_output(): void
    {
        $task = Task::factory()->create(['output' => 'correct']);
        $result = Result::factory()->create(['task_id' => $task->id, 'output' => null]);
        $internalToken = InternalToken::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $internalToken->token,
        ])->patch('/api/answer/' . $result->id, [
                    'output' => 'incorrect',
                ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseMissing('internal_tokens', ['token' => $internalToken->token]);
        $this->assertDatabaseHas('results', ['output' => 'incorrect', 'is_correct' => false]);
    }
}
