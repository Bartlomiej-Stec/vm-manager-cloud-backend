<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Result;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SetMarkTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_set_mark_when_user_is_author(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by' => $user->id]);
        $user2 = User::factory()->create();
        $result = Result::factory()->create([
            'task_id' => $task->id,
            'user_id' => $user2->id
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/answer/' . $result->id . '/mark', ['mark' => 5]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'mark' => 5
        ]);
    }

    public function test_cannot_set_mark_when_not_author(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $result = Result::factory()->create([
            'task_id' => $task->id
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/answer/' . $result->id . '/mark', ['mark' => 5]);
        $response->assertStatus(403);
    }
}
