<?php

namespace App\Helpers\Api;

class Response
{
    protected const code_success_res = 200;
    protected const code_error_res = 400;
    protected const type_success_res = "success";
    protected const type_error_res = "error";

    function success($message, $code = self::code_success_res, $type = self::type_success_res)
    {
        $res['type'] = $type;
        $res['status'] = $code;
        $res['message'] = $message;
        response()->json($res, $code)->send();
        exit;
    }

    function error($message, $code = self::code_error_res, $type = self::type_error_res)
    {
        $res['type'] = $type;
        $res['status'] = $code;
        $res['message'] = $message;
        response()->json($res, $code)->send();
        exit;
    }

    function data($data, $message = null, $code = self::code_success_res, $type = self::type_success_res)
    {
        $res['type'] = $type;
        $res['status'] = $code;
        if (!empty($message)) $res['message'] = $message;
        $res['data'] = $data;
        response()->json($res, $code)->send();
        exit;
    }
}
