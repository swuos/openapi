<?php

namespace SwuOS\Openapi\Exception;


use Throwable;

class UsernameOrPasswordErrorException extends CustomException
{
    public function __construct(string $message = "用户名或密码错误", int $code = 10005, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}