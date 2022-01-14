<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post.
 *
 * @package namespace App\Models;
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id'];
}
