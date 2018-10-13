<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\ZendeskService;
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
     * App\Services\ZendeskService
     *
     * @var string
     */
    protected $service;

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
    public function __construct(ZendeskService $service)
    {
        $this->middleware('guest')->except('logout');

        $this->service = $service;
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        if ($request->has('redirect_to')) {
            session(['redirect_to' => $request->redirect_to]);
        }
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

        if (session()->has("return_to")) {

            $location = $this->service->buildRedirect(session('return_to'));

            session()->forget('return_to');

            return redirect()->away($location);
        }

        return false;
    }
}