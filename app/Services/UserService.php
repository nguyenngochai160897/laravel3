<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use App\Mail\SendEmail;

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

    public function forgotPassword($email){
        $token = md5($email);
        $data = $this->user->forgotPassword([
            'email' => $email,
            'token' => $token
        ]);
        if($data != "NotFoundEmail"){
            Redis::set($token, $token, 'EX', 60*60);
            Mail::to($email)->send(new SendEmail($token));
        }
        return $data;
    }

    public function resetPassword($password, $token){
        $token = Redis::get($token);
        if(!$token) return "token_reset expired";
        $data = $this->user->resetPassword([
            'password' => $password,
            "token" => $token
        ]);
        return $data;
    }
}
