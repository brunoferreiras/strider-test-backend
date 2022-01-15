<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    protected $repository;
    protected $userRepository;

    public function __construct(PostRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        return $this->repository->with(['reposts', 'quotePosts'])->paginate(config('app.paginate'));
    }

    public function store(PostStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        $created = $this->repository->create($validated);
        return response()->json($created, 201);
    }

    public function allFollowing(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|exists:users,id',
        ]);
        $user = $this->userRepository->find($validated['user_id']);
        $followingIds = $user->followings()->pluck('following_id')->toArray();
        return $this->repository->getAllPostsByFollowing($followingIds);
    }
}
