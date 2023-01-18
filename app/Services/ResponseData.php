<?php


namespace App\Services;


class ResponseData
{
    public static function success($message = 'success', $data = null, $status = 200)
    {
        return response()->json([
            'result' => $data,
            'message' => $message,
            'statusCode' => $status
        ])->setStatusCode($status);
    }

    public static function error($message = 'failure', $data = null, $status = 400)
    {
        return response()->json([
            'result' => $data,
            'message' => $message,
            'statusCode' => $status
        ])->setStatusCode($status);
    }

    public static function status($message = '', $status = 200)
    {
        return [
            'message' => $message,
            'statusCode' => $status
        ];
    }

    public static function paginate($message = 'success', $data = [], $status = 200)
    {
        return response()->json([
            'result' => [
                'total' => $data->total(),
                'list' => $data,
                'size' => $data->perPage(),
                'currentPage' => $data->currentPage(),
            ],
            'message' => $message,
            'statusCode' => $status
        ])->setStatusCode($status);
    }

    public static function list($message = 'success', $data = [], $status = 200)
    {
        return response()->json([
            'result' => [
                'total' => count($data),
                'list' => $data,
            ],
            'message' => $message,
            'statusCode' => $status
        ])->setStatusCode($status);
    }
}
