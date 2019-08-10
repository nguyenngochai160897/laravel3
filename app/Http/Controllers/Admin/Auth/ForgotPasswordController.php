<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Requests\Admin\ForgotPassWordRequest;
use App\Services\UserService;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $userService;
    public function __construct(UserService $userService)
    {
        $this->middleware('guest');
        $this->userService = $userService;
    }

    public function forgotPassword(ForgotPassWordRequest $request){
        $data = $this->userService->forgotPassword($request->input('email'));
        if($data == "NotFoundEmail"){
            return redirect()->back()->withErrors(["msg" => "Email is not found"]);
        }
        echo "Check your email";
    }
}
