<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FollowerRepository;
use App\Models\Follower;

/**
 * Class FollowerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FollowerRepositoryEloquent extends BaseRepository implements FollowerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Follower::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function follow(string $follower, $following): void
    {
        $this->firstOrCreate([
            'follower_id' => $follower,
            'following_id' => $following
        ]);
    }

    public function unfollow(string $follower, $following): void
    {
        $this->deleteWhere([
            'follower_id' => $follower,
            'following_id' => $following
        ]);
    }
}
