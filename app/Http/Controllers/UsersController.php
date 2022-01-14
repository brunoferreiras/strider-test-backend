<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Repositories\FollowerRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $repository;
    protected $followerRepository;

    public function __construct(UserRepository $repository, FollowerRepository $followerRepository)
    {
        $this->repository = $repository;
        $this->followerRepository = $followerRepository;
    }

    public function store(UserStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        $created = $this->repository->create($validated);
        return response()->json($created, 201);
    }

    public function follow(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'follower_id' => 'required|exists:users,id',
            'following_id' => 'required|exists:users,id|different:follower_id',
        ]);
        $this->followerRepository->firstOrCreate($validated);
        return response()->json([], 204);
    }
}
