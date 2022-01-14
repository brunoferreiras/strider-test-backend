<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\FollowerRepository;
use App\Models\Follower;
use App\Validators\FollowerValidator;

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
    
}
