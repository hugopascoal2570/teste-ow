<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteHistoricRequest;
use App\Http\Requests\MoneyValidationRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Balance;
use App\Repositories\UserRepository;

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
    public function refund(MoneyValidationRequest $request, Balance $balance){
  
        return new UserResource($this->repository->refundBalance($request, $balance));
    }

    public function allValues(UserRequest $request){
        return $this->repository->values($request);
    }

    public function historic(){
        return UserResource::collection($this->repository->historics());
    }
    
    public function searchHistoric(){
        return UserResource::collection($this->repository->SearchHistoric());
    }

    public function searchHistoricAll(){

        return $this->repository->SearchHistoric();

    }

    public function deleteHistoricById(DeleteHistoricRequest $request){
        
        return $this->repository->deleteHistoric($request);
    }

    public function createcsv($options, $dataUser = null)
    {
        return Excel::download(new HistoricsExport, 'users.csv');
    }
}
