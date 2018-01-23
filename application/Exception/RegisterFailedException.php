<?php

namespace SwuOS\Openapi\Exception;


use Throwable;

class RegisterFailedException extends CustomException
{
    public function __construct(string $message = "注册失败", int $code = 10002, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}