<?php

namespace Tests\Feature;

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
}
