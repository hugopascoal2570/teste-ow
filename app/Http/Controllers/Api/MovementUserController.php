<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovement;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class MovementUserController extends Controller
{
    protected $repository;
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function credit(StoreMovement $request)
    {
        $user = $this->repository->creditUserMovement($request->validated());

        return new UserResource($user);
    }
}
