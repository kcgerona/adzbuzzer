<?php

namespace App\Contracts\Security;

interface JWTSSO
{
	/**
     * @param $returnTo string
     *
     * @return string
     */
	public function buildRedirect($return_to = "");

	/**
     *
     * @return string
     */
	public function generateJwt();
}
