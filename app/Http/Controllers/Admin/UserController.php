<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;
    function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showProfile(){
        $user = $this->userService->getUser();
        return view("admin.user.profile")->with("user", $user);
    }
}
