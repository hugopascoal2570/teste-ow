<?php 

namespace App\Repositories;

use App\Models\User;

class UserRepository{

    protected $entity;
    public function __construct(User $model)
    {
        $this->entity = $model;
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

    public function creditUserMovement(array $data) {
   
        $user = $this->entity->find($data['user_id']);
        $user->movements()->attach($data['movement_id']);

        return $user;
     }
}
