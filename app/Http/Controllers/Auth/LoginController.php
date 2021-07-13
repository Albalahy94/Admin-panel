<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    public function username()
    {
        //        return 'phone';
        // $req = request()->input('identify');
        // if ($req == 'email') {
        //     return 'email';
        // } else {
        //     return 'phone';
        $req = request()->input('identify');
        $new = filter_var($req, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        request()->merge([$new => $req]);
        return $new;
    }

    public function face($service)
    {
        # code...
        return Socialite::driver($service)->redirect();
    }
    public function callback($service)
    {
        # code...
        $social_user = Socialite::driver($service)->user();
        // return $user->token;
        $find_user = User::where('email', $social_user->email)->first();

        if ($find_user) {
            Auth::login($find_user);
            return redirect('home');
        } else {

            $user = new User;
            $user->name =  $social_user->name;
            $user->email  =  $social_user->email;
            $user->password =  encrypt(1234);
            $user->save();
            // $social_user->password;
            Auth::login($user);
            return redirect('home');
        }
    }
}