<?php

namespace App\Traits\Api;

trait Token
{
    function getToken($token)
    {
        return str_replace(["Basic ", "Bearer ",], "", $token);
    }

    function key() { return env('JWT_KEY', 'JWT_KEY'); }

    function timeExp() {
//        return time()+(60 * 60 * 24 * 60); // jwt valid for 60 days (60 seconds * 60 minutes * 24 hours * 60 days)
        return time()+(60 * 60 * 4); // jwt valid for 4 hours (60 seconds * 60 minutes * 24 hours)
    }
}
