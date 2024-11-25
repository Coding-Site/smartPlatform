<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse {
    public static function sendResponse($code = 200, $msg = null, $data = null): JsonResponse
    {
        $response = [
            'status'  => $code,
            'message' => $msg,
            'data'    => $data
        ];

        return response()->json($response, $code);
    }
}
