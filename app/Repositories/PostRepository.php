<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PostRepository.
 *
 * @package namespace App\Repositories;
 */
interface PostRepository extends RepositoryInterface
{
    public function getTotalPostsToday(string $userId): int;

    public function getAllPostsByFollowing(array $followingIds);
}
