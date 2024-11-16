<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    // Thông điệp lỗi mặc định
    protected $message = 'Có lỗi xảy ra trong quá trình xử lý yêu cầu của bạn.';

    // Mã trạng thái HTTP mặc định
    protected $code = 400;

    // Bạn có thể ghi đè hàm __construct nếu cần
    public function __construct($message = null, $code = null)
    {
        // Nếu bạn truyền message và code, sẽ ghi đè các giá trị mặc định
        if ($message) {
            $this->message = $message;
        }

        if ($code) {
            $this->code = $code;
        }

        parent::__construct($this->message, $this->code);
    }

    // Nếu bạn muốn trả về thông tin đặc biệt khi exception xảy ra, có thể ghi đè hàm render()
    public function render($request)
    {
        // Trả về một response JSON với thông điệp và mã trạng thái
        return response()->json([
            'message' => $this->message,
            'status' => $this->code
        ]);
    }
}
