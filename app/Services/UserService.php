<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;
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
        $provider['account_type']=config("role.MEMBER");
        $user = $this->user->loginSocial($provider);
        Auth::login($user);
    }

    public function forgotPassword($email){
        $token = md5($email);
        $codeToken = "";
        for($i = 0; $i < 5; $i++){
            $codeToken.=substr($token,rand(0,strlen($token)),1);
        }
        $data = $this->user->forgotPassword([
            'email' => $email,
            'token' => $codeToken
        ]);

        if($data != "NotFoundEmail"){
            Redis::set($codeToken, $codeToken, 'EX', config('redis.token_email'));
            Mail::to($email)->send(new SendEmail($codeToken));
        }
        return $data;
    }

    public function resetPassword($password, $token){
        $token = Redis::get($token);
        if(!$token) {
            return [
                "error" => 'token_expire'
            ];
        }
        $data = $this->user->resetPassword([
            'password' => $password,
            "token" => $token
        ]);
        return $data;
    }

    //temporary for member
    public function signUp($data){
        $data['account_type'] = config("role.MEMBER");
        $data['password'] = bcrypt($data['password']);
        $user = $this->user->signUp($data);
        Auth::login($user);
    }
}
