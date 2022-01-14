<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RepostRepository;
use App\Models\Repost;

/**
 * Class RepostRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RepostRepositoryEloquent extends BaseRepository implements RepostRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Repost::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
