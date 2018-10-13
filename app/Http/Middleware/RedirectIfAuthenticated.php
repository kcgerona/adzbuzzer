<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return $this->isFromZendesk($request,Auth::user())?: redirect('/home');
        }

        return $next($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function isFromZendesk($request, $user)
    {

        if ($request->has("return_to")) {
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
