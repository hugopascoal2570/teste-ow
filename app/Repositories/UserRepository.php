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
        return $this->entity->orderBy('id','desc')->paginate();
    }

    public function getUser(Request $request){
        
        return $this->entity->find($request);
    }

    public function createNewUser(array $data) {

        $niver = Carbon::parse($data['birthday'])->age;
        if($niver < 18){
            return response()->json(['error'=>'usuário menor de idade'], 401);
        }
        else{
       return  $this->entity->create([
            'name' =>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
            'birthday'=>$data['birthday'],
        ]);
    }
}
    public function deleteUserById($request) {
    $id = $request->all();
    $verifyId = $this->repository->where('user_id',$id)->with('user')->exists();
        if($verifyId == 'true'){
            return response()->json(['error'=>'existem dados do usuário não podemos apagar'], 401);   
        }
         $result = $this->entity->where('id',$id)->delete();
         return response()->json(['success'=>'deletado com sucesso'], 200);   
        }   
 
    public function depositBalance($request, $balance){

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $balance->deposit($request->value);

        return $balance;
    }

    public function debitBalance($request, $balance){

    $debit = auth()->user()->balance()->firstOrCreate([]);
    $debit->debit($request->value);
    return $debit;
    }
    
    public function historics(){
        return dd($this->repository->with('user')->get());

    }

    public function HistoricAll(){
        
            $result = $this->repository->with('user')->get();
            return $result;
        } 
    

    public function deleteHistoric($request){

        $historic_id = $request->all();

      $this->repository->where('id',$historic_id)->with('user')->firstOrFail()->delete();
      return response()->json(['success'=>'deletado com sucesso'], 200);

    }
}