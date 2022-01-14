<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\RepostRepository;
use App\Models\Repost;
use App\Validators\RepostValidator;

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
