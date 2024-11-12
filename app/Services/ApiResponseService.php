<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ApiResponseService
{
    /**
     * Trả về response khi thành công.
     */
    public static function success($data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Trả về response khi có lỗi.
     */
    public static function error(string $message, int $status = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    /**
     * Trả về response cho dữ liệu dạng collection hoặc array.
     */
    public static function collection(Collection|array $data, string $message = 'Success', int $status = 200): JsonResponse
    {
        return self::success($data, $message, $status);
    }

    /**
     * Trả về response cho một đối tượng đơn lẻ.
     */
    public static function item($data, string $message = 'Success', int $status = 200): JsonResponse
    {
        return self::success($data, $message, $status);
    }

    /**
     * Trả về response cho dữ liệu phân trang.
     */
    public static function paginate(LengthAwarePaginator $paginator, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ], $status);
    }
}
