<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserRepository;
use App\Models\User;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getUserByUsername(string $username): User
    {
        return $this->where('username', $username)->first();
    }

    public function getProfileByUsername(string $username): array
    {
        $user = $this->getUserByUsername($username);
        return [
            'username' => $username,
            'date_joined' => $user->dateJoined,
            'total_followers' => $user->followers()->count(),
            'total_following' => $user->followings()->count(),
            'total_posts' => $user->posts()->with('totalPosts')->count()
        ];
    }
}
