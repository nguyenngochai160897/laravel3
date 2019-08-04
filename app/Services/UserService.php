<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;

class UserService {
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

}
