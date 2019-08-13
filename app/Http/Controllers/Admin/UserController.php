<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showProfile(){
        $user = $this->userService->getUser();
        return view("admin.user.profile")->with("user", $user);
    }
}
