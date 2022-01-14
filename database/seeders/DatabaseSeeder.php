<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Repost;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create()->each(function ($user) {
            $user->posts()
                ->saveMany(Post::factory(5)->make())
                ->each(function ($post) {
                    $post->reposts()->saveMany(Repost::factory(3)->make());
                    $post->quotePosts()->saveMany(Repost::factory(3)->state(function () {
                        return ['comment' => ''];
                    })->make());
                });
        });
    }
}
