<?php

namespace App\Helpers\Api;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class Validate
{
    private $res;
    public function __construct(
        Response $res
    )
    {
        $this->res = $res;
    }

    function valid($valid = [])
    {
        $validator = Validator::make(Request::all(), $valid);

        if ($validator->fails()) {
            $message = $validator->errors();
            $this->res->error($message->all(':message')[0], 400);
        }
    }
}
