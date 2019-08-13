<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\Services\UserService;

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
    // protected $redirectTo = '/dashboard';
    private $userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('guest')->except('logout');
        $this->userService = $userService;
    }

    public function showFormLogin(){
        return view("admin.user.login");;
    }

    public function login(LoginRequest $request){
        $credentials = $request->only(['username', 'password']);
        $remember = $request->input("remember");
        if(!empty($remember)){
            $remember = true;
        }
        if(Auth::attempt($credentials, $remember)){
            // dd(Auth::user());
            if(Auth::user()->account_type == "member"){
                return redirect()->route("public.index");
            }
            return redirect()->route("dashboard");
        }
        return redirect()->back()->withErrors("Wrong credentials");
    }

    public function logout(){
        Auth::logout();
        return redirect()->route("admin.auth.showFormLogin");
    }

    public function redirectToProvider($driver){
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver){
        $user = Socialite::driver($driver)->user();
        $provider = [
            "provider_id" => $user->id,
            "provider_name" => $driver
        ];
        $this->userService->loginSocial($provider);
        return redirect()->route("public.index");
    }
}
