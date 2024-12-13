<?php

namespace App\Traits;

trait ApiResponse
{
    public function successResponse($message=null, $data=null, $status_code=200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status_code);
    }

    public function errorResponse($message=null, $errors=null, $status_code=400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status_code);
    }
}
