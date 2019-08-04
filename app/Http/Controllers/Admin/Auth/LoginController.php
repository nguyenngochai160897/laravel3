<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showFormLogin(){
        return view("admin.user.login");;
    }

    public function login(LoginRequest $request){
        $credentials = $request->only(['username', 'password']);
        if(Auth::attempt($credentials)){
            return redirect()->route("dashboard");
        }
        return redirect()->back()->withErrors("Wrong credentials");
    }

    public function logout(){
        Auth::logout();
        return redirect()->route("admin.auth.showFormLogin");
    }
}
