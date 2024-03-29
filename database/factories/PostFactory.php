<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->text(777),
            'user_id' => User::pluck('id')[$this->faker->numberBetween(0, User::count() - 1)],
        ];
    }
}
