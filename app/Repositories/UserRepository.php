<?php 

namespace App\Repositories;

use App\Models\Movement;
use App\Models\User;

class UserRepository{

    protected $entity,$repository;
    public function __construct(User $model, Movement $movement)
    {
        $this->entity = $model;
        $this->repository = $movement;
    }

    public function getAllUsers(){
        return $this->entity->latest()->paginate();
    }

    public function getUser(string $identify){
        return $this->entity->findOrFail($identify);
    }

    public function createNewUser(array $data):User {

        return $this->entity->create([
            'name' =>$data['name'],
            'email'=>$data['email'],
            'password'=>$data['password'],
            'birthday'=>$data['birthday'],
        ]);
    }

    public function deleteUser($id) {

       return $this->entity->where('id',$id)->firstOrFail()->delete();
    }

    public function insertUserMovement(array $data) {
   
        $user = $this->entity->find($data['user_id']);
        $user->movements()->attach($data['movement_id']);

        return $user;
     }

     public function showMovementUser(){
            return $this->entity->with('movements')->paginate(20);
     }

     public function dettachMovementById($movement_id){
        
        dd($movement_id);

     }
}
