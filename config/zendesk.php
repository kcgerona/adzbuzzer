<?php

return [

    /*
    |--------------------------------------------------------------------------
    | secret
    |--------------------------------------------------------------------------
    |
    | You can get this value on secr
    |   https://*.zendesk.com/agent/admin/security -> Shared secret
    */
    'secret' => env('ZENDESK_SECRET'),
    /*
    |--------------------------------------------------------------------------
    | Sub domain  
    |--------------------------------------------------------------------------
    |
    | This is the subdomain of zendesk  SUBDOMAIN.zendesk.com
    */
    'subdomain' => env('ZENDESK_SUBDOMAIN',''),
    /*
    |--------------------------------------------------------------------------
    | Brand ID 
    |--------------------------------------------------------------------------
    | Optional, 
    | 
    */
    'brand_id' => env('ZENDESK_BRAND_ID','')
    
];
