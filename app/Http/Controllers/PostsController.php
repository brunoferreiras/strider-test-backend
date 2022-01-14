<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;

class PostsController extends Controller
{
    protected $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->with(['reposts', 'quotePosts'])->paginate(30);
    }
}