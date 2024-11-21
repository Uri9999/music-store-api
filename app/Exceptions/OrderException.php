<?php

namespace App\Exceptions;

class OrderException extends CustomException
{
    public function __construct($time = 0, $message = null, $code = 400)
    {
        if (!$message) {
            $message = 'Tạo đơn hàng thất bại.';
        }

        if ($code) {
            $this->code = $code;
        }

        parent::__construct($message, $this->code);
    }
}
