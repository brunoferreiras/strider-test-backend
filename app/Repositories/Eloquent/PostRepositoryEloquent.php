<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PostRepository;
use App\Models\Post;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getTotalPostsToday(string $userId): int
    {
        return $this->where('user_id', $userId)->whereDate('created_at', Carbon::today())->count();
    }

    public function getAllPostsByFollowing(array $followingIds)
    {
        return $this->whereIn('user_id', $followingIds)->paginate(config('app.paginate'));
    }
}
