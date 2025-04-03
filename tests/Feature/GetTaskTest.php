<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_task_successfully_loaded_by_competitor(): void
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/task/' . $task->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'id',
            'title',
            'level',
            'content',
            'input',
            'created_at',
            'updated_at',
            'created_by' => [
                'id',
                'name',
                'surname'
            ],
            'code',
            'output',
        ]);
        $responseData = $response->json();
        $this->assertNull($responseData['code']);
        $this->assertNull($responseData['output']);
    }

    public function test_task_successfully_loaded_by_author(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $task = Task::factory()->create([
            'created_by' => $user->id
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/task/' . $task->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'id',
            'title',
            'level',
            'content',
            'input',
            'created_at',
            'updated_at',
            'created_by' => [
                'id',
                'name',
                'surname'
            ],
            'code',
            'output',
            'tags'
        ]);
        $responseData = $response->json();
        $this->assertNotNull($responseData['code']);
        $this->assertNotNull($responseData['output']);
    }

    public function test_failed_to_load_task_when_not_logged(): void
    {
        $task = Task::factory()->create();
        $response = $this->get('/api/task/' . $task->id);
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }
}
