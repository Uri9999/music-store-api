<?php

namespace App\Exceptions;

class SpamForgotPasswordException extends CustomException
{
    public function __construct($time = 0, $message = null, $code = null)
    {
        // Nếu bạn truyền message và code, sẽ ghi đè các giá trị mặc định
        // if ($message) {
        //     $this->message = $message;
        // }

        if (!$message) {
            $message = 'Bạn thao tác quá nhanh, vui lòng thử lại sau ' . $time . ' phút';
        }

        if ($code) {
            $this->code = $code;
        }

        parent::__construct($message, $this->code);
    }
}
