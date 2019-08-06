<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService {
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function getUser(){
        return Auth::user();
    }

    public function getAllUser(){

    }

    public function createUser(){

    }

    public function updateUser(){

    }

    public function deleteUser(){

    }
}
