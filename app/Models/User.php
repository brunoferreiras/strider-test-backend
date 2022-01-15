<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class User.
 *
 * @package namespace App\Models;
 */
class User extends Model implements Transformable
{
    use TransformableTrait, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username'];

    public function getDateJoinedAttribute($value)
    {
        return $this->created_at->format('M j, Y');
    }

    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function followers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Follower::class, 'following_id', 'id');
    }

    public function followings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Follower::class, 'follower_id', 'id');
    }
}
