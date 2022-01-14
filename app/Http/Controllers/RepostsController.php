<?php

namespace App\Http\Controllers;

use App\Repositories\RepostRepository;
use Illuminate\Http\Request;

class RepostsController extends Controller
{
    protected $repository;

    public function __construct(RepostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function repost(string $id, Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'comment' => 'nullable|string|max:777',
            'user_id' => 'required|exists:users,id'
        ]);
        $validated['post_id'] = $id;
        $created = $this->repository->create($validated);
        return response()->json($created, 201);
    }
}
