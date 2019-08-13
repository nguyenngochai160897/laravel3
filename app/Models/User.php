<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'provider_name', 'provider_id', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function loginSocial($provider){
        $user = User::where("provider_id", $provider['provider_id'])->first();
        if(!$user){
            User::insert($provider);
            $user = User::where("provider_id", $provider['provider_id'])->first();
        }
        return $user;
    }

    function forgotPassword($data){
        //check email has existed ?
        $user = User::where("email", $data['email'])->first();
        if(!$user){
            return "NotFoundEmail";
        }
        //save token in db
        $user->token = $data['token'];
        $user->save();
        return [
            'token' => $data['token'],
        ];
    }

    function resetPassword($data){
        $user = User::where("token", $data['token'])->first();
        if(!$user){
            return "not found token";
        }
        $user->token = null;
        $user->password = bcrypt($data['password']);
        $user->save();
    }

    function signUp($data){
        User::insert($data);
        return User::where($data)->first();
    }
}
