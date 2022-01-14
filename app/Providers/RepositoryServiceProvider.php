<?php

namespace App\Providers;

use App\Repositories\Eloquent\FollowerRepositoryEloquent;
use App\Repositories\Eloquent\PostRepositoryEloquent;
use App\Repositories\Eloquent\RepostRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Repositories\FollowerRepository;
use App\Repositories\PostRepository;
use App\Repositories\RepostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PostRepository::class, PostRepositoryEloquent::class);
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(FollowerRepository::class, FollowerRepositoryEloquent::class);
        $this->app->bind(RepostRepository::class, RepostRepositoryEloquent::class);
        //:end-bindings:
    }
}
