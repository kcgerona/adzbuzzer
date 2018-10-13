<?php

if(! function_exists('load_asset')) {
	function load_asset($value)
	{
		if (getenv('ENVIRONMENT_PRODUCTION','heroku') == 'heroku') {
			return secure_asset($value);
		} else {
			return asset($value);
		}
	}
}