<?php

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

if (!function_exists('responseData')) {
    function responseData($data = null, $info = [], $status = 200): JsonResponse
    {
        $response = [];
        if ($data)
            $response['data'] = $data;
        foreach ($info as $key => $data) {
            $response[$key] = $data;
        }
        return response()->json($response, $status);
    }
}

if (!function_exists('ApiResponse')) {
    function ApiResponse($data = null, $meta = [], $other = [], $description = "Success", $status = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'meta' => [
                'status' => (string)$status,
                'memoryusage' => (string)memory_get_usage(),
                'elapstime' => microtime(true) - LARAVEL_START,
                'timestamp' => now()->timestamp,
                'description' => $description
            ],
            'data' => $data,
        ];

        if (!empty($meta)) {
            $response['meta'] = array_merge($response['meta'], $meta);
        }

        if (!empty($other)) {
            $response = array_merge($response, $other);
        }

        if (config('app.env') === 'production') {
            unset($response['dev']);
        }

        if (!$data) {
            unset($response['data']);
        }

        return response()->json($response, $status);
    }
}
