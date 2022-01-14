<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface FollowerRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface FollowerRepository extends RepositoryInterface
{
    public function follow(string $follower, $following): void;

    public function unfollow(string $follower, $following): void;
}
