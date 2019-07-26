<?php

namespace App\Util;

trait Response
{
    public function okResponse($data = 'success')
    {
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function tooManyRequestsResponse($data = 'too many requests')
    {
        return response()->json([
            'data' => $data
        ], 429);
    }

    public function createdResponse($data = 'success')
    {
        return response()->json();
    }
}