<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use WithFaker;

    public function test_list_all_posts_with_reposts()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'content' => 'any_content',
            'user_id' => $user->id,
        ]);
        $response = $this->json('GET', '/api/v1/posts')
            ->assertStatus(200)
            ->decodeResponseJson();
        $expected = $post->with(['reposts', 'quotePosts'])->get()->toArray();
        $this->assertEquals($expected, $response['data']);
    }

    public function test_create_post()
    {
        $user = User::factory()->create();
        $payload = [
            'content' => 'any_create_content',
            'user_id' => $user->id
        ];
        $this->json('POST', '/api/v1/posts', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'content', 'user_id', 'created_at', 'updated_at', 'id'
            ]);
    }

    public function test_require_validation_create_post()
    {
        $user = User::factory()->create();
        $payload = [
            'content' => '',
            'user_id' => $user->id
        ];
        $this->json('POST', '/api/v1/posts', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'content' => ['The content field is required.']
                ]
            ]);

        $user = User::factory()->create();
        $payload = [
            'content' => $this->faker->realTextBetween(800, 900),
            'user_id' => $user->id
        ];
        $this->json('POST', '/api/v1/posts', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'content' => ['The content must not be greater than 777 characters.']
                ]
            ]);
    }

    public function test_users_not_allowed_create_more_5_posts_per_day()
    {
        $user = User::factory()->create();
        for ($i = 0; $i < 5; $i++) {
            $payload = [
                'content' => $this->faker->text(100),
                'user_id' => $user->id
            ];
            $this->json('POST', '/api/v1/posts', $payload)
                ->assertStatus(201)
                ->assertJsonStructure([
                    'content', 'user_id', 'created_at', 'updated_at', 'id'
                ]);
        }

        $payload = [
            'content' => $this->faker->text(100),
            'user_id' => $user->id
        ];
        $this->json('POST', '/api/v1/posts', $payload)
            ->assertStatus(403)
        ->assertJsonPath('message', "You can't create more than 5 posts per day.");
    }
}
