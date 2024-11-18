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
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Trả về response khi có lỗi.
     */
    public static function error(string $message, int $status = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors,
        ]);
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
            'status' => $status,
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => [
                'currentPage' => $paginator->currentPage(),
                'lastPage' => $paginator->lastPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ]);
    }
}
