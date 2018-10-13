<?php

namespace App\Services;

use App\Contracts\Security\JWTSSO;
use Firebase\JWT\JWT;
use Auth;

class ZendeskService implements JWTSSO
{
    /**
     * @var Firebae\JWT\JWT;
     */
    private $jwt;

    /**
     * @var zendesk secret key
     */
	protected $key;

	/**
     * @var zendesk subdomain
     */

   	protected $subdomain;
   	/**
     * Constructor
     *
     * Concat all role of user
     *
     * @return string
     */
    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;

        $this->key  = config('zendesk.secret');

		$this->subdomain = config('zendesk.subdomain');
    }

    /**
     * Build redirect url for zendesk when login
     *
     * @param return_to string 
     * @return string
     */

    public function buildRedirect($return_to = "")
    {
    	abort_unless(Auth::check(), 403);

    	$jwt = $this->generateJwt();
    	$location = "https://" . $this->subdomain . ".zendesk.com/access/jwt?jwt=" . $jwt . "&return_to=" . urlencode($return_to);

        return $location;
    }

    /**
     * Generate Jwt token with required fields
     *
     * Concat all role of user
     *
     * @return string
     */
    public function generateJwt()
    {

    	$now = time();
    	$user = Auth::user();

    	$token = array(
                "jti"   => bcrypt($now . rand()),
                "iat"   => $now,
                "name"  => $user->name,
                "email" => $user->email
            );

    	return JWT::encode($token, $this->key);
    }


}