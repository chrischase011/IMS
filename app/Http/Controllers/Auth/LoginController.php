<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\HandleLoginActivity;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {

        if($user->roles == 3 && $user->email_verified_at === null)
        {
            HandleLoginActivity::storeActivity($user->email, $request->ip(), $request->userAgent(), 'Email not verified.');
            Auth::logout();
            return back()->with('error', "Please verify your email to login.");
        }

        HandleLoginActivity::storeActivity($user->email, $request->ip(), $request->userAgent(), 'Successful Login');
        return redirect($this->redirectTo);
    }
}
