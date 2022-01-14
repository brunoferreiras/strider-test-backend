<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Post.
 *
 * @package namespace App\Models;
 */
class Post extends Model implements Transformable
{
    use TransformableTrait, HasFactory;

    protected $fillable = ['content', 'user_id'];

    public function totalReposts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Repost::class,'post_id', 'id');
    }

    public function reposts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Repost::class, 'post_id', 'id')->where('comment', '!=', '');
    }

    public function quotePosts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Repost::class)->where('comment', '=', '');
    }
}
