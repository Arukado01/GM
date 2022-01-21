<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo'))
            return $this->redirectTo();

        if (!property_exists($this, 'redirectTo')){
            if(auth()->user()->isAdminOrSupervisor()){
                return route('admin.dashboard');
            }else if(auth()->user()->isClient()){
                return route('home');
            }
        }

        if(auth()->user()->isAdmin() || auth()->user()->isSupervisor())
            return $this->redirectTo;

        $this->redirectTo = '/';
        return $this->redirectTo;
    }
}
