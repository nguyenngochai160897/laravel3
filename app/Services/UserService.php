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

    public function loginSocial($provider){
        $provider['account_type']="member";
        $user = $this->user->loginSocial($provider);
        Auth::login($user);
    }
}
