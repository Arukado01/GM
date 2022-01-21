<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }*/

    /**
     * @return string
     */
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

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('login');
    }
}
