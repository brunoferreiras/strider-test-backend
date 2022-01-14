<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
        $created = $this->repository->create($validated);
        return response()->json($created, 201);
    }
}
