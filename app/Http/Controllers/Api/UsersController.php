<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    protected $repository;
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function index()
    {
        return UserResource::collection($this->repository->getAllUsers());

    }

    public function show(Request $request)
    {
       return UserResource::collection($this->repository->getUser($request));
    }

    public function destroy($id)
    {
       $user = $this->repository->deleteUser($id);
    
       return response()->json([],204);
    }
}
