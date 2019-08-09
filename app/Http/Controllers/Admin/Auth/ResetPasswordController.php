<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Services\UserService;
use App\Http\Requests\Admin\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    private $userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest');
    }

    function showFormResetPassword($token){

    }

    function resetPassword(ResetPasswordRequest $request, $token){
        $data = $this->userService->resetPassword($request->input("password"), $token);
        if($data){
            return redirect()->back()->withErrors(["msg"=> $data]);
        }
        return redirect()->route("admin.auth.showFormLogin");
    }
}
