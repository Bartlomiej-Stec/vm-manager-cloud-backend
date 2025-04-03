<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Result;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetTaskAnswersTest extends TestCase
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
    public function test_get_answers_when_user_is_author(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'created_by' => $user->id
        ]);
        $user2 = User::factory()->create();
        Result::factory()->create([
            'task_id' => $task->id,
            'user_id' => $user2->id
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/task/' . $task->id . '/answers');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                [
                    'id',
                    'code',
                    'created_at',
                    'updated_at',
                    'output',
                    'is_correct',
                    'mark',
                    'user' => [
                        'id',
                        'name',
                        'surname'
                    ]
                ]
            ]
        ]);
    }

    public function cannot_see_answers_when_not_author(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $user2 = User::factory()->create();
        Result::factory()->create([
            'task_id' => $task->id,
            'user_id' => $user2->id
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/task/' . $task->id . '/answers');
        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
    }

    public function test_get_answers_when_user_is_moderator(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'created_by' => $user->id
        ]);
        $user2 = User::factory()->create();
        $user2->assignRole('moderator');
        Result::factory()->create([
            'task_id' => $task->id,
            'user_id' => $user2->id
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/task/' . $task->id . '/answers');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                [
                    'id',
                    'code',
                    'created_at',
                    'updated_at',
                    'output',
                    'is_correct',
                    'mark',
                    'user' => [
                        'id',
                        'name',
                        'surname'
                    ]
                ]
            ]
        ]);
    }

    
}
