<?php 

namespace App\Repositories;

use App\Models\User;
use App\Models\Historic;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserRepository{

    protected $entity, $repository;
    public function __construct(User $model, Historic $historics)
    {
        $this->entity = $model;
        $this->repository = $historics;

    }

    public function getAllUsers(){
        return $this->entity->latest()->paginate(300);
    }

    public function getUser(Request $request){
        
        return $this->entity->find($request);
    }

    public function createNewUser(array $data):User {

        $niver = Carbon::parse($data['birthday'])->age;
        if($niver < 18){
            return response()->json(['error'=>'underage user'], 401);
        }
        else{
        return $this->entity->create([
            'name' =>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
            'birthday'=>$data['birthday'],
        ]);
    }
}

    public function depositBalance($request, $balance){

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $balance->deposit($request->value);

        return $balance;
    }

    public function debitBalance($request, $balance){

    $balance = auth()->user()->balance()->firstOrCreate([]);
    $balance->debit($request->value);

    return $balance;
    }
    
    public function historics(){
      
        return auth()->user()->historics()->with(['user'])->get();
    }

    public function deleteBalanceById($request){

        $id = $request->all();

       $result = $this->repository->where('user_id',$id)->with('user')->exists();
        if($result == 'true'){
            return response()->json(['error'=>'existem dados do usuário não podemos apagar'], 401);   
        }
        return $this->entity->where('id',$id)->firstOrFail()->delete();

    }
}