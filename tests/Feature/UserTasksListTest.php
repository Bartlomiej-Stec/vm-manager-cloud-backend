<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTasksListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_get_list_of_tasks_when_logged(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        Task::factory()->count(5)->create([
            'created_by' => $user->id
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("/api/user/{$user->id}/tasks");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'current_page',
            'data' => [
                [
                    'title',
                    'id',
                    'level',
                    'content',
                    'input',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'tags'
                ]
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links' => [
                [
                    'url',
                    'label',
                    'active'
                ],
                [
                    'url',
                    'label',
                    'active'
                ],
                [
                    'url',
                    'label',
                    'active'
                ]
            ],
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ]);
        $data = $response->json();
        $this->assertEquals(5, count($data['data'] ?? []));
    }

    public function test_failed_to_get_tasks_when_not_logged(): void
    {
        $user = User::factory()->create();
        $response = $this->get("/api/user/{$user->id}/tasks");
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }

    public function test_failed_to_get_tasks_when_user_not_exists(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("/api/user/1000/tasks");
        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
    }

    public function test_get_tasks_with_level_filters(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(10)->create(['level' => 'easy', 'created_by' => $user->id]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/user/'.$user->id.'/tasks?level=easy');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(10, count($data['data'] ?? []));
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/user/'.$user->id.'/tasks?level=hard');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(0, count($data['data'] ?? []));
    }

    public function test_get_tasks_with_tags_filter(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $task = Task::factory()->create(['created_by' => $user->id]);
        $task->tags()->create(['name' => 'tag1']);
        $task->tags()->create(['name' => 'tag2']);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/user/'.$user->id.'/tasks?tags[]=tag1');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(1, count($data['data'] ?? []));
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/user/'.$user->id.'/tasks?tags[]=tag2');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(1, count($data['data'] ?? []));
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/user/'.$user->id.'/tasks?tags[]=tag3');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(0, count($data['data'] ?? []));
    }

    public function test_get_tasks_with_search(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        Task::factory()->create(['title' => 'test3', 'created_by' => $user->id]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/user/'.$user->id.'/tasks?search=test');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(1, count($data['data'] ?? []));

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/user/'.$user->id.'/tasks?search=invalid');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals(0, count($data['data'] ?? []));
    }
}
