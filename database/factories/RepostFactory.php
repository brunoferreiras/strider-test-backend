<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->text(777),
            'user_id' => User::pluck('id')[$this->faker->numberBetween(1, User::count() - 1)],
            'post_id' => Post::pluck('id')[$this->faker->numberBetween(1, Post::count() - 1)],
        ];
    }
}
