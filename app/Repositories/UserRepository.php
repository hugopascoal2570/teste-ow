<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Historic;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use App\Exports\HistoricsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class UserRepository
{
    protected $entity, $repository;
    public function __construct(User $model, Historic $historics)
    {
        $this->entity = $model;
        $this->repository = $historics;
    }

    public function getAllUsers()
    {
        return $this->entity->orderBy('id', 'desc')->paginate();
    }

    public function getUser($request)
    {
       $id = $request->all();
       $user = $this->entity->where('id',$id)->get();
       if ($user) {
        return $user;
    }  elseif (is_null($user)) {
        return response()->json(
            ['error' => 'not found users'],
            404
        );
    }
    }
    public function createNewUser(array $data)
    {
        $niver = Carbon::parse($data['birthday'])->age;
        if ($niver < 18) {
            return response()->json(['error' => 'usuário menor de idade'], 401);
        } else {
            return $this->entity->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'birthday' => $data['birthday'],
            ]);
        }
    }
    public function deleteUserById($request)
    {
        $id = $request->all();
        $verifyId = $this->repository
            ->where('user_id', $id)
            ->with('user')
            ->exists();
        if ($verifyId == 'true') {
            return response()->json(
                ['error' => 'existem dados do usuário não podemos apagar'],
                401
            );
        }
        $result = $this->entity->where('id', $id)->delete();
        return response()->json(['success' => 'deletado com sucesso'], 200);
    }

    public function depositBalance($request, $balance)
    {
        $balance = auth()
            ->user()
            ->balance()
            ->firstOrCreate([]);
        $balance->deposit($request->value);

        return $balance;
    }

    public function debitBalance($request, $balance)
    {
        $debit = auth()
            ->user()
            ->balance()
            ->firstOrCreate([]);
        $debit->debit($request->value);
        return $debit;
    }

    public function refundBalance($request, $balance)
    {
        $debit = auth()
            ->user()
            ->balance()
            ->firstOrCreate([]);
        $debit->refund($request->value);
        return $debit;
    }

    public function values($request){
        $id = $request->all();

        $values = $this->repository->where('user_id',$id)->get();
        if($values){
        $credit = $values->where('type','=','C')->sum('amount');
        $debit = $values->where('type','=','D')->sum('amount');
        $refund = $values->where('type','=','R')->sum('amount');
        return response()->json(['Credit , Debit, Refund '.$credit,$debit,$refund],200);
        }else{
            return response()->json(['error' => 'historics not found'], 404);
        }

    }

    public function historics()
    {
        $users_historics = $this->entity
            ->join('historics', 'users.id', '=', 'historics.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.birthday',
                'historics.user_id',
                'historics.type',
                'historics.amount',
                'historics.total_before',
                'historics.total_after',
                'historics.date'
            )
            ->paginate(5);
        if ($users_historics) {
            return $users_historics;
        } elseif (is_null($users_historics)) {
            return response()->json(['error' => 'historics not found'], 404);
        }
    }

    public function SearchHistoric()
    {
        return Excel::download(new HistoricsExport(), 'users.csv');
    }

    public function deleteHistoric($request)
    {
        $historic_id = $request->all();

        $result = $this->repository
            ->where('id', $historic_id)
            ->with('user')
            ->first();

        if ($result) {
            $result->delete();
            return response()->json(['success' => 'deletado com sucesso'], 200);
        } elseif (is_null($result)) {
            return response()->json(['message' => 'historic not found'], 404);
        }
    }
}
