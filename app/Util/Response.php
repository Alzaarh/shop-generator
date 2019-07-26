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

    public function modelNotFoundResponse($data = 'model not found')
    {
        return response()->json([
            'data' => $data
        ], 404);
    }

    public function badRequestResponse($data = 'bad request')
    {
        return response()->json([
            'data' => $data
        ], 400);
    }

    public function unAuthorizedResponse($data = 'unauthorized')
    {
        return response()->json([
            'data' => $data
        ], 401);
    }

    public function forbiddenResponse($data = 'forbidden')
    {
        return response()->json([
            'data' => $data
        ], 403);
    }
}