<?php
namespace App\Helper;

class Response
{
    public static function success($msg = "Request successful", $data = [], $code = 200)
    {
        return response()->json(
            [
                'status'  => 'success',
                'message' => $msg,
                'data'    => $data,
            ],
            $code);
    }

    public static function failed($msg = "Request failed", $code = 400)
    {
        return response()->json(
            [
                'status'  => 'failed',
                'message' => $msg,
            ],
            $code);
    }

    public static function error($data = null, $code = 400)
    {
        return response()->json(
            [
                'status'  => 'error',
                'message' => 'Something went wrong!',
                'data'    => $data,
            ],
            $code);
    }
}
