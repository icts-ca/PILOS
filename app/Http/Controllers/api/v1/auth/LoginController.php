<?php

namespace App\Http\Controllers\api\v1\auth;

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
        $this->middleware('guest:webldap')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function ldapLogin(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password'   => 'required|min:6'
        ]);

        if (Auth::guard('webldap')->attempt(['uid' => $request->username, 'password' => $request->password])) {
            return response('Login', 200);
        }

        return response()->json([
            'errors' => [ 'username' => [__('auth.failed')]],
        ], 401);
    }
}
