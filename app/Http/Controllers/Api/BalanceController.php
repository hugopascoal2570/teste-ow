<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MoneyValidationRequest;
use App\Http\Resources\UserResource;
use App\Models\Balance;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    
    protected $repository;
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function deposit(MoneyValidationRequest $request, Balance $balance){
  
        return new UserResource($this->repository->depositBalance($request, $balance));
    }

    public function debit(MoneyValidationRequest $request, Balance $balance){
  
        return new UserResource($this->repository->debitBalance($request, $balance));
    }

    public function historic(){
        return UserResource::collection($this->repository->historics());
    }

    public function deleteBalance(Request $request){
        return $this->repository->deleteBalanceById($request);
    }
}
