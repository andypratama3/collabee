<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, ?string $message = null, int $code = 200, ?array $meta = null): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        if ($meta) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $code);
    }

    public static function error(string $message, int $code = 400, mixed $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    public static function paginated(mixed $data, ?string $message = null): JsonResponse
    {
        $meta = [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ];

        return static::success($data->items(), $message, 200, $meta);
    }
}
