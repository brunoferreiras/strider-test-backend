<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
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

    public function store(PostStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        $created = $this->repository->create($validated);
        return response()->json($created, 201);
    }
}
