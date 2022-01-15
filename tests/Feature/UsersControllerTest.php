<?php

namespace Tests\Feature;

use App\Models\Follower;
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
}
