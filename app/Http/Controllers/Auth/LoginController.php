<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($request->has("return_to") && $request->has("brand_id")) {
            $key       = getenv("ZENDESK_KEY");
            $subdomain = getenv("ZENDESK_SUBDOMAIN");
            $now       = time();

            $token = array(
                "jti"   => bcrypt($now . rand()),
                "iat"   => $now,
                "name"  => $user->name,
                "email" => $user->email
            );

            $jwt = JWT::encode($token, $key);
            $location = "https://" . $subdomain . ".zendesk.com/access/jwt?jwt=" . $jwt;
            $location .= "&return_to=" . urlencode($request->return_to);
            
            return redirect()->away($location);
        }
    }
}
