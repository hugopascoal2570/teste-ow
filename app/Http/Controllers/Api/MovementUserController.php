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

    public function insertUserMovement(StoreMovement $request)
    {
        $user = $this->repository->insertUserMovement($request->validated());

        return new UserResource($user);
    }
    public function showUserMovement(){
            
        $user = $this->repository->showMovementUser();
        return $user;
    }

    public function dettachMovementAndUserRelation($movement_id){
  
        $user = $this->repository->dettachMovementById($movement_id);
        
        return $user;
    }
}
