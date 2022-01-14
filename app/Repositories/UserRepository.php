<?php

namespace App\Repositories;

use App\Models\User;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface UserRepository extends RepositoryInterface
{
    public function getUserByUsername(string $username): User;

    public function getProfileByUsername(string $username): array;
}
