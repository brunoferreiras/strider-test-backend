<?php

namespace Tests\Feature;

use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use WithFaker;

    public function test_create_user()
    {
        $payload = [
            'name' => 'any_create_content',
            'username' => 'any123'
        ];
        $this->json('POST', '/api/v1/users', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'name', 'username', 'created_at', 'updated_at', 'id'
            ]);
    }

    public function test_validation_create_user()
    {
        $payload = [
            'name' => 'Any',
            'username' => 'test!@#%'
        ];
        $this->json('POST', '/api/v1/users', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'username' => ['The username must only contain letters, numbers, dashes and underscores.']
                ]
            ]);

        $payload = [
            'name' => 'Any',
            'username' => 'username123456123'
        ];
        $this->json('POST', '/api/v1/users', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'username' => ['The username must not be greater than 14 characters.']
                ]
            ]);
    }

    public function test_follow_user()
    {
        $follower = User::factory()->create();
        $following = User::factory()->create();
        $payload = [
            'follower_id' => $follower->id,
            'following_id' => $following->id
        ];
        $this->json('POST', "/api/v1/users/{$following->id}/follow", $payload)
            ->assertStatus(204);
        $data = Follower::first();
        $this->assertEquals([
            'follower_id' => $follower->id,
            'following_id' => $following->id,
        ], $data->only(['follower_id', 'following_id']));
    }

    public function test_unfollow_user()
    {
        $follower = User::factory()->create();
        $following = User::factory()->create();
        Follower::create([
            'follower_id' => $follower->id,
            'following_id' => $following->id
        ]);
        $payload = [
            'follower_id' => $follower->id,
            'following_id' => $following->id
        ];
        $this->json('POST', "/api/v1/users/{$following->id}/unfollow", $payload)
            ->assertStatus(204);
    }

    public function test_get_profile()
    {
        // Create users
        $user = User::factory()->create();
        // Add new follower
        $follower = User::factory()->create();
        Follower::create([
            'follower_id' => $follower->id,
            'following_id' => $user->id
        ]);
        // Add new following
        $following = User::factory()->create();
        Follower::create([
            'follower_id' => $user->id,
            'following_id' => $following->id
        ]);
        // Add new post
        Post::create([
            'content' => 'any_content',
            'user_id' => $user->id
        ]);
        $response = $this->json('GET', "/api/v1/users/{$user->username}/profile")
            ->assertStatus(200)
            ->assertJsonStructure([
                'username', 'date_joined', 'total_followers', 'total_following', 'total_posts'
            ])->decodeResponseJson();
        $response->assertExact([
            'username' => $user->username,
            'date_joined' => $user->dateJoined,
            'total_followers' => 1,
            'total_following' => 1,
            'total_posts' => 1
        ]);
    }
}
