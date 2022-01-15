<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepostsControllersTest extends TestCase
{
    use WithFaker;

    public function test_create_repost()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'content' => 'any_content',
            'user_id' => $user->id,
        ]);
        $payload = [
            'comment' => '',
            'user_id' => $user->id
        ];
        $this->json('POST', "/api/v1/posts/{$post->id}/repost", $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'comment', 'user_id', 'post_id', 'created_at', 'updated_at', 'id'
            ]);
    }

    public function test_validation_create_repost_with_invalid_user()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'content' => 'any_content',
            'user_id' => $user->id,
        ]);
        $payload = [
            'comment' => '',
            'user_id' => 100
        ];
        $this->json('POST', "/api/v1/posts/{$post->id}/repost", $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'user_id' => ['The selected user id is invalid.']
                ]
            ]);
    }

    public function test_create_quote_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'content' => 'any_content',
            'user_id' => $user->id,
        ]);
        $payload = [
            'comment' => 'any_comment',
            'user_id' => $user->id
        ];
        $this->json('POST', "/api/v1/posts/{$post->id}/repost", $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'comment', 'user_id', 'post_id', 'created_at', 'updated_at', 'id'
            ]);
    }

    public function test_validation_create_quote_post_with_comment_greater_than_777()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'content' => 'any_content',
            'user_id' => $user->id,
        ]);
        $payload = [
            'comment' => $this->faker->realTextBetween(778, 800),
            'user_id' => $user->id
        ];
        $this->json('POST', "/api/v1/posts/{$post->id}/repost", $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'comment' => ['The comment must not be greater than 777 characters.']
                ]
            ]);
    }
}
