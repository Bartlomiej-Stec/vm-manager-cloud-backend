<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_task_successfully_added(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $code = 'return $a + 1;';
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/task/add', [
                    'title' => 'Title',
                    'content' => 'Content',
                    'level' => 'easy',
                    'input' => '16;17;18',
                    'code' => $code,
                    'tags' => ['tag1', 'tag2'], 
                ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['message', 'status']);
        $this->assertDatabaseCount('tasks', 1);
        $this->assertDatabaseHas('tags', ['name' => 'tag1']);
        $this->assertDatabaseCount('internal_tokens', 1);
    }

    public function test_failed_to_add_task_when_not_logged(): void
    {
        $response = $this->post('/api/task/add', [
            'title' => 'Title',
            'content' => 'Content',
            'level' => 'easy',
            'input' => '16;17;18',
            'code' => 'return $a + 1;',
        ]);
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseCount('tasks', 0);
    }
}
